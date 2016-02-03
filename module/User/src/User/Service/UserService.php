<?php

namespace User\Service;

use User\Mapper\UserMapper;
use User\Mapper\UserStatusMapper;
use User\Mapper\UserFileMapper;
use User\Mapper\SubscriptionMapper;
use User\Mapper\RequestLogMapper;

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
     * @var UserFileMapper
     */
    protected $userFileMapper;

    /**
     * @var SubscriptionMapper
     */
    protected $subscriptionMapper;

    /**
     * @var RequestLogMapper
     */
    protected $requestLogMapper;

    /**
     * UserService constructor.
     *
     * @param UserMapper         $userMapper
     * @param UserStatusMapper   $userStatusMapper
     * @param UserFileMapper     $userFileMapper
     * @param SubscriptionMapper $subscriptionMapper
     * @param RequestLogMapper   $requestLogMapper
     */
    public function __construct(
        UserMapper          $userMapper,
        UserStatusMapper    $userStatusMapper,
        UserFileMapper      $userFileMapper,
        SubscriptionMapper  $subscriptionMapper,
        RequestLogMapper    $requestLogMapper
    ) {
        $this->userMapper         = $userMapper;
        $this->userStatusMapper   = $userStatusMapper;
        $this->userFileMapper     = $userFileMapper;
        $this->subscriptionMapper = $subscriptionMapper;
        $this->requestLogMapper   = $requestLogMapper;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($id)
    {
        return $this->userMapper->getUserById($id);
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

        $userInfo['userInfo']              = $this->userStatusMapper->getUserInfo($userId);
        $userInfo['subInfo']['subScheme']  = $this->subscriptionMapper->getSubscriptionSchemeId($userId);
        $userInfo['subInfo']['subStatus']  = $this->subscriptionMapper->getSubscriptionStatusId($userId);

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

    /**
     * {@inheritdoc}
     */
    public function getEmail($userId)
    {
        return $this->userMapper->getUserEmail($userId);
    }

    /**
     * {@inheritdoc}
     */
    public function setRequestLog($subscriptionId, $qtyRows, array $propertySet)
    {
        return $this->requestLogMapper->set($subscriptionId, $qtyRows, $propertySet);
    }

    /**
     * {@inheritdoc}
     */
    public function userCheckout($userId)
    {
        $this->subscriptionMapper->userCheckout($userId);
    }

    /**
     * @param $userId
     * @param $vendor
     *
     * @return mixed
     */
    public function getActiveSubscription($userId, $vendor)
    {
        return $this->subscriptionMapper->getActiveSubscription($userId, $vendor);
    }

    /**
     * @param $userId
     *
     * @return array
     */
    public function getActiveSubscriptions($userId)
    {
        return $this->subscriptionMapper->getActiveSubscriptions($userId);
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function getBlockedSubscriptions($userId)
    {
        return $this->subscriptionMapper->getBlockedSubscriptions($userId);
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function getExpiredSubscriptions($userId)
    {
        return $this->subscriptionMapper->getExpiredSubscriptions($userId);
    }

    /**
     * @param $user
     * @param $dataSourceGlobal
     *
     * @return object
     */
    public function getUserFies($user, $dataSourceGlobal)
    {
        return $this->userFileMapper->getFies($user, $dataSourceGlobal);
    }

    /**
     * @param $user
     *
     * @return int
     */
    public function getNotDownloadedFilesCount($user)
    {
        return $this->userFileMapper->getNotDownloadedFilesCount($user);
    }

    /**
     * @param $user
     * @param $dataSourceGlobal
     * @param $path
     * @param $filename
     * @param $downloadedData
     *
     * @return object
     */
    public function saveFileData($user, $dataSourceGlobal, $path, $filename, $downloadedData)
    {
        return $this->userFileMapper->saveFileData($user, $dataSourceGlobal, $path, $filename, $downloadedData);
    }

    /**
     * @param $filePath
     * @param $filename
     *
     * @return array|null
     */
    public function getDownloadedData($filePath, $filename)
    {
        return $this->userFileMapper->getDownloadedData($filePath, $filename);
    }

    /**
     * @param $path
     * @param $filename
     *
     * @return object
     */
    public function increment($path, $filename)
    {
        return $this->userFileMapper->incrementFileCounter($path, $filename);
    }

    /**
     * @param $userEmail
     *
     * @return bool
     */
    public function userExists($userEmail)
    {
        return $this->userMapper->userExists($userEmail);
    }

    /**
     * @param $userEmail
     *
     * @return object|\ZfcUser\Entity\UserInterface
     */
    public function getUserByEmail($userEmail)
    {
        return $this->userMapper->getUserByEmail($userEmail);
    }
}
