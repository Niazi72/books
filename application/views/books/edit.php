<form method="post" action="" id="editBookPublishForm" name="editBookPublishForm" enctype="multipart/form-data">
    <input type="hidden" name="pkci_book_ajaxid" value="<?php echo $row['pkci_book_ajaxid'];  ?>">
    <div class="modal-body">
        <div class="container">
            <div class="container">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" value="<?php echo $row['title']; ?>" id="title" name="title" value="" placeholder="Enter title">
                    <p class="titleErr"></p>
                </div>
                <div class="form-group">
                    <label for="publishby">Publish By</label>
                    <input type="text" class="form-control" value="<?php echo $row['publishby']; ?>" id="publishby" name="publishby" placeholder="Enter publisher name">
                    <p class="publishbyErr"></p>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" value="<?php echo $row['image']; ?>" accept="image/jpeg,application/pdf,image/gif,application/msword" id="image" name="image" value="">
                    <p class="imageErr"></p>
                </div>
                <div class="form-group">
                    <img id="imageid" width='70' height='50' src="<?php echo base_url().'uploads/'.$row['image']; ?>"/>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <div class="word-counter" style="float:right">0/1000</div>
                    <textarea class="form-control" id="description" name="description"><?php echo $row['description'];?></textarea>
                    <p class="descriptionErr"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>