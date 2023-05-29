<?php
/**
 * Admin
 *
 * @package   Plugin_Name
 * @author    Mirko Schubert
 * @copyright 2023 Mirko Schubert
 */

namespace Plugin_Name\Admin;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
  exit;
}

final class Admin extends Async {

  /**
   * Action name
   *
   * @since 1.0.0
   * @var string
   */
  protected $action = PLUGIN_SLUG . '_admin';

  /**
   * Render plugin panel
   *
   * @since 1.0.0
   * @access public
   */
  public function render_panel() {

    ob_start();
    //require PLUGIN_PATH . 'admin/views/panels/plugin.php';
    return ob_get_clean();
  }

}