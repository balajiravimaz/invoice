<?php
require_once "inc/header.php";
if (isset($_SESSION['email'])) {

    header("Location: dash.php");
} else {
    require_once "class/Database.php";

    if (isset($_POST['login'])) {
        $error = array();
        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $error[] = "*" . ucfirst($key) . " is Required";
            }
        }
        if (empty($error)) {
            $db = new Database;
            $email = trim($_POST['email']);
            $pass = $_POST['password'];

            $db->query("SELECT email from users where email =:email");
            $db->bind(":email", $email);
            $db->resultset();
            $result = $db->rowCount();
            if ($result > 0) {
                $db->query("SELECT pass from users where email =:email");
                $db->bind(":email", $email);
                $upass = $db->resultset();
                if (password_verify($pass, $upass[0]['pass'])) {
                    $_SESSION['email'] = $email;
                    header("Location: dash.php");
                } else {
                    echo "<script>alert('Invalid password');</script>";
                }
            } else {
                $error[] = "Entered Email not Valid";
            }
        }
    }

?>

    <div class="container">
        <main class="form-signin">
            <?php
            if (!empty($error)) {
                foreach ($error as $err) { ?>
                    <h6 class="text-danger"><?php echo $err; ?></h6>
            <?php }
            }
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required="required">
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" name="password" id="pass" placeholder="Password" required="required">
                    <label for="pass">Password</label>
                </div>

                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <input type="submit" class="w-100 btn btn-lg btn-primary" name="login" value="Login">
            </form>
        </main>
    </div>

<?php

    require_once "inc/footer.php";
}
