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
use Utility\Helper\Xml\Xlsx;
use Utility\Helper\Save\Xml as SaveAsXml;
use Utility\Helper\Save\Csv as SaveAsCsv;
use Utility\Helper\Save\Xlsx as SaveAsXlsx;
use Utility\Helper\Save\Json as SaveAsJson;

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
     * @var \Utility\Service\Array2xmlService|null
     */
    protected $array2XmlService;

    /**
     * @var int|null
     */
    private $user;

    const SUPPORT_FORMATS = [
        'xml',
        'csv',
        'json',
//        'xlsx',
    ];

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
            'formats'       => self::SUPPORT_FORMATS,
            'userFiles'     => $userFiles,
            'flashMessages' => $this->flashMessenger()->getMessages()
        ]);
    }

    public function getFileAction()
    {
        $fullPath   = $this->params()->fromQuery('file');
        $format     = $this->params()->fromQuery('format');

        if (empty($fullPath) || empty($format)) {
            $this->getFileErrorRedirect();
        }

        if (!in_array($format, self::SUPPORT_FORMATS)) {
            $this->getFileErrorRedirect('Incorrect file format selected.');
        }

        // parse query string
        $explode  = explode('/', $fullPath);
        $filePath = $explode[0] . '/' . $explode[1];
        $filename = end($explode);

        // get data from db
        $downloadedData = $this->userService->getDownloadedData($filePath, $filename);

        // if data is false
        if (is_null($downloadedData)) {
            // set error message
            $this->getFileErrorRedirect('File not found!');
        }

        // array to xml service
        $xml2array = $this->getServiceLocator()->get('xml2Array');

        // select saving format
        switch ($format) {
            case 'xml':
                $returnedData = SaveAsXml::get($xml2array, $filename, $downloadedData);
                break;
            case 'csv':
                $returnedData = SaveAsCsv::get($downloadedData);
                break;
            case 'json':
                $returnedData = SaveAsJson::get($downloadedData);
                break;
//            case 'xlsx':
//                $addedData = Xlsx::getAllFiles($xml2array, ['itemId', 'title', 'price'], 'name');
//
//                $returnedData = SaveAsXlsx::get($downloadedData);
//                break;
            default:
                $returnedData = false;
        }

        if (!$returnedData) {
            $this->getFileErrorRedirect('Something went wrong, please try again later.');
        }

        // show save dialog
        $response = $this->getEvent()->getResponse();
        $response->getHeaders()->addHeaders([
                'Content-Type'          => $returnedData['contentType'],
                'Content-Disposition'   => 'attachment;filename="' . $filename . $returnedData['fileExtension'] . '"',
        ]);

        $response->setContent($returnedData['fileData']);

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

    protected function getFileErrorRedirect($message = null)
    {
        if (!is_null($message)) {
            $this->flashMessenger()->addMessage($message);
        }

        return $this->redirect()->toRoute('settings/default', ['action' => 'download']);
    }

    protected function getArrayToXmlService()
    {
        if (is_null($this->array2XmlService)) {
            $this->array2XmlService = $this->getServiceLocator()->get('xml2Array');
        }

        return $this->array2XmlService;
    }
}
