<?php

namespace User\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\Event;
use Zend\Http\PhpEnvironment\Request as PhpEnvironment;
use Zend\Http\Client;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class UserListener extends AbstractListenerAggregate
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedManager = $events->getSharedManager();

        $this->listeners[] = $sharedManager->attach(\ZfcUser\Service\User::class, 'register.post', [$this, 'onRegisterPost']);
    }

    /**
     * Set user timezone
     *
     * @param Event $e
     */
    public function onRegisterPost(Event $e)
    {
        $sm     = $e->getTarget()->getServiceManager();
        $em     = $sm->get('doctrine.entitymanager.orm_default');
        $user   = $e->getParam('user');
        $userId = $user->getId();

        $ip = $this->getUserIp();
        $timezone = (int)$this->getTimeZone($ip);

        $currentUser = $em->find(\User\Entity\UserStatus::class, $userId);
        $currentUser->setTimezone($timezone);

        $em->flush();

        // add message to flashMessenger
        $userEmail = $user->getEmail();

        $flashMessenger = new FlashMessenger();
        $flashMessenger->addMessage('Confirm your email (<strong>' . $userEmail . '</strong>). After you created your account we sent you a confirmation email. You need to check that out before you can sign in.');
    }

    /**
     * @param $ip
     *
     * @return string
     */
    protected function getTimeZone($ip) {
        $client = new Client('http://getcitydetails.geobytes.com/GetCityDetails?fqcn=' . $ip);

        $response = $client->send();
        $data     = json_decode($response->getBody(), true);

        return $data['geobytestimezone'];
    }

    /**
     * Get User IP
     *
     * @return string
     */
    private function getUserIp()
    {
        $environment = new PhpEnvironment();

        if (!empty($environment->getServer('HTTP_CLIENT_IP'))) {
            $ip = $environment->getServer('HTTP_CLIENT_IP');
        } elseif (!empty($environment->getServer('HTTP_X_FORWARDED_FOR'))) {
            // Check for the Proxy User
            $ip = $environment->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $environment->getServer('REMOTE_ADDR');
        }

        return $ip;
    }
}
