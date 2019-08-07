<?php

class Post_model extends CI_Model
{
	public function getPosts($id = null)
	{
		if ($id == null) {
			$result = $this->db->get('posts')->result_array();
		} else {
			$result = $this->db->get_where('posts', ['id' => $id])->result_array();
		}

		return $result;
	}

	public function createPost($data)
	{
		$this->db->insert('posts', $data);

		return $this->db->affected_rows();
	}

	public function updatePost($data, $id)
	{
		$this->db->update('posts', $data, ['id' => $id]);

		return $this->db->affected_rows();
	}

	public function deletePost($id)
	{
		$this->db->delete('posts', ['id' => $id]);

		return $this->db->affected_rows();
	}
}
