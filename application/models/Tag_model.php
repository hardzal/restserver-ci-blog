<?php

class Tag_model extends CI_Model
{
	public function getTags($id = null)
	{
		if ($id == null) {
			$result = $this->db->get('tags')->result_array();
		} else {
			$result = $this->db->get_where('tags', ['id' => $id])->result_array();
		}

		return $result;
	}

	public function createTag($data)
	{
		$this->db->insert('tags', $data);

		return $this->db->affected_rows();
	}

	public function updateTag($data, $id)
	{
		$this->db->update('tags', $data, ['id' => $id]);

		return $this->db->affected_rows();
	}

	public function deleteTag($id)
	{
		$this->db->delete('tags', ['id' => $id]);

		return $this->db->affected_rows();
	}
}
