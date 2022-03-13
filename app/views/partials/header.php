<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Word Game</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="navbar-brand mt-2 mt-lg-0" href="#">
                   Word game
                </a>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->

            <!-- Right elements -->
            <div class="d-flex align-items-center">
                <?php if ($user = authCheck()) : ?>
                    <div>Player <?php echo $user['first_name'] . ' ' . $user['last_name'] . ' points: ' .  $user['points'] ?></div>
                    <ul class="navbar-nav float-right">
                        <li class="nav-item active">
                            <a class="nav-link" href="logout">Logout</a>
                        </li>
                    </ul>
                <?php endif ?>
            </div>
            <!-- Right elements -->
        </div>
        <!-- Container wrapper -->
    </nav>

    <?php if (isset($_SESSION['message'])) : ?>
    <div class="alert alert-danger"><?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        ?></div>
<?php endif ?>