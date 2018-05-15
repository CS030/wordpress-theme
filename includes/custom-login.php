<?php
/**
 * Custom login page
 */

function my_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/css/custom-login.css" />';
}
add_action('login_head', 'my_custom_login');

function my_login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
	return 'CS030 de Utrechtse Wielervereninging';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function login_error_override() {
    return 'Ongeldig gebruikersnaam of wachtwoord.';
}
add_filter('login_errors', 'login_error_override');

function login_checked_remember_me() {
	add_filter( 'login_footer', 'rememberme_checked' );
}
add_action( 'init', 'login_checked_remember_me' );

function rememberme_checked() {
	echo "<script>document.getElementById('rememberme').checked = true;</script>";
}
