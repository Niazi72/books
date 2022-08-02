<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class admin extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('adminModel');
		$this->load->library('form_validation');
		$this->load->library("encryption");
		
		$this->load->library("pagination");
		$this->load->helper("url");
        $this->logged_in();
    }
    private function logged_in() {
        if(! $this->session->userdata('authenticated')) {
            $this->load->view('userlogin/login');
        }
    }
	function pagination()
	{
		$config = array();
		$config["base_url"] = "#";
		$config["total_rows"] = $this->adminModel->count_all();
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
			'country_table'   => $this->adminModel->fetch_details($config["per_page"], $start)
		);
		echo json_encode($output);
	}
    public function index()
	{
		if($this->session->userdata('authenticated')) {
			//$data				=	$this->adminModel->fetch_data();
			//$fetchData['data']	=	$data;
			$this->load->view('admin/index.php');
		}
	}
	public function showModal()
	{
		$html				=	$this->load->view('admin/create.php','',true);
		$response['html']	=	$html;
		echo json_encode($response);
	}
	public function store()
	{
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('password','Password','required|min_length[8]|max_length[25]');
		$this->form_validation->set_rules('category','Category','required');
		if($this->form_validation->run()	==	true)
		{
			$dataArr				=	array();
			$data['name']			=	$this->input->post('name');
			$data['email']			=	$this->input->post('email');
			$data['password']		=	$this->encryption->encrypt($this->input->post('password'));
			$data['category']		=	$this->input->post('category');
			$id						=	$this->adminModel->store($data);

			$row					=	$this->adminModel->getRow($id);
			$sData['row']			=	$row;
			$htmlRow				=	$this->load->view('admin/row.php',$sData,true);
			$response['row']		=	$htmlRow;

			$response['status']		=	1;
			$response['message']	=	'<div id="alertMsg" class="alert alert-success alert-dismissible fade show" role="alert">
											<strong>Success!</strong> Record has been added successfully.
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>';
		}
		else
		{
			$response['status']		=	0;
			$response['name']		=	strip_tags(form_error('name'));
			$response['email']		=	strip_tags(form_error('email'));
			$response['password']	=	strip_tags(form_error('password'));
			$response['category']	=	strip_tags(form_error('category'));
		}
		echo json_encode($response);
	}
	public function edit($pkci_user_ajaxid)
	{
		$row				=	$this->adminModel->edit($pkci_user_ajaxid);
		$data['row']		=	$row;
		$html				=	$this->load->view('admin/edit.php',$data,true);
		$response['html']	=	$html;
		echo json_encode($response);
	}
	public function update()
	{
		$pkci_user_ajaxid	=	$this->input->post('pkci_user_ajaxid');
		$row				=	$this->adminModel->edit($pkci_user_ajaxid);
		if(empty($row))
		{
			$response['msg']	=	"Either record deleted or not found in DB";
			$response['status']	=	100;
			json_encode($response);
			exit;
		}
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('category','Category','required');
		if($this->form_validation->run()	==	true)
		{
			$dataArr				=	array();
			$dataArr['name']		=	$this->input->post('name');
			$dataArr['email']		=	$this->input->post('email');
			$dataArr['category']	=	$this->input->post('category');
			
			$id						=	$this->adminModel->update($pkci_user_ajaxid,$dataArr);
			$row					=	$this->adminModel->getRow($id);
			$response['row']		=	$row;
			
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
			echo 123;
			$response['status']		=	0;
			$response['name']		=	strip_tags(form_error('name'));
			$response['email']		=	strip_tags(form_error('email'));
			$response['category']	=	strip_tags(form_error('category'));
		}
		echo json_encode($response);
	}
	public function delete($pkci_user_ajaxid)
	{
		$row						=	$this->adminModel->edit($pkci_user_ajaxid);
		if(empty($row))
		{
			$response['message']	=	"Either record already deleted or not found in DB";
			$response['status']		=	0;
			echo json_encode($response);
			exit;
		}
		else{
			
			$this->adminModel->delete($pkci_user_ajaxid);
			$response['message']	=	"Record has been deletd successfully!";
			$response['status']		=	1;
			echo json_encode($response);
		}
	}
}
