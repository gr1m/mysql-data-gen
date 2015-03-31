<?php

class App
{
    protected $stdin;
    protected $appDB;
    protected $dataDescription;
    protected $data;

    public function main()
    {
        $this->welcomeMessage()
            ->getDBAccess()
            ->getTable()
            ->processTable()
            ->generateData()
            ->insertData();
    }

    protected function welcomeMessage()
    {
        echo "This program will insert random data into MySQL table.\n";
        return $this;
    }

    protected function getDBAccess()
    {
        echo "Please, set DB credentials...\n";
        do {
            $handle = $this->getStdin();
            $this->appDB = $this->getAppDB();
            echo 'Hostname: ';
            $this->appDB->setDBHost(rtrim(fgets($handle), "\n"));
            echo 'Username: ';
            $this->appDB->setDBUser(rtrim(fgets($handle), "\n"));
            echo 'Password: ';
            $this->appDB->setDBPass(rtrim(fgets($handle), "\n"));
            echo 'DB name: ';
            $this->appDB->setDBName(rtrim(fgets($handle), "\n"));
        } while (!$this->appDB->createDBHandler());
        return $this;
    }

    protected function getStdin()
    {
        if (empty($this->stdin)) {
            $this->stdin = fopen("php://stdin", "r");
        }
        return $this->stdin;
    }

    protected function getAppDB()
    {
        if (empty($this->appDB)) {
            $this->appDB = new AppDB();
        }
        return $this->appDB;
    }

    protected function getTable()
    {
        $tables = $this->getAppDB()->getTables();
        $tablesTotal = count($tables);
        if ($tablesTotal) {
            echo "Tables found:\n";
            foreach ($tables as $k => $v) {
                echo "{$k} - {$v}\n";
            }
        } else {
            echo "No tables found :(\nExiting\n";
            exit;
        }
        do {
            echo 'Choose table # [0' .
                ($tablesTotal > 1 ? '-' . ($tablesTotal - 1) : '') . ']: ';
            $tableNum = rtrim(fgets($this->getStdin()), "\n");
        } while (!is_numeric($tableNum) || intval($tableNum) < 0 || intval($tableNum) >= count($tables));
        echo "Chosen table: {$tables[intval($tableNum)]}\n";
        $this->getAppDB()->setTableName($tables[intval($tableNum)]);
        return $this;
    }

    protected function processTable()
    {
        $this->dataDescription = $this->getAppDB()
            ->getDataDescription();
        echo "Table fields:\n";
        foreach ($this->dataDescription as $k => $v) {
            echo "   {$k} -> {$v['type']}, " .
                ($v['null'] ? 'NULL' : 'NOT NULL') .
                ($v['default'] ? ", default value: {$v['default']}" : '') .
                ($v['key'] ? ", key: {$v['key']}" : '') .
                ($v['extra'] ? ", extra: {$v['extra']}" : '') . "\n";
        }
        return $this;
    }

    protected function generateData()
    {
        do {
            echo 'How many rows to generate: ';
            $rows = rtrim(fgets($this->getStdin()), "\n");
        } while (intval($rows) <= 0);

        $data = array();
        for ($i = 1; $i <= intval($rows); $i++) {
            echo "Row #{$i} :\n";
            foreach ($this->dataDescription as $k => $v) {
                $element = new $v['genClass']();
                $element->setParams($v['genParams'])
                    ->setUnsigned($v['unsigned'])
                    ->setNull($v['null'])
                    ->setKey($v['key'])
                    ->setDefault($v['default'])
                    ->setExtra($v['extra'])
                    ->setMaxValue($v['maxValue'])
                    ->setRowNum($i);
                $data[$i][$k] = $element->generateValue();
                echo "   $k -> {$data[$i][$k]}\n";
            }
        }
        $this->data = $data;
        return $this;
    }

    protected function insertData()
    {
        echo 'Type YES if you want to insert data: ';
        $yes = rtrim(fgets($this->getStdin()), "\n");
        if (strtoupper($yes) == 'YES') {
            $this->getAppDB()->insertData($this->data);
        }
    }
}
