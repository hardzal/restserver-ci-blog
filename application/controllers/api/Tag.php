<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Tag extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tag_model', 'tag');
	}

	public function index_get($id = null)
	{
		$id = $this->get('id');

		if ($id == null) {
			$tags = $this->tag->getTags();
		} else {
			$tags = $this->tag->getTags($id);
		}

		if ($tags) {
			$this->response(
				[
					'status' => true,
					'data' => $tags
				],
				REST_Controller::HTTP_OK
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'Tags data not found!'
				],
				REST_Controller::HTTP_NOT_FOUND
			);
		}
	}

	public function index_post()
	{
		$data = [
			'name' => $this->post('name'),
			'created_at' => date('Y-m-d H:i:s', time())
		];

		if ($this->tag->createTag($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'successfully created data',
				'data' => $data
			], REST_Controller::HTTP_CREATED);
		} else {
			$this->response([
				'status' => false,
				'message' => 'failed created data'
			], REST_Controller::HTTP_NO_CONTENT);
		}
	}

	public function index_put()
	{
		$data = [
			'name' => $this->put('name'),
			'updated_at' => date('Y-m-d H:i:s', time())
		];

		$id = $this->put('id');

		if ($this->tag->updateTag($data, $id) > 0) {
			$this->response(
				[
					'status' => true,
					'message' => 'Successfully updated data',
					'data' => $data
				],
				REST_Controller::HTTP_OK
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'Failed updated data'
				],
				REST_Controller::HTTP_BAD_REQUEST
			);
		}
	}

	public function index_delete()
	{
		$id = $this->delete('id');

		if ($id == null) {
			$this->response([
				'status' => false,
				'message' => 'Provide an id!'
			], REST_Controller::HTTP_BAD_REQUEST);
		} else {
			if ($this->tag->deleteTag($id)) {
				$this->response([
					'status' => true,
					'message' => 'Successfully deleted data'
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Tag data not found!'
				], REST_Controller::HTTP_NOT_FOUND);
			}
		}
	}
}
