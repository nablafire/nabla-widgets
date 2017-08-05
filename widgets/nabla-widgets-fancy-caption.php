<?php

class nabla_widgets_fancy_caption extends WP_Widget {

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
		$name = nabla_widgets()->plugin_nice_name.' '.esc_html__("Fancy Caption",'nabla-custom-widgets');
		$widget_options = array( 'description' => esc_html__("Fancy Caption With Custom Img And Text",
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
			// Caption Settings
			'image'        => '',
			'accent'       => '#000',
			'accent_bg'    => '#FFF',
			// Title Settings
			'title'        => '',
			'title_font'   => '',
			'title_size'   => '24',	
			'title_color'  => '#000',	
			'title_weight' => 'normal',	
			'title_align'  => 'center',	
			// Text Settings
			'text' 	   	   => '',
			'text_font'    => '',
			'text_size'    => '16',	
			'text_color'   => '#000',				
			'text_weight'  => 'normal',	
			'text_align'   => 'justify',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		$options = array(
			// Image Settings
			'image'    	   => $instance['image'],
			'accent'       => $instance['accent'],
			'accent_bg'    => $instance['accent_bg'],
			
			// Title Settings
			'title'        => $instance['title'],
			'title_font'   => $instance['title_font'],
			'title_size'   => $instance['title_size'],
			'title_color'  => $instance['title_color'],
			'title_weight' => $instance['title_weight'],
			'title_align'  => $instance['title_align'],
			
			// Text Settings 
			'text'         => $instance['text'],
			'text_font'    => $instance['text_font'],
			'text_size'    => $instance['text_size'],
			'text_color'   => $instance['text_color'],
			'text_weight'  => $instance['text_weight'],
			'text_align'   => $instance['text_align'],
		);
		// Close PHP ---> Begin HTML backend output 	
        ?>


        <?php $templates = new nabla_widgets_admin_templates();?>


        <!-- *********************************       ICON        ********************************* -->

        <div class="nabla-widget-admin-fields">
        <h3 class="nabla-widget-admin-toggle nabla-widget-admin-toggle-1"><?php _e( 'Icon Settings', 'nabla-widgets' ); ?></h3>
        <div class="nabla-widget-admin-field nabla-widget-admin-field-1" style="display: none;">
        
        <!-- Icon Upload Field -->
        <?php $templates->admin_image_field($this, 'image', $options['image'], 'Image Icon:'); ?>

        <!-- Color Picker (Accent) -->
		<?php $templates->admin_color_field($this, 'accent', $options['accent'], 'Accent Color:') ;?>

	    <!-- Color Picker (background) -->
	    <?php $templates->admin_color_field($this, 'accent_bg', $options['accent_bg'], 'Accent Background Color:') ;?>

	    </div>
	    </div>

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
	   
		</div>
	    </div>	


	    <!-- *********************************       TEXT        ********************************* -->
	    
	    <!-- jQuery Toggle -->
   	    <div class="nabla-widget-admin-fields">
        <h3 class="nabla-widget-admin-toggle nabla-widget-admin-toggle-2">
        	<?php _e( 'Text Settings', 'nabla-widgets' ); ?></h3>
        <div class="nabla-widget-admin-field nabla-widget-admin-field-2" style="display: none;">

		<!-- Text -->
		<?php $templates->admin_text_field($this, 'text', $options['text'], 'Text:'); ?>

		 <!-- Text Font -->
        <?php $fonts_list = array_keys(nabla_widgets()->fonts); ?>
	    <?php $templates->admin_drop_down($this, 'text_font', $options['text_font'], 'Text Font:', $fonts_list); ?>

		<!-- Text Size -->
		<?php $templates->admin_number_field($this,'text_size', $options['text_size'], 'Text Size:') ;?>

		<!-- Text Weight -->
		<?php $weights_list = nabla_widgets()->styles["weight"]; ?> 		
		<?php $templates->admin_drop_down($this, 'text_weight', $options['text_weight'], 'Text Weight:', $weights_list); ?>

		<!-- Text Align -->
		<?php $align_list = nabla_widgets()->styles["align"]; ?> 		
		<?php $templates->admin_drop_down($this, 'text_align', $options['text_align'], 'Text Align:', $align_list); ?>	

		<!-- Text Color -->
		<?php $templates->admin_color_field($this, 'text_color', $options['text_color'], 'Text Color:') ;?>

	    </div>
	    </div>

        <?php //Open PHP
	}// Close WP_Widget::form function

	// Update Method
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['accent']       = strip_tags($new_instance['accent']);
		$instance['accent_bg']    = strip_tags($new_instance['accent_bg']);
		$instance['image']        = strip_tags($new_instance['image']);

		$instance['title']        = strip_tags($new_instance['title']);
		$instance['title_font']   = strip_tags($new_instance['title_font']);
		$instance['title_size']   = strip_tags($new_instance['title_size']);
		$instance['title_color']  = strip_tags($new_instance['title_color']);
		$instance['title_weight'] = strip_tags($new_instance['title_weight']);
		$instance['title_align']  = strip_tags($new_instance['title_align']);

		$instance['text']         = strip_tags($new_instance['text']);
		$instance['text_font']    = strip_tags($new_instance['text_font']);
		$instance['text_size']    = strip_tags($new_instance['text_size']);
		$instance['text_color']   = strip_tags($new_instance['text_color']);
		$instance['text_weight']  = strip_tags($new_instance['text_weight']);
		$instance['text_align']   = strip_tags($new_instance['text_align']);

		return $instance;
	}


