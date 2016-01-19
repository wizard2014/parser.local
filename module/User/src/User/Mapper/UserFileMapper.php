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
     * {@inheritdoc}
     */
    public function getFies($user, $dataSourceGlobal)
    {
        $result = [];

        $entity = $this->getUserFileEntity();

        $files = $this->em->getRepository($entity)->findBy([
            'user'             => $user,
            'dataSourceGlobal' => $dataSourceGlobal,
        ]);

        foreach ($files as $file) {
            $result[$file->getDataSourceGlobal()->getName()][] = [
                'filename'   => $file->getNameFile(),
                'path'       => $file->getPathFile(),
                'date'       => $file->getDateCreation()->format('M d, Y H:m'),
                'downloaded' => $file->getQtyDownloaded() > 0,
            ];
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotDownloadedFilesCount($user)
    {
        $entity = $this->getUserFileEntity();

        $qb = $this->em->createQueryBuilder();

        $qb->select('count(uf)')
            ->from($entity, 'uf')
            ->where('uf.user = :user')
            ->andWhere('uf.qtyDownloaded = :count')
            ->setParameter('user', $user)
            ->setParameter('count', 0);

        $count = $qb->getQuery()->getSingleScalarResult();

        return (int) $count;
    }

    /**
     * {@inheritdoc}
     */
    public function saveFileData(
        \User\Entity\User $user,
        \Utility\Entity\DataSourceGlobal $dataSourceGlobal,
        $path,
        $filename
    ) {
        $entity = $this->getUserFileEntity();
        $newFileData = new $entity();

        $newFileData->setUser($user);
        $newFileData->setDataSourceGlobal($dataSourceGlobal);
        $newFileData->setPathFile($path);
        $newFileData->setNameFile($filename);

        $this->persistFlush($newFileData);
    }

    /**
     * {@inheritdoc}
     */
    public function incrementFileCounter($filePath, $filename)
    {
        $entity = $this->getUserFileEntity();

        $file = $this->em->getRepository($entity)->findOneBy([
            'pathFile' => $filePath,
            'nameFile' => $filename
        ]);

        $newCount = $file->getQtyDownloaded() + 1;

        $file->setQtyDownloaded($newCount);

        $this->persistFlush($file);

        return $file;
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
