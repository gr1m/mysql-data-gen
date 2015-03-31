<?php

abstract class MYAbstractDataType
{
    abstract function generateValue();

    protected $params;
    protected $unsigned;
    protected $null;
    protected $key;
    protected $default;
    protected $extra;
    protected $maxValue;
    protected $rowNum;

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    public function setUnsigned($unsigned)
    {
        $this->unsigned = $unsigned;
        return $this;
    }

    public function setNull($null)
    {
        $this->null = $null;
        return $this;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    public function setExtra($extra)
    {
        $this->extra = $extra;
        return $this;
    }

    public function setMaxValue($max)
    {
        $this->maxValue = $max;
        return $this;
    }

    public function setRowNum($num)
    {
        $this->rowNum = $num;
        return $this;
    }

    public function generateNums($length)
    {
        return $this->generateString($length, '01234567890');
    }

    public function generateAlphaNums($length)
    {
        return $this->generateString($length, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    }

    protected function generateString($length, $characters)
    {
        $charactersMaxIndex = strlen($characters) - 1;
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersMaxIndex)];
        }
        return $randomString;
    }

}
