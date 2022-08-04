<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Invoice Gen</title>
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

    <meta name="theme-color" content="#7952b3">

</head>

<body>

    <header>

        <nav class="navbar navbar-expand-md navbar-dark bg-primary ">
            <div class="container">
                <a class="navbar-brand" href="index.php">Invoice Gen.</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <?php if (isset($_SESSION['email'])) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="invoice.php">Create</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="signup.php">Signup</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Login</a>
                            </li>
                        <?php endif; ?>

                    </ul>
                    <?php if (isset($_SESSION['email'])) : ?>

                        <div class="user">
                            <div class="dropdown">
                                <button class="btn btn-sm bg-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $_SESSION['email']; ?>
                                </button>
                                <ul class="dropdown-menu bg-dark" aria-labelledby="dropdownMenuButton1">
                                    <a class="dropdown-item" href="logout.php?action=logout">Logout</a>
                                </ul>
                            </div>
                        </div>

                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>