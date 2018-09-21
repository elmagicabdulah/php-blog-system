<?php

session_start();
include "../init.php";
include "includes/header.php";
if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    // get total members
    $stmt1 = $conn->prepare("SELECT id FROM `users`");
    $stmt1->execute();
    $total_users = $stmt1->rowCount();


    $stmt2 = $conn->prepare("SELECT id FROM `articles`");
    $stmt2->execute();
    $total_articles = $stmt2->rowCount();
    ?>

<div class="site-stats">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                <h1 class="display-4">Total users:</h1>
                <p class="lead"><a href="<?php echo $dashboard_home . '/users.php'; ?>"><?php echo $total_users; ?></a></p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                <h1 class="display-4">Total articles:</h1>
                <p class="lead"><a href="<?php echo $dashboard_home . '/articles.php'; ?>"><?php echo $total_articles; ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>


    


<?php

include "includes/footer.php";

} else {
    redirect("../login.php");
}