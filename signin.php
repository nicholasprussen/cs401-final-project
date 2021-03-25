<html>

<?php
session_start();

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

if (isset($_SESSION['authenticated'])) {
    if($_SESSION['authenticated']) {
      header('Location: home.php');
        exit;  
    } 
}
?>


<head>
    <?php
    include "components/head.php";
    ?>
    <link rel="stylesheet" href="css/signin.css">
    <title>Sign-In</title>
</head>


<body class="d-flex flex-column h-100 quad-color-background">

    <?php
    include "components/header.php";
    ?>

    <div class="form-wrapper">
        <div class="container form-container d-flex justify-content-center">
            <div class="container login-form-2 text-center">
                <h3>Login</h3>
                <form method="POST" action="handlers/signin_handler.php">
                    <div class="form-group">
                        <input type="text" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['email'] ?>" name="email" id="accEmail" class="form-control" placeholder="Your Email *" value="" />
                    </div>
                    <?php
                    if (isset($errors)) {
                        if (isset($errors['email'])) {
                            echo '<label for="accEmail" class="form-label text-warning"> ' . $errors['email'] . '</label>';
                        }
                    }
                    ?>
                    <div class="form-group">
                        <input type="password" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['password'] ?>" class="form-control" name="password" id="accPassword" placeholder="Your Password *" value="" />
                    </div>
                    <?php
                    if (isset($errors)) {
                        if (isset($errors['password'])) {
                            echo '<label for="accPassword" class="form-label text-warning"> ' . $errors['password'] . '</label>';
                        }
                    }
                    if (isset($errors)) {
                        if (isset($errors['loginFailed'])) {
                            echo '<label for="" class="form-label text-warning"> ' . $errors['loginFailed'] . '</label>';
                        }
                    }
                    ?>
                    <div class="form-group text-center">
                        <input type="submit" class="btnSubmit" value="Login" />
                    </div>
                    <!--<div class="form-group text-center">
                        <a href="#" class="ForgetPwd" value="Login">Forget Password?</a>
                    </div>-->
                </form>
                <div class="form-group">
                    <h3 class="new-here-text">New Here?</h3>
                </div>
                <div class="form-group text-center">
                    <a href="signup.php">
                        <input type="button" class="btnSubmit" value="Create Your Account Now" />
                    </a>
                </div>
            </div>
        </div>
    </div>


    <?php
    include "components/footer.php";
    ?>

    <script>
        document.getElementById("sign-in-button").remove();
    </script>

    <?php
    if (isset($_SESSION['form'])) {
        unset($_SESSION['form']);
    }
    ?>

</body>

</html>