	// This method controls what we see on the frontend ... 
	// This method overloads WP_widget::widget() and exposes 
	// our instance class variables set on the back end for 
	// use on the frontend. 
	function widget($args, $instance) {
		extract( $args );

		$options = array(
			'image'        => (isset($instance['image'])        ? $instance['image']        : '' ),
			'accent'       => (isset($instance['accent'])       ? $instance['accent']       : '' ),
			'accent_bg'    => (isset($instance['accent_bg'])    ? $instance['accent_bg']    : '' ),

			'title' 	   => (isset($instance['title'])        ? $instance['title']        : '' ),
			'title_font'   => (isset($instance['title_font'])   ? $instance['title_font']   : '' ),
			'title_size'   => (isset($instance['title_size'])   ? $instance['title_size']   : '' ),
			'title_color'  => (isset($instance['title_color'])  ? $instance['title_color']  : '' ),
			'title_weight' => (isset($instance['title_weight']) ? $instance['title_weight'] : '' ),
			'title_align'  => (isset($instance['title_align'])  ? $instance['title_align']  : '' ),

			'text' 	   	   => (isset($instance['text'])         ? $instance['text']         : '' ),
			'text_font'    => (isset($instance['text_font'])    ? $instance['text_font']    : '' ),
			'text_size'    => (isset($instance['text_size'])    ? $instance['text_size']    : '' ),
			'text_color'   => (isset($instance['text_color'])   ? $instance['text_color']   : '' ),
			'text_weight'  => (isset($instance['text_weight'])  ? $instance['text_weight']  : '' ),
			'text_align'   => (isset($instance['text_align'])   ? $instance['text_align']   : '' ),
		);

		// Close PHP ---> Begin HTML backend output	
		?>		

		<?php $fonts_array = (array)nabla_widgets()->fonts; ?>
		<?php echo $before_widget; ?>
		
		<?php $class = $this->write_stylesheet($options); ?>
	

		<div class="nabla-fancy-caption">
		
			<!-- Image Field -->
			<?php if( $options['image'] ) : ?>
			<div class="nabla-fancy-caption-centering">

				<div class="image-<?php echo $class; ?>">
					<div class="circle-outer"></div>
	    			<div class="circle-inner"></div>
	    			<div class="icon-inner">
	    				<img class="icon-<?php echo $class; ?>" 
	    					 src="<?php echo esc_url( $options['image'] );?>">
	    			</div>
				</div>		
			</div>		
	
			<?php endif;?>

			<!-- Title Field -->
			<?php if( $options['title'] ):?>
				<p class="title-<?php echo $class; ?>">
						<?php echo esc_html( $options['title'] );?>
				</p>
			<?php endif; ?>

			<!-- Underline -->		
			<div class="ulw-<?php echo $class; ?>">
			<div class="ul-<?php echo $class; ?>"></div>
			</div>

			<!-- Text Field -->
			<?php if( $options['text'] ):?>
				<p class="text-<?php echo $class; ?>"?>
					<?php echo esc_html( $options['text'] );?>
				</p>
			<?php endif; ?>

		</div>

	<?php echo $after_widget; ?>
		
    <?php //Open PHP
	} // Close WP_Widget::widget() function

