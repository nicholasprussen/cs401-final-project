<html>

<?php
//start session
session_start();
?>

<head>
    <?php
    include "components/head.php";
    ?>
    <link rel="stylesheet" href="css/index.css">
    <title>myGiftLists</title>
</head>


<body class="d-flex flex-column h-100 quad-color-background">

    <?php
    include "components/header.php";
    ?>

    <div class="index-main-content">
        <div class="index-main-content-1">
            <div class="container text-white">
                <div class="content-1-heading w-100">
                    <h1 class="content-1-h1">myGiftLists</h1>
                </div>
                <div class="content-1-list w-100">
                    <ul>
                        <li>Birthdays</li>
                        <li>Holidays</li>
                        <li>Weddings</li>
                    </ul>
                </div>
                <div class="content-1-button w-100">
                    <?php
                        //change button based on login status
                        $changeButton = False;
                        if (isset($_SESSION['authenticated'])) {
                            if($_SESSION['authenticated']){
                                $changeButton = True;
                            }
                        }
                        if($changeButton){
                            echo '<a href="home.php"><button type="button" class="btn text-white secondary-color-background btn-lg">Go Home</button></a>';
                        } else {
                            echo '<a href="signin.php"><button type="button" class="btn text-white secondary-color-background btn-lg">Create Your First List</button></a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    include "components/footer.php";
    ?>

</body>

</html>