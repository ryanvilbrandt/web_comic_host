<?php

function href_link($url, $text) {
    return "<a href=\"index.php?id=$url\">$text</a>";
}

function navigation_buttons($first_page_id, $previous_page_id, $next_page_id, $last_page_id)
{
    $first_text = htmlspecialchars("<<");
    $previous_text = htmlspecialchars("<");
    $next_text = htmlspecialchars(">");
    $last_text = htmlspecialchars(">>");
    $spacer = htmlspecialchars("    ");
    dump($first_page_id, $previous_page_id, $next_page_id, $last_page_id);
    $output = "<p>\n";
    if ($first_page_id == $previous_page_id) {
        $output .= $first_text . $spacer . $previous_text;
    } else {
        $output .= href_link($first_page_id, $first_text) . $spacer . href_link($previous_page_id, $previous_text);
    }
    $output .= $spacer;
    if ($next_page_id == $last_page_id) {
        $output .= $next_text . $spacer . $last_text;
    } else {
        $output .= href_link($next_page_id, $next_text) . $spacer . href_link($last_page_id, $last_text);
    }
    $output .= "</p>";
    return $output;
}