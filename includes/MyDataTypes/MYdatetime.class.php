<?php

class MYdatetime extends MYdate
{
    public function generateValue()
    {
        if ($this->extra == 'auto_increment') {
            return 'NULL';
        }

        if (in_array($this->key, array('PRI', 'UNI')) !== false) {
            $date = new DateTime($this->maxValue);
            $date->add(new DateInterval("P{$this->rowNum}S"));
            return $date->format('Y-m-d H:i:s');;
        }

        return rtrim($this->generateMyType(), "'") . ' ' .
            sprintf("%02d", mt_rand(0, 23)) . ':' .
            sprintf("%02d", mt_rand(0, 59)) . ':' .
            sprintf("%02d", mt_rand(0, 59)) . "'";
    }
}
