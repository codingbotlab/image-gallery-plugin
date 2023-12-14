<?php
/*
Plugin Name: Image Gallery Plugin
Description: A versatile WordPress plugin for managing image galleries with features like like, dislike, social media sharing, and comments.
Version: 1.0
Author: Mayank Kumar
*/

// Include admin files
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
    wp_enqueue_style('gallery-style', plugin_dir_url(__FILE__) . 'css/gallery-style.css', array(), '1.0', 'all');
    wp_enqueue_script('gallery-script', plugin_dir_url(__FILE__) . 'js/gallery-script.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'image_gallery_enqueue_scripts');
