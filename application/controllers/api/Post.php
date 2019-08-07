<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Post extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Post_model', 'post');
	}

	public function index_get($id = null)
	{
		$id = $this->get('id');

		if ($id == null) {
			$post = $this->post->getPosts();
		} else {
			$post = $this->post->getPosts($id);
		}

		if ($post) {
			$this->response(
				[
					'status' => true,
					'data' => $post
				],
				REST_Controller::HTTP_OK
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'Posts data not found.'
				],
				REST_Controller::HTTP_NOT_FOUND
			);
		}
	}

	public function index_post()
	{
		$data = [
			'category_id' => $this->post('category_id'),
			'title' => $this->post('title'),
			'image' => $this->post('image'),
			'body' => $this->post('body'),
			'published' => $this->post('published'),
			'created_at' => date('Y-m-d H:i:s', time())
		];

		if ($this->post->createPost($data)) {
			$this->response(
				[
					'status' 	=> true,
					'message' 	=> 'Successfully created post',
					'data' 		=> $data
				],
				REST_Controller::HTTP_CREATED
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'Failed created post'
				],
				REST_Controller::HTTP_NO_CONTENT
			);
		}
	}

	public function index_put()
	{
		$id = $this->put('id');

		$data = [
			'category_id' => $this->put('category_id'),
			'title' => $this->put('title'),
			'image' => $this->put('image'),
			'body' => $this->put('body'),
			'published' => $this->put('published'),
			'updated_at' => date('Y-m-d H:i:s', time())
		];

		if ($this->post->updatePost($data, $id)) {
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
			$this->response(
				[
					'status' => false,
					'message' => 'Provide an id!'
				],
				REST_Controller::HTTP_BAD_REQUEST
			);
		} else {
			if ($this->post->deletePost($id)) {
				$this->response(
					[
						'status' => true,
						'message' => 'Successfully created data'
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

	public function category_get()
	{
		$id = $this->get('id');

		if ($id == null) {
			$this->response(
				[
					'status' => false,
					'message' => 'Provide an id!'
				],
				REST_Controller::HTTP_BAD_REQUEST
			);
		} else {
			$post = $this->post->getPostByCategoryId($id);
		}

		if ($post) {
			$this->response(
				[
					'status' => true,
					'data' => $post
				],
				REST_Controller::HTTP_OK
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'Posts data not found.'
				],
				REST_Controller::HTTP_NOT_FOUND
			);
		}
	}

	public function tag_get()
	{
		$id = $this->get('id');

		if ($id == null) {
			$this->response(
				[
					'status' => false,
					'message' => 'Provide an id!'
				],
				REST_Controller::HTTP_BAD_REQUEST
			);
		} else {
			$post = $this->post->getPostByTagId($id);
		}

		if ($post) {
			$this->response(
				[
					'status' => true,
					'data' => $post
				],
				REST_Controller::HTTP_OK
			);
		} else {
			$this->response(
				[
					'status' => false,
					'message' => 'Posts data not found.'
				],
				REST_Controller::HTTP_NOT_FOUND
			);
		}
	}
}
