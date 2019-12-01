<?php

require_once "../src/db/db_base.php";

$db = new Db_Base(null, null, null, "root", "");

$tables = $db->show_tables();

$db->close();
