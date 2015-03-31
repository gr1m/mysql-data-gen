<?php

class MYdecimal extends MYint
{
    public function generateMyType()
    {
        if (isset($this->params[1]) && $this->params[1] > 0) {
            $decimal = $this->generateNums($this->params[0] - $this->params[1]) .
                '.' . $this->generateNums($this->params[1]);
        } else {
            $decimal = $this->generateNums($this->params[0]);
        }
        return $decimal;
    }
}