<?php

session_start();
include "../init.php";


if(isset($_SESSION['username']) && isset($_SESSION['id']) && isset($_SESSION['usertype'])) {

    include "includes/header.php";


    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if($do == 'manage') {

                // check if you want to get a specific article
                if(isset($_GET['articleid'])) {
                    $articleid = $_GET['articleid'];
        
                    // first check if articleid exists in db
                    $stmt = $conn->prepare("SELECT id, title, articleStatus, addedBy, publish_date FROM `articles` WHERE id = ?");
                    $stmt->execute(array($articleid));
                    $count = $stmt->rowCount();
        
                if($count > 0) { // if article's id exists
                    $row = $stmt->fetch();
        
                    // Then Show article's info
                    ?>
<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Article Status</th>
                <th scope="col">Added By</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    if($row['articleStatus'] == 1) {
                        $article_status = 'Published';
                    } elseif($row['articleStatus'] == 2) {
                        $article_status = "In Review";
                    } elseif($row['articleStatus'] == 3) {
                        $article_status = "Draft";
                    }

                    $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
                    $stmt->execute(array($row['addedBy']));
                    $added_by = $stmt->fetch()['username'];


                    echo '<tr scope="row">
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['title'] . '</td>
                    <td>' . $article_status . '</td>
                    <td><a href="users.php?userid=' . $row['addedBy'] . '">' . $added_by . '</a></td>
                    <td>' . $row['publish_date'] . '</td>
                    <td>';
                    if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                        echo '<a href="articles.php?do=edit&articleid=' . $row['id'] . '">Edit</a>
                        <a href="articles.php?do=delete&articleid=' . $row['id'] . '">Delete</a>';
                    } else {
                        echo 'None';
                    }
                    echo '</td>
                    </tr>';
                
              ?>
        </tbody>
    </table>
</div>


<?php   
                } else { // This article does not exist
                  redirect($dashboard_home . '/articles.php', '<div class="alert alert-danger" role="alert">
                  This Article does not exist, You will be redirected in 3 seconds
                </div>', 3);
                }
        
                } elseif(isset($_GET['orderby'])) { // get a specific type of Articles
                    $orderby = $_GET['orderby'];
        
                    if($orderby == "published") {
                        $stmt = $conn->prepare("SELECT id, title, articleStatus, addedBy, publish_date FROM `articles` WHERE articleStatus = ?");
                        $stmt->execute(array(1));
                        $rows = $stmt->fetchAll();
        
                        ?>

<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Article Status</th>
                <th scope="col">Added By</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($rows as $row) {

                    if($row['articleStatus'] == 1) {
                        $article_status = 'Published';
                    } elseif($row['articleStatus'] == 2) {
                        $article_status = "In Review";
                    } elseif($row['articleStatus'] == 3) {
                        $article_status = "Draft";
                    }

                    $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
                    $stmt->execute(array($row['addedBy']));
                    $added_by = $stmt->fetch()['username'];


                    echo '<tr scope="row">
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['title'] . '</td>
                    <td>' . $article_status . '</td>
                    <td><a href="users.php?userid=' . $row['addedBy'] . '">' . $added_by . '</a></td>
                    <td>' . $row['publish_date'] . '</td>
                    <td>';
                    if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                        echo '<a href="articles.php?do=edit&articleid=' . $row['id'] . '">Edit</a>
                        <a href="articles.php?do=delete&articleid=' . $row['id'] . '">Delete</a>';
                    } else {
                        echo 'None';
                    }
                    echo '</td>
                    </tr>';
                }
                
              ?>
        </tbody>
    </table>
</div>



<?php
        
        
        
                    } elseif($orderby == "inreview") {
        
                        $stmt = $conn->prepare("SELECT id, title, articleStatus, addedBy, publish_date FROM `articles` WHERE articleStatus = ?");
                        $stmt->execute(array(2));
                        $rows = $stmt->fetchAll();
        
                        ?>

<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Article Status</th>
                <th scope="col">Added By</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    foreach($rows as $row) {

                        if($row['articleStatus'] == 1) {
                            $article_status = 'Published';
                        } elseif($row['articleStatus'] == 2) {
                            $article_status = "In Review";
                        } elseif($row['articleStatus'] == 3) {
                            $article_status = "Draft";
                        }
    
                        $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
                        $stmt->execute(array($row['addedBy']));
                        $added_by = $stmt->fetch()['username'];
    
    
                        echo '<tr scope="row">
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['title'] . '</td>
                    <td>' . $article_status . '</td>
                    <td><a href="users.php?userid=' . $row['addedBy'] . '">' . $added_by . '</a></td>
                    <td>' . $row['publish_date'] . '</td>
                    <td>';
                    if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                        echo '<a href="articles.php?do=edit&articleid=' . $row['id'] . '">Edit</a>
                        <a href="articles.php?do=delete&articleid=' . $row['id'] . '">Delete</a>';
                    } else {
                        echo 'None';
                    }
                    echo '</td>
                    </tr>';
                    }
              ?>
        </tbody>
    </table>
</div>

<?php
        
                    } elseif($orderby == "draft") {


                        $stmt = $conn->prepare("SELECT id, title, articleStatus, addedBy, publish_date FROM `articles` WHERE articleStatus = ?");
                        $stmt->execute(array(3));
                        $rows = $stmt->fetchAll();
        
                        ?>

<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Article Status</th>
                <th scope="col">Added By</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
foreach($rows as $row) {

    if($row['articleStatus'] == 1) {
        $article_status = 'Published';
    } elseif($row['articleStatus'] == 2) {
        $article_status = "In Review";
    } elseif($row['articleStatus'] == 3) {
        $article_status = "Draft";
    }

    $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
    $stmt->execute(array($row['addedBy']));
    $added_by = $stmt->fetch()['username'];


    echo '<tr scope="row">
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['title'] . '</td>
                    <td>' . $article_status . '</td>
                    <td><a href="users.php?userid=' . $row['addedBy'] . '">' . $added_by . '</a></td>
                    <td>' . $row['publish_date'] . '</td>
                    <td>';
                    if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                        echo '<a href="articles.php?do=edit&articleid=' . $row['id'] . '">Edit</a>
                        <a href="articles.php?do=delete&articleid=' . $row['id'] . '">Delete</a>';
                    } else {
                        echo 'None';
                    }
                    echo '</td>
                    </tr>';
}
                
              ?>
        </tbody>
    </table>
</div>

<?php

                    }
        
                } else { // You don't want a specific Article, so fetch(get) all articles
        
                    
                // get all articles from database
                $stmt = $conn->prepare("SELECT id, title, articleStatus, addedBy, publish_date FROM `articles`");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $total_articles = $stmt->rowCount();
                $published_articles = 0;
                $inreview_articles = 0;
                $draft_articles = 0;
                foreach($rows as $row) {
                    if($row['articleStatus'] == 1) {
                        $published_articles += 1;
                    } elseif($row['articleStatus'] == 2) {
                        $inreview_articles += 1;
                    } elseif($row['articleStatus'] == 3) {
                        $draft_articles += 1;
                    }
        
                }
        
        
        ?>

<div class="site-stats">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                    <h1 class="display-4">Total articles:</h1>
                    <p class="lead"><a href="<?php echo $dashboard_home . '/articles.php'; ?>">
                            <?php echo $total_articles; ?></a></p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                    <h1 class="display-4">Published articles:</h1>
                    <p class="lead"><a href="<?php echo $dashboard_home . '/articles.php?orderby=published'; ?>">
                            <?php echo $published_articles; ?></a></p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                    <h1 class="display-4">In Review articles:</h1>
                    <p class="lead"><a href="<?php echo $dashboard_home . '/articles.php?orderby=inreview'; ?>">
                            <?php echo $inreview_articles; ?></a></p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                    <h1 class="display-4">Draft articles:</h1>
                    <p class="lead"><a href="<?php echo $dashboard_home . '/articles.php?orderby=draft'; ?>">
                            <?php echo $draft_articles; ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="control-articles">
    <div class="container">
        <a href="articles.php?do=add" class="btn btn-success">Add Article</a>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="number" min="1" name="articleid" placeholder="Article's id">
            <input type="submit" value="Search">
        </form>
    </div>
</div>


<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Article Status</th>
                <th scope="col">Added By</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    foreach($rows as $row) {

                        if($row['articleStatus'] == 1) {
                            $article_status = 'Published';
                        } elseif($row['articleStatus'] == 2) {
                            $article_status = "In Review";
                        } elseif($row['articleStatus'] == 3) {
                            $article_status = "Draft";
                        }
    
                        $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
                        $stmt->execute(array($row['addedBy']));
                        $added_by = $stmt->fetch()['username'];
    
    
                        echo '<tr scope="row">
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['title'] . '</td>
                    <td>' . $article_status . '</td>
                    <td><a href="users.php?userid=' . $row['addedBy'] . '">' . $added_by . '</a></td>
                    <td>' . $row['publish_date'] . '</td>
                    <td>';
                    if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                        echo '<a href="articles.php?do=edit&articleid=' . $row['id'] . '">Edit</a>
                        <a href="articles.php?do=delete&articleid=' . $row['id'] . '">Delete</a>';
                    } else {
                        echo 'None';
                    }
                    echo '</td>
                    </tr>';
                    }
              ?>
        </tbody>
    </table>
