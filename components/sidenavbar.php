<html>
<!-- Sidebar -->
<div class="secondary-color-background text-white" id="sidebar-wrapper">
    <div class="sidebar-heading">
        <a class="d-flex justify-content-around align-items-center profile-link" href="#">
            <img src="img/circle-transparent.png" alt="" width="40" height="40">
            <p class="m-0 profile-link">
                <?php
                    require_once 'Dao.php';
                    $dao = new Dao();

                    $userInfo = $dao->getUserInfo($_SESSION['userIdentification']);

                    echo $userInfo['firstname'] . ' ' . $userInfo['lastname'];
                ?>
            </p>
        </a>
    </div>
    <div class="list-group list-group-flush">
        <a id="sidebar-home" href="home.php" class="side-nav-bar list-group-item list-group-item-dark list-group-item-action secondary-color-background text-white">Home</a>
        <a id="sidebar-mylists" href="mylists.php" class="side-nav-bar list-group-item list-group-item-dark list-group-item-action secondary-color-background text-white">My Lists</a>
        <a id="sidebar-friends" href="friends.php" class="side-nav-bar list-group-item list-group-item-dark list-group-item-action secondary-color-background text-white">Friends</a>
        <a id="sidebar-calendar" href="calendar.php" class="side-nav-bar list-group-item list-group-item-dark list-group-item-action secondary-color-background text-white">Calendar</a>
        <a id="sidebar-myprofile" href="myprofile.php" class="side-nav-bar list-group-item list-group-item-dark list-group-item-action secondary-color-background text-white">My Profile</a>
        <a id="sidebar-settings" href="settings.php" class="side-nav-bar list-group-item list-group-item-dark list-group-item-action secondary-color-background text-white">Settings</a>
    </div>
</div>
<!-- /#sidebar-wrapper -->

</html>