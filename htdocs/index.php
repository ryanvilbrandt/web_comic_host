<?php
require_once "../conf/comic_properties.php";
require_once "../src/utils.php";

$page_list = [1575231000, 1575232000, 1575233000, 1575234000, 1575235000];
//dump($_REQUEST);
$page_num = get($_REQUEST["page"], 1575235000);
$page_index = array_search($page_num, $page_list);
$first_page = $page_list[0];
$last_page = $page_list[count($page_list) - 1];
$previous_page = $page_index === 0 ? $first_page : $page_list[$page_index - 1];
$next_page = ($page_index < count($page_list) - 1) ? $page_list[$page_index + 1] : $last_page;
//dump($page_num, $page_index, $first_page, $previous_page, $next_page, $last_page);
?>
<!DOCTYPE html>
<html lang="en">
<?php include "templates/header.php"; ?>

<body>

<?php
$image_path = "static/img/" . $page_num . ".png";

echo '<h1>Comic for ' . epoch_to_date($page_num) . '</h1>

<p><img src="' . $image_path . '" alt="Comic page"></p>

<p><a href="index.php?page=' . $first_page . '">&lt;&lt;</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="index.php?page=' . $previous_page . '">&lt;</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="index.php?page=' . $next_page . '">&gt;</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="index.php?page=' . $last_page . '">&gt;&gt;</a>'
?>


</body>
</html>
