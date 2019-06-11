<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mahasiswa_model', 'mahasiswa');

		// limits
		$this->methods['index_get']['limit'] = 3;
		$this->methods['index_create']['limit'] = 5;
	}

	public function index_get() 
	{
		$id = $this->get('id');
		
		if($id == null) {
			$mahasiswa = $this->mahasiswa->getMahasiswa();
		} else {
			$mahasiswa = $this->mahasiswa->getMahasiswa($id);
		}

		if($mahasiswa) {
			$this->response([
					'status' => true,
					'data' => $mahasiswa
				], REST_Controller::HTTP_OK
			);
		} else {
			$this->response([
				'status' => false,
				'message' => 'No data mahasiswa found'
				], REST_Controller::HTTP_NOT_FOUND
			);
		}
	}

	public function index_post() {
		$data = [
			'nim' => $this->post('nim'),
			'nama' => $this->post('nama'),
			'email' => $this->post('email'),
			'jurusan' => $this->post('jurusan')
		];

		if($this->mahasiswa->createMahasiswa($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'successfully created',
				'data' => $data
			], REST_Controller::HTTP_CREATED);
		} else {
			$this->response([
				'status' => false,
				'message' => "failed created data"
			], REST_Controller::HTTP_NO_CONTENT);
		}
	}

	public function index_put() {
		$data = [
			'nim' => $this->put('nim'),
			'nama' => $this->put('nama'),
			'email' => $this->put('email'),
			'jurusan' => $this->put('jurusan')
		];

		$id = $this->put('id');
		
		if($this->mahasiswa->updateMahasiswa($data, $id) > 0) {
			$this->response([
				'status' => true,
				'message' => 'successfully updated',
				'data' => $data
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => "failed updated data"
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_delete() {
		$id = $this->delete('id');

		if($id == null) {
			$this->response([
				'status' => false,
				'message' => 'Provide an id!'
			], REST_Controller::HTTP_BAD_REQUEST);
		} else {
			if($this->mahasiswa->deleteMahasiswa($id) > 0) {
				$this->response([
					'status' => true,
					'message' => 'Successfully delete!'
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => "Data with id {$id} not found"
				], REST_Controller::HTTP_NOT_FOUND);
			}
		}
	}
}
