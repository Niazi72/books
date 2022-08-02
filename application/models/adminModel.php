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
	function count_all()
	{
	$query = $this->db->get("ci_user_ajax");
	return $query->num_rows();
	}

	function fetch_details($limit, $start)
	{
	$output = '';
	$this->db->select("*");
	$this->db->from("ci_user_ajax");
	$this->db->limit($limit, $start);
	$query = $this->db->get();
	$output .= '
	<table class="table table-bordered" id="listShow">
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Category</th>
		<th>Action</th>
	</tr>
	';
	foreach($query->result() as $row)
	{
		if($row->category==1)
		{
			$category = "Shopkeeper";
		}
		else{
			$category = "Customer";
		}
		if(!($row->category==2))
		{
			$output .= '
			<tr id="row-'.$row->pkci_user_ajaxid.'">
				<td class="modelName">'.$row->name.'</td>
				<td class="modelEmail">'.$row->email.'</td>
				<td class="modelCategory">'.$category.'</td>
				
				<td><a href="javascript:void(0)" onclick="showEditForm('.$row->pkci_user_ajaxid.')" class="edit btn btn-sm btn-primary" >Edit</a>
				<a href="javascript:void(0)" onclick="confirmMsg('.$row->pkci_user_ajaxid.')" class="delete btn btn-sm btn-danger" >Delete</a>
				</td>
			</tr>
			';
		}
	}
	$output .= '</table>';
	return $output;
	}
}
?>