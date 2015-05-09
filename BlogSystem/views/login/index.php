<form class="form-horizontal col-lg-offset-1 col-lg-6 col-sm-8 col-xs-8" role="form" method="POST" name="login">
    <fieldset>
        <legend>Login</legend>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['username'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['username']; ?></strong>
                </div>
            <?php endif;?>
            <label for="username" class="col-md-2 control-label">Username:</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="username" name="username"
                       placeholder="Enter username"
                       value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
        </div>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['password'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['password']; ?></strong>
                </div>
            <?php endif;?>
            <label for="password" class="col-md-2 control-label">Password:</label>
            <div class="col-md-10">
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Enter password"
                       value="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">
            </div>
        </div>
        <div class="col-md-10 col-md-offset-2">
            <input type="hidden" name="formToken"value="<?= $_SESSION['formToken'] ?>" />
            <button type="reset" class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </fieldset>
</form>
