<?php

namespace User\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\Event;
use Zend\Http\PhpEnvironment\Request as PhpEnvironment;

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

    public function onRegisterPost(Event $e)
    {
        $sm = $e->getTarget()->getServiceManager();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $ip = $this->getUserIp();

        // get locale
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
