<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class books extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('booksModel');
        $this->logged_in();
		$this->load->library("pagination");
		$this->load->helper("url");
		$this->perPage	=	5;
		$config = array(
			'upload_path' => './uploads/',
			'allowed_types' => "gif|jpg|png|jpeg|pdf",
			'overwrite' => TRUE,
			'max_size' => "2048000",
			'max_height' => "768",
			'max_width' => "1024"
		);
	   	$this->load->library('upload', $config);
    }
    private function logged_in() {
        if(! $this->session->userdata('authenticated')) {
            $this->load->view('userlogin/login');
        }
    }
	public function index($row = 0)
	{
		if($this->session->userdata('authenticated')) {
			$this->load->view('books/index.php');
		}
	}
	function pagination()
	{
		$config = array();
		$config["base_url"] = "#";
		$config["total_rows"] = $this->booksModel->count_all();
		$config["per_page"] = 5;
		$config["uri_segment"] = 3;
		$config["use_page_numbers"] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination">';        
		$config['full_tag_close'] = '</ul>';        
		$config['first_link'] = 'First';        
		$config['last_link'] = 'Last';        
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';        
		$config['first_tag_close'] = '</span></li>';        
		$config['prev_link'] = '&laquo';        
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';        
		$config['prev_tag_close'] = '</span></li>';        
		$config['next_link'] = '&raquo';        
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';        
		$config['next_tag_close'] = '</span></li>';        
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';        
		$config['last_tag_close'] = '</span></li>';        
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';        
		$config['cur_tag_close'] = '</a></li>';        
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';        
		$config['num_tag_close'] = '</span></li>';
		$config["num_links"] = 1;
		$this->pagination->initialize($config);
		$page = $this->uri->segment(3);
		$start = ($page - 1) * $config["per_page"];
	
		$output = array(
			'pagination_link'  => $this->pagination->create_links(),
			'country_table'   => $this->booksModel->fetch_details($config["per_page"], $start)
		);
		echo json_encode($output);
	}
  
	public function showCreateForm()
	{
		$html				=	$this->load->view('books/create.php','',true);
		$response['html']	=	$html;
		echo json_encode($response);
	}
	public function do_upload($image){
		
		if($this->upload->do_upload('image'))
		{
			$data = array('upload_data' => $this->upload->data());
		}
		else
		{
			$error = array('error' => $this->upload->display_errors());
		}
	}
	public function insertData()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('publishby','Publish By','required');
		$this->form_validation->set_rules('description','Description','required');
		if($this->form_validation->run()	==	true)
		{
			$this->do_upload($_FILES['image']);
			$dataArr				=	array();
			$dataArr['title']		=	$this->input->post('title');
			$dataArr['publishby']	=	$this->input->post('publishby');
			$dataArr['description']	=	$this->input->post('description');
			
			if(isset($_FILES['image'])){
				$dataArr['image']	=	 $_FILES['image']['name'];
				$id					=	$this->booksModel->insert_data($dataArr);
				$row				=	$this->booksModel->getRow($id);
				$sData['row']		=	$row;
				$htmlRow			=	$this->load->view('books/row.php',$sData,true);
				$response['row']	=	$htmlRow;
			}
			$response['status']	=	1;
			$response['message']	=	'<div id="alertMsg" class="alert alert-success alert-dismissible fade show" role="alert">
											<strong>Success!</strong> Record has been added successfully.
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>';
		}
		else
		{
			$response['status']			=	0;
			$response['title']			=	strip_tags(form_error('title'));
			$response['publishby']		=	strip_tags(form_error('publishby'));
			$response['description']	=	strip_tags(form_error('description'));
		}
		echo json_encode($response);
	}
	public function GetSingleRec($pkci_book_ajaxid)
	{
		$row				=	$this->booksModel->GetSingleRec($pkci_book_ajaxid);
		$data['row']		=	$row;
		$html				=	$this->load->view('books/edit.php',$data,true);
		$response['html']	=	$html;
		echo json_encode($response);
	}
	public function update()
	{
		$pkci_book_ajaxid	=	$this->input->post('pkci_book_ajaxid');
		$row				=	$this->booksModel->GetSingleRec($pkci_book_ajaxid);
		if(empty($row))
		{
			$response['msg']	=	"Either record deleted or not found in DB";
			$response['status']	=	100;
			json_encode($response);
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('publishby','Publish By','required');
		$this->form_validation->set_rules('description','Description','required');
		if($this->form_validation->run()	==	true)
		{
			$this->do_upload($_FILES['image']);
			$dataArr				=	array();
			$dataArr['title']		=	$this->input->post('title');
			$dataArr['publishby']	=	$this->input->post('publishby');
			$dataArr['image']		=	$this->input->post('image');
			$dataArr['description']	=	$this->input->post('description');
			if(isset($_FILES['image'])){
				
				$dataArr['image']	=	$_FILES['image']['name'];
				$id					=	$this->booksModel->update_user_record($pkci_book_ajaxid,$dataArr);
				$row				=	$this->booksModel->getRow($id);
				$response['row']	=	$row;
			}
			$response['status']		=	1;
			$response['message']	=	'<div id="alertMsg" class="alert alert-success alert-dismissible fade show" role="alert">
											<strong>Success!</strong> Record has been Updated successfully.
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>';
		}
		else
		{
			$response['status']			=	0;
			$response['title']			=	strip_tags(form_error('title'));
			$response['publishby']		=	strip_tags(form_error('publishby'));
			$response['description']	=	strip_tags(form_error('description'));
		}
		echo json_encode($response);
	}
	public function delete($pkci_book_ajaxid)
	{
		$row					=	$this->booksModel->GetSingleRec($pkci_book_ajaxid);
		if(empty($row))
		{
			$response['message']	=	"Either record already deleted or not found in DB";
			$response['status']	=	0;
			echo json_encode($response);
			exit;
		}
		else{
			
			$this->booksModel->delete($pkci_book_ajaxid);
			$response['message']	=	"Record has been deletd successfully!";
			$response['status']	=	1;
			echo json_encode($response);
		}
	}
}
