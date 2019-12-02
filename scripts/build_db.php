<?php

// Change current directory to the proper root
chdir("../htdocs");
require_once("../src/db/db_base.php");


class Db_Builder extends Db_Base {

    public function __construct($host = null, $port = null, $dbname = null, $username = null, $password = null)
    {
        parent::__construct($host, $port, $dbname, $username, $password);
    }

    public function build() {
        $this->_create_database();


        $this->close();
    }

    private function _create_database() {
        global $DB_NAME;
        $query = $this->_pdo->query("CREATE DATABASE IF NOT EXISTS web_comics;");
        $query->execute();
    }
}

$db_builder = new Db_Builder(null, null, "", "root", "");
$db_builder->build();
