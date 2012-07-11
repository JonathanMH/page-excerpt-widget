<?php
	if($_POST['jmh_pew_hidden'] == 'Y') {
		$jmh_pew_page_excerpt_length = $_POST['jmh_pew_page_excerpt_length'];
		update_option('jmh_pew_page_excerpt_length', $jmh_pew_page_excerpt_length);
		
		$jmh_pew_page_id = $_POST['jmh_pew_page_id'];
		update_option('jmh_pew_page_id', $jmh_pew_page_id);
		
		$jmh_pew_link_title = $_POST['jmh_pew_link_title'];
		update_option('jmh_pew_link_title', $jmh_pew_link_title);
		
		$jmh_pew_append_link = $_POST['jmh_pew_append_link'];
		update_option('jmh_pew_append_link', $jmh_pew_append_link);
		
		$jmh_pew_link_label = $_POST['jmh_pew_link_label'];
		update_option('jmh_pew_link_label', $jmh_pew_link_label);
	} else {
		$jmh_pew_page_excerpt_length = get_option('jmh_pew_page_excerpt_length');
		$jmh_pew_page_id = get_option('jmh_pew_page_id');
		$jmh_pew_link_title = get_option('jmh_pew_link_title');
		$jmh_pew_append_link = get_option('jmh_pew_append_link');
		$jmh_pew_link_label = get_option('jmh_pew_link_label');
	}
?>

<div class="wrap">
		<input type="hidden" name="jmh_pew_hidden" value="Y">
		<?php echo "<h4>" . __( 'JMH Page Excerpt Options', 'jmh_pew_form' ) . "</h4>"; ?>
		<p><?php _e("Page Excerpt length in characters: " ); ?><input type="text" name="jmh_pew_page_excerpt_length" value="<?php echo $jmh_pew_page_excerpt_length; ?>" size="20"><?php _e(" ex: 500" ); ?></p>
		<p>
			<?php _e("Page to display: " ); ?>
			<select name="jmh_pew_page_id">
				<?php
					$pages = get_pages();
					foreach ($pages as $page){
						if ($page->ID == $jmh_pew_page_id){
							$selected = 'selected="selected"';
						}
						else {
							$selected='';
						}
						echo '<option value="'.$page->ID.'"'.$selected.'>'.$page->post_title.'</option>';	
					};
				?>
			</select>
		</p>
		<p>
			<?php _e("Link page title to page: " ); 
				if ($jmh_pew_link_title == 'Yes'){
					$checked = 'checked="checked"';
				}
				else {
					$checked = '';
				}
			?>
			<input type="checkbox" name="jmh_pew_link_title" value="Yes" <?php echo $checked ?> />
		</p>
		<p>
			<?php _e("Append a &quot;Read more&quot; link: " );
				if ($jmh_pew_append_link == 'Yes'){
					$checked = 'checked="checked"';
				}
				else {
					$checked = '';
				}
			?>
			<input type="checkbox" name="jmh_pew_append_link" value="Yes" <?php echo $checked ?> />
		</p>
		<p>
			<p><?php _e("Read More Link Label: " ); ?><input type="text" name="jmh_pew_link_label" value="<?php echo $jmh_pew_link_label; ?>" size="20"></p>
		</p>
</div>
