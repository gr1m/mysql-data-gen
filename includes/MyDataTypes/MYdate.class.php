<?php

class MYdate extends MYAbstractDataType
{
    public function generateValue()
    {
        if ($this->extra == 'auto_increment') {
            return 'NULL';
        }

        if (in_array($this->key, array('PRI', 'UNI')) !== false) {
            $date = new DateTime($this->maxValue);
            $date->add(new DateInterval("P{$this->rowNum}D"));
            return "'{$date->format('Y-m-d')}'";
        }

        return $this->generateMyType();
    }

    public function generateMyType()
    {
        return "'" . mt_rand(1000, 9999) . '-' .
            sprintf("%02d", mt_rand(1, 12)) . '-' .
            sprintf("%02d", mt_rand(1, 21)) . "'";
    }
}
