<?php

namespace User\Mapper;

interface RequestLogMapperInterface
{
    /**
     * @param       $subscriptionId
     * @param       $qtyRows
     * @param array $propertySet
     *
     * @return object
     */
    public function set($subscriptionId, $qtyRows, array $propertySet);
}
