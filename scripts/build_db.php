<?php

// Change current directory to the proper root
chdir("../htdocs");
require_once("../src/db/db_base.php");


class Db_Builder extends Db_Base
{

    public function __construct()
    {
        global $DB_ROOT_PASSWORD;
        parent::__construct(null, null, "", "root", $DB_ROOT_PASSWORD);
    }

    public function build()
    {
        $this->_create_database();

        $this->close();
    }

    private function _create_database()
    {
        global $DB_HOST, $DB_NAME, $DB_USERNAME, $DB_PASSWORD;
        $this->execute("CREATE DATABASE IF NOT EXISTS " . $DB_NAME . ";");
        $this->execute(
            "CREATE USER IF NOT EXISTS " . $DB_USERNAME . "@" . $DB_HOST . " IDENTIFIED BY ?;",
            array($DB_PASSWORD)
        );
        $this->execute(
            "GRANT ALL PRIVILEGES ON " . $DB_NAME . ".* TO ?@?;",
            array($DB_USERNAME, $DB_HOST)
        );
        // Close and reopen connection using connection information in config file.
        $this->close();
        $this->_connect();
        $this->execute("
        CREATE TABLE IF NOT EXISTS version (
            version INTEGER PRIMARY KEY
        );");
        $this->execute("INSERT INTO version (version) VALUES (0);");
    }
}

$db_builder = new Db_Builder();
$db_builder->build();
