<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adminModel extends CI_Model {
	public function store($data)
	{
		$this->db->insert('ci_user_ajax',$data);
		return $id	=	$this->db->insert_id();
	}
	public function getRow($pkci_user_ajaxid)
	{
		$this->db->where('pkci_user_ajaxid',$pkci_user_ajaxid);
		return $singleRecordFetch	=	$this->db->get('ci_user_ajax')->row_array(); 
	}
	public function fetch_data()
	{
		return $fetchData	=	$this->db->get('ci_user_ajax')->result_array();
	}
	public function edit($pkci_user_ajaxid)
	{
		$this->db->where('pkci_user_ajaxid',$pkci_user_ajaxid);
		return $singleRecordFetch	=	$this->db->get('ci_user_ajax')->row_array();
	}
	public function update($pkci_user_ajaxid,$dataArr)
	{
		$this->db->where('pkci_user_ajaxid',$pkci_user_ajaxid);
		$this->db->update('ci_user_ajax',$dataArr);
		return $pkci_user_ajaxid;
	}
	public function delete($pkci_user_ajaxid)
	{
		$this->db->where('pkci_user_ajaxid',$pkci_user_ajaxid);
		$this->db->delete('ci_user_ajax');
		
	}
	public function login($email, $password)
    {
		$this->load->library("encryption");
        $this->db->where('email', $email);
        $query = $this->db->get('ci_user_ajax');
        if($query->num_rows() == 1) {
			$savePassword	=	$this->encryption->decrypt($query->row()->password);
			if($password	==	$savePassword)
			{
            	return $query->row();
			}
        }
        return false;
    }
}
?>