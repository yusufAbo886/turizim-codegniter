<?php
class Excel_export_model extends CI_Model
{
	function fetch_data()
	{
		$this->db->order_by("prId", "DESC");
		$query = $this->db->get("products");
		return $query->result();
	}


}
