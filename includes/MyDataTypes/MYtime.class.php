<?php

class MYtime extends MYAbstractDataType
{
    public function generateValue()
    {
        if ($this->extra == 'auto_increment') {
            return 'NULL';
        }

        if (in_array($this->key, array('PRI', 'UNI')) !== false) {
            $minus = '';
            if (strpos($this->maxValue, '-') === 0) {
                $minus = '-';
            }
            $timeArray = explode(':', $this->maxValue);

            $newTime = abs($timeArray[0]) * 3600 + $timeArray[1] * 60 + $timeArray[2] +
                ($minus ? -$this->rowNum : $this->rowNum);

            $hours = floor($newTime / 3600);
            $minutes = floor(($newTime % 3600) / 60);
            $seconds = ($newTime % 3600) % 60;

            return ($newTime >= 0 ? '' : '-') . $hours . ':' .
                sprintf('%02d', $minutes) . ':' . sprintf('%02d', $seconds);
        }

        return $this->generateMyType();
    }

    public function generateMyType()
    {
        return (mt_rand(0, 1) ? '' : '-') . sprintf('%02d', mt_rand(0, 838)) . ':' .
            sprintf('%02d', mt_rand(0, 59)) . ':' . sprintf('%02d', mt_rand(0, 59));
    }
}
