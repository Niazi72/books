<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<script type="text/javascript" src="{% static 'home/jquery.js' %}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<title>Books Publisher</title>
</head>
<body class='bodyClass'>
<!---NavBar For books crud--->
<?php if(($this->session->userdata('category')== '0') || ($this->session->userdata('category')== '1')) { ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light"> <a class="navbar-brand" href="<?php echo base_url().'books' ?>"><img width='90' height='60' src="<?php echo base_url().'book-publishing-process.jpeg'; ?>"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active"> <a class="nav-link publishBook" href="<?php echo base_url().'books' ?>" > Books <span class="sr-only">(current)</span></a> </li>
        </ul>
    </div>
    <div class="ml-auto"> <a  class="nav-link" href="javascript:void(0)" onClick="logout()">Logout</a> </div>
</nav>
<?php  } else{ ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light"> <a class="navbar-brand" href="<?php echo base_url().'books' ?>"><img width='90' height='60' src="<?php echo base_url().'admin.png'; ?>"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active"> <a class="nav-link publishBook" href="<?php echo base_url().'books' ?>" > Books <span class="sr-only">(current)</span></a> </li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url().'user' ?>"> User </a> </li>
            </ul>
        </div>
        <div class="ml-auto"> <a  class="nav-link" href="javascript:void(0)" onClick="logout()">Logout</a> </div>
    </nav>
<?php } ?>
<!-- <nav class="navbar navbar-expand-lg bg-primary ">
<div class="container">
<h3>Book Ajax crud</h3>
<a style="margin-left:76%;" href="javascript:void(0)" onClick=""class="btn btn-primary">Logout</a>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
</ul>
</div>
</div>
</nav> -->
<div id="ajaxResponse">
</div>
<!---Creat Modal--->
<div class="container">
    <div class="row pt-4">
        <div class="col-md-6"><h4>Publish Books</h4></div>
        <div class="col-md-6 text-right">
        <?php if ($this->session->userdata('category')== '2' || $this->session->userdata('category')== '1') { ?>
            <a href="javascript:void(0)" onClick="showModel()"class="btn btn-primary">Create</a>
            <?php } ?>
        </div>
        
        <!---Grid Show--->
        <div class="col-md-12 pt-4">
            <table class="table"  id="gridshow">
                <tbody>
                    <div class="table-responsive" id="country_table"></div>
                </tbody>
            </table>
            <ul style =" display:block;float:right;" class="pagination" id="pagination_link"></ul>
        </div>
    </div>
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
    $(document).ready(function(){

        function load_country_data(page)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>books/pagination/"+page,
                method:"GET",
                dataType:"json",
                success:function(data)
                {
                    $('#country_table').html(data.country_table);
                    $('#pagination_link').html(data.pagination_link);
                }
            });
        }

        load_country_data(1);

        $(document).on("click", ".pagination li a", function(event){
            event.preventDefault();
            var page = $(this).data("ci-pagination-page");
            load_country_data(page);
        });

    });
    function showModel()
    {
        $('#createFormModal').modal('show');
        $('#createFormModal #title').html('Book Publish');
        $.ajax({
            url: '<?php echo base_url().'showCreateForm' ?>',
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
            url: '<?php echo base_url().'insertData' ?>',
            type: 'POST',
            data:new FormData(this),
            processData:false,
            contentType:false,
            dataType: 'json',
            success: function(response){
				if(response['status']    ==  1)
                {
                    $('#createFormModal').modal('hide');
                    $('#ajaxResponse').html(response['message']);
                    setTimeout(function() { $("#ajaxResponse").hide(); }, 3000);
                    $('#gridshow').append(response['row']);
                }
            }
        })
    })
    //For Update
    function showEditForm(id)
    {
        $('#createFormModal .modal-title').html('Edit');
        $.ajax({
            url: '<?php echo base_url().'books/GetSingleRec/' ?>'+id,
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
            url: '<?php echo base_url().'update' ?>',
            type: 'POST',
            data:new FormData(this),
            processData:false,
            contentType:false,
            dataType: 'json',
            success: function(response){
               if(response['status']    ==  1)
               {
                    $('#createFormModal').modal('hide');
                    $('#ajaxResponse').html(response['message']);
                    setTimeout(function() { $("#ajaxResponse").hide(); }, 3000);
                    $('#gridshow').append(response['row']);

                    var id  =   response["row"]["pkci_book_ajaxid"];
                     $("#row-"+id+" .modelTitle").html(response["row"]["title"]);
                    
                    $("#row-"+id+" .modelPublishby").html(response["row"]["publishby"]);
                    $("#row-"+id+" .modelDescription").html(response["row"]["description"]);
                    var image = $("#row-"+id+" .modelImage #imageid").attr('src', "<?php echo base_url()?>"+response["row"]["image"]);
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
            url: '<?php echo base_url().'books/delete/' ?>'+id,
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
<div style=" padding-bottom:50px;"></div>
</html>