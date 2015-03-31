<?php

class MYbinary extends MYAbstractDataType
{
    public function generateValue()
    {
        return "X'{$this->generateAlphaNums(mt_rand(1, 10))}'";
    }

}
