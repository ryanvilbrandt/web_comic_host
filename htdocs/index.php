<?php
require_once "../conf/comic_properties.php";
require_once "../src/utils.php";
require_once "../src/db/web_comic_db_reader.php";
require_once "templates/comic_page.php";
require_once "templates/missing_page.php";

$db = new WebComicDbReader();
$post_id = get($_REQUEST["id"], null);
$content = "";
try {
    if (is_null($post_id)) {
        $post_id = $db->get_last_page_id();
        $last_page_id = $post_id;
    }

    $post = $db->get_post_by_id($post_id);
    if (is_null($post)) {
        $content = missing_page($post_id);
    } else {
        $first_page_id = $db->get_first_page_id();
        var_dump(gettype($first_page_id));
        if (!isset($last_page_id))
            $last_page_id = $db->get_last_page_id();
        $previous_page_id = $db->get_previous_page_id($post["post_date"]);
        if (is_null($previous_page_id))
            $previous_page_id = $first_page_id;
        $next_page_id = $db->get_next_page_id($post["post_date"]);
        if (is_null($next_page_id))
            $next_page_id = $last_page_id;
        $content = comic_page($post, $first_page_id, $previous_page_id, $next_page_id, $last_page_id);
    }
} catch (MySqlException $e) {
    var_dump($e);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "templates/header.php"; ?>

<body>

<?php echo $content; ?>

</body>
</html>
