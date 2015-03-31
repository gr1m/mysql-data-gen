<?php

class MYblob extends MYAbstractDataType
{
    public function generateValue()
    {
        return "'{$this->generateNums(mt_rand(10,100))}'";
    }

}
