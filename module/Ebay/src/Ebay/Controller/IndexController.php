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

                $resultData = $this->findItemsService->findItems($data, $appId);

                // if returns error
                if (500 === $resultData) {
                    $this->flashMessenger()->addMessage(['Invalid key, please check it out and add again.']);

                    // change key status to Invalid
                    $this->dataSourceService->setInvalidKey($this->user, $data['region']);
                } else {
                    $path     = md5($this->userService->getEmail($this->user)) . '/' . self::VENDOR;
                    $filename = self::VENDOR . uniqid('_');

                    // @todo send success message

                    // if success
                    if (!empty($resultData)) {
                        // save into db
                        /* $insertedData = */$this->userService->saveFileData(
                            $this->userService->getUser($this->user),
                            $this->dataSourceService->getSourceGlobalById($data['region']),
                            $path,
                            $filename,
                            $resultData
                        );

                        // set log
                        /* $requestLog = */$this->userService->setRequestLog(
                            'subId',
                            count($resultData),
                            [
                                'keyword'       => $data['keyword'],
                                'sortOrder'     => $data['sortOrder'],
                                'minPrice'      => $data['minPrice'],
                                'maxPrice'      => $data['maxPrice'],
                                'itemsQty'      => $data['itemsQty'],
                                'listingType'   => $data['listingType'],
                                'region'        => $this->dataSourceService->getRegionNameById($data['region']),
                            ]
                        );
                    } else {
                        $this->flashMessenger()->addMessage(['Nothing found! Change your search criteria and try again.']);
                    }
                }
            }
        }

        return $this->redirect()->toRoute('get-started');
    }
}
