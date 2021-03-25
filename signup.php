<html>

<?php
session_start();

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

if (isset($_SESSION['authenticated'])) {
    if($_SESSION['authenticated']){
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
            <div class="login-form-2 container">
                <h3>Sign-Up</h3>
                <h6>Inputs marked with * are required</h6>
                <form method="POST" action="handlers/signup_handler.php" class="text-white">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="firstname" class="form-label">First Name *</label>
                                <input id="firstname" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['firstname'] ?>" name="firstname" type="text" class="form-control" placeholder="Jack" aria-label="First name">
                                <?php
                                if (isset($errors)) {
                                    if (isset($errors['firstname'])) {
                                        echo '<label for="firstname" class="form-label text-warning"> ' . $errors['firstname'] . '</label>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="col">
                                <label for="lastname" class="form-label">Last Name *</label>
                                <input id="lastname" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['lastname'] ?>" name="lastname" type="text" class="form-control" placeholder="Sparrow" aria-label="Last name">
                                <?php
                                if (isset($errors)) {
                                    if (isset($errors['lastname'])) {
                                        echo '<label for="lastname" class="form-label text-warning"> ' . $errors['lastname'] . '</label>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="text" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['email'] ?>" name="email" id="email" class="form-control" placeholder="captainoftheblackpearl@aol.com" value="" />
                        <?php
                        if (isset($errors)) {
                            if (isset($errors['email'])) {
                                echo '<label for="email" class="form-label text-warning"> ' . $errors['email'] . '</label>';
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="password" class="form-label">Password *</label>
                                <input id="password" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['password'] ?>" name="password" type="password" class="form-control" placeholder="" aria-label="Password">
                                <?php
                                if (isset($errors)) {
                                    if (isset($errors['password'])) {
                                        echo '<label for="password" class="form-label text-warning"> ' . $errors['password'] . '</label>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="col">
                                <label for="passwordConfirm" class="form-label">Confirm Password *</label>
                                <input id="passwordConfirm" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['passwordConfirm'] ?>" name="passwordConfirm" type="password" class="form-control" placeholder="" aria-label="Confirm Password">
                                <?php
                                if (isset($errors)) {
                                    if (isset($errors['passwordConfirm'])) {
                                        echo '<label for="passwordConfirm" class="form-label text-warning"> ' . $errors['passwordConfirm'] . '</label>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row g-3 text-left">

                        <div class="col-12">
                            
                            <label for="address1" class="form-label">Address 1</label>
                            <input type="text" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['address1'] ?>" class="form-control" id="address1" name="address1" placeholder="420 Tortuga Ln">
                            <?php
                            if (isset($errors)) {
                                if (isset($errors['address']['address1'])) {
                                    echo '<label for="address1" class="form-label text-warning"> ' . $errors['address']['address1'] . '</label>';
                                }
                            }
                            ?>
                        </div>
                        <div class="col-12">
                            <label for="address2" class="form-label">Address 2</label>
                            <input type="text" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['address2'] ?>" class="form-control" id="address2" name="address2" placeholder="Apartment, studio, or floor">
                            <?php
                            if (isset($errors)) {
                                if (isset($errors['address']['address2'])) {
                                    echo '<label for="address2" class="form-label text-warning"> ' . $errors['address']['address2'] . '</label>';
                                }
                            }
                            ?>
                        </div>
                        <div class="col-md-2">
                            <label for="zip" class="form-label">Zipcode</label>
                            <input type="text" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['zip'] ?>" class="form-control" id="zip" name="zip">
                            <?php
                            if (isset($errors)) {
                                if (isset($errors['address']['zipcode'])) {
                                    echo '<label for="zipcode" class="form-label text-warning"> ' . $errors['address']['zipcode'] . '</label>';
                                }
                            }
                            ?>
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['city'] ?>" class="form-control" id="city" name="city">
                            <?php
                            if (isset($errors)) {
                                if (isset($errors['address']['city'])) {
                                    echo '<label for="city" class="form-label text-warning"> ' . $errors['address']['city'] . '</label>';
                                }
                            }
                            ?>
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <input type="text" value="<?php if (isset($_SESSION['form'])) echo $_SESSION['form']['state'] ?>" id="state" name="state" class="form-control">
                            <?php
                            if (isset($errors)) {
                                if (isset($errors['address']['state'])) {
                                    echo '<label for="state" class="form-label text-warning"> ' . $errors['address']['state'] . '</label>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <h6>No partial addresses will be accepted.</h6>
                    <h6>Addresses are validated through USPS.</h6>
                    <div class="text-center">
                        <?php
                        if (isset($errors)) {
                            if (isset($errors['address']['general'])) {
                                echo '<label for="" class="form-label text-warning"> ' . $errors['address']['general'] . '</label>';
                            }
                            if (isset($errors['emailTaken'])) {
                                echo '<label for="" class="form-label text-warning"> ' . $errors['emailTaken'] . '</label>';
                            }
                        }
                        ?>
                    </div>
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

        let zip = document.getElementById('zip');

        zip.addEventListener('keyup', function(e) {
            if (zip.value.length !== 0) {
                var request = new XMLHttpRequest();

                request.open('GET', 'http://ZiptasticAPI.com/' + zip.value);

                request.onload = function() {
                    var jsonObj = JSON.parse(this.response);

                    let city = "";
                    let state = "";

                    if (!('error' in jsonObj)) {
                        city = jsonObj['city'];
                        state = jsonObj['state'];

                        document.getElementById('city').value = city;
                        document.getElementById('state').value = state;
                    }
                }

                request.send();
            }
        });
    </script>

    <?php
    if (isset($_SESSION['form'])) {
        unset($_SESSION['form']);
    }
    ?>

</body>

</html>