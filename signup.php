<html>

<?php
session_start();

if (isset($_SESSION['authenticated'])) {
    header('Location: home.php');
    exit;
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
            <div class="login-form-2 container">
                <h3>Sign-Up</h3>
                <h6>Inputs marked with * are required</h6>
                <form method="POST" action="handlers/signup_handler.php" class="text-white">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="firstname" class="form-label">First Name *</label>
                                <input id="firstname" name="firstname" type="text" class="form-control" placeholder="Jack" aria-label="First name">
                            </div>
                            <div class="col">
                                <label for="lastname" class="form-label">Last Name *</label>
                                <input id="lastname" name="lastname" type="text" class="form-control" placeholder="Sparrow" aria-label="Last name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="captainoftheblackpearl@aol.com" value="" />
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="password" class="form-label">Password *</label>
                                <input id="password" name="password" type="password" class="form-control" placeholder="" aria-label="Password">
                            </div>
                            <div class="col">
                                <label for="passwordConfirm" class="form-label">Confirm Password *</label>
                                <input id="passwordConfirm" name="passwordConfirm" type="password" class="form-control" placeholder="" aria-label="Confirm Password">
                            </div>
                        </div>
                    </div>
                    <!--
                        <div class="form-group row g-3 text-left">
                            <div class="col-12">
                                <label for="address1" class="form-label">Address 1</label>
                                <input type="text" class="form-control" id="address1" name="address1" placeholder="420 Tortuga Ln">
                            </div>
                            <div class="col-12">
                                <label for="address2" class="form-label">Address 2</label>
                                <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment, studio, or floor">
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city">
                            </div>
                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <select id="state" name="state" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="zip" class="form-label">Zip</label>
                                <input type="text" class="form-control" id="zip" name="zip">
                            </div>
                        </div>
                        !-->
                    <div class="form-group text-center extra-top-padding">
                        <input type="submit" class="btnSubmit" value="Sign-Up" />
                    </div>
                </form>
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