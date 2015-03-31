<?php

class MYbit extends MYAbstractDataType
{
    public function generateValue()
    {
        if ($this->extra == 'auto_increment') {
            return 'NULL';
        }

        if (in_array($this->key, array('PRI', 'UNI')) !== false) {
            return decbin(bindec($this->maxValue) + $this->rowNum);
        }

        return $this->generateMyType();
    }

    public function generateMyType()
    {
        $max = bindec($this->generateString($this->params[0], '1'));
        return decbin(mt_rand(0, $max));
    }
}
