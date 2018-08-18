<?php
/**
 * Trainer module SSO
 *
 *
 */
add_action('parse_request', 'trainers_redirect');
add_action('parse_request', 'trainers_sso');

function trainers_redirect() {
   if($_SERVER["REQUEST_URI"] == '/trainers') {
			$token = wp_get_session_token();
			$user_id = get_current_user_id();
			if($user_id) {
				header("Location: http://trainers.cs030.nl/login.php?user_id=".$user_id."&token=".$token);
			} else {
				wp_redirect('/wp-login.php?redirect_to=/trainers');
			}
			exit();
   }
}

function trainers_sso() {
	if(strpos($_SERVER["REQUEST_URI"], '/trainers/sso') === 0) {
		$manager = WP_Session_Tokens::get_instance( $_GET['user_id'] );
		if ($manager->verify( $_GET['token'] )) {
			$user = get_userdata($_GET['user_id']);

			$ua_trainer = rua_get_level_by_name('trainer');
			$is_trainer = $ua_trainer ? rua_has_user_level($user->ID, $ua_trainer->ID) : false;

			$data = array();
			$data["id"] = $user->id;
			$data["name"] = $user->display_name;
			$data["email"] = $user->user_email;
			$data["joomla_id"] = $user->supersaas_id;
			$data["is_trainer"] = $is_trainer;

			$message = array();
			$message["success"] = true;
			$message["data"] = $data;

			header('Content-Type: application/json');
			echo json_encode($message);
		} else {
			$message = array();
			$message["success"] = false;

			header("HTTP/1.1 401 Unauthorized");
			header('Content-Type: application/json');
			echo json_encode($message);
		}
		exit();
 }
}
