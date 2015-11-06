<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;

class ReSendController extends AbstractActionController
{
    protected $session;

    public function __construct()
    {
        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();

        $this->session = new Container('token');
    }

    public function indexAction()
    {
        /**
         * @todo validate 'is user'
         */

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            // validate token
            $token = $this->tokenValidate($data['token']);

            // clear data
            array_walk_recursive($data, function (&$value) {
                $value = trim(strip_tags($value));
            });

            // process
        }

        return new ViewModel([
            'token' => $this->token(),
        ]);
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
