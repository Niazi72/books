<form method="post" action="" id="userAddForm" name="userAddForm" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="container">
            <div class="container">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="" placeholder="Enter user name">
                    <p class="titleErr"></p>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" autocomplete="off">
                    <p class="publishbyErr"></p>
                </div>
                <div class="form-group">
                    <label for="email">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="*****">
                    <p class="publishbyErr"></p>
                </div>
                <div class="form-group">
                    <input type="radio" id="shopkeeper" name="category" value="1">
  					<label for="shopkeeper">Shopkeeper</label>
                    <input type="radio" id="customer" name="category" value="0">
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