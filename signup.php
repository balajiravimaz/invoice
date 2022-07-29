<?php
require_once "inc/header.php";
require_once "class/Database.php";

?>
<div class="container">

    <?php

    if (isset($_POST['signup'])) {
        $error = array();
        $msg = array();
        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $error[] = "* " . ucfirst($key) . " is required";
            }
        }
        if(empty($error)){
            $db = new Database();
            $name = trim(ucfirst($_POST['name']));
            $email = trim($_POST['email']);
            $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);       

            $db->query("insert into users (name,email,pass) values(:name,:email,:pass)");
            $db->bind(":name", $name);
            $db->bind(":email", $email);
            $db->bind(":pass", $pass);
            $db->execute();

            if($db->lastInsertId()){
                $msg [] =  "New user Created Successfully";
            }
        }
    }

    ?>
    <div class="signin">
        <?php
        if (!empty($error)) {
            foreach ($error as $err) { ?>
                <h6 class="text-danger"><?php echo $err; ?></h6>
        <?php }
        }
        if (!empty($msg)) {
            foreach ($msg as $err) { ?>
                <h6 class="text-success text-center"><?php echo $err; ?></h6>
        <?php }
        } ?>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <h1 class="h3 mb-3 text-center">Please sign up <span class="text-danger"><b>(All Fields mandatory)</b></span></h1>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="name" required="required">
                <label for="name">Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required="required">
                <label for="email">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Password" required="required">
                <label for="pass">Password</label>
            </div>
            <!-- <div class="form-floating mb-3">
                <textarea name="address" id="address" name="address" class="form-control" required="required"></textarea>
                <label for="address">Address</label>
            </div> -->
            <!-- <div class="form-floating mb-3">
                <div class="mb-3">
                    <label for="logo" class="form-label">Logo</label>
                    <input class="form-control" type="file" name="logo" id="logo">
                </div>
            </div>
            <div class="form-floating mb-3">
                <div class="mb-3">
                    <label for="sign" class="form-label">Sign</label>
                    <input class="form-control" type="file" name="sign" id="sign">
                </div>
            </div> -->
            <input type="submit" class="w-100 btn btn-lg btn-primary" name="signup" value="Sign Up">
        </form>
    </div>
</div>
<?php
require_once "inc/footer.php"
?>