</div>


<?php
                }


    } // manage ends here


    elseif($do == "delete") {

        if(isset($_GET['articleid'])) {

        $articleid = $_GET['articleid'];

        // first check if articleid exists in db
        $stmt = $conn->prepare("SELECT id, addedBy FROM `articles` WHERE id = ?");
        $stmt->execute(array($articleid));
        $count = $stmt->rowCount();

        if($count > 0) { // if article's id exists
            
            $row = $stmt->fetch();

            if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {

            // Then delete it from db
            $stmt = $conn->prepare("DELETE FROM `articles` WHERE id = ?");
            $stmt->execute(array($articleid));
            redirect($dashboard_home . '/articles.php', '<div class="alert alert-success" role="alert">
            Successfully deleted the article, You will be redirected in 3 seconds
            </div>', 3);
        } else {
            redirect($dashboard_home, '<div class="alert alert-danger" role="alert">
            You don\'t have the permissions to delete this, You will be redirected in 3 seconds
            </div>', 3);
        }

    } else { // if This article does not exists
        // show error message then redirect
        redirect($dashboard_home . '/articles.php', '<div class="alert alert-danger" role="alert">
        This article does not exist, You will be redirected in 3 seconds
    </div>', 3);
    }
    


        } else { // articleid is not given
            redirect($dashboard_home);
        }

    } // delete ends here


    elseif($do == "edit") {

        if(isset($_GET['articleid'])) {

            $articleid = $_GET['articleid'];
            

            // first check if articleid exists in db
            $stmt = $conn->prepare("SELECT id, title, body, articleStatus, addedBy FROM `articles` WHERE id = ?");
            $stmt->execute(array($articleid));
            $count = $stmt->rowCount();

            if($count > 0) { // if article's id exists

                $row = $stmt->fetch();

                if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                ?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?do=update'; ?>" method="POST">
        <input type="hidden" name="articleid" value="<?php echo $row['id']; ?>">
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title:</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" id="title" value="<?php echo $row['title']; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="body" class="col-sm-2 col-form-label">Body:</label>
            <div class="col-sm-10">
                <textarea name="body" class="form-control" id="body"><?php echo $row['body']; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="article-status">Article status:</label>
            <?php
                    if($row['articleStatus'] == 1) {
                    echo '<p class="text-info">Article is published</p>';
                    } elseif($row['articleStatus'] == 2) {
                        echo '<p class="text-info">Article is in review</p>';
                    } elseif($row['articleStatus'] == 3) {
                            echo '<p class="text-info">Article is a draft</p>';
                    }
                    ?>
            <select class="form-control" id="article-status" name="articlestatus">
                <option value="1">Published</option>
                <option value="2">In review</option>
                <option value="3">Draft</option>
            </select>
        </div>
        <input type="submit" value="Edit">
    </form>
</div>

<?php

                } else {
                    redirect($dashboard_home, '<div class="alert alert-danger" role="alert">
            You don\'t have the permissions to edit this, You will be redirected in 3 seconds
            </div>', 3);
                }

            } else { // This Article does not exists
              redirect($dashboard_home . '/articles.php', '<div class="alert alert-danger" role="alert">
              This article does not exist, You will be redirected in 3 seconds
            </div>', 3);
            }



        } else { // articleid is not given
            redirect($dashboard_home);
        }
        

    } // edit ends here

    elseif($do == "update") {

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $articleid = $_POST['articleid'];

            $title = $_POST['title'];
            $body = $_POST['body'];
            $article_status = $_POST['articlestatus'];

            $stmt = $conn->prepare("UPDATE `articles` SET title = :title, body = :body, articleStatus = :articlestatus WHERE id = :articleid");
            $stmt->execute(array(":title" => $title, ":body" => $body, ":articlestatus" => $article_status, ":articleid" => $articleid));

            redirect($dashboard_home . '/articles.php', '<div class="alert alert-success" role="alert">
                Successfully Updated the article\'s info, You will be redirected in 3 seconds
                </div>', 3);


        } else { // request method is not post
            redirect($dashboard_home);

        }


    } // update ends here


    elseif($do == "add") {
        ?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?do=insert'; ?>" method="POST">
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title:</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" id="title">
            </div>
        </div>
        <div class="form-group row">
            <label for="body" class="col-sm-2 col-form-label">Body:</label>
            <div class="col-sm-10">
                <textarea name="body" class="form-control" id="body"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="article-status">Article status:</label>
            <select class="form-control" id="article-status" name="articlestatus">
                <option value="1">Published</option>
                <option value="2">In review</option>
                <option value="3">Draft</option>
            </select>
        </div>
        <input type="submit" value="Add">
    </form>
</div>



<?php
    } // add ends here

    elseif($do == "insert") {

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            // get the id of the user who wrote teh article
            $added_by = $_SESSION['id'];

            $title = $_POST['title'];
            $body = $_POST['body'];
            $article_status = $_POST['articlestatus'];

            $stmt = $conn->prepare("INSERT INTO `articles`(title, body, articleStatus, addedBy) VALUES(:title, :body, :articlestatus, :addedby)");
            $stmt->execute(array(":title" => $title, ":body" => $body, ":articlestatus" => $article_status, ":addedby" => $added_by));
            
            redirect($dashboard_home . '/articles.php', '<div class="alert alert-success" role="alert">
                Successfully Added the article\'s info, You will be redirected in 3 seconds
                </div>', 3);


        } else { // if request method is not post
            redirect($dashboard_home);
        }

    } // insert ends here

    include "includes/footer.php";




} else { // user is not logged in
    redirect('/blog/login.php');
}