<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://fb.com/simon.ugorji.7
 * @since      1.0.0
 *
 * @package    Coding_Blocks
 * @subpackage Coding_Blocks/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Coding_Blocks
 * @subpackage Coding_Blocks/public
 * @author     Simon Ugorji <ugorji757@gmail.com>
 */
class Coding_Blocks_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Coding_Blocks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Coding_Blocks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
//GET THEME FROM DB
global $wpdb;
$entries = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks_settings') ;
$theme = esc_sql($entries[0]->theme);

if (isset($theme)) {
define( 'CODING_BLOCKS_THEME', $theme);
}
else {
	define( 'CODING_BLOCKS_THEME', 'sunburst' );
}

 //REGISTER USER'S THEME CSS
wp_register_style( 'coding-blocks-theme', plugin_dir_url( __FILE__ ) . 'lib/themes/'.CODING_BLOCKS_THEME.'.css', false, $this->version );
//ENQUEUE THEM
wp_enqueue_style('coding-blocks-theme');

		 //ENQUEUE FONTAWESOME
		wp_enqueue_style( $this->plugin_name . '-fontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), $this->version, 'all' );

		//ENQUEUE COPYBTN CSS FILE
		wp_enqueue_style( $this->plugin_name . '-default-theme', plugin_dir_url( __FILE__ ) . 'css/default-theme.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Coding_Blocks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Coding_Blocks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

//ENQUEUE GOOGLE PRETTIFY JS
wp_enqueue_script( $this->plugin_name .'-prettify', plugin_dir_url( __FILE__ ) . 'lib/prettify/run_prettify.js?autoload=true&skin=', array(), $this->version, 'all' );
         //ENQUEUE COPYBUTTON JS
		wp_enqueue_script( $this->plugin_name .'-copy-btn', plugin_dir_url( __FILE__ ) . 'js/copy-button.js', array('jquery'), $this->version, false );

 		//ENQUEUE CLIPBOARD JS
		wp_enqueue_script( $this->plugin_name .'-clipboard', plugin_dir_url( __FILE__ ) . 'js/clipboard.js', array(), $this->version, false );

		//ENQUEUE PUBLIC ADMIN JS
		wp_enqueue_script( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'js/coding-blocks-public.js', array(), $this->version, false );

		//ENQUEUE DECODE ENTITY JS
		wp_enqueue_script( $this->plugin_name .'-decode-entity', plugin_dir_url( __FILE__ ) . 'js/decode_entity.js', array(), $this->version, false );

	}

}
