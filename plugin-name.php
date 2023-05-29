<?php
/**
 * Plugin Name:       WordPress Plugin Template
 * Plugin URI:        https://example.com/plugin-name-uri/
 * Description:       A opinionated WordPress Plugin Template.
 * Author:            Mirko Schubert
 * Author URI:        https://mirkoschubert.de/
 * 
 * Version:           1.0.0
 * Requires at least: 5.6
 * Tested up to:      6.3
 * 
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * 
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 * 
 * @package           Plugin_Name
 * @author            Mirko Schubert
 * @link              https://mirkoschubert.de/
 * @since             1.0.0
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define('PLUGIN_NAME', 'Plugin_Name');
define('PLUGIN_SLUG', 'plugin-name');
define('PLUGIN_VERSION', '1.0.0');
define('PLUGIN_MIN_PHP', '7.4.0');
define('PLUGIN_MIN_WP', '5.6');
define('PLUGIN_FILE', __FILE__);
define('PLUGIN_BASE', plugin_basename(PLUGIN_FILE));
define('PLUGIN_PATH', plugin_dir_path(PLUGIN_FILE));
define('PLUGIN_URL', plugin_dir_url(PLUGIN_FILE));

// Include autoloader.
require_once PLUGIN_PATH . 'includes/class-autoload.php';

/**
 * Get and initialize the plugin instance.
 *
 * @since  1.0.0
 * @return \Plugin_Name\Includes\Plugin Plugin instance
 */
function plugin_name() {
    // To prevent parse error for PHP prior to 5.3.0.
    $class = '\Plugin_Name\Includes\Plugin';
    return $class::get_instance();
}

plugin_name();