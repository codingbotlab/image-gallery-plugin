<?php
// Admin Category

// Callback function for managing categories in the admin dashboard
function manage_category_page() {
    // Check if form is submitted for updating categories
    if (isset($_POST['update_categories'])) {
        $updated_categories = isset($_POST['updated_categories']) ? $_POST['updated_categories'] : array();

        foreach ($updated_categories as $category_id => $updated_data) {
            $updated_name = sanitize_text_field($updated_data['name']);
            $updated_slug = sanitize_title($updated_data['slug']);

            wp_update_term((int) $category_id, 'category', array('name' => $updated_name, 'slug' => $updated_slug));
        }
    }

    // Check if form is submitted for deleting categories
    if (isset($_POST['delete_categories'])) {
        $categories_to_delete = isset($_POST['delete_categories']) ? $_POST['delete_categories'] : array();

        foreach ($categories_to_delete as $category_id) {
            wp_delete_term((int) $category_id, 'category');
        }
    }

    // Get all categories
    $categories = get_categories([
        'taxonomy'   => 'category',
        'hide_empty' => false,
    ]);

    echo '<div class="wrap">';
    echo '<h2>Categories</h2>';

    // Display update form
    echo '<form method="post">';
    echo '<input type="hidden" name="update_categories" value="1" />';
    echo '<input type="hidden" name="delete_categories" value="1" />';
    echo '<table class="wp-list-table widefat fixed striped categories">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col" id="name" class="manage-column column-name column-primary">Name</th>';
    echo '<th scope="col" id="slug" class="manage-column column-slug">Slug</th>';
    echo '<th scope="col" id="posts" class="manage-column column-posts num">Count</th>';
    echo '<th scope="col" id="actions" class="manage-column column-actions">Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody id="the-list">';
    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            echo '<tr id="category-' . $category->term_id . '">';
            echo '<td class="name column-name column-primary">';
            echo '<strong>' . esc_html($category->name) . '</strong>';
            
            echo '</td>';
            echo '<td class="slug column-slug">' . esc_html($category->slug) . '</td>';
            echo '<td class="posts column-posts num">' . esc_html($category->count) . '</td>';
            echo '<td class="actions column-actions">';
            echo '<div class="row-actions">';
            echo '<span class="edit"><a href="#" onclick="editCategory(' . esc_attr($category->term_id) . ');">Edit</a> |</span>';
            echo '<span class="update" style="display:none;"><a href="#" onclick="updateCategory(' . esc_attr($category->term_id) . ');">Update</a> |</span>';
            echo '<span class="delete"><a href="#" onclick="deleteCategory(' . esc_attr($category->term_id) . ');">Delete</a> |</span>';
            echo '</div>';
            echo '<span class="cancel" style="display:none;"><a href="#" onclick="cancelUpdateCategory(' . esc_attr($category->term_id) . ');">Cancel</a></span>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="4">No categories found.</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</form>';
    echo '</div>';
    ?>
    <style>
    /* Add the CSS styling here */
    

    
    }
</style>

    <script>
        function editCategory(categoryId) {
            var nameColumn = document.getElementById('category-' + categoryId).getElementsByClassName('name')[0];
            var name = nameColumn.querySelector('strong').textContent;
            var slug = document.getElementById('category-' + categoryId).getElementsByClassName('slug')[0].textContent;

            nameColumn.innerHTML = '<strong><input type="text" name="updated_categories[' + categoryId + '][name]" value="' + name + '" /></strong>';
            document.getElementById('category-' + categoryId).getElementsByClassName('slug')[0].innerHTML = '<input type="text" name="updated_categories[' + categoryId + '][slug]" value="' + slug + '" />';
            document.getElementById('category-' + categoryId).getElementsByClassName('edit')[0].style.display = 'none';
            document.getElementById('category-' + categoryId).getElementsByClassName('update')[0].style.display = 'inline-block';
            document.getElementById('category-' + categoryId).getElementsByClassName('cancel')[0].style.display = 'inline-block';
        }

        function updateCategory(categoryId) {
            document.querySelector('form').submit();
        }

        function cancelUpdateCategory(categoryId) {
            location.reload();
        }

        function deleteCategory(categoryId) {
            if (confirm('Are you sure you want to delete this category?')) {
                var deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete_categories[]';
                deleteInput.value = categoryId;
                document.querySelector('form').appendChild(deleteInput);
                document.querySelector('form').submit();
            }
        }
    </script>
<?php
}
?>
