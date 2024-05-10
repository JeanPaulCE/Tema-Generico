<?php
/**
 * chocucos Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package chocucos
 * @since 1.0.0
 */

/**
 * Define Constants
 */

define( 'CHILD_THEME_CHOCUCOS_VERSION', '1.0.0' );

require_once __DIR__ . '/campos_personalizados.php';

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'chocucos-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_CHOCUCOS_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function custom_register_header_post_type() {
    $header = array(
        'public' => true,
        'label'  => 'Headers',
        'supports' => array( 'title', 'editor' ),
        'show_in_rest' => true,
        'menu_position' => 4,
    );
    $footer = array(
        'public' => true,
        'label'  => 'Footers',
        'supports' => array( 'title', 'editor' ),
        'show_in_rest' => true,
        'menu_position' => 4,
    );
   
    register_post_type( 'header', $header );
    register_post_type( 'footer', $footer );
    
    
}
add_action( 'init', 'custom_register_header_post_type' );

function custom_elementor_support() {
    add_post_type_support( 'header', 'elementor' );
    add_post_type_support( 'footer', 'elementor' );
}



