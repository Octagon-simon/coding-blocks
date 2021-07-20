<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://fb.com/simon.ugorji.7
 * @since      1.0.0
 *
 * @package    Coding_Blocks
 * @subpackage Coding_Blocks/admin
 */

/** 
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Coding_Blocks
 * @subpackage Coding_Blocks/admin
 * @author     Simon Ugorji <ugorji757@gmail.com>
 */
class Coding_Blocks_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

//ADD ADMIN MENU		
add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9); 
	}

	/**
	 * Register the stylesheets for the admin area.
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
			

		
/*
*
* Register and enqueue a custom stylesheet in the WordPress admin.
*
*/
   
   //REGISTER BULMA CSS
   wp_register_style( 'coding-blocks-bulma', plugin_dir_url( __FILE__ ) . 'css/bulma.css', false, $this->version );
   
   //REGISTER CODINGBLOCKS CSS
   wp_register_style( 'coding-blocks-admin', plugin_dir_url( __FILE__ ) . 'css/coding-blocks-admin.css', false, $this->version );

   //REGISTER FONTAWESOME
 wp_register_style( 'coding-blocks-fontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', false, '5.15.3' );

   //ENQUEUE THEM
   wp_enqueue_style('coding-blocks-bulma');
   wp_enqueue_style('coding-blocks-admin');
   wp_enqueue_style('coding-blocks-fontAwesome');

  //ADD ACTION
add_action( 'admin_enqueue_scripts', 'enqueue_styles' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
wp_enqueue_script( $this->plugin_name .'-prettify', plugin_dir_url( __FILE__ ) . 'prettify/run_prettify.js?autoload=true&skin=sunburst', array(), $this->version, 'all' );

       //ENQUEUE CODINGBLOCKS CLIPBOARD JS
wp_enqueue_script( $this->plugin_name .'-clipboard', plugin_dir_url( __FILE__ ) . 'js/clipboard.js', array(), $this->version, 'screen' );

       //ENQUEUE CODINGBLOCKS ADMIN JS
wp_enqueue_script( $this->plugin_name .'-admin', plugin_dir_url( __FILE__ ) . 'js/coding-blocks-admin.js', array(), $this->version, 'screen' );
      
	  //ADD ACTION
    add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
	}


public function addPluginAdminMenu() {
		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page(  $this->plugin_name, 'Coding Blocks', 'administrator', $this->plugin_name, array( $this, 'DisplayCodingBlocksGetStartedPage' ), 'dashicons-shortcode', 26 );
		
		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page( $this->plugin_name, 'Coding Block Insert', 'Insert Code', 'administrator', $this->plugin_name.'-block-insert', array( $this, 'DisplayCodingBlockBuildPage' ));

		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page( $this->plugin_name, 'Coding Block Configure', 'Configure', 'administrator', $this->plugin_name.'-block-configure', array( $this, 'DisplayCodingBlockConfigurePage' ));

				//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page( $this->plugin_name, 'Coding Block About', 'About', 'administrator', $this->plugin_name.'-about', array( $this, 'DisplayCodingBlockAboutPage' ));
	}


	public function DisplayCodingBlocksGetStartedPage() {
	require( dirname( __FILE__ ) . '/pages/header.php' );
		require( dirname( __FILE__ ) . '/pages/get-started.php' );
		require( dirname( __FILE__ ) . '/pages/footer.php' );
  }

public function DisplayCodingBlockBuildPage() {

require( dirname( __FILE__ ) . '/pages/header.php' );
		require( dirname( __FILE__ ) . '/pages/block-insert.php' );
		require( dirname( __FILE__ ) . '/pages/footer.php' );
}

	public function DisplayCodingBlockConfigurePage() {
		
	$formflag = 0;
	if(isset($_GET['action']) && $_GET['action']=='block-del' )
	{
		require( dirname( __FILE__ ) . '/pages/header.php' );
		include( dirname( __FILE__ ) . '/pages/block-del.php');
		require( dirname( __FILE__ ) . '/pages/footer.php' );
		$formflag=1;
	}
if(isset($_GET['action']) && $_GET['action']=='block-insert' )
	{
		require( dirname( __FILE__ ) . '/pages/header.php' );
		include( dirname( __FILE__ ) . '/pages/block-insert.php');
		require( dirname( __FILE__ ) . '/pages/footer.php' );
		$formflag=1;
	}

	if(isset($_GET['action']) && $_GET['action']=='block-edit' )
	{
		require( dirname( __FILE__ ) . '/pages/header.php' );
		include( dirname( __FILE__ ) . '/pages/block-edit.php');
		require( dirname( __FILE__ ) . '/pages/footer.php' );
		$formflag=1;
	}
	if($formflag == 0){
		require( dirname( __FILE__ ) . '/pages/header.php' );
		require( dirname( __FILE__ ) . '/pages/blocks.php' );
		require( dirname( __FILE__ ) . '/pages/footer.php' );
	}
		//require_once 'partials/'.$this->plugin_name.'-admin-configure.php';
	}

	public function DisplayCodingBlockAboutPage() {

require( dirname( __FILE__ ) . '/pages/header.php' );
		require( dirname( __FILE__ ) . '/pages/about.php' );
		require( dirname( __FILE__ ) . '/pages/footer.php' );
}

}