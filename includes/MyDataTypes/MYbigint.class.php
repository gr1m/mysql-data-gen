<?php

class MYbigint extends MYint
{
    public function generateMyType()
    {
        if ($this->unsigned) {
            return mt_rand(0, 1844674) . mt_rand(0, 4073709) . mt_rand(0, 551615);
        } else {
            return (mt_rand(0, 1) ? '' : '-') .
                mt_rand(0, 922337) .
                mt_rand(0, 2036854) .
                mt_rand(0, 775807);
        }
    }
}