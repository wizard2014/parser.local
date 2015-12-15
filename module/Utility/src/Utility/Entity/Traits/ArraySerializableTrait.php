<?php

namespace Utility\Entity\Traits;

trait ArraySerializableTrait
{
    /**
     * @param array $array
     */
    public function exchangeArray(array $array)
    {
        foreach ($array as $key => $val) {
            $this->$key = $val;
        }
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
