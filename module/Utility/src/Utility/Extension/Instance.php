<?php

namespace Utility\Extension;
use Twig_Extension;

class Instance extends Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'instance';
    }

    /**
     * {@inheritdoc}
     */
    public function getTests()
    {
        return [
            new \Twig_SimpleTest('instanceof', [$this, 'isInstanceOf'])
        ];
    }

    /**
     * @param $object
     * @param $class
     *
     * @return bool
     */
    public function isInstanceOf($object, $class)
    {
        $reflectionClass = new \ReflectionClass($class);

        return $reflectionClass->isInstance($object);
    }
}