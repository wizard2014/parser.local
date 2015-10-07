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

        return new ViewModel([
            'token' => $this->token(),
        ]);
    }

    public function getRegionAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $ebayDataSourceGlobalEbay = $this->mapper['dataSourceGlobal']->getSourceGlobalByName('eBay');
            $ebayDataSourceRegional   = $this->mapper['dataSourceRegional']->getDataByRegion($ebayDataSourceGlobalEbay['id'], 'en', 'ebay'); // ebay in english

            return new JsonModel([
                'ebaySourceRegional' => $ebayDataSourceRegional,
            ]);
        }
    }

    public function getCategoryAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $data = $request->getPost();

            if (!empty($data['parentId'])) {
                $categories = $this->mapper['category']->getCategory($data['region'], $data['level'], $data['parentId']);
            } else {
                $categories = $this->mapper['category']->getMainCategory($data['region'], $data['level']);
            }

            return new JsonModel([
                'categoryList' => $categories,
            ]);
        }

        return $this->redirect()->toRoute('zfcuser');
    }

    /**
     * @return string
     */
    private function token()
    {
        $token = md5(uniqid(mt_rand(), true));

        $this->session->offsetSet('token', $token);

        return $token;
    }
}
