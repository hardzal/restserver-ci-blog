<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->methods['index_get']['limit'] = 5;

		$this->load->model('User_model', 'user');
	}

	public function index_get($id = null)
	{
		$id = $this->get('id');

		if ($id == null) {
			$user = $this->user->getUsers();
		} else {
			$user = $this->user->getUsers($id);
		}

		if ($user) {
			$this->response(
				[
					'status' => true,
					'data' => $user
				],
				REST_Controller::HTTP_OK
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'User data not found.'
				],
				REST_Controller::HTTP_NOT_FOUND
			);
		}
	}

	public function index_post()
	{
		$password_hash = password_hash($this->post('password'), PASSWORD_DEFAULT);

		$data = [
			'username' => $this->post('username'),
			'password' => $password_hash,
			'email' => $this->post('email'),
			'name' => $this->post('name'),
			'avatar' => $this->post('avatar'),
			'created_at' => date('Y-m-d H:i:s', time())
		];

		if ($this->user->createUser($data)) {
			$this->response(
				[
					'status' => true,
					'message' => 'Successfully created user.',
					'data' => $data
				],
				REST_Controller::HTTP_CREATED
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'Failed created user.'
				],
				REST_Controller::HTTP_NO_CONTENT
			);
		}
	}

	public function index_put()
	{
		$id = $this->put('id');

		$password_hash = password_hash($this->put('password'), PASSWORD_DEFAULT);

		$data = [
			'username' => $this->put('username'),
			'email' => $this->put('email'),
			'name' => $this->put('name'),
			'avatar' => $this->put('avatar'),
			'updated_at' => date('Y-m-d H:i:s', time())
		];

		if (!$password_hash) {
			$user = $this->user->getUsers($id);

			$password_hash = $user['password'];
		}

		$data['password'] = $password_hash;

		if ($id == null) {
			$this->response(
				[
					'status' => false,
					'message' => 'Provide an id!'
				],
				REST_Controller::HTTP_BAD_REQUEST
			);
		} else {
			if ($this->user->updateUser($data, $id)) {
				$this->response(
					[
						'status' => true,
						'messsage' => 'Successfully update user.'
					],
					REST_Controller::HTTP_OK
				);
			} else {
				$this->response(
					[
						'status' => false,
						'message' => 'Failed updated data.'
					],
					REST_Controller::HTTP_BAD_REQUEST
				);
			}
		}
	}

	public function index_delete()
	{
		$id = $this->delete('id');

		if ($id == null) {
			$this->response(
				[
					'status' => false,
					'message' => 'Provide an id!'
				],
				REST_Controller::HTTP_BAD_REQUEST
			);
		} else {
			if ($this->user->deleteUser($id)) {
				$this->response(
					[
						'status' => true,
						'message' => 'Successful deleted data.'
					],
					REST_Controller::HTTP_OK
				);
			} else {
				$this->response(
					[
						'status' => false,
						'message' => "Data with id {$id} not found"
					],
					REST_Controller::HTTP_NOT_FOUND
				);
			}
		}
	}
}
