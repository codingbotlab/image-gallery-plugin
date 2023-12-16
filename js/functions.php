<?php
// Add this code to your functions.php file or a custom plugin
if (isset($_POST['image_id'])) {
    $image_id = intval($_POST['image_id']);

    if ($image_id > 0) {
        // Delete the image
        if (wp_delete_attachment($image_id, true)) {
            // Optionally, you can redirect the user or perform other actions
        } else {
            // Handle deletion failure
        }
    }
}

?>