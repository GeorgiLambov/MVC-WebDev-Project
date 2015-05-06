<form class="form-horizontal col-lg-6 col-sm-6 col-xs-6" role="form" method="POST" name="register">
    <fieldset>
        <legend>Register</legend>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['username'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['username']; ?></strong>
                </div>
            <?php endif;?>
            <label for="username" class="col-lg-2 control-label">Username:</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username"
                       value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>">
            </div>
        </div>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['firstName'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['firstName']; ?></strong>
                </div>
            <?php endif;?>
            <label for="first-name" class="col-lg-2 control-label">First name:</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="first-name" name="firstName" placeholder="Enter your name"
                       value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : '' ?>">
            </div>
        </div>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['lastName'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['lastName']; ?></strong>
                </div>
            <?php endif;?>
            <label for="last-name" class="col-lg-2 control-label">Last name:</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="last-name" name="lastName" placeholder="Enter your last name"
                       value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : '' ?>">
            </div>
        </div>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['email'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['email']; ?></strong>
                </div>
            <?php endif;?>
            <label for="email" class="col-lg-2 control-label">Email:</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email"
                       value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
            </div>
        </div>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['password'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['password']; ?></strong>
                </div>
            <?php endif;?>
            <label for="password" class="col-lg-2 control-label">Password:</label>
            <div class="col-lg-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>
        </div>
        <div class="form-group col-md-12">
            <?php if(isset($this->fieldsErrors['confirmPassword'])) :?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $this->fieldsErrors['confirmPassword']; ?></strong>
                </div>
            <?php endif;?>
            <label for="confirm-password" class="col-lg-2 control-label">Confirm password:</label>
            <div class="col-lg-10">
                <input type="password" class="form-control" id="confirm-password" name="confirmPassword" placeholder="Enter password">
            </div>
        </div>
        <div class="col-lg-10 col-lg-offset-2">
            <input type="hidden" name="submitted" value="1"/>
            <button type="reset" class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
    </fieldset>
</form>


