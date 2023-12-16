<?php
function image_gallery_page() {
    echo '<style>
    .image-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin: 10px 0;
        padding: 15px;
        box-sizing: border-box;
    }

    img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .button-container {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .button-container button,
    .button-container a {
        flex: 1;
        padding: 5px 10px;
        margin: 5px;
        cursor: pointer;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
    }

    .button-container button {
        background-color: white;
        color: black;
        border: solid 2px black;
    }

    .button-container a {
        background-color: white;
        color: black;
        border: solid 2px black;
    }

    @media (min-width: 576px) {
        .image-card {
            max-width: 48%;
        }
    }

    @media (min-width: 768px) {
        .image-card {
            max-width: 48%;
        }
    }

    @media (min-width: 992px) {
        .image-card {
            max-width: 31%;
        }
    }

    @media (min-width: 1200px) {
        .image-card {
            max-width: 23%;
        }
    }

    body {
        font-size: 16px;
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }

    .wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    @media (max-width: 576px) {
        body {
            font-size: 14px;
        }

        h2 {
            font-size: 20px;
        }

        .image-card {
            padding: 10px;
        }

        .button-container button,
        .button-container a {
            padding: 3px 6px;
        }
    }
</style>
';

    echo '<div class="wrap">';
    echo '<h2>Image Gallery</h2>';

    $args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page' => -1,
        'post_parent'    => get_the_ID(), // Add this line to filter by the current post
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $image_id = get_the_ID();
            $image_src = wp_get_attachment_image_src($image_id, 'full');
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            $image_title = get_the_title();
            $image_caption = get_the_excerpt();
            $image_description = get_the_content(); // Retrieve image description
            $upload_date = get_the_date('F j, Y');
            $file_type = get_post_mime_type($image_id);
            $dimensions = wp_get_attachment_metadata($image_id);
            $file_size = size_format(filesize(get_attached_file($image_id)), 2);
            $media_file_url = wp_get_attachment_url($image_id);
            $permalink = get_permalink(get_the_ID());

            echo '<div class="image-card" id="image-card-' . esc_attr($image_id) . '">';
            
            echo '<img src="' . esc_url($image_src[0]) . '" alt="' . esc_attr($image_alt) . '">';
            echo '<div class="button-container">';
            echo '<a href="' . esc_url($media_file_url) . '" download="' . esc_attr($image_alt) . '">Download</a>';
            echo '<button onclick="openPermalink(\'' . $permalink . '\')">Permalink</button>';
            echo '</div>';
            echo '<p><strong>ID:</strong> ' . esc_html($image_id) . '</p>';
            echo '<p><strong>Title:</strong> ' . esc_html($image_title) . '</p>';
            echo '<p><strong>Alt Text:</strong> ' . esc_html($image_alt) . '</p>';
            echo '<p><strong>Caption:</strong> ' . esc_html($image_caption) . '</p>';
            echo '<p><strong>Description:</strong> ' . esc_html($image_description) . '</p>'; // Display image description
            echo '<p><strong>Upload Date:</strong> ' . esc_html($upload_date) . '</p>';
            echo '<p><strong>File Type:</strong> ' . esc_html($file_type) . '</p>';
            echo '<p><strong>Dimensions:</strong> ' . esc_html($dimensions['width'] . 'x' . $dimensions['height']) . '</p>';
            echo '<p><strong>File Size:</strong> ' . esc_html($file_size) . '</p>';
            
            echo '<div class="button-container">';
            echo '<button onclick="editImage(' . $image_id . ')">Edit</button>';
            echo '<a href="' . esc_url($media_file_url) . '" target="_blank">View</a>';
            echo '<button onclick="deleteImage(' . $image_id . ')">Delete</button>';
            echo '</div>';
            
            echo '</div>';
        }

        wp_reset_postdata();
    } else {
        echo '<p>No images found</p>';
    }

    echo '<script>
        function openPermalink(url) {
            window.open(url, "_blank");
        }

        function deleteImage(imageId) {
            var confirmation = confirm("Are you sure you want to delete this image?");
            
            if (confirmation) {
                // Create a form element dynamically
                var form = document.createElement("form");
                form.style.display = "none";
                form.method = "POST";
                form.action = ""; // Add the URL to your server-side script here

                // Add an input field for the image ID
                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "image_id";
                input.value = imageId;
                form.appendChild(input);

                // Add the form to the document
                document.body.appendChild(form);

                // Submit the form to trigger image deletion
                form.submit();
            } else {
                console.log("Image deletion canceled.");
            }
        }

        function editImage(imageId) {
            // Construct the URL to the media edit page for the specified image ID
            var editUrl = "' . admin_url('post.php?action=edit&post=') . '" + imageId;
            
            // Open the media edit page in a new tab
            window.open(editUrl, "_blank");
        }
    </script>';

    echo '</div>';
}

?>
