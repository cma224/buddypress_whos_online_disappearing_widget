<?php
/*
Plugin Name: BP Who's Online Disappearing Widget
Description: This is a custom version of the BuddyPress "Who's Online" widget that hides the widget from logged out users.
Text Domain: buddypress
Domain Path: /languages
Version: 1.0.0
Author: Cristian Abello
Author URI: mailto:cristian.abello@valpo.edu
License: GNU AGPL
*/

if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'BP_Whos_Online_Disappearing_Widget_Framework' ) ) :


/**
 * BP_Whos_Online_Disappearing_Widget_Framework class.
 */
class BP_Whos_Online_Disappearing_Widget_Framework {


    /**
     * instance function.
     *
     * @access public
     * @static
     * @return \BP_Whos_Online_Disappearing_Widget_Framework $instance
     */
	public static function instance() {

		// Store the instance locally to avoid private static replication
		static $instance = null;

		// Only run these methods if they haven't been run previously
		if ( null === $instance ) {
			$instance = new BP_Whos_Online_Disappearing_Widget_Framework;
			$instance->actions();
		}

		// Always return the instance
		return $instance;
	}


    /**
     * __construct function.
     *
     * @access private
     * @return \BP_Whos_Online_Disappearing_Widget_Framework
     */
	private function __construct() { /* Do nothing here */ }
	
		public static function meets_requirements() {
		
		if ( class_exists('bp')){
			return true;
		}
		else{
			return false;
	}
	}
	

	/**
	 * actions function.
	 *
	 * @access private
	 * @return void
	 */
	private function actions() {


		add_action( 'bp_include', array( $this, 'includes' ) );

        // these are for template file overrides.
		add_action( 'bp_register_theme_packages', array( $this, 'bp_custom_templatepack_work' ) );
		add_filter( 'pre_option__bp_theme_package_id', array( $this, 'bp_custom_templatepack_package_id' ) );
		add_action( 'wp', array( $this, 'bp_templatepack_kill_legacy_js_and_css' ), 999 );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'widgets_init', function() { return register_widget( 'BP_Core_Whos_Online_Disappearing_Widget' );     } );
	}


	/**
	 * include function.
	 *
	 * @access public
	 * @return void
	 */
	public function includes() {
        // to include a file place it in the inc directory
        foreach( glob(  plugin_dir_path(__FILE__) . 'includes/*.php' ) as $filename ) {
            include $filename;
        }
	}
	
	
	/**
	 * enqueue_scripts function.
	 * 
	 * @access public
	 * @return void
	 */
	public function enqueue_scripts() {
	
	}


	/**
	 * templatepack_work function.
	 *
	 * @access public
	 * @return void
	 */
	public function bp_custom_templatepack_work() {

		bp_register_theme_package( array(
				'id'		 => 'templates',
				'name'	 => __( 'BuddyPress Templates', 'buddypress' ),
				'version' => bp_get_version(),
				'dir'	 => plugin_dir_path( __FILE__ ) . '/templates',
				'url'	 => plugin_dir_url( __FILE__ ) . '/templates'
			) );

	}


	/**
	 * templatepack_package_id function.
	 *
	 * @access public
	 * @param mixed $package_id
	 * @return void
	 */
	public function bp_custom_templatepack_package_id( $package_id ) {
		return 'templates';
	}


	
	/**
	 * templatepack_kill_legacy_js_and_css function.
	 *
	 * @access public
	 * @return void
	 */
	public function bp_templatepack_kill_legacy_js_and_css() {
		wp_dequeue_script( 'groups_widget_groups_list-js' );
		wp_dequeue_script( 'bp_core_widget_members-js' );
	}


}


/**
 * bp_custom_template_stack function.
 *
 * @access public
 * @return void
 */
function bp_whos_online_disappearing_widget_framework() {
	return BP_Whos_Online_Disappearing_Widget_Framework::instance();
}
    bp_whos_online_disappearing_widget_framework();

endif;
