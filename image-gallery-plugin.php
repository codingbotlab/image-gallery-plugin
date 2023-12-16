<?php
/*
Plugin Name: Image Gallery Plugin
Description: A versatile WordPress plugin for managing image galleries with features like like, dislike, social media sharing, and comments.
Version: 1.0
Author: Mayank Kumar
*/

// Include admin files
require_once plugin_dir_path(__FILE__) . 'js/functions.php';
require_once plugin_dir_path(__FILE__) . 'admin/menu.php';
require_once plugin_dir_path(__FILE__) . 'admin/image-callback.php';
require_once plugin_dir_path(__FILE__) . 'admin/add-image.php';
require_once plugin_dir_path(__FILE__) . 'admin/category.php';
require_once plugin_dir_path(__FILE__) . 'admin/tags.php';
require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
require_once plugin_dir_path(__FILE__) . 'admin/user-management.php';
require_once plugin_dir_path(__FILE__) . 'admin/image-details.php';

// Include shortcode file
require_once plugin_dir_path(__FILE__) . 'gallery-shortcodes.php';

// Include premium styles handler
require_once plugin_dir_path(__FILE__) . 'premium-styles-handler.php';

// Enqueue styles and scripts
function image_gallery_enqueue_scripts() {
    wp_enqueue_style('gallery-style', plugin_dir_url(__FILE__) . 'css/gallery-style.css');
    wp_enqueue_script('gallery-script', plugin_dir_url(__FILE__) . 'js/gallery-script.js');
}
add_action('admin_enqueue_scripts', 'image_gallery_enqueue_scripts');

function enqueue_custom_styles() {
    // If it's a plugin
    wp_enqueue_style('custom-dwnbtn-styles', plugins_url('css/dwnbtn.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'enqueue_custom_styles');


function enqueue_custom_template_styles() {
    // If it's a plugin
    wp_enqueue_style('custom-template-styles', plugins_url('css/custom-style-default.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'enqueue_custom_template_styles');










