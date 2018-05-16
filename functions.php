<?php
/**
 * Default customizations
 */

// Include Beans
require_once( get_template_directory() . '/lib/init.php' );

// Include custom made scripts
require_once('includes/custom-login.php');

// Remove Beans Default Styling
remove_theme_support( 'beans-default-styling' );

// Enqueue uikit assets
beans_add_smart_action( 'beans_uikit_enqueue_scripts', 'cs_enqueue_uikit_assets', 7 );

function cs_enqueue_uikit_assets() {

	// Enqueue uikit extra components
	beans_uikit_enqueue_components( array( 'flex' ) );

	// Enqueue uikit overwrite theme folder
	beans_uikit_enqueue_theme( 'cs', get_stylesheet_directory_uri() . '/assets/less/uikit' );

	// Add the theme style as a uikit fragment to have access to all the variables
	beans_compiler_add_fragment( 'uikit', array(
		get_stylesheet_directory_uri() . '/assets/less/style.less',
		get_stylesheet_directory_uri() . '/assets/less/image.less',
		get_stylesheet_directory_uri() . '/assets/less/news.less',
		get_stylesheet_directory_uri() . '/assets/less/filter.less',
		get_stylesheet_directory_uri() . '/assets/less/footer.less',
		get_stylesheet_directory_uri() . '/assets/less/highlight.less',
		get_stylesheet_directory_uri() . '/assets/less/avatar.less',
		get_stylesheet_directory_uri() . '/assets/less/home.less',
	), 'less' );

}

// Remove page post type comment support
beans_add_smart_action( 'init', 'cs_post_type_support' );

function cs_post_type_support() {
	remove_post_type_support( 'page', 'comments' );
}

// Setup document fragements, markups and attributes
beans_add_smart_action( 'wp', 'cs_setup_document' );

function cs_setup_document() {

	// Header
	beans_remove_attribute( 'beans_header', 'class', ' uk-block' );
	beans_wrap_markup( 'beans_fixed_wrap_header', 'totem_overlay_navigation', 'div', array( 'class' => 'tm-overlay-navigation uk-clearfix' ) );

	// Breadcrumb
	beans_remove_action( 'beans_breadcrumb' );

	// Navigation
	beans_add_attribute( 'beans_sub_menu_wrap', 'class', 'uk-dropdown-center' );
	beans_add_attribute( 'beans_sub_menu_wrap', 'class', 'uk-dropdown-small' );
	beans_add_attribute( 'beans_primary_menu_offcanvas_button', 'class', 'offcanvas-menu-button');
	beans_remove_attribute( 'beans_menu_item_child_indicator', 'class', 'uk-margin-small-left' );

	// Offcanvas
	beans_add_attribute( 'beans_widget_area_offcanvas_bar', 'class', 'uk-offcanvas-bar-flip' );
	beans_add_attribute( 'beans_primary_menu_offcanvas_button', 'class', 'uk-button-primary' );

	// Post content
	beans_remove_attribute( 'beans_post', 'class', ' uk-panel-box' );
	beans_add_attribute( 'beans_post_content', 'class', 'uk-text-large' );
	beans_add_attribute( 'beans_post_more_link', 'class', 'uk-button uk-button-small' );

	// Post image
	//beans_modify_action_hook( 'beans_post_image', 'beans_post_title_before_markup' );
	beans_remove_action( 'beans_post_image' );

	// Post meta
	//beans_remove_action( 'beans_post_meta' );
	//beans_remove_action( 'beans_post_meta_author' );
	beans_remove_action( 'beans_post_meta_categories' );

	// Post read more
	beans_replace_attribute( 'beans_next_icon_more_link', 'class' , 'angle-double-right', 'long-arrow-right' );

	// Posts pagination
	beans_remove_markup( 'beans_previous_icon_posts_pagination' );
	beans_remove_markup( 'beans_next_icon_posts_pagination' );

	// Comment badge
	beans_add_attribute( 'beans_moderator_badge', 'class', 'uk-border-rounded uk-align-right' );
	beans_add_attribute( 'beans_moderation_badge', 'class', 'uk-border-rounded uk-align-right' );

	// Comment meta
	beans_modify_action_priority( 'beans_comment_metadata', 9 );

	// Comment form
	beans_add_attribute( 'beans_comment_form_submit', 'class', 'uk-button-large' );
	beans_replace_attribute( 'beans_comment_fields_wrap', 'class', 'uk-width-medium-1-1', 'uk-width-medium-4-10' );
	beans_replace_attribute( 'beans_comment_form', 'class', 'uk-width-medium-1-3', 'uk-width-medium-1-1' );

	if ( !is_user_logged_in() )
		beans_replace_attribute( 'beans_comment_form_comment', 'class', 'uk-width-medium-1-1', 'uk-width-medium-6-10' );

	// Search
	beans_add_attribute( 'beans_search_title', 'class', 'uk-margin-large-bottom' );

	if ( is_search() )
		beans_remove_action( 'beans_post_image' );

}

