<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use User\Service\UserService;
use Utility\Service\DataSourceService;
use Utility\Service\SubscriptionService;
use Utility\Service\AttributeService;
use Utility\Helper\Csrf\Csrf;
use Utility\Helper\Xml\Xml;

class SettingsController extends AbstractActionController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var DataSourceService
     */
    protected $dataSourceService;

    /**
     * @var SubscriptionService
     */
    protected $subscriptionService;

    /**
     * @var AttributeService
     */
    protected $attributeService;

    /**
     * @var int|null
     */
    private $user;

    /**
     * @param UserService         $userService
     * @param DataSourceService   $dataSourceService
     * @param SubscriptionService $subscriptionService
     * @param AttributeService    $attributeService
     */
    public function __construct(
        UserService             $userService,
        DataSourceService       $dataSourceService,
        SubscriptionService     $subscriptionService,
        AttributeService        $attributeService
    ) {
        $this->userService              = $userService;
        $this->dataSourceService        = $dataSourceService;
        $this->subscriptionService      = $subscriptionService;
        $this->attributeService         = $attributeService;

        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();
    }

    public function indexAction()
    {
        $redirect = $this->userService->getRedirectRule($this->user);

        if (!$redirect) {
            return $this->redirect()->toRoute('settings/default', ['action' => 'subscription']);
        }

        return $this->redirect()->toRoute('settings/default', ['action' => 'profile']);
    }

    public function profileAction()
    {
        $userId = $this->user;

        /**
         * @todo change solution
         */
        $userInfo = $this->userService->getUserInfo($userId);
        $userInfo['subInfo']['subScheme'] = $this->attributeService->getAttributeValueById($userInfo['subInfo']['subScheme']);
        $userInfo['subInfo']['subStatus'] = $this->attributeService->getAttributeValueById($userInfo['subInfo']['subStatus']);

        // [1 = > 'Ebay'...]
        $vendors = $this->dataSourceService->getVendors(); // form for Ebay, Amazon, etc...

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $token = $request->getPost('token');

            if (isset($token) && Csrf::valid($token)) {
                $data = $request->getPost()->toArray();

                // clear data
                array_walk_recursive($data, function (&$value) {
                    $value = trim(strip_tags($value));
                });

                if ($dataSourceGlobal = $this->dataSourceService->getSourceGlobalById($data['vendor'])) {
                    $user = $this->userService->getUser($this->user);

                    // set app key
                    $this->dataSourceService->setKey($user, $dataSourceGlobal, $data['key']);
                }
            }

            return new JsonModel([
                'token' => Csrf::generate(),
            ]);
        }

        return new ViewModel([
            'userInfo' => $userInfo,
            'vendors'  => $vendors,
            'token'    => Csrf::generate(),
        ]);
    }

    public function notificationAction()
    {
        $userId = $this->user;

        $isEmailSubscriber = $this->userService->isEmailSubscriber($userId);

        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $token = $request->getPost('token');

            if (isset($token) && Csrf::valid($token)) {
                $this->userService->changeSubscription($userId, $isEmailSubscriber);
            }

            return new JsonModel([
                'token' => Csrf::generate(),
            ]);
        }

        return new ViewModel([
            'isEmailSubscriber' => $isEmailSubscriber,
            'token'             => Csrf::generate(),
        ]);
    }

    public function downloadAction()
    {
        $vendors = $this->dataSourceService->getVendors();

        $userFiles = $this->userService->getUserFies($this->user, array_flip($vendors));

        return new ViewModel([
            'userFiles' => $userFiles
        ]);
    }

    public function getFileAction()
    {
        $fullPath = $this->params()->fromQuery('file');

        if (empty($fullPath)) {
            return $this->redirect()->toRoute('settings/default', ['action' => 'download']);
        }

        // get file if exists
        $data = Xml::getAsXml($fullPath);

        // if data is false
        if (false === $data) {
            // @todo set error message

            return $this->redirect()->toRoute('settings/default', ['action' => 'download']);
        }

        $explode = explode('/', $fullPath);
        $filePath = $explode[0] . '/' . $explode[1];
        $filename = end($explode);

        // show save dialog
        $response = $this->getEvent()->getResponse();
        $response->getHeaders()->addHeaders([
                'Content-Type'          => 'text/xml',
                'Content-Disposition'   => 'attachment;filename="' . $filename . '.xml"',
            ]
        );

        $response->setContent($data);

        // increment download counter
        $this->userService->increment($filePath, $filename);

        return $response;
    }

    public function subscriptionAction()
    {
        return new ViewModel();
    }

    public function statisticsAction()
    {
        return new ViewModel();
    }
}
