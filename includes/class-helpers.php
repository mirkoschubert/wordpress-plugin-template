<?php
/**
 * Helpers
 *
 * @package   Plugin_Name
 * @author    Mirko Schubert
 * @since     1.0.0
 */

namespace Plugin_Name\Includes;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Helpers methods
 *
 * @class Plugin_Name\Includes\Helpers
 * @since 1.0.0
 */
class Helpers {


  /**
	 * Convert php.ini number notation (e.g.: '2M') to an integer
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $size Size value.
	 * @return integer
	 */
	public static function let_to_num( $size ) {
		$let = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );
		switch ( strtoupper( $let ) ) {
			case 'P':
				$ret *= 1024;
				// no break.
			case 'T':
				$ret *= 1024;
				// no break.
			case 'G':
				$ret *= 1024;
				// no break.
			case 'M':
				$ret *= 1024;
				// no break.
			case 'K':
				$ret *= 1024;
		}
		return $ret;
	}


  /**
	 * Get user capability
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public static function get_user_capability() {

		return apply_filters( PLUGIN_SLUG . '/user_capability', 'manage_options' );
	}

  /**
   * Check user capability
   *
   * @since 1.0.0
   * @access public
   *
   * @return boolean
   */
  public static function current_user_can() {

    $capability = self::get_user_capability();
    return current_user_can($capability);
  }

  /**
   * Get plugin page
   *
   * @since 1.0.0
   * @access public
   *
   * @return string
   */
  public static function get_plugin_page() {

    global $plugin_page;

    $page = $plugin_page ?: '';
    if (wp_doing_ajax()) {
      $path = wp_parse_url(wp_get_referer());
      if (isset($path['query'])) {
        wp_parse_str($path['query'], $output);
      }
      if (!isset($output['page'])) {
        return '';
      }
      $page = $output['page'];
    }
    if (strpos($page, PLUGIN_SLUG . '-') !== 0) {
      return '';
    }
    return str_replace(PLUGIN_SLUG . '-', '', $page);
  }


  /**
	 * Get activated plugins
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return number
	 */
	public static function get_active_plugins() {

		$active_plugins = (array) get_option( 'active_plugins' );
		if ( is_multisite() ) {
			$network_plugins = (array) get_site_option( 'active_sitewide_plugins' );
			$network_plugins = array_keys( $network_plugins );
			$active_plugins  = array_merge( $active_plugins, $network_plugins );
		}
		return $active_plugins;
	}


  /**
	 * Get debug mode state
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return boolean
	 */
	public static function get_debug_mode() {
		return defined( 'WP_DEBUG' ) && WP_DEBUG;
	}


  /**
	 * Get PHP memory limit
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public static function get_memory_limit() {

		// Set default limit in case.
		$memory_limit = '128M';
		if ( function_exists( 'ini_get' ) ) {
			$memory_limit = ini_get( 'memory_limit' );
		}
		// If unlimited memory.
		if ( ! $memory_limit || -1 === (int) $memory_limit ) {
			return '&infin;';
		}
		$memory_limit = self::let_to_num( $memory_limit );
		$memory_limit = size_format( $memory_limit );
		return $memory_limit;
	}


  /**
	 * Get PHP memory usage
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public static function get_memory_usage() {

		$memory_usage = __( 'unknown', 'speedyfy' );
		if ( function_exists( 'memory_get_usage' ) ) {
			$memory_usage = memory_get_usage();
			$memory_usage = size_format( $memory_usage );
		}
		return $memory_usage;
	}


  /**
	 * Get WordPress max upload size
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public static function get_max_upload_size() {

		$max_upload_size = wp_max_upload_size();
		$max_upload_size = size_format( $max_upload_size );
		return $max_upload_size;
	}


  /**
	 * Get PHP software
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public static function get_server_software() {

		$server_software = __( 'unknown', 'speedyfy' );
		if ( ! empty( $_SERVER['SERVER_SOFTWARE'] ) ) {
			$server_software = wp_unslash( $_SERVER['SERVER_SOFTWARE'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		}
		return $server_software;
	}


  /**
	 * Get PHP post max size
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public static function get_post_max_size() {

		$post_max_size = __( 'unknown', 'speedyfy' );
		if ( function_exists( 'ini_get' ) ) {
			$post_max_size = ini_get( 'post_max_size' );
			$post_max_size = self::let_to_num( $post_max_size );
			$post_max_size = size_format( $post_max_size );
		}
		return $post_max_size;
	}


  /**
	 * Get PHP max execution time
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return number
	 */
	public static function get_max_execution_time() {

		$max_execution_time = __( 'unknown', 'speedyfy' );
		if ( function_exists( 'ini_get' ) ) {
			$max_execution_time = ini_get( 'max_execution_time' );
		}
		return $max_execution_time;
	}


  /**
	 * Get PHP max input vars
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return number
	 */
	public static function get_max_input_vars() {

		$max_input_vars = 1000;
		if ( version_compare( PHP_VERSION, '5.3.9', '>=' ) && function_exists( 'ini_get' ) ) {
			$max_input_vars = ini_get( 'max_input_vars' );
		}
		return $max_input_vars;
	}
}
