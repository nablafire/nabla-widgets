<?php

class nabla_widgets_fancy_image extends WP_Widget{

	function __construct(){
		//	For Reference 
		// -----------------------------------------------------------
		// WP_Widget::__construct( string $id_base, 
		//  					   string $name, 
		//                         array $widget_options = array(), 
		//                         array $control_options = array() );
		// -----------------------------------------------------------
		$name = nabla_widgets()->plugin_nice_name.' '.esc_html__("Fancy Image",'nabla-custom-widgets');
		$widget_options = array( 'description' => esc_html__("Fancy Image With Paralax Effect",
		 				      		                         'nabla-custom-widgets'));
		$control_options = array();

		// Call WP_Widget::__construct ..
		parent::__construct(false, $name, $widget_options, $control_options);	
	} // Close constructor method

	function form($instance){
		// Set up some default widget settings.
		$defaults = array(
			'div_image'    => '',
			'div_color'	   => '#fff',
			'div_corners'  => '2', 
			'div_padding'  => '10px',
			'div_margin'   => '10px',
			'div_height'   => '0',
			'div_parallax' => false,
			'div_opacity'  => '1.0',		
		);
		// Parse args into $instance. Unfortunately we cannot easily parse a  
		// multidimensional array.
		$instance = wp_parse_args( (array) $instance, $defaults );
		

		/* Create some local variables */
		$options  = array(
			'div_image'    => $instance['div_image'],
			'div_color'    => $instance['div_color'],
			'div_corners'  => $instance['div_corners'],	
			'div_padding'  => $instance['div_padding'],
			'div_margin'   => $instance['div_margin'],
			'div_height'   => $instance['div_height'],
			'div_parallax' => $instance['div_parallax'],
			'div_opacity'  => $instance['div_opacity'],
		);
		?>

	   <?php $templates = new nabla_widgets_admin_templates();?>


	    <!-- *********************************       TITLE        ********************************* -->
	    
	    <!-- jQuery Toggle -->
		<div class="nabla-widget-admin-fields">
        <h3 class="nabla-widget-admin-toggle nabla-widget-admin-toggle-1"><?php _e('Image Settings', 'nabla-widgets' ); ?></h3>
        <div class="nabla-widget-admin-field nabla-widget-admin-field-1" style="display: none;">

        <!-- Image Upload Field -->
        <?php $templates->admin_image_field($this, 'div_image', $options['div_image'], 'Image:'); ?>

        <!-- Parallax Effect-->
		<?php $templates->admin_checkbox($this, 'div_parallax', $options['div_parallax'], 'Parallax:', $instance) ;?>
        
		  <!-- Div Padding -->
	    <?php $label  = 'Padding (px): Use CSS Format' ?>	
	    <?php $before = 'top(px) right(px) bottom(px) left(px)'?>
	    <?php $after  = 'Example: 10px 10px 10px 10px'; ?>
		<?php $templates->admin_input_field($this, 'div_padding', $options['div_padding'], $label, $before, $after); ?>

	    <!-- Div Margin -->
   	    <?php $label  = 'Margin (px): Use CSS Format' ?>	
   	    <?php $templates->admin_input_field($this, 'div_margin', $options['div_margin'], $label, $before, $after); ?>

		<!-- Div Corners -->
		<?php $templates->admin_number_field($this,'div_corners', $options['div_corners'], 'Round Corners (px):') ;?>

		<!-- Div Height -->
		<?php $templates->admin_number_field($this,'div_height', $options['div_height'], 'Fixed Height: (0 = auto)') ;?>

		<!-- Image Opacity -->
		<?php $templates->admin_number_field($this,'div_opacity', $options['div_opacity'],'Image Opacity:', 0, 1, 0.05) ;?>

		<!-- Background Color -->
    	<?php $templates->admin_color_field($this, 'div_color', $options['div_color'], 'Default Background Color:') ;?>

        </div>
        </div>

    <?php } // Close Backend HTML generation (form function)


