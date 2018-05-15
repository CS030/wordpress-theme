<?php
/**
 * Custom for buddypress profile pages
 */

// Enqueue UIkit components.
add_action( 'beans_uikit_enqueue_scripts', 'example_view_enqueue_uikit_assets' );

function example_view_enqueue_uikit_assets() {
	// Enqueue cover and slidshow UIkit components used in the slideshow section.
	beans_uikit_enqueue_components( array( 'tab' ) );
}

// BuddyPress -> UI-kit

function custom_bp_profile_group_tabs( $tabs, $groups, $group_name ) {
	$tabs  = str_replace("class=\"current\">", "class=\"current uk-active\">", $tabs);
	return $tabs;
}

add_filter('xprofile_filter_profile_group_tabs','custom_bp_profile_group_tabs', 1, 3);

// remove beans_post_header
beans_remove_action('beans_post_title');

// Always add this function at the bottom of template file.
beans_load_document();
