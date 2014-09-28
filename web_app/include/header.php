<?php

require_once 'include/user_clearance.inc.php';

$db = new dbHelper();
$db->ud_connectToDB();

//Clearance::updateUserClearance();

$result = $db->ud_whereQuery('ud_high_frequency');
$high = $db->ud_mysql_fetch_assoc_all($result);

if (!ud_user_loggedin()) {
    ?>
    <div class="header">
        <div class="row">
            <div class="large-12 columns">
                <nav class="top-bar">
                    <ul>
                        <li class="name">
                            <a href="http://www.utopiadevelopers.com" target="_blank"><img
                                    src="resources/img/common/utopia.png"></a>
                        </li>
                        <li class="toggle-topbar"><a href="#"></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
<?php
} else {
    $src = $_SESSION['profile'];
    ?>

    <div class="header">
        <div class="row">
            <div class="large-12 columns">
                <nav class="top-bar">
                    <ul class="title-area">
                        <!-- Title Area -->
                        <li class="name logo">
                            <a href="http://www.utopiadevelopers.com" target="_blank">
                                <img src="resources/img/common/utopia.png">
                            </a>
                        </li>
                        <li class="toggle-topbar menu-icon">
                            <a href="#"><span>Menu</span></a>
                        </li>
                    </ul>
                    <section class="top-bar-section">
                        <!-- Left Nav Section -->
                        <ul class="left">
                            <li class="divider"></li>
                            <?php
                            if (Clearance::checkClearance(Clearance::$MODULE_HIGH_FREQUENCY_HEADER)) {
                                ?>
                                <li class="has-dropdown"><a href="#">WORDLIST</a>
                                    <ul class="dropdown">
                                        <li class="divider"></li>
                                        <li><a href="dashboard.php">ALL WORDS</a></li>
                                        <?php
                                        foreach ($high as $datah) {
                                            echo '<li class="divider"></li>';
                                            echo '<li><a href="dashboard.php?high=' . $datah['id'] . '">' . strtoupper($datah['name']) . '</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </li>
                            <?php
                            } else {
                                ?>
                                <li><a href="dashboard.php">WORDLIST</a></li>
                            <?php
                            }
                            ?>
                            <li class="divider"></li>
                            <?php
                            if (Clearance::checkClearance(Clearance::$MODULE_HIGH_FREQUENCY_HEADER)) {
                                ?>
                                <li class="has-dropdown"><a href="#">FAV</a>
                                    <ul class="dropdown">
                                        <li class="divider"></li>
                                        <li><a href="fav.php">ALL FAVS</a></li>
                                        <?php
                                        foreach ($high as $datah) {
                                            echo '<li class="divider"></li>';
                                            echo '<li><a href="fav.php?high=' . $datah['id'] . '">' . strtoupper($datah['name']) . '</a></li>';
                                        }
                                        ?>
                                    </ul>
                                </li>
                            <?php
                            } else {
                                ?>
                                <li><a href="fav.php">FAVOURITES</a></li>
                            <?php
                            }
                            ?>
                            <li class="divider"></li>
                            <li><a href="ignore.php">IGNORE</a></li>
                            <li class="divider"></li>
                            <li><a href="recent.php">RECENT</a></li>
                            <li class="divider"></li>
                            <?php
                            if (Clearance::checkClearance(Clearance::$MODULE_HIGH_FREQUENCY_ADD)) {
                                ?>
                                <li class="has-dropdown"><a href="#">ADMINPANEL</a>
                                    <ul class="dropdown">
                                        <li class="divider"></li>
                                        <?php
                                        if (Clearance::checkClearance(Clearance::$MODULE_ADMIN_PANEL)) {
                                            ?>
                                            <li><a href="createuser.php">CREATE USER</a></li>
                                            <li class="divider"></li>
                                            <li><a href="adminpanel.php">DASHBOARD</a></li>
                                            <li class="divider"></li>
                                            <li><a href="user_history.php">MY LOGIN HISTORY</a></li>
                                            <li class="divider"></li>
                                            <li><a href="login_history.php">USERS LOGIN HISTORY</a></li>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (Clearance::checkClearance(Clearance::$SUPER_ADMIN)) {
                                            ?>
                                            <li class="divider"></li>
                                            <li class="has-dropdown"><a href="#">JSON</a>
                                                <ul class="dropdown">
                                                    <li><a href="json.php">COMPLETE</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="json_test.php">TEST</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="json_alphabet.php">ALPHABET</a></li>
                                                </ul>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                        <li class="divider"></li>
                                        <li><a href="high_frequency.php">HIGH FREQUENCY WORDS</a></li>
                                        <?php
                                        if (Clearance::checkClearance(Clearance::$MODULE_ANDROID)) {
                                            ?>

                                            <li class="divider"></li>
                                            <li class="has-dropdown"><a href="#">ANDROID</a>
                                                <ul class="dropdown">
                                                    <li><a href="endpoints.php">API</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="json.php">CREATE JSON</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="gcm_user.php">GCM USERS</a></li>
                                                </ul>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (Clearance::checkClearance(Clearance::$MODULE_WORD_P)) {
                                            ?>

                                            <li class="divider"></li>
                                            <li><a href="word_pronunciation.php">WORD PRONUNCIATION</a></li>
                                        <?php
                                        }
                                        ?>

                                    </ul>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>

                        <ul class="right">
                            <li class="has-dropdown"><a href="#"> <img alt="user"
                                                                       class="user-image" src="<?php echo $src; ?>"/>Welcome,<span
                                        style="margin-left:5px;"><?php echo substr($_SESSION['name'], 0, strpos($_SESSION['name'], ' ')); ?></span>
                                </a>
                                <ul class="dropdown">
                                    <li><a href="profile.php">Profile</a></li>
                                    <li class="divider"></li>
                                    <li><a href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </section>
                </nav>
            </div>
        </div>
    </div>
<?php
}
?>