<?php

require_once "db_base.php";

class WebComicDbReader extends Db_Base {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $post_id
     * @return int
     * @throws MySqlException
     */
    public function get_post_by_id($post_id) {
        return $this->fetch("SELECT * FROM posts WHERE post_id = ?", array($post_id));
    }

    /**
     * @return int
     * @throws MySqlException
     */
    public function get_first_page_id() {
        return $this->scalar("SELECT CAST(post_id AS INT) FROM posts ORDER BY post_date LIMIT 1");
    }

    /**
     * @return int
     * @throws MySqlException
     */
    public function get_last_page_id() {
        return $this->scalar("SELECT post_id FROM posts ORDER BY post_date DESC LIMIT 1");
    }

    /**
     * Returns null if there are no pages earlier.
     * @param $datetime
     * @return int
     * @throws MySqlException
     */
    public function get_previous_page_id($datetime) {
//        $sql = "COALESCE(
//            (SELECT post_id FROM posts WHERE post_date < ? ORDER BY post_date LIMIT 1),
//            (SELECT post_id FROM posts ORDER BY post_date LIMIT 1)
//        )";
        $sql = "SELECT post_id FROM posts WHERE post_date < ? ORDER BY post_date LIMIT 1;";
        return $this->scalar($sql, array($datetime));
    }

    /**
     * Returns null if there are no pages later.
     * @param $datetime
     * @return int
     * @throws MySqlException
     */
    public function get_next_page_id($datetime) {
        $sql = "SELECT post_id FROM posts WHERE post_date > ? ORDER BY post_date DESC LIMIT 1;";
        return $this->scalar($sql, array($datetime));
    }
}
