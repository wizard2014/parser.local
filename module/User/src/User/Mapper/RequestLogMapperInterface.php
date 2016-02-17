<?php

namespace User\Mapper;

interface RequestLogMapperInterface
{
    /**
     * @param       $subscriptionId
     * @param array $propertySet
     *
     * @return object
     */
    public function set($subscriptionId, array $propertySet);
}