// Modify the read more text.
add_filter( 'beans_post_more_link_text_output', 'cs_modify_read_more' );
function cs_modify_read_more() {
	return 'Lees meer';
}

// Modify beans layout (filter)
beans_add_smart_action( 'beans_layout_grid_settings', 'cs_layout_grid_settings' );

function cs_layout_grid_settings( $layouts ) {

	return array_merge( $layouts, array(
		'grid' => 10,
		'sidebar_primary' => 2,
		'sidebar_secondary' => 2,
	) );

}


// Modify beans default layout (filter)
beans_add_smart_action( 'beans_default_layout', 'cs_default_layout' );

function cs_default_layout( $layouts ) {
	return 'sp_c_ss';
}

// Modify the categories widget count (filter)
beans_add_smart_action( 'beans_widget_count_output', 'cs_widget_counts' );

function cs_widget_counts() {
	return '$2';
}

// Modify the tags cloud widget (filter)
beans_add_smart_action( 'wp_generate_tag_cloud', 'cs_widget_tags_cloud' );

function cs_widget_tags_cloud( $output ) {

	$output = preg_replace( '#tag-link-#', 'uk-button uk-button-mini tag-link-', $output );
	$output = preg_replace( "#style='font-size:.+pt;'#", '', $output );

	return $output;

}


// Remove comment after note (filter).
beans_add_smart_action( 'comment_form_defaults', 'cs_comment_form_defaults' );

function cs_comment_form_defaults( $args ) {
	$args['comment_notes_after'] = '';
	return $args;
}


// Modify comment title
beans_add_smart_action( 'beans_comment_title_append_markup', 'cs_comment_title_prefix' );

function cs_comment_title_prefix() {

	echo beans_open_markup( 'totem_comment_title_extra', 'span', array(
			'class' => 'uk-margin-small-left',
		) );

		echo beans_output( 'totem_comment_title_extra', __( 'says:', 'tm-totem' ) );

	echo beans_close_markup( 'totem_comment_title_extra', 'span' );

}


// Add avatar uikit circle class (filter)
beans_add_smart_action( 'get_avatar', 'cs_avatar' );

function cs_avatar( $output ) {

	return str_replace( "class='avatar", "class='avatar uk-border-circle", $output ) ;

}

// Add CS settings page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title'	=> 'CS Settings',
		'menu_title'	=> 'CS Settings',
		'menu_slug'		=> 'cs_settings',
		'capability'	=> 'edit_posts'
	));
}

// Overwrite the footer content.
beans_modify_action_callback( 'beans_footer_content', 'beans_child_footer_content' );

function beans_child_footer_content() {
?>
	<div class="uk-grid">
			<div class="uk-width-medium-1-2">
				<?php echo beans_widget_area( 'footer_1' );?>
			</div>
			<div class="uk-width-medium-1-2">
				<?php echo beans_widget_area( 'footer_2' );?>
			</div>
	</div>
<?php
}

// Remove the site title tag.
beans_remove_action( 'beans_site_title_tag' );

// hide admin bar for non admins
add_action('set_current_user', 'cc_hide_admin_bar');

function cc_hide_admin_bar() {
  if (!current_user_can('edit_posts')) {
		add_filter( 'show_admin_bar', '__return_false', PHP_INT_MAX );
  }
}

// Add login sidebar
add_action( 'widgets_init', 'beans_child_register_widget_areas' );

/**
 * Register the widget areas (sidebars).
 */
