<?php

namespace Utility\Mapper;

use Doctrine\ORM\EntityManagerInterface;

class AttributeValueMapper
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var \Utility\Entity\AttributeValue
     */
    protected $attributeValueEntity = \Utility\Entity\AttributeValue::class;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Utility\Entity\AttributeValue
     */
    public function getAttributeValueEntity()
    {
        return $this->attributeValueEntity;
    }

    /**
     * @param \Utility\Entity\AttributeValue $attributeValueEntity
     */
    public function setAttributeValueEntity($attributeValueEntity)
    {
        $this->attributeValueEntity = $attributeValueEntity;
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function getAttributeValueById($id)
    {
        $entity = $this->getAttributeValueEntity();

        $qb = $this->em->createQueryBuilder();

        $qb
            ->select('av')
            ->from($entity, 'av')
            ->where('av.id = ?1')
            ->setParameter(1, $id);

        $qs = $qb->getQuery()->getArrayResult()[0];

        return $qs['attributeValue'];
    }

    /**
     * @param $entity
     */
    public function persist($entity)
    {
        $this->em->persist($entity);
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
