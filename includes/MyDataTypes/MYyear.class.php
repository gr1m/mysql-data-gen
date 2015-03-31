<?php

class MYyear extends MYAbstractDataType
{
    public function generateValue()
    {
        if ($this->extra == 'auto_increment') {
            return 'NULL';
        }

        if (in_array($this->key, array('PRI', 'UNI')) !== false) {
            return $this->maxValue + $this->rowNum;
        }

        return $this->generateMyType();
    }

    public function generateMyType()
    {
        if (isset($this->params[0]) && $this->params[0] == 2) {
            return mt_rand(0, 99);
        }
        return mt_rand(1901, 2155);
    }
}
