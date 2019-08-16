<?php

function getLogin()
{
	$ci = &get_instance();
	$users = $ci->db->get('users')->result_array();

	$result = array();

	foreach ($users as $user) {
		$result[$user['username']] = $user['password'];
	}

	return $result;
}
