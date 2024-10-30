<?php
/*
Plugin Name: CSS Breakpoint Tools
Plugin URI: https://www.andreadegiovine.it/download/css-breakpoint-tools/?utm_source=wordpress_org&utm_medium=plugin_link&utm_campaign=css_breakpoint_tools
Description: This plugin help you to create multidevice CSS style, when save this options the plugin will adfd a CSS style in your section for all webpage.
Author: Andrea De Giovine
Author URI: https://www.andreadegiovine.it/?utm_source=wordpress_org&utm_medium=plugin_details&utm_campaign=css_breakpoint_tools
Text Domain: css-breakpoint-tools
Version: 0.1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Invalid request.' );
}

if ( ! class_exists( 'CSS_Breakpoint_Tools' ) ) {
    class CSS_Breakpoint_Tools {
        public $textdomain = 'css_breakpoint_tools';
        public $priority = PHP_INT_MAX;

        public function __construct(){
            add_action('admin_menu', array($this, 'wp_admin_page'), $this->priority );
            add_action( 'wp_head', array($this, 'css_breakpoint_head'), $this->priority );
        }
        public function wp_admin_page(){
            $css_page = add_submenu_page( 'themes.php', __('CSS Breakpoint Tools',$this->textdomain), __('CSS Breakpoint',$this->textdomain), 'manage_options', $this->textdomain, array($this, 'wp_admin_page_render') );

            add_action( 'admin_init', array( $this, 'css_breakpoint_tools_settings'), $this->priority );

            add_action( 'load-' . $css_page, array($this, 'wp_admin_assets_hook'), $this->priority );
        }
        public function wp_admin_assets_hook(){
            add_action( 'admin_enqueue_scripts', array($this, 'wp_admin_assets'), $this->priority );
        }
        public function wp_admin_assets(){
            wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
            wp_enqueue_script( 'css_breakpoint-code-editor', plugin_dir_url( __FILE__ ) . '/assets/css_breakpoint.js', array( 'jquery' ), '', true );
        }
        public function css_breakpoint_tools_settings() {
            register_setting( $this->textdomain, 'max_width_575_98_px' );
            register_setting( $this->textdomain, 'max_width_767_98_px' );
            register_setting( $this->textdomain, 'max_width_991_98_px' );
            register_setting( $this->textdomain, 'max_width_1199_98_px' );
        }
        public function wp_admin_page_render(){ ?>

<div class="wrap">
    <h1><?php echo __('CSS Breakpoint Tools',$this->textdomain);?></h1>
    <p><?php echo __('This plugin help you to create multidevice CSS style, when save this options the plugin will adfd a CSS style in your <head> section for all webpage.',$this->textdomain);?></p>

    <form method="post" action="options.php">
        <?php settings_fields( $this->textdomain ); ?>
        <?php do_settings_sections( $this->textdomain ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php echo __('Extra small devices (portrait phones, less than 576px)',$this->textdomain);?></th>
                <td><textarea rows="10" style="width: 100%;" name="max_width_575_98_px" class="code_editor_wp"><?php echo wp_unslash( esc_attr( get_option('max_width_575_98_px') ) ); ?></textarea></td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Small devices (landscape phones, less than 768px)',$this->textdomain);?></th>
                <td><textarea rows="10" style="width: 100%;" name="max_width_767_98_px" class="code_editor_wp"><?php echo wp_unslash( esc_attr( get_option('max_width_767_98_px') ) ); ?></textarea></td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Medium devices (tablets, less than 992px)',$this->textdomain);?></th>
                <td><textarea rows="10" style="width: 100%;" name="max_width_991_98_px" class="code_editor_wp"><?php echo wp_unslash( esc_attr( get_option('max_width_991_98_px') ) ); ?></textarea></td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php echo __('Large devices (desktops, less than 1200px)',$this->textdomain);?></th>
                <td><textarea rows="10" style="width: 100%;" name="max_width_1199_98_px" class="code_editor_wp"><?php echo wp_unslash( esc_attr( get_option('max_width_1199_98_px') ) ); ?></textarea></td>
            </tr>

        </table>

        <?php submit_button(); ?>

    </form>
</div>

<?php }
        public function css_breakpoint_head() {
            if ( '' !== esc_attr( get_option('max_width_1199_98_px') ) ) {
                echo "<style>\n@media only screen and (max-width: 1199.98px) {\n" . wp_unslash( esc_attr( get_option('max_width_1199_98_px') ) ) . "\n}\n</style>\n";
            }
            if ( '' !== esc_attr( get_option('max_width_991_98_px') ) ) {
                echo "<style>\n@media only screen and (max-width: 991.98px) {\n" . wp_unslash( esc_attr( get_option('max_width_991_98_px') ) ) . "\n}\n</style>\n";
            }
            if ( '' !== esc_attr( get_option('max_width_767_98_px') ) ) {
                echo "<style>\n@media only screen and (max-width: 767.98px) {\n" . wp_unslash( esc_attr( get_option('max_width_767_98_px') ) ) . "\n}\n</style>\n";
            }
            if ( '' !== esc_attr( get_option('max_width_575_98_px') ) ) {
                echo "<style>\n@media only screen and (max-width: 575.98px) {\n" . wp_unslash( esc_attr( get_option('max_width_575_98_px') ) ) . "\n}\n</style>\n";
            }
        }




    }
    new CSS_Breakpoint_Tools();
}