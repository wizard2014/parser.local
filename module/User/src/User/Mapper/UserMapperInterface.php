<?php

namespace User\Mapper;

interface UserMapperInterface
{
    /**
     * @return \User\Entity\User
     */
    public function getUserEntity();

    /**
     * @param \User\Entity\User $userEntity
     */
    public function setUserEntity($userEntity);

    /**
     * @param $userId
     *
     * @return \User\Entity\User
     */
    public function getUserById($userId);

    /**
     * @param $userEmail
     *
     * @return \ZfcUser\Entity\UserInterface
     */
    public function getUserByEmail($userEmail);

    /**
     * @param $userEmail
     *
     * @return bool
     */
    public function userExists($userEmail);
}
