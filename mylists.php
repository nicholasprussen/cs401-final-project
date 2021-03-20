<html>

<?php
include 'components/checkauthenticated.php';

$session_listname = (isset($_SESSION['currentListName'])) ? $_SESSION['currentListName'] : '';
?>

<head>
    <?php
    include "components/head.php";
    ?>
    <link rel="stylesheet" href="css/mylists.css">
    <link rel="stylesheet" href="css/sidebarnav.css">
    <title>My Lists</title>
</head>


<body class="d-flex flex-column h-100 quad-color-background">

    <!-- Create List Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="createlist_handler.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New List</h5>
                        <button type="button" class="btn-close Close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="newlistname">List Name</label>
                            <input type="text" id="newlistname" name="newlistname" placeholder="List #12324321323...">
                        </div>
                        <div class="form-group form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="public" name="public">
                            <label class="form-check-label" for="public">Publicly Viewable?</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Create Item Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="createlistitem_handler.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create List Item</h5>
                        <button type="button" class="btn-close Close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="itemname">Item Name</label>
                            <input type="text" id="itemname" name="itemname" placeholder="1337X Gaming Chair">
                        </div>
                        <div class="form-group">
                            <label for="itemlink">Item Link (Optional)</label>
                            <input type="text" id="itemlink" name="itemlink" placeholder="https://www.google.com">
                        </div>
                        <div class="form-group">
                            <label for="itemprice">Price</label>
                            <input type="number" min="1" step="any" id="itemprice" name="itemprice" placeholder="696969.69">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

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

            <div class="container-fluid page-content-set-height p-0 d-flex">
                <div class="bg-white lists-container border-right border-black">
                    <ul>
                        <li>
                            <!-- Button trigger modal -->
                            <button type="button" class="w-100 h-100 list-button" data-toggle="modal" data-target="#exampleModal">
                                Create New List (+)
                            </button>
                        </li>
                        <?php
                        require_once 'Dao.php';
                        $dao = new Dao();

                        $sqlList = $dao->getUserLists($_SESSION['userIdentification']);

                        $intCounter = 0;
                        foreach ($sqlList as $key => $value) {
                            echo '<li><button class="w-100 h-100 list-button" id="button-' . $intCounter . '" onClick="getInformation(' . $intCounter . ')">' . $value . '</button></li>';
                            $intCounter++;
                        }

                        // for($x = $intCounter + 1; $x < 50; $x++) {
                        //     echo '<li><button class="w-100 h-100 list-button" id="button-' . $x . '" onClick="getInformation('. $x . ')">List #' . $x . '</button></li>';
                        // }
                        ?>



                    </ul>
                </div>
                <div id="current-list-container" class="current-list-container">
                    <ul id="current-list-list">

                    </ul>
                </div>
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

        currentButton = null;

        currentPage = "sidebar-mylists";

        document.getElementById(currentPage).classList.remove("secondary-color-background");

        document.getElementById(currentPage).style.backgroundColor = "#3AAFA9";


        function getInformation(x) {
            if (currentButton) {
                currentButton.style.backgroundColor = "";
                currentButton.style.color = "";
            }
            button = document.getElementById("button-" + x);
            button.style.backgroundColor = "#17252A";
            button.style.color = "white";

            $.ajax({
                type: "POST",
                url: "getListData.php",
                data: {
                    'listname': button.innerHTML
                }
            }).done(function(msg) {
                //console.log(msg);
                document.getElementById("current-list-list").innerHTML = msg;
            });
            currentButton = button;
        }

        var currListName = '<?php echo $session_listname ?>';

        listOfButtons = document.getElementsByTagName("BUTTON");

        for (x = 0; x < listOfButtons.length; x++) {
            if (listOfButtons[x].innerHTML === currListName) {
                listOfButtons[x].click();
            }
        }
    </script>

    <?php
    include "components/footer.php";
    ?>

</body>

</html>