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
    <title>Settings</title>
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
                Hello
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

        currentPage = "sidebar-settings";

        document.getElementById(currentPage).classList.remove("secondary-color-background");

        document.getElementById(currentPage).style.backgroundColor = "#3AAFA9";
    </script>

    <?php
    include "components/footer.php";
    ?>

</body>

</html>