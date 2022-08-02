<?php
include('dbconn.php');
include('insert.php');
session_start();
?> 
<!doctype html>
<html lang="en">
  <head>
  	<style type="text/css">
		table{
			margin-top:150px;
			border:1px solid;
			background-color:#eee;
		}
		td{
			border:0px;
			padding:10px;
		}
		th{
			border-bottom:1px solid;
			background-color:#ddd;
		}
	</style>
    <!-- Required meta tags -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Books Publisher</title>
	</head>
	<body style="background-color:#0DCAF0 !important;">
    	<?php if($this->session->flashdata('message')){?>
		<div class="alert alert-danger">
        	<?php echo $this->session->flashdata('message'); ?>
        </div>
		<?php } ?>
       	<form>
        	<table align="center">
            	<tr>
                	<th colspan="2">
                    	<h2>Login</h2>
                    </th>
                </tr>
                <tr>
                	<td>User Name</td>
                    <td><input type="text" name="username" ></td>
                </tr>
                <tr>
                	<td>Password</td>
                    <td><input type="password" name="password" ></td>
                </tr>
                <tr>
                	<td align="right" colspan="2">
                    	<input type="submit" nname="login" value="login">
                    </td>
                </tr>
            </table>
        </form>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    <div style=" padding-bottom:50px;">
    </div>
</html>