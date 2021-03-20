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
    <title>My Profile</title>
</head>


<body class="d-flex flex-column h-100 quad-color-background">

    <?php
    include "components/header.php";
    ?>

    <div class="d-flex container p-0" id="wrapper">

        <?php
            include "components/sidenavbar.php";
        ?>

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <?php
                include "components/sidenavbartoggler.php";
            ?>

            <div class="container-fluid">
                <?php
                    require_once 'Dao.php';
                    $dao = new Dao();

                    $userInfo = $dao->getUserInfo($_SESSION['userIdentification']);

                    echo print_r($userInfo, 1);
                ?>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        currentPage = "sidebar-myprofile";

        document.getElementById(currentPage).classList.remove("secondary-color-background");

        document.getElementById(currentPage).style.backgroundColor = "#3AAFA9";
    </script>

    <?php
    include "components/footer.php";
    ?>

</body>

</html>