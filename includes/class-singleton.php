<?php
/**
 * Singleton
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
 * Singleton trait
 *
 * @class Plugin_Name\Includes\Singleton
 * @since 1.0.0
 */
trait Singleton {

  /**
   * Class Object
   *
   * @since 1.0.0
   * @var object
   */
  protected static $instance = null;

  /**
   * Singleton instance
   *
   * @since 1.0.0
   * @access public
   */
  final public static function get_instance() {

    if (is_null(static::$instance)) {
      static::$instance = new static();
    }

    return static::$instance;
  }

  /**
   * Private constructor
   *
   * @since 1.0.0
   * @access private
   */
  final private function __construct() {

    $this->init();
  }

  /**
   * Default init method
   * This method can be overridden if needed.
   *
   * @since 1.0.0
   * @access protected
   */
  protected function init() {}

  /**
   * Prevent clonning of the singleton object
   *
   * @since 1.0.0
   * @access private
   */
  private function __clone() {}

  /**
   * Prevent de-serializing of the Singleton object
   *
   * @since 1.0.0
   * @access private
   */
  public function __wakeup() {}
}
