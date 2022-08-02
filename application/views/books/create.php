<form method="post" action="" id="bookPublishForm" name="bookPublishForm" enctype="multipart/do_upload">
    <div class="modal-body">
        <div class="container">
            <div class="container">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="" placeholder="Enter title" required>
                    <p class="titleErr"></p>
                </div>
                <div class="form-group">
                    <label for="publishby">Publish By</label>
                    <input type="text" class="form-control" id="publishby" name="publishby" placeholder="Enter publisher name" required>
                    <p class="publishbyErr"></p>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" accept="image/jpeg,application/pdf,image/gif,application/msword" id="image" name="image" required>
                    <p class="imageErr"></p>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Description</label>
                    <div class="word-counter" style="float:right">0/1000</div>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                    <p class="descriptionErr"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" id="insertBtn" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>