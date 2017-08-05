<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class nabla_widgets_fancy_title extends WP_Widget {

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
		$name = nabla_widgets()->plugin_nice_name.' '.esc_html__("Fancy Title",'nabla-custom-widgets');
		$widget_options = array( 'description' => esc_html__("Fancy Title Area",
		 				      		                         'nabla-custom-widgets'));
		$control_options = array();



		// Call WP_Widget::__construct ...
		parent:: __construct(false, $name, $widget_options, $control_options);	
	}

	// This method controls what we see on the backend ... 
	// This method overloads WP_widget::form();

	function form($instance) {

		// Set up some default widget settings. 
		$defaults = array(
			// Title Settings
			'title'        => '',
			'title_font'   => '',
			'title_size'   => '24',	
			'title_color'  => '#000',	
			'title_weight' => 'normal',	
			'title_align'  => 'left',
			'title_opacity'=> '1.0',

			// Div Settings
			'div_color'	   => '#fff',
			'div_trans'    => false,
			'div_corners'  => '2', 
			'div_padding'  => '10px',
			'div_margin'   => '10px',
			'div_height'   => '0',					
		);
		// Parse args into $instance. Unfortunately we cannot easily parse a  
		// multidimensional array.
		$instance = wp_parse_args( (array) $instance, $defaults );

		// Create some local variables 
		$options  = array(

			// Title Settings
			'title'        => $instance['title'],
			'title_font'   => $instance['title_font'],
			'title_size'   => $instance['title_size'],
			'title_color'  => $instance['title_color'],
			'title_weight' => $instance['title_weight'],
			'title_align'  => $instance['title_align'],
			'title_opacity'=> $instance['title_opacity'],
			
			// Div Settings
			'div_color'    => $instance['div_color'],
			'div_trans'    => $instance['div_trans'],
			'div_corners'  => $instance['div_corners'],	
			'div_padding'  => $instance['div_padding'],
			'div_margin'   => $instance['div_margin'],
			'div_height'   => $instance['div_height'],
		);
		// Close PHP ---> Begin HTML backend output 	
        ?>

		 <?php $templates = new nabla_widgets_admin_templates();?>


	    <!-- *********************************       TITLE        ********************************* -->
	    
	    <!-- jQuery Toggle -->
	    <div class="nabla-widget-admin-fields">
        <h3 class="nabla-widget-admin-toggle nabla-widget-admin-toggle-1">
        	<?php _e('Title Settings', 'nabla-widgets' ); ?></h3>
        <div class="nabla-widget-admin-field nabla-widget-admin-field-1" style="display: none;">
        		
        <!-- Title -->
	    <?php $templates->admin_input_field($this, 'title', $options['title'], 'Title:'); ?>

	    <!-- Title Font -->
        <?php $fonts_list = array_keys(nabla_widgets()->fonts); ?>
	    <?php $templates->admin_drop_down($this, 'title_font', $options['title_font'], 'Title Font:', $fonts_list); ?>

		<!-- Title Size -->
		<?php $templates->admin_number_field($this,'title_size', $options['title_size'], 'Title Size:') ;?>

		<!-- Title Weight -->
		<?php $weights_list = nabla_widgets()->styles["weight"]; ?> 		
		<?php $templates->admin_drop_down($this, 'title_weight', $options['title_weight'], 'Title Weight:', $weights_list); ?>

		<!-- Title Align -->
		<?php $align_list = nabla_widgets()->styles["align"]; ?> 		
		<?php $templates->admin_drop_down($this, 'title_align', $options['title_align'], 'Title Align:', $align_list); ?>	

		<!-- Title Color -->
		<?php $templates->admin_color_field($this, 'title_color', $options['title_color'], 'Title Color:') ;?>

		<!-- Title Opacity -->
		<?php $templates->admin_number_field($this,'title_opacity', $options['title_opacity'],'Title Opacity:', 0, 1, 0.05) ;?>


		</div>
	    </div>	


   	    <!-- *********************************       DIV        ********************************* -->
   	    
   	    <!-- jQuery Toggle -->
   	    <div class="nabla-widget-admin-fields">
        <h3 class="nabla-widget-admin-toggle nabla-widget-admin-toggle-3">
        	<?php _e( 'Div Settings', 'nabla-widgets' ); ?></h3>
        <div class="nabla-widget-admin-field nabla-widget-admin-field-3" style="display: none;">
        
        <!-- Div Color -->	
    	<?php $templates->admin_color_field($this, 'div_color', $options['div_color'], 'Div Color:') ;?>

        <!-- Div Transparency -->	
		<?php $templates->admin_checkbox($this, 'div_trans', $options['div_trans'], 'Transparent:', $instance) ;?>

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

		</div>
		</div>
        <?php //Open PHP
	}// Close WP_Widget::form function

	// Update Method
	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['title']        = strip_tags($new_instance['title']);
		$instance['title_font']   = strip_tags($new_instance['title_font']);
		$instance['title_size']   = strip_tags($new_instance['title_size']);
		$instance['title_color']  = strip_tags($new_instance['title_color']);
		$instance['title_weight'] = strip_tags($new_instance['title_weight']);
		$instance['title_align']  = strip_tags($new_instance['title_align']);
		$instance['title_opacity']= strip_tags($new_instance['title_opacity']);

		$instance['div_color']    = strip_tags($new_instance['div_color']);
		$instance['div_corners']  = strip_tags($new_instance['div_corners']);
		$instance['div_padding']  = strip_tags($new_instance['div_padding']);
		$instance['div_margin']   = strip_tags($new_instance['div_margin']);
		$instance['div_height']   = strip_tags($new_instance['div_height']);
		$instance['div_trans']    = strip_tags($new_instance['div_trans']);

		return $instance;	
	}


	// This method controls what we see on the frontend ... 
	// This method overloads WP_widget::widget();
	function widget($args, $instance) {
		extract( $args );

		// Store args in local vairables. Here we have some ternaries to default to empty string 
		// if variables are not set on the backend. 
		$options = array(
		'title' 	   => (isset($instance['title'])         ? $instance['title']        : '' ),
		'title_font'   => (isset($instance['title_font'])    ? $instance['title_font']   : '' ),
		'title_size'   => (isset($instance['title_size'])    ? $instance['title_size']   : '' ),
		'title_color'  => (isset($instance['title_color'])   ? $instance['title_color']  : '' ),
		'title_weight' => (isset($instance['title_weight'])  ? $instance['title_weight'] : '' ),
		'title_align'  => (isset($instance['title_align'])   ? $instance['title_align']  : '' ),
		'title_opacity'=> (isset($instance['title_opacity']) ? $instance['title_opacity']  : '' ),

		'div_color'    => (isset($instance['div_color'])    ? $instance['div_color']   : '' ),
		'div_corners'  => (isset($instance['div_corners'])  ? $instance['div_corners'] : '' ),
		'div_padding'  => (isset($instance['div_padding'])  ? $instance['div_padding'] : '' ),
		'div_margin'   => (isset($instance['div_margin'])   ? $instance['div_margin']  : '' ),
		'div_height'   => (isset($instance['div_height'])   ? $instance['div_height']  : '' ),
		'div_trans'    => $instance['div_trans']		    ? true : false,

		);
		// Close PHP ---> Begin HTML backend output	
		?>		

		<?php echo $before_widget; ?>

		<?php $class = $this->write_stylesheet($options); ?>

		<div class="<?php echo esc_html($class);?>">

			<?php if( $options['title'] ): ?>
				<p class="t-<?php echo esc_html($class);?>">
						<?php echo esc_html( $options['title'] );?>			
				</p>
			<?php endif; ?>			

		</div>

		<?php echo $after_widget; ?>
    	<?php //Open PHP
	} // Close WP_Widget::widget() function

	function write_stylesheet($options){?>

		<?php $fonts_array = (array)nabla_widgets()->fonts; ?>
		<?php $background  = $options['div_trans'] ? 'transparent' : $options['div_color'] ?>
		<?php $div_auto    = ((int)$options['div_height'] != 0 ? esc_html($options['div_height']).'px' : '100%')?>

		<link rel="stylesheet" 
			  href="<?php echo '//fonts.googleapis.com/css?family='.
			  			str_replace(' ', '+', $options['title_font']).':'.$options['title_weight']?>">		
		<style>
		.nabla-fancy-title-<?php echo esc_html($this->id);?> {
			background-color: <?php echo esc_html($background)?>;
			border-radius   : <?php echo esc_html($options['div_corners'])?>px;
			padding 		: <?php echo esc_html($options['div_padding'])?>;
			margin 			: <?php echo esc_html($options['div_margin'])?>;
			height 			: <?php echo esc_html($div_auto)?>;
			display 		: block;

		}		
		.t-nabla-fancy-title-<?php echo esc_html($this->id);?> {
			<?php echo $fonts_array[$options['title_font']];?>;
			font-size  	 	: <?php echo esc_html($options['title_size'])?>px;
			color 			: <?php echo esc_html($options['title_color'])?>;
			text-align  	: <?php echo esc_html($options['title_align'])?>;
			font-weight  	: <?php echo esc_html($options['title_weight'])?>;
			opacity 		: <?php echo esc_html($options['title_opacity'])?>;
		}
		</style>

	<?php return 'nabla-fancy-title-'.esc_html($this->id);}

}// Close Widget Class