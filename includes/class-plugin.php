<?php
/**
 * Initialize plugin
 *
 * @package   Plugin_Name
 * @author    Mirko Schubert
 * @since     1.0.0
 */

namespace Plugin_Name\Includes;

//use Plugin_Name\FrontEnd;
use Plugin_Name\Admin;
use Plugin_Name\Includes;
//use Plugin_Name\Includes\Settings\Settings;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Instance of the plugin
 *
 * @class Plugin_Name\Includes\Plugin
 * @since 1.0.0
 */
final class Plugin
{

    use Includes\Singleton;

    /**
     * Holds plugin instances
     *
     * @since  1.0.0
     * @access public
     *
     * @var object
     */
    protected $instances;

    /**
     * Constructor
     *
     * @since  1.0.0
     * @access public
     */
    public function __construct()
    {

        global $wp_version;

        $is_wp_5_1 = version_compare($wp_version, '5.1', '>=');
        $site_hook = $is_wp_5_1 ? 'wp_initialize_site' : 'wpmu_new_blog';

        add_action('plugins_loaded', [$this, 'init'], 0);
        add_action($site_hook, [$this, 'insert_site']);
        add_action('wpmu_drop_tables', [$this, 'delete_site']);
        add_action('upgrader_process_complete', [$this, 'update'], 10, 2);

        register_activation_hook(PLUGIN_FILE, [$this, 'activation']);
        register_deactivation_hook(PLUGIN_FILE, [$this, 'deactivation']);

    }

    /**
     * Magic get method
     *
     * @since  1.0.0
     * @access public
     *
     * @param  string $name Instance name.
     * @return mixed.
     */
    public function __get($name) {
        return $this->instances->$name;
    }

    /**
     * Magic set method
     *
     * @since  1.0.0
     * @access public
     *
     * @param  string $name  Instance name.
     * @param  string $class Instance class.
     * @return mixed.
     */
    public function __set($name, $class) {
        if (!isset($this->instances)) {
            $this->instances = (object) [];
        }
        $this->instances->$name = $class;
    }

    /**
     * Magic isset method
     *
     * @since  1.0.0
     * @access public
     *
     * @param  string $name Instance name.
     * @return boolean.
     */
    public function __isset($name) {
        return isset($this->instances->$name);
    }

    /**
     * Init instances
     *
     * @since  1.0.0
     * @access public
     */
    public function init() {

        do_action(PLUGIN_SLUG . '/loaded');

        $this->load_textdomain();
        //$this->includes();
        //$this->init_front();
        $this->initAdmin();

        do_action(PLUGIN_SLUG . '/init');
    }

    /**
     * Includes main helpers
     *
     * @since  1.0.0
     * @access public
     */
    public function includes()
    {

        //new Includes\I18n();
        //new Includes\Extend();
        //new Includes\Indexer();
        //new Includes\REST_API();
        //new Includes\Gutenberg();

    }

    /**
     * Init frontend plugin
     *
     * @since  1.0.0
     * @access public
     */
    public function initFront()
    {

        //new FrontEnd\Init();
        //new FrontEnd\Localize();
        //new FrontEnd\REST_API();
        //new FrontEnd\Intercept();

        //FrontEnd\Filter::get_instance();
        //FrontEnd\Styles::get_instance();
        //FrontEnd\Scripts::get_instance();

    }

    /**
     * Init backend plugin
     *
     * @since  1.0.0
     * @access public
     */
    public function initAdmin()
    {

        if (!is_admin()) {
            return;
        }

        //$this->settings = Settings::get_instance();

        //new Admin\Settings();
        //new Admin\Menu();
        //new Admin\posts();
        //new Admin\Plugin();
        //new Admin\Actions();
        //new Admin\TinyMCE();
        //new Admin\MetaBox();
        new Admin\Enqueue();
        //new Admin\Localize();

    }

    /**
     * Create custom tables and delete transients on plugin update
     *
     * @since  1.0.0
     * @access public
     *
     * @param array $upgrader_object Holds upgrader arguments.
     * @param array $options         Holds plugin options.
     */
    public function update($upgrader_object, $options)
    {

        if ('update' !== $options['action'] || 'plugin' !== $options['type']) {
            return;
        }

        if (empty($options['plugins'])) {
            return;
        }

        foreach ($options['plugins'] as $plugin) {
            if (PLUGIN_BASE === $plugin) {
                $network_wide = is_plugin_active_for_network(PLUGIN_BASE);

                //Includes\Database::create_tables($network_wide, true);
                //Includes\Helpers::delete_transient();

                // Trigger action when plugin is updated.
                do_action(PLUGIN_SLUG . '/updated');
                break;
            }
        }
    }

    public function load_textdomain() {
      load_plugin_textdomain(PLUGIN_SLUG, false, basename(dirname(PLUGIN_FILE)) . '/languages');
    }

    /**
     * Create custom tables and delete transients on plugin activation
     *
     * @since  1.0.0
     * @access public
     *
     * @param boolean $network_wide Whether to enable the plugin for all sites in the network.
     */
    public function activation($network_wide)
    {

        //Includes\Database::create_tables($network_wide, true);
        //Includes\Helpers::delete_transient();

        // Trigger action when plugin is activated.
        do_action(PLUGIN_SLUG . '/activated');

    }

    /**
     * Delete transients on plugin deactivation
     *
     * @since  1.0.0
     * @access public
     */
    public function deactivation()
    {

        //Includes\Helpers::delete_transient();
        //wp_clear_scheduled_hook('wpgb_cron');

        // Trigger action when plugin is deactivated.
        do_action(PLUGIN_SLUG . '/deactivated');

    }

    /**
     * Create custom tables whenever a new site is created (multisite)
     *
     * @since  1.0.0
     * @access public
     *
     * @param WP_Site|integer $new_site New site object | New site id.
     */
    public function insertSite($new_site)
    {

        global $wp_version;

        if (!is_plugin_active_for_network(PLUGIN_BASE)) {
            return;
        }

        if ('wpmu_new_blog' === current_action()) {
            $site_id = $new_site;
        } else {
            $site_id = $new_site->id;
        }

        switch_to_blog($site_id);
        //Includes\Database::create_tables(true, true);
        restore_current_blog();

    }

    /**
     * Delete custom tables whenever a site is delete (multisite)
     *
     * @since  1.0.0
     * @access public
     *
     * @param array $tables New site object.
     */
    public function deleteSite($tables)
    {

        /* global $wpdb;

        return array_merge(
        [
        "{$wpdb->prefix}wpgb_grids",
        "{$wpdb->prefix}wpgb_cards",
        "{$wpdb->prefix}wpgb_index",
        "{$wpdb->prefix}wpgb_facets",
        ],
        $tables
        ); */

    }
}
