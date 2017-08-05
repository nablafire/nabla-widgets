<?php

class nabla_widgets_minimal extends WP_Widget {

	// Our widget constructor will call the WP_Widget 
	// parent class constructor (i.e. inheritance).
	function __construct() {

		//	For Reference 
		// -----------------------------------------------------------
		// WP_Widget::__construct( string $id_base, 
		//  					   string $name, 
		//                         array $widget_options = array(), 
		//                         array $control_options = array() );
		// -----------------------------------------------------------
		$name = nabla_widgets()->plugin_nice_name.' '.esc_html__("Minimal",'nabla-custom-widgets');
		$widget_options = array( 'description' => esc_html__("Header And Text Area",
		 				      		                         'nabla-custom-widgets'));
		$control_options = array();

		// Call WP_Widget::__construct ...
		parent:: __construct(false, $name, $widget_options, $control_options);	
	}


	// This method controls what we see on the backend ... 
	// This method overloads WP_widget::form();

	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array(
			'text' => '',
			'title' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		$text = $instance['text'];
		$title = $instance['title'];
		
		// Close PHP ---> Begin HTML backend output 	
        ?>
        

        <p>
        	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','nabla-custom-widgets'); ?> 
    		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
        </p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php  esc_html_e('Text:','nabla-custom-widgets'); ?> 
			<textarea rows="10" cols="15" class="widefat" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>"><?php echo esc_html($text); ?></textarea></label>
		</p>

        <?php //Open PHP
	}// Close WP_Widget::form function

	// Update Method
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}


	// This method controls what we see on the frontend ... 
	// This method overloads WP_widget::widget();
	function widget($args, $instance) {
		extract( $args );
		$text = (isset($instance['text'])) ? $instance['text'] : '' ;
		$title = (isset($instance['title'])) ? $instance['title'] : '' ;

	// Close PHP ---> Begin HTML backend output	
	?>		

	<?php echo $before_widget; ?>
		
		<div class="nabla-minimal">
			<?php if( $title ) { ?>
				<h3 class="nabla-minimal-title"><?php echo esc_html( $title );?></h3>
			<?php } ?>
			<?php if( $text ) { echo wpautop(esc_html($text)); } ?>
		</div>

	<?php echo $after_widget; ?>
		
    <?php //Open PHP
	} // Close WP_Widget::widget() function

}// Close Widget Class