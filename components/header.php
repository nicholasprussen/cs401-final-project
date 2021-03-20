<html>

<header>
    <nav class="navbar navbar-dark black-background">
        <div class="container">
            <div>
                <a class="navbar-brand d-flex justify-content-around align-items-center" href="index.php">
                    <img src="img/favicon.png" alt="" width="40" height="40" class="">
                    <p class="m-0 extra-padding-left">myGiftLists</p>
                </a>
            </div>

            <div>
                <?php
                if (isset($_SESSION['authenticated'])) {
                    echo '<a id="sign-in-button" class="navbar-brand d-flex justify-content-around align-items-center" href="signout.php">
                                <button type="button" class="btn text-white secondary-color-background">Sign-Out</button>
                            </a>';
                } else {
                    echo    '<a id="sign-in-button" class="navbar-brand d-flex justify-content-around align-items-center" href="signin.php">
                                    <button type="button" class="btn text-white secondary-color-background">Sign-In</button>
                                </a>';
                }

                // if ($isSignedIn) {
                //     echo    '<a class="navbar-brand d-flex justify-content-around align-items-center" href="#">
                //                     <p class="m-0 extra-padding-right">Nicholas Prussen</p>
                //                     <img src="img/circle-transparent.png" alt="" width="40" height="40">
                //                 </a>';
                // } else {
                //     echo    '<a id="sign-in-button" class="navbar-brand d-flex justify-content-around align-items-center" href="signin.php">
                //                     <button type="button" class="btn text-white secondary-color-background">Sign-In</button>
                //                 </a>';
                // }
                ?>


            </div>
        </div>
    </nav>
</header>

</html>