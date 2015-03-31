<?php

class MYint extends MYAbstractDataType
{
    public function generateValue()
    {
        if ($this->extra == 'auto_increment') {
            return 'NULL';
        }

        if (in_array($this->key, array('PRI', 'UNI')) !== false) {
            return ($this->maxValue + $this->rowNum);
        }

        return $this->generateMyType();
    }

    public function generateMyType()
    {
        if ($this->unsigned) {
            return mt_rand(0, 42949) . mt_rand(0, 67295);
        } else {
            return (mt_rand(0, 1) ? '' : '-') . mt_rand(0, 2147483647);
        }
    }
}
