<?php

class MYtinyint extends MYint
{
    public function generateMyType()
    {
        if ($this->unsigned) {
            return mt_rand(0, 255);
        } else {
            return mt_rand(-128, 127);
        }
    }
}
