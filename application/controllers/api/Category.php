<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Category extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Category_model', 'category');
	}

	public function index_get()
	{
		$id = $this->get('id');

		if ($id == null) {
			$categories = $this->category->getCategories();
		} else {
			$categories = $this->category->getCategories($id);
		}

		if ($categories) {
			$this->response(
				[
					'status' => true,
					'data' 	=> $categories
				],
				REST_Controller::HTTP_OK
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'No categories data found'
				],
				REST_Controller::HTTP_NOT_FOUND
			);
		}
	}

	public function index_post()
	{
		$data = [
			'name' => $this->post('name')
		];

		if ($this->category->createCategory($data) > 0) {
			$this->response(
				[
					'status' => true,
					'message' => 'successfully created data',
					'data' => $data
				],
				REST_Controller::HTTP_CREATED
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'failed created data'
				],
				REST_Controller::HTTP_NO_CONTENT
			);
		}
	}

	public function index_put()
	{
		$data = [
			'name' => $this->put('name'),
			'updated_at' => date('Y-m-d H:i:s', time())
		];

		$id = $this->put('id');

		if ($this->category->updateCategory($data, $id) > 0) {
			$this->response(
				[
					'status' => true,
					'message' => 'successfully updated data',
					'data' => $data
				],
				REST_Controller::HTTP_OK
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'failed updated data',
				],
				REST_Controller::HTTP_BAD_REQUEST
			);
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
			if ($this->category->deleteCategory($id) > 0) {
				$this->response(
					[
						'status' => true,
						'message' => 'Successfully deleted data!'
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
