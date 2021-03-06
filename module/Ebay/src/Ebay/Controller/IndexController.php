<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Ebay\Service\CategoryService;
use Utility\Service\DataSourceService;
use User\Service\UserService;
use Utility\Service\ValidateService;
use Utility\Helper\Csrf\Csrf;
use Ebay\Sender\WorkerSender;

class IndexController extends AbstractActionController
{
    const VENDOR = 'ebay';

    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * @var FindItemsService
     */
    protected $findItemsService;

    /**
     * @var DataSourceService
     */
    protected $dataSourceService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var ValidateService
     */
    protected $validateService;

    /**
     * @var int|null
     */
    protected $user;

    /**
     * IndexController constructor.
     *
     * @param CategoryService   $categoryService
     * @param DataSourceService $dataSourceService
     * @param UserService       $userService
     * @param ValidateService   $validateService
     */
    public function __construct(
        CategoryService   $categoryService,
        DataSourceService $dataSourceService,
        UserService       $userService,
        ValidateService   $validateService
    ) {
        $this->categoryService   = $categoryService;
        $this->dataSourceService = $dataSourceService;
        $this->userService       = $userService;
        $this->validateService   = $validateService;

        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            // validate token
            $token = Csrf::valid($data['token']);

            // clear data
            array_walk_recursive($data, function (&$value) {
                $value = trim(strip_tags($value));
            });

            // validate form data
            $errors = $this->validateService->validateFormData(self::VENDOR, $data, $this->user);
            // validate category
            if (!isset($errors['region']) && !empty($categoryValid = $this->categoryService->validate($data))) {
                $errors['category'] = $categoryValid;
            }

            if (!empty($errors)) {
                $this->flashMessenger()->addMessage($errors);
            } elseif ($token) {
                // get user app key if exists
                $appId = $this->dataSourceService->getKey($this->user, $data['region']);

                $data['ebay_global_id'] = $this->dataSourceService->getEbayGlobalId($data['region']);

                // set log
                $activeSubscription = $this->userService->getActiveSubscription($this->user, $data['region']);
                $propertySet        = $this->propertySetPrepare($data);
                // add region name
                $propertySet['region'] = ucwords($this->dataSourceService->getRegionNameById($data['region']));

                /* $requestLog = */$this->userService->setRequestLog($activeSubscription, $propertySet);

                $email    = $this->userService->getEmail($this->user);
                $path     = md5($email) . '/' . self::VENDOR;
                $filename = self::VENDOR . uniqid('_');

                // enqueue
                $sender = new WorkerSender();
                $sender->execute([
                    'responseData' => $data,
                    'appId'        => $appId,
                    'user'         => $this->user,
                    'region'       => $data['region'],
                    'path'         => $path,
                    'filename'     => $filename,
                ]);

                $this->flashMessenger()->addMessage(['After all necessary operations, we will send you an e-mail.|info']);
            }
        }

        return $this->redirect()->toRoute('get-started');
    }

    /**
     * Skip not selected filters
     *
     * @param $data
     *
     * @return array
     */
    protected function propertySetPrepare($data)
    {
        $exclude = [
            'category',
            'token',
            'region',
        ];

        $prepare = [];

        foreach ($data as $key => $value) {
            if (!empty($value) && (!in_array($key, $exclude) && strpos($key, 'id') === false)) {
                $prepare[$key] = $value;
            }
        }

        return $prepare;
    }
}
