<?php
add_filter('jwt_auth_token_before_dispatch', 'add_user_data', 10, 2);

function add_user_data($data, $user)
{

		$ua_trainer = rua_get_level_by_name('trainer');

		$is_trainer = $ua_trainer ? rua_has_user_level($user->ID, $ua_trainer->ID) : false;

    return $data = array(
      'token'    => $data['token'],
			'name' => $user->display_name,
			'email' => $user->user_email,
			'id' => $user->ID,
			'joomla_id' => $user->supersaas_id,
			'is_trainer' => $is_trainer,
    );
}
