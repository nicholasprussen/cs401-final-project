<html>

<?php
  include 'components/checkauthenticated.php';
?>

<head>
    <?php
    include "components/head.php";
    ?>
    <link rel="stylesheet" href="css/calendar.css">
    <link rel="stylesheet" href="css/sidebarnav.css">
    <title>Calendar</title>
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

            <div class="container-fluid p-0 calendar-wrapper">
                <?php

                    for($x = 0; $x < 30;$x++){
                        echo "<div class='calendar-day'><h3>" . date('l, F jS', strtotime('+' . $x . ' days')) . "</h3><div class='calendar-day-content'><p>No Events To Show</p></div></div>";
                    }

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

        currentPage = "sidebar-calendar";

        document.getElementById(currentPage).classList.remove("secondary-color-background");

        document.getElementById(currentPage).style.backgroundColor = "#3AAFA9";
    </script>

    <?php
    include "components/footer.php";
    ?>

</body>

</html>