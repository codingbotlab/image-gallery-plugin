<?php
// Image Gallery Shortcodes

// Shortcode for default style
function image_gallery_default_shortcode($atts) {
    // Your default gallery HTML and styling here
}
add_shortcode('image_gallery_default', 'image_gallery_default_shortcode');

// Shortcode for custom style 1
function image_gallery_style1_shortcode($atts) {
    // Your custom style 1 gallery HTML and styling here
}
add_shortcode('image_gallery_style1', 'image_gallery_style1_shortcode');

// Shortcode for custom style 2
function image_gallery_style2_shortcode($atts) {
    // Your custom style 2 gallery HTML and styling here
}
add_shortcode('image_gallery_style2', 'image_gallery_style2_shortcode');

// Shortcode for displaying detailed view of an image
function image_details_shortcode($atts) {
    // Your shortcode logic for detailed image view
}
add_shortcode('image_details', 'image_details_shortcode');
?>
