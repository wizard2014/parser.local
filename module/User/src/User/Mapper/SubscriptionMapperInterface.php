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
     *
     * @return \DateTimeZone
     */
    public function getDateCreation($userId);

    /**
     * @param $userId
     *
     * @return \DateTimeZone
     */
    public function getDateActivation($userId);

    /**
     * @param $userId
     *
     * @return \DateTimeZone
     */
    public function getDateExpiration($userId);

    /**
     * @param $userId
     *
     * @return bool
     */
    public function getIsBlocked($userId);

    /**
     * @param $userId
     *
     * @return int
     */
    public function getRequestCounterTotal($userId);

    /**
     * @param $userId
     *
     * @return int
     */
    public function getRequestCounterDaily($userId);

    /**
     * @param $userId
     *
     * @return \DateTimeZone
     */
    public function getDateStartCounter($userId);

    /**
     * @param $userId
     *
     * @return int
     */
    public function getSubscriptionSchemeId($userId);

    /**
     * @param $userId
     *
     * @return int
     */
    public function getSubscriptionStatusId($userId);

    /**
     * @param $userId
     *
     * @return bool
     */
    public function isFreeSubUser($userId);

    /**
     * @param $userId
     *
     * @return bool
     */
    public function isActiveUser($userId);
}
