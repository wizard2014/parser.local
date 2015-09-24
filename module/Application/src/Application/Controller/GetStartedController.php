<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;

class GetStartedController extends AbstractActionController
{
    protected $mapper;
    protected $cache;
    private $user;

    public function __construct($mapper, $cache)
    {
        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();

        $this->session = new Container('token');

        $this->mapper = $mapper;
        $this->cache  = $cache;
    }

    public function indexAction()
    {
        // check for log in
        if (is_null($this->user)) {
            return $this->redirect()->toRoute('zfcuser');
        }

        $ebayDataSourceGlobalEbay = $this->mapper['dataSourceGlobal']->getSourceGlobalByName('eBay');
        $ebayDataSourceRegional   = $this->mapper['dataSourceRegional']->getDataByRegion($ebayDataSourceGlobalEbay->getId(), 'en', 'ebay'); // ebay in english

        return new ViewModel([
            'ebaySourceGlobal'   => $ebayDataSourceGlobalEbay,
            'ebaySourceRegional' => $ebayDataSourceRegional,
            'token'              => $this->token(),
        ]);
    }

    public function getCatalogItemAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $data = $request->getPost();

            $region   = $data['region'];
            $level    = $data['level'];
            $parentId = $data['parentId'];

            $categories = $this->cache->getItem($region)[$region]['level_' . $level];

            return new JsonModel([
                'catalogList'   => $categories,
                'categoryLevel' => $level,
            ]);
        }

        return $this->redirect()->toRoute('zfcuser');
    }

    private function token()
    {
        $token = md5(uniqid(mt_rand(), true));

        $this->session->offsetSet('token', $token);

        return $token;
    }
}
