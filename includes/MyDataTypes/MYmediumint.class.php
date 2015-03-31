<?php

class MYmediumint extends MYint
{
    public function generateMyType()
    {
        if ($this->unsigned) {
            return mt_rand(0, 16777215);
        } else {
            return mt_rand(-8388608, 8388607);
        }
    }
}