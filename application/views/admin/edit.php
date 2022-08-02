<form method="post" action="" id="userEditForm" name="userEditForm" enctype="multipart/form-data">
<input type="hidden" name="pkci_user_ajaxid" value="<?php echo $row['pkci_user_ajaxid'];  ?>">    
<div class="modal-body">
        <div class="container">
            <div class="container">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" value="<?php echo $row['name']; ?>" id="name" name="name" value="" placeholder="Enter user name" required>
                    <p class="titleErr"></p>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" value="<?php echo $row['email']; ?>" id="email" name="email" placeholder="Enter email address" autocomplete="off" required>
                    <p class="publishbyErr"></p>
                </div>
                <div class="form-group">
                    <input type="radio" id="shopkeeper" name="category" value="1" <?php echo ($row['category']== '1') ?  "checked" : "" ;  ?> require>
  					<label for="shopkeeper">Shopkeeper</label>
                    <input type="radio" id="customer" name="category" value="0" <?php echo ($row['category']== '0') ?  "checked" : "" ;  ?>>
  					<label for="customer">Customer</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>