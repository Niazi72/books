<?php 
if(($this->session->userdata('category')== '0') || ($this->session->userdata('category')== '1')) {
    redirect('books');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<script type="text/javascript" src="{% static 'home/jquery.js' %}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<title>Books Publisher</title>
</head>
<body class='bodyClass'>
<!---NavBar For Admin Panel--->
<nav class="navbar navbar-expand-lg navbar-light bg-light"> <a class="navbar-brand" href="<?php echo base_url().'user' ?>"><img width='90' height='60' src="<?php echo base_url().'admin.png'; ?>"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active"> <a class="nav-link publishBook" href="<?php echo base_url().'books' ?>" > Books <span class="sr-only">(current)</span></a> </li>
            <li class="nav-item"> <a class="nav-link" href="javascript:void(0)" onClick=""> User </a> </li>
        </ul>
    </div>
    <div class="ml-auto"> <a  class="nav-link" href="javascript:void(0)" onClick="logout()">Logout</a> </div>
</nav>
<div id="ajaxResponse"> </div>
<div class="container">
    <div class="row pt-4">
    <div class="col-md-6"><h4>Users</h4></div>
        <div class="col-md-6 text-right">
            <a href="javascript:void(0)" onClick="showUserModal()"class="btn btn-primary">Create</a>
        </div>
        <!---Grid Show--->
        <div class="col-md-12 pt-4">
            <table class="table"  id="listShow">
                <tbody>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Category</th>
                        <th scope="col">Actions</th>
                    </tr>
                    <?php

					$i	=	1;
                    if(!empty($data))
                    {
                        foreach($data as $row)
                        {
                            $data['row']    =   $row;
                            $this->load->view('admin/row.php',$data);
                        }
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td>Record not found.</td>
                        </tr>
                        <?php
                    }
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!---User Add Form-->
<div class="modal fade" id="userAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="createForm"></div>
        </div>
    </div>
</div>
<!---Delete Model--->
<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Conformation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="deleteRec()">Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="partnerContent"></div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
    
	function showUserModal()
    {
        $('#userAddModal').modal('show');
        $.ajax({
            url: '<?php echo base_url().'admin/showModal' ?>',
            type: 'POST',
            data: {},
            dataType: 'json',
            success: function(response){
                $('#createForm').html(response["html"]);
            }
        })
    }
    $('body').on("submit","#userCreateForm",function(e){
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url().'admin/store' ?>',
            type: 'POST',
            data:new FormData(this),
            processData:false,
            contentType:false,
            dataType: 'json',
            success: function(response){
				if(response['status']    ==  1)
                {
                    $('#userAddModal').modal('hide');
                    $('#ajaxResponse').html(response['message']);
                    setTimeout(function() { $("#ajaxResponse").hide(); }, 3000);
                    $('#listShow').append(response['row']);
                }
                else
                {
                    $('#passwordErr').html(response['password']);
                }
            }
        })
    })
    //For edit
    function showEditForm(id)
    {
        $('#userAddModal .modal-title').html('Edit');
        $.ajax({
            url: '<?php echo base_url().'admin/edit/' ?>'+id,
            type: 'POST',
            dataType: 'json',
            success: function(response){
                $('#userAddModal #createForm').html(response["html"]);
                $('#userAddModal').modal('show');
            }
        });
    }
    //Update user Form
    $('body').on("submit", "#userEditForm", function(e){
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url().'admin/update' ?>',
            type: 'POST',
            data:new FormData(this),
            processData:false,
            contentType:false,
            dataType: 'json',
            success: function(response){
               if(response['status']    ==  1)
               {
                    $('#userAddModal').modal('hide');
                    $('#ajaxResponse').html(response['message']);
                    setTimeout(function() { $("#ajaxResponse").hide(); }, 3000);
                    $('#listShow').append(response['row']);

                    var id  =   response["row"]["pkci_user_ajaxid"];
                    $("#row-"+id+" .modelName").html(response["row"]["name"]);
                    $("#row-"+id+" .modelEmail").html(response["row"]["email"]);
                    if(response["row"]["category"]   ==  1)
                    {
                        $("#row-"+id+" .modelCategory").html('Shoopkeeper');
                    }
                    else
                    {
                        alert($('#passwordErr').html(response['password']));
                        $("#row-"+id+" .modelCategory").html('Customer');
                    }
               }
            }
        })
    })
    function confirmMsg(id)
    {
        $("#deleteModel").modal('show');
        $("#deleteModel .modal-body").html('Are you sure?');
        $("#deleteModel").data('id',id);
    }
    function deleteRec()
    {
        var id  =   $("#deleteModel").data('id');
        $.ajax({
            url: '<?php echo base_url().'admin/delete/' ?>'+id,
            type: 'POST',
            data:$(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                if(response['status']    ==  1)
                {
                    $("#deleteModel").modal('hide');
                    $('#ajaxResponse').html(response['message']);
                    setTimeout(function() { $("#ajaxResponse").hide(); }, 3000);
                    $('#row-'+id).remove();
                }
                else{
                    $("#deleteModel").modal('hide');
                    $('#ajaxResponse').html(response['message']);
                    setTimeout(function() { $("#ajaxResponse").hide(); }, 3000);
                }
            }
        })
    }
    function logout()
    {
        $.ajax({
            url: '<?php echo base_url().'login/logout' ?>',
            success: function(response){
                location.reload(true);
            }
        })
    }
</script>
</body>
</html>