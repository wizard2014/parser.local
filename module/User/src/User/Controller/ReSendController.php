<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;
use User\Mapper\User as UserMapper;
use HtUserRegistration\Mapper\UserRegistrationMapperInterface;
use HtUserRegistration\Mailer\MailerInterface;

class ReSendController extends AbstractActionController
{
    protected $session;
    protected $user;
    protected $mapper;
    protected $userRegistrationMapper;
    protected $mailer;

    public function __construct(
        UserMapper $mapper,
        UserRegistrationMapperInterface $userRegistrationMapper,
        MailerInterface $mailer
    )
    {
        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();

        $this->session                = new Container('token');
        $this->mapper                 = $mapper;
        $this->userRegistrationMapper = $userRegistrationMapper;
        $this->mailer                 = $mailer;
    }

    public function indexAction()
    {
        // if user log in
        if (null !== $this->user) {
            return $this->redirect()->toRoute('zfcuser');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            // validate token
            $token = $this->tokenValidate($data['token']);

            // clear data
            array_walk_recursive($data, function (&$value) {
                $value = trim(strip_tags($value));
            });

            if ($token) {
                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $this->flashMessenger()->addMessage('Invalid Email');
                } else {
                    // check user exists
                    $userExists = $this->mapper->userExists($data['email']);

                    if (!$userExists) {
                        return $this->redirect()->toRoute('zfcuser');
                    }

                    $user = $this->mapper->getUserByEmail($data['email']);

                    $registrationRecord = $this->getUserRegistrationMapper()->findByUser($user);

                    // a record was found
                    // update expiry
                    if (!$registrationRecord->isResponded()) {
                        $registrationRecord->setRequestTime(new \DateTime());
                        $registrationRecord->generateToken();
                        $this->getUserRegistrationMapper()->update($registrationRecord);

                        // resend email
                        $this->mailer->sendVerificationEmail($registrationRecord);

                        $this->flashMessenger()->addMessage($data['email'] . '|info');
                    }
                }
            }

            $this->prg();
        }

        return new ViewModel([
            'token'          => $this->token(),
            'flashMessenger' => $this->flashMessenger()->getMessages(),
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

    /**
     * Gets userRegistrationMapper
     *
     * @return UserRegistrationMapperInterface
     */
    protected function getUserRegistrationMapper()
    {
        return $this->userRegistrationMapper;
    }
}
