<?php
require_once "../conf/db_conf.php";
require_once "../src/utils.php";

class Db_Base {

    /**
     * @var PDO
     */
    protected $_pdo;

    public function __construct($host=null, $port=null, $dbname=null, $username=null, $password=null) {
        $this->_connect($host, $port, $dbname, $username, $password);
    }

    protected function _connect($host=null, $port=null, $dbname=null, $username=null, $password=null) {
        $connect_array = $this->_build_connection_string($host, $port, $dbname, $username, $password);
        $this->_pdo = new PDO($connect_array[0], $connect_array[1], $connect_array[2]);
    }

    private function _build_connection_string($host, $port, $dbname, $username, $password) {
        if (!isset($host)) {
            global $DB_HOST;
            $host = $DB_HOST;
        }
        if (!isset($port)) {
            global $DB_PORT;
            $port = $DB_PORT;
        }
        if (!isset($dbname)) {
            global $DB_NAME;
            $dbname = $DB_NAME;
        }
        if (!isset($username)) {
            global $DB_USERNAME;
            $username = $DB_USERNAME;
        }
        if (!isset($password)) {
            global $DB_PASSWORD;
            $password = $DB_PASSWORD;
        }
        $connect_string = 'mysql:';
        if (isset($host) and !empty($host))
            $connect_string .= 'host=' . $host . ';';
        if (isset($port) and !empty($port))
            $connect_string .= 'port=' . $port . ';';
        if (isset($dbname) and !empty($dbname))
            $connect_string .= 'dbname=' . $dbname . ';';
        return [$connect_string, $username, $password];
    }

    public function close() {
        $this->_pdo = null;
    }

    public function execute($sql, $params=null) {
        $query = $this->_pdo->prepare($sql);
        $query->execute($params);
        if ($query->errorInfo()[0] != 0)
            var_dump($query->errorInfo());
        return $query;
    }

    public function show_tables() {
        return $this->execute("show TABLES;")->fetchAll();
    }
}