function beans_child_register_widget_areas() {

	beans_deregister_widget_area( 'sidebar_secondary' );

	beans_register_widget_area( array(
			'name' => 'Sidebar ingelogd',
			'id' => 'sidebar_login'
	) );

	beans_register_widget_area( array(
		'name' => 'Footer 1',
		'id' => 'footer_1'
	));

	beans_register_widget_area( array(
		'name' => 'Footer 2',
		'id' => 'footer_2'
	));
}

// Edit sidebar action
beans_modify_action_callback( 'beans_widget_area_sidebar_primary', 'beans_child_view_widget_area_sidebar' );

/**
 * Replace sidebar_primary widget area with custom_sidebar.
 */
function beans_child_view_widget_area_sidebar() {
	if (is_user_logged_in()) {
    echo beans_widget_area( 'sidebar_login' );
	} else {
    echo beans_widget_area( 'sidebar_primary' );
	}
}


/**
 * Supersaas filter
 */

add_filter( 'do_shortcode_tag', 'supersaas_format_output', 10, 3);

function supersaas_format_output($output, $tag, $attr){
	if('supersaas' != $tag)
		return $output;

	$output = str_replace("type=\"submit\"", "type=\"submit\" class=\"uk-button uk-button-primary\"", $output);
	return $output;
}

/**
 * WooCommerce
 */

 // remove woocommerce scripts on unnecessary pages
function woocommerce_de_script() {
	if (function_exists( 'is_woocommerce' )) {
		if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() ) { // if we're not on a Woocommerce page, dequeue all of these scripts
			wp_dequeue_script('wc-add-to-cart');
			wp_dequeue_script('jquery-blockui');
			wp_dequeue_script('jquery-placeholder');
			wp_dequeue_script('woocommerce');
			wp_dequeue_script('jquery-cookie');
			wp_dequeue_script('wc-cart-fragments');
		}
	}
}
add_action( 'wp_print_scripts', 'woocommerce_de_script', 100 );
add_action( 'wp_enqueue_scripts', 'remove_woocommerce_generator', 99 );
function remove_woocommerce_generator() {
	if (function_exists( 'is_woocommerce' )) {
		if (!is_woocommerce()) { // if we're not on a woo page, remove the generator tag
			remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
		}
	}
}

// remove woocommerce styles, then add woo styles back in on woo-related pages
function child_manage_woocommerce_css(){
	if (function_exists( 'is_woocommerce' )) {
		if (!is_woocommerce()) { // this adds the styles back on woocommerce pages. If you're using a custom script, you could remove these and enter in the path to your own CSS file (if different from your basic style.css file)
			wp_dequeue_style('woocommerce-layout');
			wp_dequeue_style('woocommerce-smallscreen');
			wp_dequeue_style('woocommerce-general');
		}
	}
}
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_css' );

function dequeue_buddypress() {
	if (!is_admin()) {
		wp_dequeue_style('bp-legacy-css');
		wp_deregister_script('bp-jquery-query');
		wp_deregister_script('bp-confirm');
	}
}
add_action('wp_enqueue_scripts', 'dequeue_buddypress');

function dequeue_mailpoet() {
	if (!is_admin()) {
		wp_dequeue_style('mailpoet_public');
		wp_deregister_script('mailpoet_vendor');
		wp_deregister_script('mailpoet_public');
	}
}
add_action('wp_enqueue_scripts', 'dequeue_mailpoet');

// remove layouts
beans_remove_action(  'beans_do_register_post_meta' ); // will remove the options from pages
beans_remove_action(  'beans_do_register_term_meta' ); // will remove the options from posts

// Change except length to max 20 words.
function cs_custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'cs_custom_excerpt_length', 999 );

// Change the posts query to load only 'Nieuws' when not logged in.
add_action('pre_get_posts', 'cs_alter_query');

function cs_alter_query($query) {

	if (!$query->is_main_query())
		return;

	if(!is_user_logged_in()) {
		$cat_id = get_cat_ID('Nieuws');
		$query->set('category__in', $cat_id);
	}

	remove_all_actions ( '__after_loop');
}

// set default layout
beans_add_filter( 'beans_layout', 'c_sp' );

// Add meta to head
add_action( 'beans_head', 'cs_head_meta' );

function cs_head_meta() {
?>
<meta name="theme-color" content="#ed1b24" />
<link rel="manifest" href="<?php echo get_stylesheet_directory_uri() ?>/assets/manifest.webmanifest">

<?php
}

beans_remove_action( 'beans_post_navigation' );
