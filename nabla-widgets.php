<?php
	/*
	Plugin Name: 	Nabla Widgets
	Description: 	Nabla Custom Widget Plugin
	Version: 		1.0.1
	Author: 		Nabla Code
	Author URI: 	http://www.nabla-code.com/
	Domain Path:    /languages
	Text Domain:	nabla-custom-widgets
	License: GPLv3 or later
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	*/

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	// BEGIN CONTAINER CLASS. This class will contiain the names of our 
	// widget, stylesheet URIs, JS URIs. It will also enqueue our styles 
	// and scripts for us. Finally it will register and unregister widgets
	// which we will develop independently.  
	if ( !class_exists('nabla_widgets') ) {

		class nabla_widgets {

			public static $instance = null;
			public $plugin_name = 'nabla_widgets';
			public $plugin_nice_name = 'Nabla';
			// Init. Calls constructor.
			public static function init() {
			    $class = __CLASS__;
		        new $class;
		    }

			// Constructor 
		    function __construct() {
		    	// See load_scripts and load_admin_scripts below
		    	add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ));
		    	add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ));

				// Define some constant paths for JS and CSS
			    if (!defined('NABLA_WIDGETS_CSS_URL')) {
					define( 'NABLA_WIDGETS_CSS_URL', plugin_dir_url( __FILE__ ).'css/' );
				} 
				if (!defined('NABLA_WIDGETS_JS_URL')) {
					define( 'NABLA_WIDGETS_JS_URL', plugin_dir_url( __FILE__ ).'js/' );
				}
				if (!defined('NABLA_WIDGETS_INC_URL')) {
					define( 'NABLA_WIDGETS_INC_URL', plugin_dir_url( __FILE__ ).'inc/' );
				}

				// Load Google Fonts JSON object into array
				$fonts_json  = file_get_contents(NABLA_WIDGETS_INC_URL."json/google-fonts.json");
		  		$this->fonts = (array)json_decode($fonts_json, true);

		  		// Load Misc JSON Objects into arrays
		  		$styles_json  = file_get_contents(NABLA_WIDGETS_INC_URL."json/font-styles.json");
				$this->styles = (array)json_decode($styles_json, true);		  	

		    }
		    // Load Scripts for Constructor
		    function load_scripts() { 
				wp_enqueue_style("font-awesome", "//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css");
				wp_enqueue_style("nabla-widget-styles", NABLA_WIDGETS_CSS_URL."nabla-styles.css");
			}
			// Load all needed css and js for backend
			function load_admin_scripts() { 
				wp_enqueue_media();
		        wp_enqueue_style( 'wp-color-picker' );
		        wp_enqueue_script( 'wp-color-picker' );
		        wp_enqueue_style("nabla-styles-admin", NABLA_WIDGETS_CSS_URL."admin/nabla-styles-admin.css");
   		        wp_enqueue_script("nabla-scripts-admin", NABLA_WIDGETS_JS_URL."admin/nabla-scripts-admin.js", array( 'jquery' ),'1.0.0', true );
   		        wp_enqueue_script("nabla-widget-scripts", NABLA_WIDGETS_JS_URL."nabla-widgets.js", array( 'jquery' ),'1.0.0', true );
		  	}


		    // Getters and Setters
			public static function get_instance() {				
				if ( self::$instance==null ) {self::$instance = new nabla_widgets();}
				return self::$instance;
			}
			
			public function add($name) {
				return register_widget($name);
			}
			
			public function remove($name) {
				return unregister_widget($name);
			}
			
			public function replace($name){				
				unregister_widget($name);
				return register_widget($name);
			}

		}
	
	}
	// END CONTAINER CLASS


	// Initialize instance of the container class if it does not 
	// exist. Otherwise simply return the pointer. Note the caps
	// here - this is to not conflict with the class name and 
	// class constructor. Technically, this method is a getter 
	// method for the entire plugin class.  
	if ( ! function_exists('Nabla_Widgets') ) {
		function Nabla_Widgets() {
			// Instantiate the class --> calls new nabla_widgets() 
			$nabla_widgets_pointer = nabla_widgets::get_instance();
			return $nabla_widgets_pointer;
		}
	}

	// Automatically load widget classes when they are required with include
	// statements. The files are to be developed in the 'widgets' directory.	
	spl_autoload_register( 'nabla_widgets_register_classes' );
	
	// Autoloader ... this is load the class files that we call
	// within this php file. 
	function nabla_widgets_register_classes( $class_name ) {

		if (strpos($class_name, 'nabla_widgets') !== false) {

			// We will look in these directories for the class files. 
			if ( class_exists( $class_name ) ) {return;}
			$array_paths = array(	
       			'widgets/',
       			'widgets/admin/',
   			);

			//load the needed class files
		    foreach($array_paths as $path)
   			{		
   				// Class name is the class we call, and class file is the file the class
   				// is located in. Therefore, if we have a class called my_myclass then 
   				// we must store it in my-class.php in one of the directories above ... 
 				$class_file = str_replace( '_', '-', $class_name );    			
				$class_path = plugin_dir_path( __FILE__ ). $path . $class_file . '.php';

				if ( file_exists( $class_path ) ) {include $class_path; return;}
			} 
		}
	}

	//run the plugin
	add_action( 'plugins_loaded', array( 'nabla_widgets', 'init' ));
	
	//register widgets
	//add_action( 'widgets_init', function(){
	//	register_widget( 'nabla_widgets_minimal' );
	//});

	add_action( 'widgets_init', function(){
		register_widget( 'nabla_widgets_fancy_caption' );
	});

	add_action( 'widgets_init', function(){
		register_widget( 'nabla_widgets_fancy_text' );
	});
	
	add_action( 'widgets_init', function(){
		register_widget( 'nabla_widgets_fancy_image' );
	});
	
	add_action( 'widgets_init', function(){
		register_widget( 'nabla_widgets_fancy_title' );
	});