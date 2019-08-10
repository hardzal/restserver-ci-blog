<?php

class User_model extends CI_Model
{
	public function getUsers($id = null)
	{
		if ($id == null) {
			$result = $this->db->get('users')->result_array();
		} else {
			$result = $this->db->get_where('users', ['id' => $id])->result_array();
		}

		return $result;
	}

	public function createUser($data)
	{
		$this->db->insert('users', $data);

		return $this->db->affected_rows();
	}

	public function updateUser($data, $id)
	{
		$this->db->update('users', $data, ['id' => $id]);

		return $this->db->affected_rows();
	}

	public function deleteUser($id)
	{
		$this->db->delete('users', ['id' => $id]);

		return $this->db->affected_rows();
	}
}
