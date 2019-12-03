<?php

require_once "navigation_buttons.php";

function comic_page($post, $first_page_id, $previous_page_id, $next_page_id, $last_page_id)
{
    $navigation_html = navigation_buttons($first_page_id, $previous_page_id, $next_page_id, $last_page_id);
    return <<<TEXT
<h1>{$post["name"]}</h1>

<em>{$post["post_date"]}</em>

$navigation_html

<p><img src="{$post["comic_page_path"]}" alt="{$post["alt_text"]}"></p>

$navigation_html
TEXT;
}
