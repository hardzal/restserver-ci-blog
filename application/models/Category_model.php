<?php

class Category_model extends CI_Model
{

	public function getCategories($id = null)
	{
		if ($id == null) {
			$result = $this->db->get('categories')->result_array();
		} else {
			$result = $this->db->get_where('categories', ['id' => $id])->result_array();
		}

		return $result;
	}

	public function createCategory($data)
	{
		$this->db->query("INSERT INTO categories VALUES ('', '$data[name]', now(), '')");

		return $this->db->affected_rows();
	}

	public function updateCategory($data, $id)
	{
		$this->db->query('categories', $data, ['id' => $id]);

		return $this->db->affected_rows();
	}

	public function deleteCategory($id)
	{
		$this->db->delete('categories', ['id' => $id]);

		return $this->db->affected_rows();
	}
}
