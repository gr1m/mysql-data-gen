<?php

class MYtimestamp extends MYAbstractDataType
{
    public function generateValue()
    {
        if ($this->extra == 'auto_increment') {
            return 'NULL';
        }

        if (in_array($this->key, array('PRI', 'UNI')) !== false) {
            return date('Y-m-d H:i:s', strtotime($this->maxValue) + $this->rowNum);
        }

        return $this->generateMyType();
    }

    public function generateMyType()
    {
        return date('Y-m-d H:i:s', mt_rand(0, 2147483647));
    }
}
