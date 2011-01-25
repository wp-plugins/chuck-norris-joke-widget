<?php
/**
 * Plugin Name: Chuck Norris Jokes Widget
 * Plugin URI: http://maartendecat.be/chuck-norris-jokes-wordpress-plugin/
 * Description: A widget that shows Chuck Norris jokes on your blog. For personalized Chuck Norris jokes starring yourself, please refer to the Personalized Chuck Norris Jokes Widget.
 * Version: 0.7
 * Author: Maarten Decat
 * Author URI: http://maartendecat.be
 * License: GPL2
 *
 * Copyright 2010  Maarten Decat  (email : mdecat@ulyssis.be)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

add_action( 'widgets_init', 'load_ChuckNorrisJokeWidget' );

function load_ChuckNorrisJokeWidget() {
	register_widget( 'ChuckNorrisJokeWidget' );
	wp_enqueue_script('jquery');
	wp_register_script('chuck-norris-jquery', plugins_url('/chuck-norris-joke-widget/jquery.icndb.min.js'));
	wp_enqueue_script('chuck-norris-jquery');
}

/**
 * The Chuck Norris Widget.
 */
class ChuckNorrisJokeWidget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function ChuckNorrisJokeWidget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'chuck-norris-jokes', 'description' => __('A widget that shows Chuck Norris jokes on your blog.', 'chuck-norris-jokes-widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'chuck-norris-jokes-widget' );

		/* Create the widget. */
		parent::WP_Widget( 'chuck-norris-jokes-widget', __('Chuck Norris Joke', 'chuck-norris-jokes-widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Output the quote */ ?>
<!-- Chuck Norris Joke Widget plugin -->
<div id="chuck-norris-joke-widget"></div>
<script type="text/javascript">
(function($) {
$.icndb.client.id = 2;
$.icndb.client.version = 0.7;
$(document).ready(function() {
    $.icndb.getRandomJoke({
		success: function(joke) {
			$('#chuck-norris-joke-widget').html(joke.joke);
		}
	});
});
})(jQuery);
</script>
<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		
	}
}

?>
