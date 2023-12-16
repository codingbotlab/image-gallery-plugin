<?php
// Admin Settings

// Callback function for plugin settings in the admin dashboard
function plugin_settings_page() {
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Handle form submission and update settings
        update_option('download_button_enabled', isset($_POST['download_enabled']));

        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    // Display the settings page content
    echo '<div class="wrap">';
    echo '<h2>Settings</h2>';
    echo '<form method="post" action="">';

    // Add your existing settings or new settings here
    echo '<label for="download_enabled">Enable Download Button:</label>';
    echo '<input type="checkbox" id="download_enabled" name="download_enabled" ' . checked(get_option('download_button_enabled'), true, false) . '>';

    echo '<p class="submit"><input type="submit" name="submit" class="button-primary" value="Save Changes"></p>';
    echo '</form>';
    echo '</div>';
}

// Modify the post content to conditionally render the download button
function modify_post_content($content) {
    // Check if the download button is enabled
    $download_button_enabled = get_option('download_button_enabled', true);

    // If enabled, add the download button to the content
    if ($download_button_enabled) {
        global $post;
        $attachment_id = get_post_thumbnail_id($post->ID); // Get the attachment ID of the featured image

        if ($attachment_id) {
            $content .= '<div class="dwnbtn" style="max-width: 100%; height: auto;"><a href="' . wp_get_attachment_url($attachment_id) . '" download=""><button class="download-button">Download Image</button></a></div>';
        }
    }

    return $content;
}

// Hook the content modification into the_content filter
add_filter('the_content', 'modify_post_content');
?>