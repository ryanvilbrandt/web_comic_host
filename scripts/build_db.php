<?php

// Change current directory to the proper root
chdir("../htdocs");
require_once("../src/db/db_base.php");


class Db_Builder extends Db_Base
{

    public function __construct($host = null, $port = null, $dbname = null, $username = null, $password = null)
    {
        parent::__construct($host, $port, $dbname, $username, $password);
//        $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
    }

    public function build()
    {
        $this->_create_database();

        $this->close();
    }

    private function _create_database()
    {
        global $DB_NAME;
//        $sql = "
//            CREATE DATABASE IF NOT EXISTS :dbname;
//            CREATE TABLE IF NOT EXISTS version (
//            version INTEGER PRIMARY KEY
//            );
//            INSERT INTO version (version) VALUES (0) ON CONFLICT DO NOTHING;
//        ";
//        $this->execute($sql, array(":dbname" => $DB_NAME));
        $sql = "CREATE DATABASE IF NOT EXISTS :dbname;";
        $this->execute($sql, array(":dbname" => $DB_NAME));
    }
}

$db_builder = new Db_Builder(null, null, "", "root", "");
$db_builder->build();
