<form class="form-horizontal col-lg-8 col-sm-8 col-xs-8" role="form" method="POST" name="addPost">
    <fieldset>
        <legend>Create new Post</legend>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['title'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['title']; ?></strong>
                </div>
            <?php endif;?>
            <label for="title" class="col-lg-2 control-label">Title:</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="title" name="title"
                       placeholder="Enter title"
                       value="<?php isset($_POST['title']) ? htmlspecialchars($_POST['title'] ): ''  ?>">
            </div>
        </div>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['text'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['text']; ?></strong>
                </div>
            <?php endif;?>
            <label for="text" class="col-lg-2 control-label">Text:</label>
            <div class="col-lg-10">
                <textarea style="resize:none" class="col-lg-12 col-xs-12" rows="5" name="text" id="text"  placeholder="Post text"   value="<?= isset($_POST['text']) ? htmlspecialchars($_POST['text']) :  ''  ?>" ></textarea>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="tag1" class="col-lg-2 control-label">Tags:</label>
            <div class="col-xs-3 col-lg-2">
                <input type="text" class="form-control" name="tag1" id="tag1"
                       placeholder="Tag"
                       value="<?= isset($_POST['tag1']) ? htmlspecialchars($_POST['tag1'] ): ''  ?>">
            </div>
            <div class="col-xs-3 col-lg-2">
                <input type="text" class="form-control" name="tag2"
                       placeholder="Tag"
                       value="<?= isset($_POST['tag2']) ? htmlspecialchars($_POST['tag2'] ): ''  ?>">
            </div>
            <div class="col-xs-3 col-lg-2">
                <input type="text" class="form-control" name="tag3"
                       placeholder="Tag"
                       value="<?= isset($_POST['tag3']) ? htmlspecialchars($_POST['tag3'] ): ''  ?>">
            </div>
            <div class="col-xs-3 col-lg-2">
                <input type="text" class="form-control" name="tag4"
                       placeholder="Tag"
                       value="<?= isset($_POST['tag4']) ? htmlspecialchars($_POST['tag4'] ): ''  ?>">
            </div>
            <div class="col-xs-3 col-lg-2">
                <input type="text" class="form-control" name="tag5"
                       placeholder="Tag"
                       value="<?= isset($_POST['tag5']) ? htmlspecialchars($_POST['tag5'] ): ''  ?>">
            </div>
        </div>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['tag1'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['tag1']; ?></strong>
                </div>
            <?php endif;?>
            <?php if(isset($this->fieldsErrors['tag2'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['tag2']; ?></strong>
                </div>
            <?php endif;?>
            <?php if(isset($this->fieldsErrors['tag3'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['tag3']; ?></strong>
                </div>
            <?php endif;?>
            <?php if(isset($this->fieldsErrors['tag4'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['tag4']; ?></strong>
                </div>
            <?php endif;?>
            <?php if(isset($this->fieldsErrors['tag5'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['tag5']; ?></strong>
                </div>
            <?php endif;?>
        </div>
        <div class="col-lg-10 col-lg-offset-2">
            <input type="hidden" name="formToken"value="<?= $_SESSION['formToken'] ?>" />
            <button type="reset" class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-primary add-post">Add post</button>
        </div>
        <fieldset>
</form>
