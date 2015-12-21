<?php

namespace User\Service;

interface UserServiceInterface
{
    /**
     * @param $userId
     *
     * @return bool
     */
    public function getRedirectRule($userId);

    /**
     * @param $userId
     *
     * @return array
     */
    public function getUserInfo($userId);

    /**
     * @param $userId
     *
     * @return bool
     */
    public function isEmailSubscriber($userId);

    /**
     * @param $userId
     * @param $isEmailSubscriber
     */
    public function changeSubscription($userId, $isEmailSubscriber);
}
