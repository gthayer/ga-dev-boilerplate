<?php
/**
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           GA_Dev_Boilerplate
 *
 * @wordpress-plugin
 * Plugin Name:       GA Dev Boilerplate
 * Description:       A simple WordPress boilerplate plugin for Google Analytics development.
 * Version:           1.0.0
 * Author:            Gary Thayer
 * Author URI:        http://hallme.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ga-dev-boilerplate
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


class GA_Dev_Boilerplate {
	/**
	 * Instance of this class.
	 *
	 * @since	 1.0.0
	 *
	 * @var		object
	 */
	protected static $instance = null;

	/**
	 * Plugin Name
	 *
	 * @since	 1.0.0
	 *
	 * @var		string
	 */
	public $plugin_name;

	/**
	 * Version
	 *
	 * @since	 1.0.0
	 *
	 * @var		string
	 */
	public $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks.
	 *
	 * @since	1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'ga_dev_boilerplate';
		$this->version = '1.0.0';

		add_action( 'wp_enqueue_scripts', array( $this, 'scripts_styles' ) );
		add_filter( 'clean_url', array( $this, 'async_url' ), 11, 1 );
		add_action( 'wp_head', array( $this, 'display_ga_snippet' ) );

		// You may add any other hooks here.
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since	  1.0.0
	 *
	 * @return	 object	 A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @since	  1.0.0
	 */
	public function scripts_styles() {
		if ( ! is_admin() ) {
			wp_enqueue_script( $this->plugin_name, plugins_url( '/js/main_analytics.js?#asyncload', __FILE__ ), 'jquery', $this->version, false );
		}
	}

	/**
	 * Add async attribute to JS file links
	 *
	 * @since 	1.0.0
	 *
	 * @param 	string 	$url Script and Styles URL.
	 * @return 	string	A version of the file link, possibly with an async attribute.
	 */
	public function async_url( $url ) {
		if ( strpos( $url, '#asyncload' ) === false ) {
			return $url;
		} else if ( is_admin() ) {
			return str_replace( '#asyncload', '', $url );
		} else {
			return str_replace( '#asyncload', '', $url ) . "' async='async";
		}
	}

	/**
	 * Echo the GA snippet in the header
	 *
	 * @since	  1.0.0
	 */
	public function display_ga_snippet() {
		echo "
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-XXXXXXX-X', 'auto');
			ga('require', 'linkid', 'linkid.js');
			ga('require', 'displayfeatures');
			ga('require', 'main_analytics');
			ga('send', 'pageview');
		</script>
		";
	}
}

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
add_action( 'plugins_loaded', array( 'GA_Dev_Boilerplate', 'get_instance' ) );
