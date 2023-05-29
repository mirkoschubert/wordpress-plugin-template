<?php
/**
 * Enqueue
 *
 * @package   Plugin_Name
 * @author    Mirko Schubert
 * @since     1.0.0
 */

namespace Plugin_Name\Admin;

use Plugin_Name\Includes\Helpers;
use Plugin_Name\Includes\Loaders;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue admin assets
 *
 * @class Plugin_Name\Admin\Enqueue
 * @since 1.0.0
 */
class Enqueue {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		add_action('admin_enqueue_scripts', [$this, 'plugin_page_scripts']);
		//add_action( 'admin_enqueue_scripts', [ $this, 'plugin_post_scripts' ] );
		//add_action( 'admin_enqueue_scripts', [ $this, 'plugin_term_scripts' ] );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function plugin_page_scripts() {

		$plugin_page = Helpers::get_plugin_page();

		if (empty($plugin_page)) {
			return;
		}

		$this->enqueue_wp_scripts();
		$this->enqueue_main_script();

		switch ($plugin_page) {
			case 'settings':
				$this->enqueue_settings();
				break;
		}
	}



	/**
	 * Enqueue WordPress scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_wp_scripts() {
		wp_enqueue_media();
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_style('wp-color-picker');
	}

	/**
	 * Enqueue main admin panel scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_main_script() {
		wp_enqueue_script(PLUGIN_SLUG . '-helpers', PLUGIN_URL . 'admin/assets/js/helpers.js', [], PLUGIN_VERSION, true);
		wp_enqueue_script(PLUGIN_SLUG . '-admin', PLUGIN_URL . 'admin/assets/js/admin.js', ['jquery'], PLUGIN_VERSION, true);
		wp_enqueue_style(PLUGIN_SLUG . '-admin', PLUGIN_URL . 'admin/assets/css/admin.css', [], PLUGIN_VERSION);
	}



	/**
	 * Enqueue Codemirror scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_codemirror() {

		//wp_enqueue_script( PLUGIN_SLUG . '-code-script', PLUGIN_URL . 'admin/assets/js/codemirror.js', [], PLUGIN_VERSION, true );
		//wp_enqueue_style( PLUGIN_SLUG . '-code-style', PLUGIN_URL . 'admin/assets/css/codemirror.css', [], PLUGIN_VERSION );
	}

	/**
	 * Enqueue settings scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_settings() {

		wp_enqueue_script(PLUGIN_SLUG . '-settings', PLUGIN_URL . 'admin/assets/js/settings.js', ['jquery'], PLUGIN_VERSION, true);
	}
}
