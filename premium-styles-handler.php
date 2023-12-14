<?php
// Premium Styles Handler

function is_user_premium() {
    // Implement logic to check if the user is premium (e.g., purchased the premium version)
    // Return true if premium, false otherwise
    return false; // Placeholder, replace with your logic
}

function enqueue_premium_styles() {
    if (is_user_premium()) {
        wp_enqueue_style('premium-style3', plugin_dir_url(__FILE__) . 'css/premium-style3.css', array('gallery-style'), '1.0', 'all');
        wp_enqueue_style('premium-style4', plugin_dir_url(__FILE__) . 'css/premium-style4.css', array('gallery-style'), '1.0', 'all');
        wp_enqueue_style('premium-style5', plugin_dir_url(__FILE__) . 'css/premium-style5.css', array('gallery-style'), '1.0', 'all');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_premium_styles');
?>
