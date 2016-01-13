<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Ebay\Service\CategoryService;
use Ebay\Service\FindItemsService;
use Utility\Service\DataSourceService;
use User\Service\UserService;
use Utility\Helper\Csrf\Csrf;
use Utility\Helper\Xml\Xml;

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

    protected $userService;

    /**
     * @var int|null
     */
    protected $user;

    /**
     * @param CategoryService   $categoryService
     * @param FindItemsService  $findItemsService
     * @param DataSourceService $dataSourceService
     * @param UserService       $userService
     */
    public function __construct(
        CategoryService   $categoryService,
        FindItemsService  $findItemsService,
        DataSourceService $dataSourceService,
        UserService       $userService
    ) {
        $this->categoryService   = $categoryService;
        $this->findItemsService  = $findItemsService;
        $this->dataSourceService = $dataSourceService;
        $this->userService       = $userService;

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
            $errors = $this->dataSourceService->validate('ebay', $data);
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

                $results = $this->findItemsService->findItems($data, $appId);

                // if returns error
                if (500 === $results) {
                    $this->flashMessenger()->addMessage(['Invalid key, please check it out and add again.']);

                    // change key status to Invalid
                    $this->dataSourceService->setInvalidKey($this->user, $data['region']);
                } else {
                    $path     = md5($this->userService->getEmail($this->user)) . '/' . self::VENDOR;
                    $filename = self::VENDOR . uniqid('_');

                    // save data into db
                    // todo

                    // save data into file
                    Xml::saveAsXml($results, $path, $filename);
                }
            }
        }

        return $this->redirect()->toRoute('get-started');
    }
}
