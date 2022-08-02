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
<!---NavBar For books crud--->
<nav class="navbar navbar-expand-lg bg-primary ">
<div class="container">
<h3>Book Ajax crud</h3>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
</nav>
<div id="ajaxResponse">
</div>
<!---Creat Modal--->
<div class="container my-4">
    <div class="row">
        <div class="col-md-6"><h4>Publish Books</h4></div>
        <div class="col-md-6 text-right">
            <a href="javascript:void(0)" onclick="showModel()"class="btn btn-primary">Create</a>
        </div>
    </div>
</div>
<!---Grid Show--->
<div class="container my-4" id="gridshow">
    <table class="table" id="myTable">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Publish By</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i  =   1;
            if(!empty($data))
            {
                foreach($data as $row)
                {
                    $data['row']    =   $row;
                    $this->load->view('bookForm/row.php',$data);
                }
            }else{
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
<!---Modal-->
<div class="modal fade" id="createFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Book Publish</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="response"></div>
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


<!-- Optional JavaScript --> 
<!-- jQuery first, then Popper.js, then Bootstrap JS --> 
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
    function showModel()
    {
        $('#createFormModal').modal('show');
        $('#createFormModal #title').html('Book Publish');
        $.ajax({
            url: '<?php echo base_url().'index.php/booksController/showCreateForm' ?>',
            type: 'POST',
            data: {},
            dataType: 'json',
            success: function(response){
                $('#response').html(response["html"]);
            }
        })
    }
    $('body').on("submit","#bookPublishForm",function(e){
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url().'index.php/booksController/insertData' ?>',
            type: 'POST',
            data:new FormData(this),
            processData:false,
            contentType:false,
            dataType: 'json',
            success: function(response){
               if(response['status']    ==  0)
               {
                    if(response['title'] != '')
                    {
                        $('.titleErr').html(response['title']).addClass('invalid-feedback d-block');
                        $('#title').addClass('is-invalid');
                    }else{
                        $('.titleErr').html('').removeClass('invalid-feedback d-block');
                        $('#title').removeClass('is-invalid');
                    }

                    if(response['publishby'] != '')
                    {
                        $('.publishbyErr').html(response['publishby']).addClass('invalid-feedback d-block');
                        $('#publishby').addClass('is-invalid');
                    }else{
                        $('.publishbyErr').html('').removeClass('invalid-feedback d-block');
                        $('#publishby').removeClass('is-invalid');
                    }
                    
                    if(response['description'] != '')
                    {
                        $('.descriptionErr').html(response['description']).addClass('invalid-feedback d-block');
                        $('#description').addClass('is-invalid');
                    }else{
                        $('.descriptionErr').html('').removeClass('invalid-feedback d-block');
                        $('#description').removeClass('is-invalid');
                    }
               }else{
                    $('#createFormModal').modal('hide');
                    $('#ajaxResponse').html(response['message']);
                    setTimeout(function() { $("#ajaxResponse").hide(); }, 3000);

                    $('.titleErr').html('').removeClass('invalid-feedback d-block');
                    $('#title').removeClass('is-invalid');

                    $('.publishbyErr').html('').removeClass('invalid-feedback d-block');
                    $('#publishby').removeClass('is-invalid');

                    $('.descriptionErr').html('').removeClass('invalid-feedback d-block');
                    $('#description').removeClass('is-invalid');
                    $('#gridshow tr:last').after(response['row']);
               }
            }
        })
    })

    //For Update
    function showEditForm(id)
    {
        $('#createFormModal .modal-title').html('Edit');
        $.ajax({
            url: '<?php echo base_url().'index.php/booksController/GetSingleRec/' ?>'+id,
            type: 'POST',
            dataType: 'json',
            success: function(response){
                $('#createFormModal #response').html(response["html"]);
                $('#createFormModal').modal('show');
            }
        });
    }
    //edit Book Publish Form
    $('body').on("submit","#editBookPublishForm",function(e){
        e.preventDefault(); 
        $.ajax({
            url: '<?php echo base_url().'index.php/booksController/update' ?>',
            type: 'POST',
            data:new FormData(this),
            processData:false,
            contentType:false,
            dataType: 'json',
            success: function(response){
               if(response['status']    ==  0)
               {
                    if(response['title'] != '')
                    {
                        $('.titleErr').html(response['title']).addClass('invalid-feedback d-block');
                        $('#title').addClass('is-invalid');
                    }else{
                        $('.titleErr').html('').removeClass('invalid-feedback d-block');
                        $('#title').removeClass('is-invalid');
                    }

                    if(response['publishby'] != '')
                    {
                        $('.publishbyErr').html(response['publishby']).addClass('invalid-feedback d-block');
                        $('#publishby').addClass('is-invalid');
                    }else{
                        $('.publishbyErr').html('').removeClass('invalid-feedback d-block');
                        $('#publishby').removeClass('is-invalid');
                    }
                    
                    if(response['description'] != '')
                    {
                        $('.descriptionErr').html(response['description']).addClass('invalid-feedback d-block');
                        $('#description').addClass('is-invalid');
                    }else{
                        $('.descriptionErr').html('').removeClass('invalid-feedback d-block');
                        $('#description').removeClass('is-invalid');
                    }
               }else{
                    $('#createFormModal').modal('hide');
                    $('#ajaxResponse').html(response['message']);
                    setTimeout(function() { $("#ajaxResponse").hide(); }, 3000);
                    $('.titleErr').html('').removeClass('invalid-feedback d-block');
                    $('#title').removeClass('is-invalid');

                    $('.publishbyErr').html('').removeClass('invalid-feedback d-block');
                    $('#publishby').removeClass('is-invalid');

                    $('.descriptionErr').html('').removeClass('invalid-feedback d-block');
                    $('#description').removeClass('is-invalid');

                    $('#gridShow').html(response['row'])
                    
                    
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
            url: '<?php echo base_url().'index.php/booksController/delete/' ?>'+id,
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
</script>
</body>
<div style=" padding-bottom:50px;"></div>
</html>
