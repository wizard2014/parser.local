<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use User\Service\UserService;
use HtUserRegistration\Mapper\UserRegistrationMapperInterface;
use HtUserRegistration\Mailer\MailerInterface;
use Utility\Helper\Csrf\Csrf;

class ReSendController extends AbstractActionController
{
    /**
     * @var int|null
     */
    protected $user;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var UserRegistrationMapperInterface
     */
    protected $userRegistrationMapper;

    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * ReSendController constructor.
     *
     * @param UserService                     $userService
     * @param UserRegistrationMapperInterface $userRegistrationMapper
     * @param MailerInterface                 $mailer
     */
    public function __construct(
        UserService                     $userService,
        UserRegistrationMapperInterface $userRegistrationMapper,
        MailerInterface                 $mailer
    ) {
        $auth = new AuthenticationService();
        $this->user = $auth->getIdentity();

        $this->userService            = $userService;
        $this->userRegistrationMapper = $userRegistrationMapper;
        $this->mailer                 = $mailer;
    }

    public function indexAction()
    {
        // if user log in
        if (null !== $this->user) {
            return $this->redirect()->toRoute('settings/default', ['action' => 'profile']);
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            // validate token
            $token = Csrf::valid($data['token']);

            // clear data
            array_walk_recursive($data, function (&$value) {
                $value = trim(strip_tags($value));
            });

            if ($token) {
                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $this->flashMessenger()->addMessage('Invalid Email');
                } else {
                    // check user exists
                    $userExists = $this->userService->userExists($data['email']);

                    if (!$userExists) {
                        return $this->redirect()->toRoute('zfcuser/register');
                    }

                    $user = $this->userService->getUserByEmail($data['email']);

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
            'token'          => Csrf::generate(),
            'flashMessenger' => $this->flashMessenger()->getMessages(),
        ]);
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
