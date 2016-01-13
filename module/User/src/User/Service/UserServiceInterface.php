<?php

namespace User\Service;

interface UserServiceInterface
{
    /**
     * @param $id
     *
     * @return object|\User\Entity\User
     */
    public function getUser($id);

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

    /**
     * @param $userId
     *
     * @return string
     */
    public function getEmail($userId);
}
