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
    <script src="js/sidebar-style.js"></script>
    <title>Calendar</title>
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

            <div class="container-fluid p-0 calendar-wrapper">
                <h1 class="p-1">Current Status:</h1>
                <p class="p-1">This page uses some php to display the next 30 days, but the ability to add events is not yet supported.</p>
                <?php

                    //print div for each of the next 30 calendar days
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
    <?php
    include "components/menu_toggle.php";
    ?>

    <script>
        $(function() {
            changeStyle("#sidebar-calendar");
        });
    </script>

    <?php
    include "components/footer.php";
    ?>

</body>

</html>