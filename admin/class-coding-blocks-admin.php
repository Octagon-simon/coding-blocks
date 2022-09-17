<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://fb.com/simon.ugorji.106
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
class Coding_Blocks_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		//ADD ADMIN MENU				
		add_action('admin_menu', array($this, 'addPluginAdminMenu'), 9);
	}

	/**
	 * Register the stylesheets for the admin area.
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

		/*Register and enqueue a custom stylesheet in the WordPress admin*/

		//REGISTER BULMA CSS
		//wp_register_style('coding-blocks-bulma', plugin_dir_url(__FILE__) . 'css/bulma.css', false, $this->version);

		//REGISTER CODINGBLOCKS CSS
		wp_register_style('coding-blocks-admin', plugin_dir_url(__FILE__) . 'css/coding-blocks-admin.css', false, $this->version);

		//REGISTER CODINGBLOCKS DEFAULT THEME
		wp_register_style('coding-blocks-default-theme', plugin_dir_url(__FILE__) . 'css/default-theme.css', false, $this->version);

		//Enqueue registered stylesheets

		//wp_enqueue_style('coding-blocks-bulma');
		wp_enqueue_style('coding-blocks-default-theme');
		wp_enqueue_style('coding-blocks-admin');
		wp_enqueue_style('coding-blocks-theme');

		//ADD ACTION
		add_action('admin_enqueue_scripts', 'enqueue_styles');

	}

	/**
	 * Register the JavaScript for the admin area.
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

		//enqueue jquery
		wp_enqueue_script('jquery');

		//ENQUEUE GOOGLE PRETTIFY JS		
		wp_enqueue_script($this->plugin_name . '-prettify', plugin_dir_url(__FILE__) . 'lib/prettify/run_prettify.js?autoload=true&skin=', array(), $this->version, 'all');

		//ENQUEUE CODINGBLOCKS ADMIN JS		
		wp_enqueue_script($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'js/coding-blocks-admin.js', array(), $this->version, 'screen');

		//ADD ACTION
		add_action('wp_enqueue_scripts', 'enqueue_scripts');
	}

	public function addPluginAdminMenu()
	{
		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page(__( $this->plugin_name, 'Coding Blocks' ), 'Coding Blocks', 'administrator', $this->plugin_name, array($this, 'DisplayCodingBlocksGetStartedPage'), 'dashicons-shortcode', 26);

		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page($this->plugin_name, 'Coding Blocks | New Snippet', 'New Snippet', 'administrator', $this->plugin_name . '-new-snippet', array($this, 'DisplayCodingBlocksNewSnippetPage'));

		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page($this->plugin_name, 'Coding Blocks | Manage Snippets', 'Manage Snippets', 'administrator', $this->plugin_name . '-snippets', array($this, 'DisplayCodingBlocksEditPage'));

		//preview snippets
		add_submenu_page($this->plugin_name, 'Coding Blocks | Theme Preview', 'Theme Preview', 'administrator', $this->plugin_name . '-preview', array($this, 'DisplayCodingBlocksPreviewPage'));

		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		add_submenu_page($this->plugin_name, 'Coding Blocks | Plugin Options', 'Plugin Options', 'administrator', $this->plugin_name . '-settings', array($this, 'DisplayCodingBlocksOptionsPage'));
	}


	public function DisplayCodingBlocksGetStartedPage()
	{
		require(dirname(__FILE__) . '/pages/get-started.html');
		require(dirname(__FILE__) . '/pages/footer.html');
	}
	public function DisplayCodingBlocksNewSnippetPage()
	{
		require(dirname(__FILE__) . '/pages/new-snippet.php');
		require(dirname(__FILE__) . '/pages/footer.html');
	}

	public function DisplayCodingBlocksEditPage()
	{

		$formflag = 0;
		if (isset($_GET['action']) && $_GET['action'] == 'delete-snippet') {
			include(dirname(__FILE__) . '/pages/delete-snippet.php');
			require(dirname(__FILE__) . '/pages/footer.html');
			$formflag = 1;
		}
		if (isset($_GET['action']) && $_GET['action'] == 'new-snippet') {
			include(dirname(__FILE__) . '/pages/new-snippet.php');
			require(dirname(__FILE__) . '/pages/footer.html');
			$formflag = 1;
		}

		if (isset($_GET['action']) && $_GET['action'] == 'edit-snippet') {
			include(dirname(__FILE__) . '/pages/edit-snippet.php');
			require(dirname(__FILE__) . '/pages/footer.html');
			$formflag = 1;
		}
		if ($formflag == 0) {
			require(dirname(__FILE__) . '/pages/snippets.php');
			require(dirname(__FILE__) . '/pages/footer.html');
		}
	}

	public function DisplayCodingBlocksOptionsPage()
	{
		require(dirname(__FILE__) . '/pages/settings.php');
		require(dirname(__FILE__) . '/pages/footer.html');
	}

	public function DisplayCodingBlocksPreviewPage()
	{
		require(dirname(__FILE__) . '/pages/preview.html');
		require(dirname(__FILE__) . '/pages/footer.html');
	}

}