	// Update Method
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['div_image']    = strip_tags($new_instance['div_image']);	
		$instance['div_color']    = strip_tags($new_instance['div_color']);
		$instance['div_corners']  = strip_tags($new_instance['div_corners']);
		$instance['div_padding']  = strip_tags($new_instance['div_padding']);
		$instance['div_margin']   = strip_tags($new_instance['div_margin']);
		$instance['div_height']   = strip_tags($new_instance['div_height']);
		$instance['div_parallax'] = strip_tags($new_instance['div_parallax']);
		$instance['div_opacity']  = strip_tags($new_instance['div_opacity']);
		return $instance;	
	}


	// This method controls what we see on the frontend ... 
	// This method overloads WP_widget::widget();	
	function widget($args, $instance) {

		extract( $args );
		// Store args in local vairables. Here we have some ternaries to default to empty string 
		// if variables are not set on the backend. 
		$options = array(
			'div_image'    => (isset($instance['div_image'])    ? $instance['div_image']   : '') ,		
			'div_color'    => (isset($instance['div_color'])    ? $instance['div_color']   : '' ),
			'div_corners'  => (isset($instance['div_corners'])  ? $instance['div_corners'] : '' ),
			'div_padding'  => (isset($instance['div_padding'])  ? $instance['div_padding'] : '' ),
			'div_margin'   => (isset($instance['div_margin'])   ? $instance['div_margin']  : '' ),
			'div_height'   => (isset($instance['div_height'])   ? $instance['div_height']  : '' ),
			'div_opacity'  => (isset($instance['div_opacity'])  ? $instance['div_opacity'] : '' ),
			'div_parallax' => $instance['div_parallax']		    ? true : false,
		);
		//Close PHP ?>

		<!--- Begin Frontend Output Section -->
		<?php echo $before_widget; ?>

		<!--- Write Corresponding Stylesheet-->
		<?php $class = $options['div_parallax'] ? $this->stylesheet_parallax($options) 
												: $this->stylesheet_no_parallax($options); ?>

		<div class="<?php echo $class;?>">
			<div class="bg-<?php echo $class;?>">
			</div>
		</div>

		<!--- End Frontend Output Section -->
		<?php echo $after_widget; ?>

	<?php } //Open PHP - Close WP_Widget::widget() function

	// Functions to write CSS depending on whether we want a parallax effect
	function stylesheet_parallax($options){

		 ?><style>
			.nabla-image-widget-parallax-<?php echo esc_html($this->id);?>{ 
				background-color: <?php echo esc_html($options['div_color']);?>;
				border-radius   : <?php echo esc_html($options['div_corners'].'px')?>;
				padding         : <?php echo esc_html($options['div_padding'])?>;
				margin          : <?php echo esc_html($options['div_margin'])?>;
			} 
			.nabla-image-widget-parallax-<?php echo esc_html($this->id);?> [class*="bg-"]{ 
		    	border-radius   : <?php echo esc_html($options['div_corners'].'px')?>;
				position 		: relative;
				text-indent  	: -9999px;
				background-size : cover;
			    background-position   : top center;
				background-attachment : fixed;
			}
			.bg-nabla-image-widget-parallax-<?php echo esc_html($this->id);?>{
				background-image: url(<?php echo esc_html($options['div_image']);?>);
			    height          : <?php echo esc_html($options['div_height']).'px;'?>;
			    opacity  		: <?php echo esc_html($options['div_opacity'])?>;     			   	 
			}
		</style><?php 
        return "nabla-image-widget-parallax-".esc_html($this->id);
	}

	function stylesheet_no_parallax($options){

		 ?><style>
			.nabla-image-widget-no-parallax-<?php echo esc_html($this->id);?>{ 
				background-color: <?php echo esc_html($options['div_color']);?>;
				border-radius   : <?php echo esc_html($options['div_corners'].'px')?>;
				padding         : <?php echo esc_html($options['div_padding'])?>;
				margin          : <?php echo esc_html($options['div_margin'])?>;
			} 
			.bg-nabla-image-widget-no-parallax-<?php echo esc_html($this->id);?>{ 
				background-size : cover;
				background-image: url(<?php echo esc_html($ptions['div_image']);?>);
				border-radius   : <?php echo esc_html($options['div_corners'].'px')?>;
			    height          : <?php echo esc_html($options['div_height']).'px;'?>;
			    opacity  		: <?php echo esc_html($options['div_opacity'])?>;     			   	 
			}
		</style><?php 
        return "nabla-image-widget-no-parallax-".esc_html($this->id);
	}
}// Close Widget Class
