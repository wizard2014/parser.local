<?php

namespace User\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class RequestLogMapper implements RequestLogMapperInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \User\Entity\RequestLog
     */
    protected $requestLog = \User\Entity\RequestLog::class;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \User\Entity\RequestLog
     */
    public function getRequestLog()
    {
        return $this->requestLog;
    }

    /**
     * @param \User\Entity\RequestLog $requestLog
     */
    public function setRequestLog($requestLog)
    {
        $this->requestLog = $requestLog;
    }

    /**
     * {@inheritdoc}
     */
    public function set($subscriptionId, array $propertySet)
    {
        $entity = $this->getRequestLog();

        $requestLog = new $entity();
        $requestLog->setSubscription($subscriptionId);
        $requestLog->setPropertySet($propertySet);

        $this->persistFlush($requestLog);

        return $requestLog;
    }

    /**
     * flush
     */
    public function flush()
    {
        $this->em->flush();
    }

    /**
     * @param $entity
     *
     * @return mixed
     */
    public function persistFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
     * @param $entity
     */
    public function remove($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}
