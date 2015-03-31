<?php

class MYchar extends MYAbstractDataType
{
    public function generateValue()
    {
        if (in_array($this->key, array('PRI', 'UNI')) !== false) {
            for ($i = 0; $i < $this->rowNum; $i++) {
                ++$this->maxValue;
            }
            return "'{$this->maxValue}'";
        }

        return $this->generateMyType();
    }

    public function generateMyType()
    {
        return "'{$this->generateAlphaNums(mt_rand(1, $this->params[0]))}'";
    }
}
