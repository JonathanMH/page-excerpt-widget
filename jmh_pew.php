<?php
/*
	Plugin Name: Page Excerpt Widget
	Plugin URI: http://jonathanmh.com/blog/117-wordpress-page-excerpt-widget
	Description: Plugin for displaying a page excerpt in a widget area
	Author: Jonathan M. Hethey
	Version: 0.1
	Author URI: http://jonathanmh.com
*/

function jmh_pew_trim($text, $length) {
	// if the text is longer than the length it is supposed to be
	if (strlen($text) > $length){
		// trim to length
		$text = substr($text, 0, $length);
		// find last whitespace in string
		$last_whitespace = strrpos($text, ' ');
		// trim to last whitespace in string
		$text = substr($text, 0, $last_whitespace);
		// append dots
		$text .=' [...]';
		return $text;
	}
	// if the text is shorter than the trim limit, pass it on
	else {
		return $text;
	}
};


function jmh_pew_output($page_id) {
	$trim_at = get_option('jmh_pew_page_excerpt_length');
	$page_data = get_page($page_id);
	// remove html tags from output
	$content = strip_tags($page_data->post_content);
	// call trim function
	$content = jmh_pew_trim($content,$trim_at);
	$title = $page_data->post_title;
	$link = get_permalink($page_id);
	$trimmed_page = array(
		'title' => $page_data->post_title,
		'content' => $content,
		'link' => $link
	);
	return $trimmed_page;
}

function jmh_pew_widget_control(){
	// include file for the options area
	include('jmh_pew_admin.php');
}

function jmh_pew_widget() {
$page_id = get_option('jmh_pew_page_id');
$trimmed_page = jmh_pew_output($page_id);
//
echo $before_widget;
//
echo $before_title;
//
$link_title = get_option('jmh_pew_link_title');
if($link_title == 'Yes'){
	// output title with link
	echo '<h1 class="jmh_pew_title"><a href="'.$trimmed_page['link'].'">'.$trimmed_page['title'].'</a></h1>';
}
else{
	// output title without link
	echo '<h1 class="jmh_pew_title">'.$trimmed_page['title'].'</h1>';
}
//
echo $after_title;

echo '<p class="jmh_pew_content">'.$trimmed_page['content'].'</p>';

if (get_option('jmh_pew_append_link') == 'Yes'){
	$link_label = get_option('jmh_pew_link_label');
	if (!$link_label > 0){
		// if no link_label specified, set default
		$link_label = 'Read Page';
	}
	echo '<a class="jmh_pew_readmore" href="'.$trimmed_page['link'].'">'.$link_label.'</a>';
}
else {
	// do nothing
}
//
echo $after_widget;
}
	register_sidebar_widget('Page Excerpt Widget',
	'jmh_pew_widget');
	register_widget_control('Page Excerpt Widget',
	'jmh_pew_widget_control', 300, 200 ); 
?>
