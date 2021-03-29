<html>

<?php
include 'components/checkauthenticated.php';
?>

<head>
    <?php
    include "components/head.php";
    ?>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/sidebarnav.css">
    <script src="js/sidebar-style.js"></script>
    <title>Home</title>
</head>

<body class="d-flex flex-column h-100 quad-color-background">

    <?php
    include "components/header.php";
    ?>

    <div class="d-flex container-lg p-0" id="wrapper">

        <?php
        include "components/sidenavbar.php";
        ?>

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <?php
            include "components/sidenavbartoggler.php";
            ?>

            <div class="p-0 m-0 container-fluid home-content-wrapper">
                <div class="home-container d-flex flex-column">
                    <div class="home-heading">
                        <h1 class="text-center">Welcome Home,
                            <?php
                            require_once 'Dao.php';
                            $dao = new Dao();

                            $userInfo = $dao->getUserInfo($_SESSION['userIdentification']);

                            echo $userInfo['firstname'];

                            $firstFiveLists = $dao->getFiveUserLists($_SESSION['userIdentification']);
                            ?>
                        </h1>
                    </div>
                    <div class="row tall-row">
                        <div class="col-xl home-col d-flex justify-content-center align-items-center">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Recent Lists</h5>
                                </div>
                                <?php
                                if (empty($firstFiveLists)) {
                                    echo '<div class="card-body"><h6 class="card-text">No Recent lists. <a href="mylists.php">Create One Now</a></h6></div>';
                                } else {
                                    echo '<ul class="list-group list-group-flush">';
                                    foreach ($firstFiveLists as $key => $value) {
                                        echo '<li class="list-group-item"><a href="mylists.php?list=' . $value . '">' . $value . '</a></li>';
                                    }
                                    echo  '</ul>';
                                }
                                ?>
                                <div class="card-body d-flex">
                                    <a href="mylists.php" class="btn btn-primary mt-auto">Go to My Lists</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl home-col d-flex justify-content-center align-items-center">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Friend Requests</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Friends are not allowed at this time</p>
                                </div>
                                <?php

                                ?>
                                <div class="card-body d-flex">
                                    <a href="friends.php" class="btn btn-primary mt-auto disabled">Go to My Friends</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row tall-row flex-grow-1">
                        <div class="col-xl home-col d-flex justify-content-center align-items-center">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Upcoming Events</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Events are not supported at this time</p>
                                </div>
                                <?php

                                ?>
                                <div class="card-body d-flex">
                                    <a href="calendar.php" class="btn btn-primary mt-auto">Go to Calendar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl home-col d-flex justify-content-center align-items-center">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">My Profile</h5>
                                </div>
                                <div class="card-body">
                                    <h5 class="bold">Name:</h5>
                                    <?php echo '<p class="card-text">' . $userInfo['firstname'] . ' ' . $userInfo['lastname'] . '</p>' ?>
                                    <h5 class="bold">Email:</h5>
                                    <?php echo '<p class="card-text">' . $userInfo['email'] . '</p>' ?>
                                    <h5 class="bold">Address:</h5>
                                    <?php if(isset($userInfo['address'])){ echo '<p class="card-text">' . $userInfo['address'] . '</p>'; } else {echo '<p class="card-text">N/A</p>';} ?>
                                </div>
                                <?php

                                ?>
                                <div class="card-body d-flex">
                                    <a href="myprofile.php" class="btn btn-primary mt-auto">Go to My Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <?php
    include "components/menu_toggle.php";
    ?>

    <script>
        $(function() {
            changeStyle("#sidebar-home");
        });
    </script>

    <?php
    include "components/footer.php";
    ?>

</body>

</html>