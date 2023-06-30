<?php

class Web_m extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function addMessage($data) {
		try {
			$this->db->insert('message', $data);
			$id = $this->db->insert_id();

            $db_error = $this->db->error();
			if($db_error['code'] > 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false;
            }

            return $id;
		} catch(Exception $e) {
			log_message('error: ', $e->getMessage());
            return false;
		}
	}

	function getMessage() {
		try {
			$this->db->select('id, id as key, name, email, suggest')
					 ->from('message');

			$query = $this->db->get();
			$result = $query->result_array();

			$db_error = $this->db->error();
			if($db_error['code'] > 0) {
                throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
                return false;
            }

			return $result;
		} catch(Exception $e) {
			log_message('error: ', $e->getMessage());
			return false;
		}
	}
}
