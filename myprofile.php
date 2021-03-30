<html>

<?php
  include 'components/checkauthenticated.php';
?>

<head>
    <?php
    include "components/head.php";
    ?>
    <link rel="stylesheet" href="css/myprofile.css">
    <link rel="stylesheet" href="css/sidebarnav.css">
    <script src="js/sidebar-style.js"></script>
    <title>My Profile</title>
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

            <div class="container-fluid myprofile-wrapper">
                <h1 class="p-1">Current Status:</h1>
                <p class="p-1">This page will be used for displaying a users data that was provided and give the ability to alter data. This functionality has not been added yet, but will be implemented soon. For now here's all your personal info :)</p>
                <?php
                    require_once 'Dao.php';
                    $dao = new Dao();

                    $userInfo = $dao->getUserInfo($_SESSION['userIdentification']);

                    echo '<pre>' . print_r($userInfo, 1) . "</pre>";
                ?>
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
            changeStyle("#sidebar-myprofile");
        });
    </script>

    <?php
    include "components/footer.php";
    ?>

</body>

</html>