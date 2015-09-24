<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    protected $ebayFindingService;
    protected $session;

    /**
     * @param $ebayFindingService
     */
    public function __construct($ebayFindingService)
    {
        $this->ebayFindingService = $ebayFindingService;

        $this->session = new Container('token');
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            // validate token
            $token = $this->tokenValidate($data['token']);

            if ($token) {
                $results = $this->ebayFindingService->findItems($data);

                // save result

            }
        }

        return $this->redirect()->toRoute('get-started');
    }

    /**
     * @param $token
     *
     * @return bool
     */
    protected function tokenValidate($token) {
        $sessionToken = $this->session->offsetGet('token');

        if (!empty($token) && $token === $sessionToken) {
            return true;
        }

        return false;
    }
}
