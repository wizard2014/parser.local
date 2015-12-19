<?php

namespace User\Service;

use User\Mapper\UserMapper;
use User\Mapper\UserStatusMapper;

class UserService
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
     * @param UserMapper       $userMapper
     * @param UserStatusMapper $userStatusMapper
     */
    public function __construct(
        UserMapper       $userMapper,
        UserStatusMapper $userStatusMapper
    ) {
        $this->userMapper       = $userMapper;
        $this->userStatusMapper = $userStatusMapper;
    }

    /**
     * @param $userId
     *
     * @return bool
     */
    public function getRedirectRule($userId)
    {
        $isFreeUser     = $this->userStatusMapper->isFreeSubUser($userId);
        $isActiveUser   = $this->userStatusMapper->isActiveUser($userId);

        if ($isFreeUser || !$isActiveUser) {
            return false;
        }

        return true;
    }

    public function getUserInfo($userId)
    {
        $memberSince = $this->userStatusMapper->getMemberSince($userId);

    }
}
