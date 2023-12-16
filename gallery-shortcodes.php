<?php
// Image Gallery Shortcodes

// Shortcode for default style

require_once plugin_dir_path(__FILE__) . 'templates/default.php';
add_shortcode('image_gallery_default', 'image_gallery_default_shortcode');

// Shortcode for custom style 1
function image_gallery_style1_shortcode($atts) {
    // Your custom style 1 gallery HTML and styling here
    return '<div class="image-gallery-style1">Custom Style 1 Gallery Content Goes Here</div>';
}
add_shortcode('image_gallery_style1', 'image_gallery_style1_shortcode');

// Shortcode for custom style 2
function image_gallery_style2_shortcode($atts) {
    // Your custom style 2 gallery HTML and styling here
    return '<div class="image-gallery-style2">Custom Style 2 Gallery Content Goes Here</div>';
}
add_shortcode('image_gallery_style2', 'image_gallery_style2_shortcode');

// Shortcode for displaying detailed view of an image
function image_details_shortcode($atts) {
    // Your shortcode logic for detailed image view
    $atts = shortcode_atts(array(
        'id' => '',
    ), $atts);

    // Get detailed image view content based on the provided image ID
    $image_id = intval($atts['id']);
    $image_content = ''; // Your detailed image view content goes here

    return '<div class="image-details">' . $image_content . '</div>';
}
add_shortcode('image_gallery', 'image_details_shortcode');
?>
