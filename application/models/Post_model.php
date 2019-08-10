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

	public function getPostByCategoryId($id)
	{
		return $this->db->get_where('posts', ['category_id' => $id])->result_array();
	}

	public function getPostByTagId($post_id, $tag_id)
	{
		$this->db->select('*');
		$this->db->where('post_tags.post_id', $post_id);
		$this->db->where('post_tags.tag_id', $tag_id);
		$this->db->from('post_tags');
		$this->db->join('posts', 'posts.id = post_tags.post_id');
		$this->db->join('tags', 'tags.id = post_tags.tag_id');

		return $this->db->get()->result_array();
	}

	public function getPostByUserId($post_id, $user_id)
	{
		$this->db->select('*');
		$this->db->where('user_post.post_id', $post_id);
		$this->db->where('user_post.tag_id', $user_id);
		$this->db->from('user_post');
		$this->db->join('posts', 'posts.id = user_posts.post_id');
		$this->db->join('users', 'users.id = user_posts.tag_id');

		return $this->db->get()->result_array();
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
