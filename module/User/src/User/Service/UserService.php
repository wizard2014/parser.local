<?php

namespace User\Service;

use User\Mapper\UserMapper;
use User\Mapper\UserStatusMapper;
use User\Mapper\SubscriptionMapper;

class UserService implements UserServiceInterface
{
    /**
     * @var UserMapper
     */
    protected $userMapper;

    /**
     * @var UserMapper
     */
    protected $userStatusMapper;

    /**
     * @var SubscriptionMapper
     */
    protected $subscriptionMapper;

    /**
     * @param UserMapper         $userMapper
     * @param UserStatusMapper   $userStatusMapper
     * @param SubscriptionMapper $subscriptionMapper
     */
    public function __construct(
        UserMapper          $userMapper,
        UserStatusMapper    $userStatusMapper,
        SubscriptionMapper  $subscriptionMapper
    ) {
        $this->userMapper         = $userMapper;
        $this->userStatusMapper   = $userStatusMapper;
        $this->subscriptionMapper = $subscriptionMapper;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectRule($userId)
    {
        $isFreeUser     = $this->subscriptionMapper->isFreeSubUser($userId);
        $isActiveUser   = $this->subscriptionMapper->isActiveUser($userId);

        if ($isFreeUser || !$isActiveUser) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserInfo($userId)
    {
        $userInfo = [];

        $userInfo['user']                   = $this->userStatusMapper->getUserInfo($userId);
        $userInfo['subscr']['subSchemeId']  = $this->subscriptionMapper->getSubscriptionSchemeId($userId);
        $userInfo['subscr']['subStatusId']  = $this->subscriptionMapper->getSubscriptionStatusId($userId);

        return $userInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmailSubscriber($userId)
    {
        return $this->userStatusMapper->isEmailSubscriber($userId);
    }

    /**
     * {@inheritdoc}
     */
    public function changeSubscription($userId, $isEmailSubscriber)
    {
        if ($isEmailSubscriber) {
            $this->userStatusMapper->unsubscribe($userId);
        } else {
            $this->userStatusMapper->subscribe($userId);
        }
    }
}
