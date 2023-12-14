<?php
// Admin Menu

// Function to add a custom menu in the WordPress admin dashboard
function add_admin_menu() {
    add_menu_page(
        'Image Gallery',    // Page title
        'Image Gallery',    // Menu title
        'manage_options',   // Capability required to access
        'image-gallery',    // Menu slug
        'image_gallery_page',// Callback function to display content
        'dashicons-images', // Icon (you can choose from Dashicons)
        20                  // Menu position
    );
}
add_action('admin_menu', 'add_admin_menu');

// Callback function to display content on the custom admin menu page
function image_gallery_page() {
    // Your admin menu page content here
    echo '<div class="wrap">';
    echo '<h2>Image Gallery</h2>';
    // Add your content here
    echo '</div>';
}
?>
