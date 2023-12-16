<?php
// Admin Tags

// Callback function for managing tags in the admin dashboard
function manage_tags_page() {
    // Check if form is submitted for updating tags
    if (isset($_POST['update_tags'])) {
        $updated_tags = isset($_POST['updated_tags']) ? $_POST['updated_tags'] : array();

        foreach ($updated_tags as $tag_id => $updated_data) {
            $updated_name = sanitize_text_field($updated_data['name']);
            $updated_slug = sanitize_title($updated_data['slug']);

            wp_update_term((int) $tag_id, 'post_tag', array('name' => $updated_name, 'slug' => $updated_slug));
        }
    }

    // Check if form is submitted for deleting tags
    if (isset($_POST['delete_tags'])) {
        $tags_to_delete = isset($_POST['delete_tags']) ? $_POST['delete_tags'] : array();

        foreach ($tags_to_delete as $tag_id) {
            wp_delete_term((int) $tag_id, 'post_tag');
        }
    }

    // Get all tags
    $tags = get_tags([
        'taxonomy'   => 'post_tag', // Use 'post_tag' for default tags, replace with your custom taxonomy if applicable
        'hide_empty' => false,       // Set to true if you want to hide empty tags
    ]);

    echo '<div class="wrap">';
    echo '<h2>Tags</h2>';

    // Display update form
    echo '<form method="post">';
    
    echo '<table class="wp-list-table widefat fixed striped tags">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col" id="name" class="manage-column column-name column-primary">Name</th>';
    echo '<th scope="col" id="slug" class="manage-column column-slug">Slug</th>';
    echo '<th scope="col" id="posts" class="manage-column column-posts num">Count</th>';
    echo '<th scope="col" id="actions" class="manage-column column-actions">Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody id="the-list">';
    if ($tags && !is_wp_error($tags)) {
        foreach ($tags as $tag) {
            echo '<tr id="tag-' . $tag->term_id . '">';
            echo '<td class="name column-name column-primary">';
            echo '<strong>' . esc_html($tag->name) . '</strong>';
            
            echo '</td>';
            echo '<td class="slug column-slug">' . esc_html($tag->slug) . '</td>';
            echo '<td class="posts column-posts num">' . esc_html($tag->count) . '</td>';
            echo '<td class="actions column-actions">';
            echo '<div class="row-actions">';
            echo '<span class="edit"><a href="#" onclick="editTag(' . esc_attr($tag->term_id) . ');">Edit</a> |</span>';
            echo '<span class="update" style="display:none;"><a href="#" onclick="updateTag(' . esc_attr($tag->term_id) . ');">Update</a> |</span>';
            echo '<span class="delete"><a href="#" onclick="deleteTag(' . esc_attr($tag->term_id) . ');">Delete</a> |</span>';
            echo '</div>';
            echo '<span class="cancel" style="display:none;"><a href="#" onclick="cancelUpdate(' . esc_attr($tag->term_id) . ');">Cancel</a></span>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="4">No tags found.</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</form>';
    echo '</div>';
    ?>
    <style>
        /* Add the CSS styling here */
    
    </style>
    <script>
        function editTag(tagId) {
            var nameColumn = document.getElementById('tag-' + tagId).getElementsByClassName('name')[0];
            var name = nameColumn.querySelector('strong').textContent;
            var slug = document.getElementById('tag-' + tagId).getElementsByClassName('slug')[0].textContent;

            nameColumn.innerHTML = '<strong><input type="text" name="updated_tags[' + tagId + '][name]" value="' + name + '" /></strong>';
            document.getElementById('tag-' + tagId).getElementsByClassName('slug')[0].innerHTML = '<input type="text" name="updated_tags[' + tagId + '][slug]" value="' + slug + '" />';
            document.getElementById('tag-' + tagId).getElementsByClassName('edit')[0].style.display = 'none';
            document.getElementById('tag-' + tagId).getElementsByClassName('update')[0].style.display = 'inline-block';
            document.getElementById('tag-' + tagId).getElementsByClassName('cancel')[0].style.display = 'inline-block';
        }

        function updateTag(tagId) {
            document.querySelector('form').submit();
        }

        function cancelUpdate(tagId) {
            location.reload();
        }

        function deleteTag(tagId) {
            if (confirm('Are you sure you want to delete this tag?')) {
                var deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete_tags[]';
                deleteInput.value = tagId;
                document.querySelector('form').appendChild(deleteInput);
                document.querySelector('form').submit();
            }
        }
    </script>
<?php
}
?>
