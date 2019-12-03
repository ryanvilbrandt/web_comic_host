<?php
require_once "../conf/db_conf.php";
require_once "../src/utils.php";

class Db_Base
{

    /**
     * @var mysqli
     */
    protected $_mysqli;
    private $throw_exceptions = false;

    public function __construct($host = null, $port = null, $dbname = null, $username = null, $password = null,
                                $autocommit = true, $throw_exceptions = true)
    {
        $this->throw_exceptions = $throw_exceptions;
        $this->_connect($host, $port, $dbname, $username, $password, $autocommit);
    }

    protected function _connect($host = null, $port = null, $dbname = null, $username = null, $password = null,
                                $autocommit = true)
    {
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
        $this->_mysqli = new mysqli($host, $username, $password, $dbname, $port);
        $this->_mysqli->autocommit($autocommit);
    }

    public function commit() {
        $this->_mysqli->commit();
    }

    public function rollback() {
        $this->_mysqli->rollback();
    }

    public function close()
    {
        $this->_mysqli->close();
    }

    /**
     * @param $sql
     * @param null $params
     * @return false|mysqli_stmt
     * @throws MySqlException
     */
    public function execute($sql, $params = null)
    {
        $query = $this->_mysqli->prepare($sql);
        if (!is_null($params))
            $query->bind_param(...$params);
        $query->execute();
        if ($query->errno != 0) {
            if ($this->throw_exceptions) {
                throw new MySqlException($query->error);
            } else {
                var_export($query->error_list);
            }
        }
        return $query;
    }

    /**
     * @param $sql
     * @param null $params
     * @return mixed
     * @throws MySqlException
     */
    public function scalar($sql, $params = null)
    {
        return $this->execute($sql, $params)->get_result()->fetch_row()[0];
    }

    /**
     * @param $sql
     * @param null $params
     * @return array
     * @throws MySqlException
     */
    public function fetch($sql, $params = null)
    {
        return $this->execute($sql, $params)->get_result()->fetch_array();
    }

    /**
     * @param $sql
     * @param null $params
     * @return array
     * @throws MySqlException
     */
    public function fetch_all($sql, $params = null)
    {
        $result = $this->execute($sql, $params)->get_result();
        $arr = array();
        for ($i = 0; $i < $result->num_rows; $i++) {
            array_push($arr, $result->fetch_array());
        }
        return $arr;
    }

    /**
     * @return array
     * @throws MySqlException
     */
    public function show_tables()
    {
        return $this->fetch_all("show TABLES;");
    }
}


class MySqlException extends Exception
{
}
