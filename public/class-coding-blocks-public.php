<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://fb.com/simon.ugorji.106
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
class Coding_Blocks_Public
{

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
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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
		//Get theme from configuration

		$config = get_option('coding_blocks_config') ? json_decode(get_option('coding_blocks_config')) : null;

		$theme = ( !empty($config->theme) ) ? $config->theme : 'pinky-night';

		//REGISTER USER'S THEME CSS
		wp_register_style('coding-blocks-theme', plugin_dir_url(__FILE__) . 'lib/themes/' .$theme. '.css', false, $this->version); 
		
		//enqueue
		wp_enqueue_style('coding-blocks-theme');

		//enqueue default css
		wp_enqueue_style($this->plugin_name . '-default-theme', plugin_dir_url(__FILE__) . 'css/default-theme.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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
		//enqueue JQUERY
		wp_enqueue_script('jquery');
		
		//enqueue google prettify
		wp_enqueue_script($this->plugin_name . '-prettify', plugin_dir_url(__FILE__) . 'lib/prettify/run_prettify.js?autoload=true&skin=', array(), $this->version, 'all');

		//enqueue public js
		wp_enqueue_script($this->plugin_name . '-public', plugin_dir_url(__FILE__) . 'js/coding-blocks-public.js', array(), $this->version, false);
	}

}
