<?php

namespace User\Mapper;

interface SubscriptionMapperInterface
{
    /**
     * @return \User\Entity\Subscription
     */
    public function getUserSubscription();

    /**
     * @param \User\Entity\Subscription $userSubscription
     */
    public function setUserSubscription($userSubscription);

    /**
     * @param $userId
     * @param $vendor
     *
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getActiveSubscription($userId, $vendor);

    /**
     * @param $id
     *
     * @return \DateTimeZone
     */
    public function getDateCreation($id);

    /**
     * @param $id
     *
     * @return \DateTimeZone
     */
    public function getDateActivation($id);

    /**
     * @param $id
     *
     * @return \DateTimeZone
     */
    public function getDateExpiration($id);

    /**
     * @param $id
     *
     * @return bool
     */
    public function getIsBlocked($id);

    /**
     * @param $id
     *
     * @return int
     */
    public function getRequestCounterTotal($id);

    /**
     * @param $id
     *
     * @return int
     */
    public function getRequestCounterDaily($id);

    /**
     * @param $id
     *
     * @return \DateTimeZone
     */
    public function getDateStartCounter($id);

    /**
     * @param $id
     *
     * @return int
     */
    public function getSubscriptionSchemeId($id);

    /**
     * @param $id
     *
     * @return int
     */
    public function getSubscriptionStatusId($id);

    /**
     * @param $id
     *
     * @return bool
     */
    public function isFreeSubUser($id);

    /**
     * @param $id
     *
     * @return bool
     */
    public function isActiveUser($id);
}
