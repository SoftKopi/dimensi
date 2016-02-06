<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Season_model extends CI_Model {

	private $tbl;

	public function __construct(){
		parent::__construct();
		$this->tbl = 'seasons';
	}

	public function select_all(){
		$this->db->select('*');
		$this->db->from($this->tbl);

		return $this->db->get();
	}
}