<?php
function image_gallery_default_shortcode($atts) {
    $output = ''; // Initialize output variable
    
    // Custom query to fetch posts
    $query = new WP_Query(array(
        'post_type' => 'post', // Change 'post' to your desired post type
        'posts_per_page' => -1 // Display all posts, you can change this number
    ));
    
    // Check if there are posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            // Your custom HTML for each post
            $output .= '<div class="image-gallery-default">';
            $output .= '<div class="card">';
            
            $output .= '<div class="card-thumbnail"><a href="' . get_permalink() . '" class="post-thumbnail-link">' . get_the_post_thumbnail() . '</a></div>';
            $output .= '<h2 class="card-title"><a href="' . get_permalink() . '" class="post-title-link">' . get_the_title() . '</a></h2>';
            
            // Additional post details hidden by default
            $output .= '<div class="card-details" style="display:none;">';
            
            $output .= '<div class="card-date">Published on: ' . get_the_date() . '</div>';
            $output .= '<div class="card-modified-date">Last modified: ' . get_the_modified_date() . '</div>';
            $output .= '<div class="card-author">Author: ' . get_the_author() . '</div>';
            
            $categories = get_the_category();
            if ($categories) {
                $output .= '<div class="card-categories">Categories: ';
                foreach ($categories as $category) {
                    $output .= '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>, ';
                }
                $output = rtrim($output, ', '); // Remove trailing comma and space
                $output .= '</div>';
            }
            
            $tags = get_the_tags();
            if ($tags) {
                $output .= '<div class="card-tags">Tags: ';
                foreach ($tags as $tag) {
                    $output .= '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>, ';
                }
                $output = rtrim($output, ', '); // Remove trailing comma and space
                $output .= '</div>';
            }
            
            $output .= '<div class="card-comments">Comments: ' . get_comments_number() . '</div>';
            
            $output .= '</div>'; // Close card-details div
            
            // Read more button with JavaScript to toggle details visibility
            $output .= '<div class="read-more" onclick="toggleDetails(this)"><button>Read more</button></div>';
            
            $output .= '</div>';
            $output .= '</div>';
        }
        
        // Reset post data
        wp_reset_postdata();
    } else {
        $output = 'No posts found'; // Message if no posts are found
    }
    
    // JavaScript script for toggling details visibility
    $output .= '<script>';
    $output .= 'function toggleDetails(button) {';
    $output .= '  var card = button.closest(".card");';
    $output .= '  var details = card.querySelector(".card-details");';
    $output .= '  details.style.display = (details.style.display === "none") ? "block" : "none";';
    $output .= '}';
    $output .= '</script>';
    
    return $output;
}
?>
