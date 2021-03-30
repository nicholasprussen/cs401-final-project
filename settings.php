<html>

<?php
  include 'components/checkauthenticated.php';
?>

<head>
    <?php
    include "components/head.php";
    ?>
    <link rel="stylesheet" href="css/settings.css">
    <link rel="stylesheet" href="css/sidebarnav.css">
    <script src="js/sidebar-style.js"></script>
    <title>Settings</title>
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

            <div class="container-fluid settings-wrapper">
                <h1 class="p-1">Current Status:</h1>
                <p class="p-1">This page will be used to allow users to save settings about their pages, but currently there aren't any settings for them to change so nothing has been built.</p>
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
            changeStyle("#sidebar-settings");
        });
    </script>

    <?php
    include "components/footer.php";
    ?>

</body>

</html>