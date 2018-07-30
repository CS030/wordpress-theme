<?php
// Register the plugins WooCommerce template overrides

add_filter( 'woocommerce_locate_template', 'wcb_woocommerce_locate_template', 10, 3 );

function wcb_woocommerce_locate_template( $template, $template_name, $template_path ) {

  global $woocommerce;

  $_template = $template;

	if ( ! $template_path ) $template_path = $woocommerce->template_url;

  // Look within passed path within the theme - this is priority
  $template = locate_template(
    array(
      $template_path . $template_name,
      $template_name
    )
  );

	// Modification: Get the template from this plugin, if it exists
  $theme_path  = get_template_directory() . '/woocommerce/';

  if ( ! $template && file_exists( $theme_path . $template_name ) )
    $template = $theme_path . $template_name;

  // Use default template
  if ( ! $template )
    $template = $_template;

  // Return what we found
  return $template;

}


// Add WooCommerce theme support
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


// Use the Beans layout engine
add_filter( 'beans_layout', 'wcb_woocommerce_layout' );

function wcb_woocommerce_layout( $layout ) {

    // Get the layout post meta from woo shop page.
    if ( is_shop() ) {
        return beans_get_post_meta( 'beans_layout', beans_get_default_layout(), wc_get_page_id( 'shop' ) );
    }

    return $layout;

}

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