	function write_stylesheet($options){?>

		<?php $fonts_array = (array)nabla_widgets()->fonts; ?>
		<link rel="stylesheet" 
			  href="<?php echo '//fonts.googleapis.com/css?family='.
			  			str_replace(' ', '+', $options['title_font']).':'.$options['title_weight']?>">		
		<link rel="stylesheet"
		      href="<?php echo '//fonts.googleapis.com/css?family='.
		      			str_replace(' ', '+', $options['text_font']).':'.$options['text_weight']?>">

		<style>
			/* This is clearly not the best way to do this ... */
			.image-nabla-fancy-caption-<?php echo esc_html($this->id);?> {
 				width 			: var(--accent-size);
    			height 			: var(--accent-size);
    			position 		: relative;
			    margin 			: 0 auto; /* To center the accented icon */
			}
			.image-nabla-fancy-caption-<?php echo esc_html($this->id);?> > .circle-outer{
			    position 		: absolute;
    			width 			: calc(var(--accent-size) - 10px);
    			height 			: calc(var(--accent-size) - 10px);
    			top 			: 5px;
    			left 			: 5px;
       			border-radius 	: 50%;
				background-color: <?php echo esc_attr( $options['accent'] )?>;
			}
			.image-nabla-fancy-caption-<?php echo esc_html($this->id);?> > .circle-inner{
				position 		: absolute;
    			width 			: calc(var(--accent-size) - 24px);
    			height 			: calc(var(--accent-size) - 24px); /* Thickness *2*/
    			top 			: 12px;
    			left 			: 12px; /*Determines ring thickness*/
    			border-radius 	: 50%;
				background-color: <?php echo esc_attr( $options['accent_bg'] ) ?>;
			}

			.image-nabla-fancy-caption-<?php echo esc_html($this->id);?> > .icon-inner{
    			position 		: absolute;
    			width 			: var(--accent-size);
    			height 			: var(--accent-size);
    			text-align 		: center;
    			padding-top 	: calc((var(--accent-size) - var(--icon-size))/2);
    			max-height 		: var(--icon-size);
			}

			.icon-nabla-fancy-caption-<?php echo esc_html($this->id);?>{
				/* Note the possibility of different widths */
				max-height 		:var(--icon-size); 
			}

			.title-nabla-fancy-caption-<?php echo esc_html($this->id);?>{
				<?php echo $fonts_array[$options['title_font']]?>
				font-size 		: <?php echo esc_html($options['title_size'])?>px;
				color 			: <?php echo esc_html($options['title_color'])?>;
				text-align 		: <?php echo esc_html($options['title_align'])?>;
				font-weight 	: <?php echo esc_html($options['title_weight'])?>;
			}

			.ulw-nabla-fancy-caption-<?php echo esc_html($this->id);?>{
			    width 			: 100%;
    			margin-top 		: 10px;
			}

			.ul-nabla-fancy-caption-<?php echo esc_html($this->id);?>{
				background-color: <?php echo esc_attr( $options['accent'] );?>;
				width 			: 50%;
    			height 			: 3px;
   				margin 			: 0 auto; /* to center underline */
			}
			.text-nabla-fancy-caption-<?php echo esc_html($this->id);?>{
				<?php echo $fonts_array[$options['text_font']] ?>
				font-size 		: <?php echo esc_html($options['text_size'])?>px;
				color 			: <?php echo esc_html($options['text_color'])?>;
				text-align 		: <?php echo esc_html($options['text_align'])?>;
				font-weight 	: <?php echo esc_html($options['text_weight'])?>;
			}

		</style><?php 
        return "nabla-fancy-caption-".esc_html($this->id);
	}

}// Close Widget Class