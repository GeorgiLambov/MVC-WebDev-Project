<div class="panel panel-default col-lg-10 col-sm-10 col-xs-10">
    <div class="well well-lg col-lg-12">
              <div class="panel-title col-lg-8">
                <p><?= htmlspecialchars($this->post['title'])?></p>
            </div>
            <div class="col-lg-4 text-left">
               <p>Posted on:  &nbsp; <span><?= htmlspecialchars($this->makeDateInFormat( $this->post['date']))?>&nbsp;</span>
                <span class="badge">Visits:&nbsp; <?= htmlspecialchars($this->post['visits'])?></span>
               </p>
            </div>
       </div>
    <div class="panel-body">
       <p> <?= htmlspecialchars($this->post['text']) ?></p>
            <div class="col-lg-11 text-right">
                <p>Post#: <?= htmlspecialchars($this->post['id'])?></p>
            </div>
    </div>
    <?php foreach ($this->comments as $comment): ?>
        <div class="well well-lg col-lg-12">
            <div class="text-left col-lg-10">
                <p>Author: <?= htmlspecialchars($comment['author'] ) ?>: </p>
                <p>Text: <?= htmlspecialchars($comment['text']) ?></p>
            </div>
            <div class="text-left col-lg-2">
                <?= htmlspecialchars($this->makeDateInFormat($comment['date'])) ?>
            </div>
        </div>
    <?php endforeach;?>
    <form class="form-horizontal col-lg-offset-4 col-lg-6 col-sm-10 col-xs-10"
          id="<?= count($this->fieldsErrors) > 0 ? '' : 'comment-form';?>"  method="POST">
        <fieldset>
            <legend>Leave a Reply</legend>
            <div class="form-group col-md-12">
                <?php if(isset($this->fieldsErrors['text'])) :?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong><?php echo $this->fieldsErrors['text']; ?></strong>
                    </div>
                <?php endif;?>
                <label for="text" class="col-lg-2 control-label">Text</label>
                <div class="col-lg-10">
            <textarea  style="resize:none" class="form-control" rows="3" name="text" id="text" placeholder="Enter your comment here..."
                ><?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : '' ?></textarea>
                </div>
            </div>
            <div class="form-group col-md-12">
                <?php if(isset($this->fieldsErrors['author'])) :?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong><?php echo $this->fieldsErrors['author']; ?></strong>
                    </div>
                <?php endif;?>
                <label for="author" class="col-lg-2 control-label">Name</label>
                <div class="col-lg-10">
                    <input type="text" name="author" class="form-control" id="name"
                           placeholder="Name (required)" value="<?php echo isset($_POST['author']) ? htmlspecialchars($_POST['author']) : '' ?>">
                </div>
            </div>
            <div class="form-group col-md-12">
                <?php if(isset($this->fieldsErrors['email'])) :?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong><?php echo $this->fieldsErrors['email']; ?></strong>
                    </div>
                <?php endif;?>
                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                    <input type="text" name="email" class="form-control" id="inputEmail" placeholder="Email (optionally)"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <input type="hidden" name="formToken"value="<?= $_SESSION['formToken'] ?>" />
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>

