<?php

// Change current directory to the proper root
chdir("../htdocs");
require_once("../src/db/db_base.php");

$db = new Db_Base();

$db->execute("DELETE FROM posts WHERE TRUE;");

$sql = "INSERT INTO 
    posts (name, post_date, comic_page_path, tags, text)
VALUES 
    ('Page 197', '2019-11-13 00:00:00', 'static/img/Page-197', '[\"comic\"]', 'Blog post 1'),
    ('Page 195', '2019-11-11 12:00:00', 'static/img/Page-195', '[\"comic\"]', 'Blog post 1'),
    ('Page 196', '2019-11-12 00:00:00', 'static/img/Page-196', '[\"comic\"]', 'Blog post 1'),
    ('Page 193', '2019-11-10 00:00:00', 'static/img/Page-193', '[\"comic\"]', 'Blog post 1'),
    ('Page 194', '2019-11-11 00:00:00', 'static/img/Page-194', '[\"comic\"]', 'Blog post 1');
";
$db->execute($sql);
