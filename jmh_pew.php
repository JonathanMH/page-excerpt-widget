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
		if (!empty($title) && $instance['display_title'] == 'on') {
			echo $before_title;
			if ($instance['link_title']){
				echo '<a href="'. get_permalink($instance['page_id']) .'">'. $title . '</a>';
			}
			else {
				echo $title;
			}
			echo $after_title;
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
		$instance['display_title'] = strip_tags($new_instance['display_title']);
		$instance['link_title'] = strip_tags($new_instance['link_title']);
		return $instance;
	}

	function form($instance) {
		$default = 	array( 'title' => __('Page Excerpt Widget'), 'excerpt_length' => __(500), 'display_title' => __('on') );
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
			.': </label><input type="text" id="'
			.$field_excerpt_length_id
			.'" name="'
			.$field_excerpt_length
			.'" value="'
			.esc_attr( $instance['excerpt_length'] )
			.'" /></p>';
		$field_display_title_id = $this->get_field_id('display_title');
		$field_display_title = $this->get_field_name('display_title');
		
		
		if ($instance['display_title'] == 'on'){
			$checked = 'checked="checked"';
		}
		else {
			$checked = '';
		}
		
		echo "\r\n"
			.'<p><label for="'
			.$field_display_title_id
			.'">'
			.__('Display Page Title')
			.': </label><input type="checkbox" id="'
			.$field_display_title_id
			.'" name="'
			.$field_display_title
			.'" value="on"'
			.$checked
			.'/></p>';
		
		$field_link_title_id = $this->get_field_id('link_title');
		$field_link_title = $this->get_field_name('link_title');
		
		
		if ($instance['link_title'] == 'on'){
			$checked = 'checked="checked"';
		}
		else {
			$checked = '';
		}
		
		echo "\r\n"
			.'<p><label for="'
			.$field_link_title_id
			.'">'
			.__('Link Page Title')
			.': </label><input type="checkbox" id="'
			.$field_link_title_id
			.'" name="'
			.$field_link_title
			.'" value="on"'
			.$checked
			.'/></p>';
	}
	
/* class end */
}
}

add_action('widgets_init', 'page_excerpt_widgets');

function page_excerpt_widgets(){
	register_widget('PageExcerptWidget');
}

?>
