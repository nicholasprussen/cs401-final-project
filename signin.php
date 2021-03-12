<html>

<?php
if (!isset($_SESSION)) {
    session_start();
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

    <div class="h-100">
        <div class="container-xl p-0 signin-full-container flex-shrink-0">
            <div class="container login-container">
                <div class="login-form-2 text-center">
                    <h3>Login</h3>
                    <form method="POST" action="accCreate.php" onSubmit="return ValidityChecker()">
                        <div class="form-group">
                            <input type="text" name="email" id="accEmail" class="form-control" placeholder="Your Email *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="accPassword" placeholder="Your Password *" value="" />
                        </div>
                        <div class="form-group ">
                            <input type="submit" class="btnSubmit" value="Login" />
                        </div>
                        <div class="form-group">
                            <a href="#" class="ForgetPwd" value="Login">Forget Password?</a>
                        </div>
                    </form>
                    <div class="form-group ">
                        <h3 class="new-here-text">New Here?</h3>
                    </div>
                    <div class="form-group ">
                        <input type="button" class="btnSubmit" value="Create Your Account Now" />
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

</body>

</html>