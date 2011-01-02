<?php
/**
 * Plugin Name: Chuck Norris Jokes Widget
 * Plugin URI: http://maartendecat.be/chuck-norris-jokes-wordpress-plugin/
 * Description: A widget that shows Chuck Norris jokes on your blog. 
 * Version: 0.1
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

add_action( 'widgets_init', 'load_ChuckNorrisWidgets' );

function load_ChuckNorrisWidgets() {
	register_widget( 'ChuckNorrisWidget' );
}

/**
 * The Chuck Norris Widget.
 */
class ChuckNorrisWidget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function ChuckNorrisWidget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'chuck-norris-jokes', 'description' => __('A widget that shows Chuck Norris jokes on your blog.', 'chuck-norris-jokes-widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'chuck-norris-jokes-widget' );

		/* Create the widget. */
		parent::WP_Widget( 'chuck-norris-jokes-widget', __('Chuck Norris Jokes Widget', 'chuck-norris-jokes-widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$firstName = $instance['firstName'];
		$lastName = $instance['lastName'];
		$useName = $instance['useName'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		//if ( $title )
		//	echo $before_title . $title . $after_title;

		$hardCodedQuote = "In the Bible, Jesus turned water into wine. But then $firstName $lastName turned that wine into beer.";
		
		$file = fopen ('http://icndb.com/api.php?f=rand&fn=' . $firstName . '&ln=' . $lastName, "r");
		if (!$file) {
			echo($hardCodedQuote);
		}
		$result = '';
		while (!feof ($file)) {
			$result .= fgets ($file, 1024);
		}
		fclose($file);
		$result = json_decode($result);
		if($result->type == 'success') {
			echo($result->value->quote);
		} else {
			echo($hardCodedQuote);
		}

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['firstName'] = strip_tags( $new_instance['firstName'] );
		$instance['lastName'] = strip_tags( $new_instance['lastName'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array('firstName' => 'Chuck', 'lastName' => 'Norris');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		Want to star in your own jokes? Fill in your name below! If you want the original Chuck Norris jokes, just click save.

		<!-- First name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'firstName' ); ?>">First name:</label>
			<input id="<?php echo $this->get_field_id( 'firstName' ); ?>" name="<?php echo $this->get_field_name( 'firstName' ); ?>" value="<?php echo $instance['firstName']; ?>" style="width:100%;"/>
		</p>

		<!-- Last name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'lastName' ); ?>">Last name:</label>
			<input id="<?php echo $this->get_field_id( 'lastName' ); ?>" name="<?php echo $this->get_field_name( 'lastName' ); ?>" value="<?php echo $instance['lastName']; ?>" style="width:100%;"/>
		</p>
<?php
	}
}

?>
