<?php

class AppDB {

    protected $dbHost;
    protected $dbUser;
    protected $dbPass;
    protected $dbName;
    protected $dbHandler;
    protected $tableName;
    protected $dataDescription;


    public function setDBHost ($str) {
        $this->dbHost = $str;
        return $this;
    }

    public function setDBUser ($str) {
        $this->dbUser = $str;
        return $this;
    }

    public function setDBPass ($str) {
        $this->dbPass = $str;
        return $this;
    }

    public function setDBName ($str) {
        $this->dbName = $str;
        return $this;
    }

    public function setTableName ($str) {
        $this->tableName = $str;
        return $this;
    }

    public function createDBHandler () {
        if (!$this->dbHost || !$this->dbName) {
            echo "Host and DB name are required!\n";
            return false;
        }
        try {
            $this->dbHandler = new PDO("mysql:host={$this->dbHost};dbname={$this->dbName};charset=utf8",
                $this->dbUser,
                $this->dbPass);
            $this->dbHandler->query('SELECT 123');
        } catch (PDOException $e) {
            echo "Fail to connect\n";
            return false;
        }
        return true;
    }

    public function getDBHandler(){
        if (empty($this->dbHandler)) {
            $this->createDBHandler();
        }
        return $this->dbHandler;
    }

    public function getTables() {
        $response = $this->getDBHandler()->query('SHOW TABLES')->fetchALL(PDO::FETCH_NUM);
        $tables = array();
        foreach ($response as $k => $row) {
            $tables[] = $row[0];
        }
        return $tables;
    }

    public function getDataDescription() {
        $fields = $this->getDBHandler()->query("DESCRIBE {$this->tableName}")->fetchAll(PDO::FETCH_ASSOC);
        $totalRows = $this->getDBHandler()->query("SELECT count(*) FROM {$this->tableName}")->fetch(PDO::FETCH_NUM);
        echo "Total Rows: {$totalRows[0]}\n";
        $data = array();
        foreach ($fields as $field) {
            $type = array();
            $genParams = array();
            preg_match('/^([^\(]+)\(?([^\)]+)?\)?\s?(unsigned)?$/', $field['Type'], $type);
            $genParams = isset($type[2]) ? explode(',', $type[2]) : '';
            $unsigned = false;
            if (isset($type[3]) && $type[3] == 'unsigned') {
                $unsigned = true;
            }
            $maxValue = $this->getDBHandler()
                ->query("SELECT {$field['Field']} FROM {$this->tableName} ORDER BY {$field['Field']} DESC")
                ->fetch(PDO::FETCH_NUM);
            $data['`'.$field['Field'].'`'] = array(
                'type'      => $field['Type'],
                'genClass'  => 'MY' . $type[1],
                'genParams' => $genParams,
                'unsigned'  => $unsigned,
                'null'      => $field['Null'] == 'YES',
                'key'       => $field['Key'],
                'default'   => $field['Default'],
                'extra'     => $field['Extra'],
                'maxValue'  => $maxValue[0],
            );
        }
        $this->dataDescription = $data;
        return $data;
    }

    public function insertData($data) {
        foreach ($data as $row) {
            $fields = implode(',', array_keys($row));
            $values = implode(',', array_values($row));
            $this->getDBHandler()
                ->query("INSERT INTO {$this->tableName} ({$fields}) VALUES ({$values})");
        }

    }
}