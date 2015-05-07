<script type="text/javascript" src="/content/comment-form.js"></script>
<div class="panel panel-default col-lg-10 col-sm-10 col-xs-10">
    <div class="panel-heading">
        <div class="row">
            <div class="panel-title col-lg-12"><?= htmlspecialchars($this->post['title'])?></div>
            <div class="col-lg-10 text-right">
                 <span>
                        Posted on:  <?= htmlspecialchars($this->makeDateInFormat($this->post['date']))?>
                 </span>
            </div>
            <div class="col-lg-2">
                    <span class="badge">
                     Visits: <?= htmlspecialchars($this->post['visits'])?>
                    </span>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?= htmlspecialchars($this->post['text']) ?>
        <br/>
        <div class="row">
            <div class="col-lg-12 text-right">
                <input name="comment" class="btn btn-primary" type="button" value="Leave a Reply" onclick="showCommentForm()" id="showBtn"/>
                <span >Post#: <?= htmlspecialchars($this->post['id'])?></span>
            </div>
        </div>
    </div>
    <?php foreach ($this->comments as $comment): ?>
        <div class="well well-lg">
            <div class="text-left col-lg-10">
                <span>Author: <?= htmlspecialchars($comment['author'] ) ?>: </span>

                Text: <?= htmlspecialchars($comment['text']) ?>
            </div>
            <div class="text-right col-lg-2">
                <?= htmlspecialchars($this->makeDateInFormat($comment['date'])) ?>
            </div>
        </div>
    <?php endforeach;?>
        <form class="form-horizontal col-lg-offset-3 col-lg-6 col-sm-6 col-xs-6"
              id="<?= count($this->fieldsErrors) > 0 ? '' : 'comment-form';?>"  method="POST">
            <fieldset>
                <legend>Add comment</legend>
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
                <div class="form-group col-md-12">
                    <?php if(isset($this->fieldsErrors['text'])) :?>
                        <div class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong><?php echo $this->fieldsErrors['text']; ?></strong>
                        </div>
                    <?php endif;?>
                    <label for="text" class="col-lg-2 control-label">Text</label>
                    <div class="col-lg-10">
            <textarea class="form-control" rows="5" name="text" id="text" placeholder="Enter your comment here..."
                ><?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : '' ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <input type="reset" class="btn btn-default" value="Cancel" onclick="hideForm()"/>
                        <input type="hidden" value="1" name="submitted"/>
                        <input type="submit" class="btn btn-primary" value="Add comment"/>
                    </div>
                </div>
            </fieldset>
        </form>
</div>

