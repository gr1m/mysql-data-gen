<?php

class MYsmallint extends MYint
{
    public function generateMyType()
    {
        if ($this->unsigned) {
            return mt_rand(0, 65535);
        } else {
            return mt_rand(-32768, 32767);
        }
    }
}
