<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class booksModel extends CI_Model {
	function __construct() { 
        // Set table name 
        $this->table = 'ci_books_ajax'; 
    } 

	public function insert_data($data)
	{
		$this->db->insert('ci_books_ajax',$data);
		return $id	=	$this->db->insert_id();
	}
	function count_all()
 {
  $query = $this->db->get("ci_books_ajax");
  return $query->num_rows();
 }

 function fetch_details($limit, $start)
 {
  $output = '';
  $this->db->select("*");
  $this->db->from("ci_books_ajax");
  $this->db->limit($limit, $start);
  $query = $this->db->get();
  $output .= '
  <table class="table table-bordered" id="gridshow">
   <tr>
    <th>Title</th>
    <th>Publish By</th>
	<th>Image</th>
	<th>Description</th>
	<th>Action</th>
   </tr>
  ';
  foreach($query->result() as $row)
  {
   $output .= '
   <tr id="row-'.$row->pkci_book_ajaxid.'">
    <td class="modelTitle">'.$row->title.'</td>
    <td class="modelPublishby">'.$row->publishby.'</td>
	<td class="modelImage"><img id="imageid" width="50" height="50" src='.base_url()."uploads/".$row->image.'></td>
	<td class="modelDescription">'.$row->description.'</td>
    
	<td><a href="javascript:void(0)" onclick="showEditForm('.$row->pkci_book_ajaxid.')" class="edit btn btn-sm btn-primary" >Edit</a>
	<a href="javascript:void(0)" onclick="confirmMsg('.$row->pkci_book_ajaxid.')" class="delete btn btn-sm btn-danger" >Delete</a>
	</td>
   </tr>
   ';
  }
  $output .= '</table>';
  return $output;
 }
	public function fetch_data()
	{
		return $fetchData	=	$this->db->get('ci_books_ajax')->result_array();
	}
	public function getRow($pkci_book_ajaxid)
	{
		$this->db->where('pkci_book_ajaxid',$pkci_book_ajaxid);
		return $singleRecordFetch	=	$this->db->get('ci_books_ajax')->row_array(); 
	}
	public function GetSingleRec($pkci_book_ajaxid)
	{
		$this->db->where('pkci_book_ajaxid',$pkci_book_ajaxid);
		return $singleRecordFetch	=	$this->db->get('ci_books_ajax')->row_array();
	}
	public function update_user_record($pkci_book_ajaxid,$dataArray)
	{
		$title			=	$dataArray['title'];
		$publishby		=	$dataArray['publishby'];
		$description	=	$dataArray['description'];
		$image			=	$dataArray['image'];
		if(!empty($image))
		{
			$this->db->where('pkci_book_ajaxid',$pkci_book_ajaxid);
			$this->db->update('ci_books_ajax',array('title'=>$title,'publishby'=>$publishby,'description'=>$description,'image'=>$image));
			return $pkci_book_ajaxid;
		}
		else
		{
			$this->db->where('pkci_book_ajaxid',$pkci_book_ajaxid);
			$this->db->update('ci_books_ajax',array('title'=>$title,'publishby'=>$publishby,'description'=>$description));
			return $pkci_book_ajaxid;
		}
	}
	public function delete($pkci_book_ajaxid)
	{
		$this->db->where('pkci_book_ajaxid',$pkci_book_ajaxid);
		$this->db->delete('ci_books_ajax');
		
	}
	public function login($email,$password)
	{
		$this->db->where('email',$email);
		$this->db->where('password',$password);
		//$this->db->where('category',1);
		$query	=	$this->db->get('ci_user_ajax');
		if($query->num_rows()	==	1)
		{
			return $query->row();
		}
		return false;
	}
}
?>