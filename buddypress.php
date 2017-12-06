<?php
// Enqueue UIkit components.
add_action( 'beans_uikit_enqueue_scripts', 'example_view_enqueue_uikit_assets' );

function example_view_enqueue_uikit_assets() {
	// Enqueue cover and slidshow UIkit components used in the slideshow section.
	beans_uikit_enqueue_components( array( 'tab' ) );
}

// remove beans_post_header
beans_remove_action('beans_post_title');

// Always add this function at the bottom of template file.
beans_load_document();
