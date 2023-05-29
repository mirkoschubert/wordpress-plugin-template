<?php

/**
 * The public-specific functionality of the plugin.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/Public
 * @since      1.0.0
 */

class Plugin_Name_Public {

  private static $_instance = null; 

  public function __construct() {

  }

  public function enqueue_styles() {

		wp_enqueue_style(PLUGIN_NAME, plugin_dir_url(__FILE__) . 'assets/css/main.css', array(), PLUGIN_VERSION, 'all');
	}

  public function enqueue_scripts() {

		wp_enqueue_script(PLUGIN_NAME, plugin_dir_url(__FILE__) . 'assets/js/main.js', array('jquery'), PLUGIN_VERSION, false);
	}

  public static function instance( $file = '', $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	}
}