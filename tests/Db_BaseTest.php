<?php

use PHPUnit\Framework\TestCase;
require_once "../src/db/db_base.php";

class Db_BaseTest extends TestCase
{

    /**
     * @var Db_Base
     */
    private static $db;

    public static function setUpBeforeClass(): void
    {
        self::$db = new Db_Base(null, null, null, null, null, false);

        self::$db->execute("TRUNCATE posts;");

        $sql = "INSERT INTO 
            posts (name, post_date, comic_page_path, tags, text)
        VALUES 
            ('Page 197', '2019-11-13 00:00:00', 'static/img/Page-197.png', '[\"comic\"]', 'Blog post 1'),
            ('Page 193', '2019-11-10 00:00:00', 'static/img/Page-193.png', '[\"comic\"]', 'Blog post 4');
        ";
        self::$db->execute($sql);
    }

    public static function tearDownAfterClass(): void
    {
        self::$db->rollback();
        self::$db->close();
    }

    public function testScalar()
    {
        $result = self::$db->scalar("SELECT post_id FROM posts WHERE name=?;", array('s', "Page 193"));
        $this->assertSame(2, $result);
    }

    public function testFetch()
    {
        $expected = array(
            0 => 2,
            "post_id" => 2,
            1 => "Page 193",
            "name" => "Page 193"
        );
        $result = self::$db->fetch("SELECT post_id, name FROM posts WHERE name=?;", array('s', "Page 193"));
        $this->assertSame($expected, $result);
    }

    public function testFetch_all()
    {
        $expected = array(
            array(
                0 => 1,
                "post_id" => 1,
                1 => "Page 197",
                "name" => "Page 197"
            ),
            array(
                0 => 2,
                "post_id" => 2,
                1 => "Page 193",
                "name" => "Page 193"
            ),
        );
        $result = self::$db->fetch_all("SELECT post_id, name FROM posts;");
        $this->assertSame($expected, $result);
    }
}
