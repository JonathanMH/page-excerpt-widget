<?php
/*
	Plugin Name: Page Excerpt Widget
	Plugin URI: http://jonathanmh.com/blog/117-wordpress-page-excerpt-widget
	Description: Plugin for displaying a page excerpt in a widget area
	Author: Jonathan M. Hethey
	Version: 0.2
	Author URI: http://jonathanmh.com
*/

global $wp_version;
if((float)$wp_version >= 2.8){
class PageExcerptWidget extends WP_Widget {

	/*
	* construct
	*/
	
	function PageExcerptWidget() {
		parent::WP_Widget(
			'PageExcerptWidget'
			, 'Page Excerpt Widget'
			, array(
				'description' => 'Display Excerpt of Page in any Widget Area'
			)
		);
	}
	
	function pew_trim($text, $length) {
		// if the text is longer than the length it is supposed to be
		if (strlen($text) > $length){
			// trim to length
			$text = substr($text, 0, $length);
			// find last whitespace in string
			$last_whitespace = strrpos($text, ' ');
			// trim to last whitespace in string
			$text = substr($text, 0, $last_whitespace);
			// append dots
			//$text .=' [...]';
			return $text;
		}
		// if the text is shorter than the trim limit, pass it on
		else {
			return $text;
		}
	}
	
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$page_data = get_page($instance['page_id']);
		
		
		
		
		$title = $page_data->post_title;
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		};
		echo $this->pew_trim($page_data->post_content, $instance['excerpt_length']);
			
		echo '<pre>';
		print_r($page_data);
		echo '</pre>';
		echo $after_widget;
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['page_id'] = strip_tags($new_instance['page_id']);
		$instance['excerpt_length'] = strip_tags($new_instance['excerpt_length']);
		return $instance;
	}

	function form($instance) {
		$default = 	array( 'title' => __('Page Excerpt Widget'), 'excerpt_length' => __(500) );
		$instance = wp_parse_args( (array) $instance, $default );
		$page_id = $this->get_field_name('page_id');
		_e("Page to display: " );
			?>
			<select name="<?php echo $page_id; ?>">
				<?php
					$pages = get_pages();
					foreach ($pages as $page){
						if ($page->ID == $instance['page_id']){
							$selected = 'selected="selected"';
						}
						else {
							$selected='';
						}
						echo '<option value="'
							.$page->ID.'"'
							.$selected.'>'
							.$page->post_title
							.'</option>';
					};
				?>
			</select>
		<?php
		$field_excerpt_length_id = $this->get_field_id('excerpt_length');
		$field_excerpt_length = $this->get_field_name('excerpt_length');
		echo "\r\n"
			.'<p><label for="'
			.$field_id
			.'">'
			.__('Excerpt Length')
			.': <input type="text" id="'
			.$field_excerpt_length_id
			.'" name="'
			.$field_excerpt_length
			.'" value="'
			.esc_attr( $instance['excerpt_length'] )
			.'" /><label></p>';
	}
	
	function temmp2($instance) {
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
	}
	
/* class end */
}
}

add_action('widgets_init', 'page_excerpt_widgets');

function page_excerpt_widgets(){
	register_widget('PageExcerptWidget');
}

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
if (isset($before_widget)){
	echo $before_widget;
}
//
if (isset($before_title)){
	echo $before_title;
}
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
if (isset($after_title)){
	echo $after_title;
}

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
if (isset($after_widget)){
	echo $after_widget;
}
}
/*
	wp_register_sidebar_widget( 1, 'Page Excerpt Widget',
	'jmh_pew_widget');
	wp_register_widget_control( 1, 'Page Excerpt Widget',
	'jmh_pew_widget_control');
/*
add_action('init', 'jmh_pew_multi_register');
function jmh_pew_multi_register() {
 
	$prefix = 'page-excerpt-widget'; // $id prefix
	$name = __('Page Excerpt Widget');
	$widget_ops = array('classname' => 'widget_name_multi', 'description' => __('This is an example of a widget which you can add many times'));
	$control_ops = array('width' => 200, 'height' => 200, 'id_base' => $prefix);
 
	$options = get_option('widget_name_multi');
	if(isset($options[0])) unset($options[0]);
 
	if(!empty($options)){
		foreach(array_keys($options) as $widget_number){
			wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'widget_name_multi', $widget_ops, array( 'number' => $widget_number ));
			wp_register_widget_control($prefix.'-'.$widget_number, $name, 'widget_name_multi_control', $control_ops, array( 'number' => $widget_number ));
		}
	} else{
		$options = array();
		$widget_number = 1;
		wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'widget_name_multi', $widget_ops, array( 'number' => $widget_number ));
		wp_register_widget_control($prefix.'-'.$widget_number, $name, 'widget_name_multi_control', $control_ops, array( 'number' => $widget_number ));
	}
}
//*/
?>
