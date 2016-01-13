<?php

namespace User\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class UserFileMapper implements UserFileMapperInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \User\Entity\UserFile
     */
    protected $userFileEntity = \User\Entity\UserFile::class;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \User\Entity\UserFile
     */
    public function getUserFileEntity()
    {
        return $this->userFileEntity;
    }

    /**
     * @param \User\Entity\UserFile $userFileEntity
     */
    public function setUserFileEntity($userFileEntity)
    {
        $this->userFileEntity = $userFileEntity;
    }

    /**
     * @param $user
     * @param $dataSourceGlobal
     *
     * @return object
     */
    public function getFies($user, $dataSourceGlobal)
    {
        $entity = $this->getUserFileEntity();

        $files = $this->em->getRepository($entity)->find([
            'user' => $user,
            'dataSourceGlobal' => $dataSourceGlobal
        ]);

        return $files;
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
