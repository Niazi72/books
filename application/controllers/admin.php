<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class admin extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('adminModel');
		$this->load->library('form_validation');
		$this->load->library("encryption");
        $this->logged_in();
    }
    private function logged_in() {
        if(! $this->session->userdata('authenticated')) {
            $this->load->view('userlogin/login');
        }
    }
    public function index()
	{
		if($this->session->userdata('authenticated')) {
			$data				=	$this->adminModel->fetch_data();
			$fetchData['data']	=	$data;
			$this->load->view('admin/index.php',$fetchData);
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
