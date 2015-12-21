<?php

namespace User\Mapper;

interface UserStatusMapperInterface
{
    /**
     * @return \User\Entity\UserStatus
     */
    public function getUserStatusEntity();

    /**
     * @param \User\Entity\UserStatus $userStatusEntity
     */
    public function setUserStatusEntity($userStatusEntity);

    /**
     * @param $userId
     *
     * @return \DateTime
     */
    public function getMemberSince($userId);

    /**
     * @param $userId
     *
     * @return bool
     */
    public function isEmailSubscriber($userId);

    /**
     * @param $userId
     *
     * @return int
     */
    public function getQtyTotalFree($userId);

    /**
     * @param $userId
     *
     * @return int
     */
    public function getQtyTotalSubscriber($userId);

    /**
     * @param $userId
     *
     * @return int
     */
    public function getQtyTotal($userId);

    /**
     * Set email Subscriber
     *
     * @param $userId
     *
     * @return bool
     */
    public function subscribe($userId);

    /**
     * Unset email Subscriber
     *
     * @param $userId
     *
     * @return bool
     */
    public function unsubscribe($userId);

    /**
     * @param $userId
     *
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserInfo($userId);
}
