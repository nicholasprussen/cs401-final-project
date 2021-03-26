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

    <div class="d-flex container p-0" id="wrapper">

        <?php
        include "components/sidenavbar.php";
        ?>

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <?php
            include "components/sidenavbartoggler.php";
            ?>

            <div class="container-fluid home-content-wrapper">
                <?php
                echo $_SESSION['userIdentification'];
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
            changeStyle("#sidebar-home");
        });
    </script>

    <?php
    include "components/footer.php";
    ?>

</body>

</html>