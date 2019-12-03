<?php /** @noinspection PhpUnhandledExceptionInspection */

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
//        $this->_drop_user_and_tables();
        $this->_create_database();
        $this->_create_tables();

        $this->close();
    }

    private function _drop_user_and_tables() {
        // DO NOT USE. FOR DEVELOPMENT ONLY
        print("DROPping web_comic database and web_comic user. Hope you know what you're doing...\n");
        $this->execute("DROP DATABASE IF EXISTS web_comic");
        $this->execute("DROP USER IF EXISTS web_comic@localhost");
    }

    private function _create_database()
    {
        global $DB_HOST, $DB_NAME, $DB_USERNAME, $DB_PASSWORD;
        try {
            $version = $this->scalar("SELECT version FROM " . $DB_NAME . ".version;");
        } catch (MySqlException $e) {}
        if (isset($version) and $version >= 0) {
            print("Skipping _create_database...\n");
            $this->close();
            $this->_connect();
            return;
        }

        printf("Building %s database and creating %s user and version table...\n", $DB_NAME, $DB_USERNAME);
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
        $this->execute("INSERT IGNORE INTO version (version) VALUES (0);");
    }

    private function _create_tables()
    {
        if ($this->scalar("SELECT version FROM version;") >= 1) {
            print("Skipping _create_tables...\n");
            return;
        }

        print("Building tables...");
        $sql = "
        CREATE TABLE posts (
            post_id INT AUTO_INCREMENT PRIMARY KEY,
            name TEXT UNIQUE NOT NULL,
            post_date DATETIME UNIQUE NOT NULL DEFAULT NOW(),
            comic_page_path TEXT,
            alt_text TEXT,
            tags JSON NOT NULL DEFAULT '[]',
            text TEXT NOT NULL,
            created_ts DATETIME NOT NULL DEFAULT NOW(),
            updated_ts DATETIME NOT NULL DEFAULT NOW()
        );
        ";
        $this->execute($sql);

        $this->execute("UPDATE version SET version = 1;");
    }
}

$db_builder = new Db_Builder();
$db_builder->build();
