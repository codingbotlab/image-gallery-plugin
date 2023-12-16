<?php
// Admin Add Image

// Callback function for adding images in the admin dashboard
function add_image_page() {
    // Check if form is submitted
    if (isset($_POST['submit'])) {
        // Include necessary WordPress files
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        // Handle the uploaded file
        $attachment_id = media_handle_upload('file_input_name', 0);

        // Check if the upload was successful
        if (is_wp_error($attachment_id)) {
            // Error handling
            echo 'Error uploading image: ' . $attachment_id->get_error_message();
        } else {
            // Image uploaded successfully
            $image_title = isset($_POST['image_title']) ? sanitize_text_field($_POST['image_title']) : '';
            $image_description = isset($_POST['image_description']) ? sanitize_text_field($_POST['image_description']) : '';
            $image_alt = isset($_POST['image_alt']) ? sanitize_text_field($_POST['image_alt']) : '';
            $image_caption = isset($_POST['image_caption']) ? sanitize_text_field($_POST['image_caption']) : '';

            // Set the attachment data
            $attachment_data = array(
                'ID'           => $attachment_id,
                'post_title'   => $image_title,
                'post_content' => $image_description,
                'post_excerpt' => $image_caption,
            );

            // Update the attachment data
            wp_update_post($attachment_data);

            // Get selected categories and tags
            $selected_categories = isset($_POST['image_categories']) ? $_POST['image_categories'] : array();
            $selected_tags = isset($_POST['image_tags']) ? explode(',', sanitize_text_field($_POST['image_tags'])) : array();

            // Check if new categories are specified
            $new_categories = isset($_POST['new_categories']) ? explode(',', sanitize_text_field($_POST['new_categories'])) : array();

            // Add new categories to the existing ones
            $all_categories = array_merge($selected_categories, $new_categories);

            // Create a new post with the image attachment
            $new_post = array(
                'post_title'    => $image_title,
                'post_status'   => 'publish',
                'post_type'     => 'post',
                'post_author'   => 1, // Change this to the desired author ID
                'post_category' => $all_categories,
                'tags_input'    => $selected_tags,
                'post_parent'   => 0,
                'post_content'  => '<div style="max-width: 100%; height: auto;"><a href="' . '"><img src="' . wp_get_attachment_url($attachment_id) . '" style="width: 100%;" /></a></div>' . $image_description ,
            );

            // Insert the post into the database
            $post_id = wp_insert_post($new_post);

            // Set the featured image for the new post
            set_post_thumbnail($post_id, $attachment_id);

            echo 'Image uploaded successfully! Post created with ID: ' . $post_id;

            // Display the uploaded image with responsive styles
            echo '<div style="max-width: 100%; height: auto;">';
            echo '<img src="' . wp_get_attachment_url($attachment_id) . '" style="width: 100%;" />';
            echo '</div>';
        }
    }

    echo '<div class="wrap">';
    echo '<h2>Add Image</h2>';
    // Add your content here
    $tags = get_tags([
        'hide_empty' => false,
    ]);

    echo '<form method="post" enctype="multipart/form-data">';
    echo '<label for="file_input_name">Choose File:</label>';
    echo '<input type="file" name="file_input_name" id="fileInput" accept="image/*" />';
    echo '<div id="uploadedImageContainer"></div>';
    echo '<label for="image_title">Title:</label><input type="text" name="image_title" id="image_title" />';
    echo '<label for="image_alt">Alt Text:</label><input type="text" name="image_alt" id="image_alt" />';
    echo '<label for="image_caption">Caption:</label><textarea name="image_caption" id="image_caption"></textarea>';
    echo '<label for="image_description">Description:</label><textarea name="image_description" id="image_description"></textarea>';

    // Display existing categories with drop-down list
    echo '<label for="image_categories">Select Categories:</label>';
    echo '<select name="image_categories[]" id="image_categories" multiple>';
    $categories = get_categories([
        'hide_empty' => false,
    ]);
    foreach ($categories as $category) {
        echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
    }
    echo '</select><br>';

    // Provide an input field to add new categories
    echo '<label for="new_categories">New Categories (comma-separated):</label>';
    echo '<input type="text" name="new_categories" id="new_categories" /><br>';

    // Display existing tags with drop-down list
    echo '<label for="image_tags">Select Tags:</label>';
    echo '<select name="image_tags[]" id="image_tags" multiple>';
    foreach ($tags as $tag) {
        echo '<option value="' . esc_attr($tag->name) . '">' . esc_html($tag->name) . '</option>';
    }
    echo '</select><br>';

    // Provide an input field for new tags
    echo '<label for="new_tags">New Tags (comma-separated):</label>';
    echo '<input type="text" name="image_tags" id="image_tags" /><br>';

    echo '<input type="submit" name="submit" value="Upload" />';
    echo '</form>';

    // Container for displaying the uploaded image
    echo '</div>';

    // JavaScript for real-time image preview and opening media library
    echo '<script>
        document.getElementById("fileInput").addEventListener("change", function() {
            var fileInput = this;
            var uploadedImageContainer = document.getElementById("uploadedImageContainer");

            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    uploadedImageContainer.innerHTML = "<div style=\'max-width: 100%; height: auto;\'><img src=\'" + e.target.result + "\' style=\'width: 100%;\' /></div>";
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        });

        jQuery(document).ready(function($) {
            $("#upload-btn").click(function(e) {
                e.preventDefault();

                // Create a new media frame
                var frame = wp.media({
                    title: "Select or Upload Image",
                    button: {
                        text: "Use this image"
                    },
                    multiple: false  // Set this to true if you want to allow multiple image selection
                });

                // When an image is selected in the media frame...
                frame.on("select", function() {
                    // Get the selected attachment object
                    var attachment = frame.state().get("selection").first().toJSON();

                    // Set the selected image URL to the hidden input
                    $("#fileInput").val(attachment.url);

                    // Display the selected image in the container
                    $("#uploadedImageContainer").html("<div style=\'max-width: 100%; height: auto;\'><img src=\'" + attachment.url + "\' style=\'width: 100%;\' /></div>");
                });

                // Open the media frame
                frame.open();
            });
        });
    </script>';
}

echo '<script>
    jQuery(document).ready(function($){
        $("#open-media-library-btn").click(function(e) {
            e.preventDefault();

            // Create a new media frame
            var frame = wp.media({
                title: "Select or Upload Image",
                button: {
                    text: "Use this image"
                },
                multiple: false  // Set this to true if you want to allow multiple image selection
            });

            // When an image is selected in the media frame...
            frame.on("select", function() {
                // Get the selected attachment object
                var attachment = frame.state().get("selection").first().toJSON();

                // Set the selected image URL to the hidden input
                $("#fileInput").val(attachment.url);

                // Display the selected image in the container
                $("#uploadedImageContainer").html("<div style=\'max-width: 100%; height: auto;\'><img src=\'" + attachment.url + "\' style=\'width: 100%;\' /></div>");
            });

            // Open the media frame
            frame.open();
        });
    });
    
</script>';

?>
