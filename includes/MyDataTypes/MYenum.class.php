<?php

class MYenum extends MYAbstractDataType
{
    public function generateValue()
    {
        return array_rand($this->params);
    }
}
