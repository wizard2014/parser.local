<?php

namespace User\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\Event;
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
        $user = $e->getParam('user');

        // add message to flashMessenger
        $userEmail = $user->getEmail();

        $flashMessenger = new FlashMessenger();
        $flashMessenger->addMessage($userEmail . '|info', 'zfcuser-login-form');
    }
}
