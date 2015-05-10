<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog System</title>
    <link rel="stylesheet" href="/content/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/content/bootstrap-theme.css">
    <link rel="stylesheet" href="/content/paging/public/css/zebra_pagination.css" type="text/css">
    <script type="text/javascript" src="/content/paging/public/javascript/zebra_pagination.js"></script>
    <script type="text/javascript" src="/content/jquery-2.1.3.js"></script>
</head>
<body>
<div class="container" >
    <div class="page-header col-lg-12 col-sm-12 col-xs-12">
        <h3>Welcome to this Custom MVC Blog application</h3>
    </div>
    <nav class="navbar navbar-default col-lg-12 col-sm-12 col-xs-12">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/Home">Home</a>
            </div>
            <ul class="nav navbar-nav navbar-left">
                <?php if($this->auth->isLogged()): ?>
                    <li><a href="/posts/create">Create Post</a></li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form col-lg-12 col-sm-8 col-xs-8" role="search" action="/posts" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search" name="tagName">
                    </div>
                    <input type="hidden" name="formToken"value="<?= $_SESSION['formToken'] ?>" />
                    <button type="submit" class="btn btn-default">Search</button>
                </form>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(!$this->auth->isLogged()): ?>
                    <li><a href="/register">Register</a></li>
                    <li><a href="/login">LogIn</a></li>
                <?php endif; ?>
                <?php if($this->auth->isLogged()) :?>
                   <li><a href="#"> Hi, <?= htmlspecialchars($_SESSION['username']) ?></a></li>
                   <li><a href="/logout">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
        <?php if(isset($_SESSION['messages'])): ?>
            <?php if($_SESSION['messages']['type'] == 'error'): ?>
                <div class="alert alert-dismissible alert-danger col-lg-12 col-sm-12 col-xs-12">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $_SESSION['messages']['text']; ?></strong>
                </div>
            <?php endif; ?>
            <?php if($_SESSION['messages']['type'] == 'info'): ?>
                <div class="alert alert-dismissible alert-success col-lg-12 col-sm-12 col-xs-12">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo $_SESSION['messages']['text']; ?></strong>
                </div>
            <?php endif; ?>
            <?php unset($_SESSION['messages']) ?>
        <?php endif; ?>
        <div class="btn-group-vertical col-md-2 col-sm-12 col-xs-12">
            <a href="/posts" class="btn btn-default">All Posts</a>
            <a href="/posts/byDays/1" class="btn btn-default">Last day</a>
            <a href="/posts/byDays/7" class="btn btn-default">Last week</a>
            <a href="/posts/byDays/30" class="btn btn-default">Last month</a>
            <a href="/posts/byDays/365" class="btn btn-default">Last year</a>
            <br>
        </div>
