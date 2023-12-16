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

    // Add submenus for each callback
    
    add_submenu_page('image-gallery', 'Add Image', 'Add Image', 'manage_options', 'add-image', 'add_image_page');
    add_submenu_page('image-gallery', 'Manage Categories', 'Manage Categories', 'manage_options', 'manage-categories', 'manage_category_page');
    add_submenu_page('image-gallery', 'Manage Tags', 'Manage Tags', 'manage_options', 'manage-tags', 'manage_tags_page');
    add_submenu_page('image-gallery', 'Plugin Settings', 'Plugin Settings', 'manage_options', 'plugin-settings', 'plugin_settings_page');
    add_submenu_page('image-gallery', 'User Management', 'User Management', 'manage_options', 'user-management', 'user_management_page');
    add_submenu_page('image-gallery', 'Upgrade', 'Upgrade', 'manage_options', 'Upgrade', 'upgrade_page');
}
add_action('admin_menu', 'add_admin_menu');


// ... (Other callback functions remain the same)
?>
