<?php

session_start();
include "../init.php";

if(isset($_SESSION['id']) && isset($_SESSION['username'])) {

    include "includes/header.php";

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if($do == "manage") {


         // check if you want to get a specific comment
         if(isset($_GET['commentid'])) {
            $commentid = $_GET['commentid'];

            // first check if articleid exists in db
            $stmt = $conn->prepare("SELECT comment_id, post_id, comment, addedBy, publish_date, commentStatus FROM `comments` WHERE comment_id = ?");
            $stmt->execute(array($commentid));
            $count = $stmt->rowCount();

        if($count > 0) { // if comment's id exists
            $row = $stmt->fetch();

            // Then Show comment's info
            ?>
<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Post</th>
                <th scope="col">Comment</th>
                <th scope="col">Added By</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($row['commentStatus'] == 1) {
                $comment_status = 'Published';
            } elseif($row['commentStatus'] == 2) {
                $comment_status = "In Review";
            }

            $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
            $stmt->execute(array($row['addedBy']));
            $added_by = $stmt->fetch()['username'];
            $stmt = $conn->prepare("SELECT title FROM `articles` WHERE id = ?");
            $stmt->execute(array($row['post_id']));
            $article_title = $stmt->fetch()['title'];
            $comment = (strlen($row['comment']) > 80) ? substr($row['comment'], 0, 80) . '....' : $row['comment'];
    
    
            echo '<tr scope="row">
            <td>' . $row['comment_id'] . '</td>
            <td><a href="articles.php?articleid=' . $row['post_id'] . '">' . $article_title . '</a></td>
            <td>' . $comment . '</td>
            <td><a href="users.php?userid=' . $row['addedBy'] . '">' . $added_by . '</a></td>
            <td>' . $comment_status . '</td>
            <td>' . $row['publish_date'] . '</td>
            <td>';
            if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                echo '<a href="comments.php?do=edit&commentid=' . $row['comment_id'] . '">Edit</a>
                <a href="comments.php?do=delete&commentid=' . $row['comment_id'] . '">Delete</a>';
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
        } else { // This comment does not exist
          redirect($dashboard_home . '/comments.php', '<div class="alert alert-danger" role="alert">
          This Comment does not exist, You will be redirected in 3 seconds
        </div>', 3);
        }

        } elseif(isset($_GET['orderby'])) { // get a specific type of Articles
            $orderby = $_GET['orderby'];

            if($orderby == "published") {
                $stmt = $conn->prepare("SELECT comment_id, post_id, comment, addedBy, publish_date, commentStatus FROM `comments` WHERE commentStatus = ?");
                $stmt->execute(array(1));
                $rows = $stmt->fetchAll();

                ?>

<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Post</th>
                <th scope="col">Comment</th>
                <th scope="col">Added By</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
        foreach($rows as $row) {

            if($row['commentStatus'] == 1) {
                $comment_status = 'Published';
            } elseif($row['commentStatus'] == 2) {
                $comment_status = "In Review";
            }

            $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
            $stmt->execute(array($row['addedBy']));
            $added_by = $stmt->fetch()['username'];
            $stmt = $conn->prepare("SELECT title FROM `articles` WHERE id = ?");
            $stmt->execute(array($row['post_id']));
            $article_title = $stmt->fetch()['title'];
            $comment = (strlen($row['comment']) > 80) ? substr($row['comment'], 0, 80) . '....' : $row['comment'];
    
    
            echo '<tr scope="row">
            <td>' . $row['comment_id'] . '</td>
            <td><a href="articles.php?articleid=' . $row['post_id'] . '">' . $article_title . '</a></td>
            <td>' . $comment . '</td>
            <td><a href="users.php?userid=' . $row['addedBy'] . '">' . $added_by . '</a></td>
            <td>' . $comment_status . '</td>
            <td>' . $row['publish_date'] . '</td>
            <td>';
            if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                echo '<a href="comments.php?do=edit&commentid=' . $row['comment_id'] . '">Edit</a>
                <a href="comments.php?do=delete&commentid=' . $row['comment_id'] . '">Delete</a>';
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

                $stmt = $conn->prepare("SELECT comment_id, post_id, comment, addedBy, publish_date, commentStatus FROM `comments` WHERE commentStatus = ?");
                $stmt->execute(array(2));
                $rows = $stmt->fetchAll();

                ?>

<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Post</th>
                <th scope="col">Comment</th>
                <th scope="col">Added By</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($rows as $row) {

                if($row['commentStatus'] == 1) {
                    $comment_status = 'Published';
                } elseif($row['commentStatus'] == 2) {
                    $comment_status = "In Review";
                }
    
                $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
                $stmt->execute(array($row['addedBy']));
                $added_by = $stmt->fetch()['username'];
                $stmt = $conn->prepare("SELECT title FROM `articles` WHERE id = ?");
                $stmt->execute(array($row['post_id']));
                $article_title = $stmt->fetch()['title'];
                $comment = (strlen($row['comment']) > 80) ? substr($row['comment'], 0, 80) . '....' : $row['comment'];
    
    
                echo '<tr scope="row">
                <td>' . $row['comment_id'] . '</td>
                <td><a href="articles.php?articleid=' . $row['post_id'] . '">' . $article_title . '</a></td>
                <td>' . $comment . '</td>
                <td><a href="users.php?userid=' . $row['addedBy'] . '">' . $added_by . '</a></td>
                <td>' . $comment_status . '</td>
                <td>' . $row['publish_date'] . '</td>
                <td>';
                if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                    echo '<a href="comments.php?do=edit&commentid=' . $row['comment_id'] . '">Edit</a>
                    <a href="comments.php?do=delete&commentid=' . $row['comment_id'] . '">Delete</a>';
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

        } else { // You don't want a specific Comment, so fetch(get) all comments

            
        // get all comments from database
        $stmt = $conn->prepare("SELECT comment_id, post_id, comment, addedBy, publish_date, commentStatus FROM `comments`");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $total_comments = $stmt->rowCount();
        $published_comments = 0;
        $inreview_comments = 0;
        foreach($rows as $row) {
            if($row['commentStatus'] == 1) {
                $published_comments += 1;
            } elseif($row['commentStatus'] == 2) {
                $inreview_comments += 1;
            }

        }


?>

<div class="site-stats">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                    <h1 class="display-4">Total comments:</h1>
                    <p class="lead"><a href="<?php echo $dashboard_home . '/comments.php'; ?>">
                            <?php echo $total_comments; ?></a></p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                    <h1 class="display-4">Published comments:</h1>
                    <p class="lead"><a href="<?php echo $dashboard_home . '/comments.php?orderby=published'; ?>">
                            <?php echo $published_comments; ?></a></p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                    <h1 class="display-4">In Review comments:</h1>
                    <p class="lead"><a href="<?php echo $dashboard_home . '/comments.php?orderby=inreview'; ?>">
                            <?php echo $inreview_comments; ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="control-articles">
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="number" min="1" name="commentid" placeholder="Comment's id">
            <input type="submit" value="Search">
        </form>
    </div>
</div>


<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Post</th>
                <th scope="col">Comment</th>
                <th scope="col">Added By</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($rows as $row) {

                if($row['commentStatus'] == 1) {
                    $comment_status = 'Published';
                } elseif($row['commentStatus'] == 2) {
                    $comment_status = "In Review";
                }
    
                $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
                $stmt->execute(array($row['addedBy']));
                $added_by = $stmt->fetch()['username'];
                $stmt = $conn->prepare("SELECT title FROM `articles` WHERE id = ?");
                $stmt->execute(array($row['post_id']));
                $article_title = $stmt->fetch()['title'];
                $comment = (strlen($row['comment']) > 80) ? substr($row['comment'], 0, 80) . '....' : $row['comment'];
    
    
                echo '<tr scope="row">
                <td>' . $row['comment_id'] . '</td>
                <td><a href="articles.php?articleid=' . $row['post_id'] . '">' . $article_title . '</a></td>
                <td>' . $comment . '</td>
                <td><a href="users.php?userid=' . $row['addedBy'] . '">' . $added_by . '</a></td>
                <td>' . $comment_status . '</td>
                <td>' . $row['publish_date'] . '</td>
                <td>';
                if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                    echo '<a href="comments.php?do=edit&commentid=' . $row['comment_id'] . '">Edit</a>
                    <a href="comments.php?do=delete&commentid=' . $row['comment_id'] . '">Delete</a>';
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

        if(isset($_GET['commentid'])) {

        $commentid = $_GET['commentid'];

        // first check if commentid exists in db
        $stmt = $conn->prepare("SELECT comment_id, addedBy FROM `comments` WHERE comment_id = ?");
        $stmt->execute(array($commentid));
        $count = $stmt->rowCount();

        if($count > 0) { // if comment's id exists

            $row = $stmt->fetch();

            if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {

            // Then delete it from db
            $stmt = $conn->prepare("DELETE FROM `comments` WHERE comment_id = ?");
            $stmt->execute(array($commentid));
            redirect($dashboard_home . '/comments.php', '<div class="alert alert-success" role="alert">
            Successfully deleted the comment, You will be redirected in 3 seconds
            </div>', 3);
        } else {
            redirect($dashboard_home, '<div class="alert alert-danger" role="alert">
            You don\'t have the permissions to delete this, You will be redirected in 3 seconds
            </div>', 3);
        }

    } else { // if This comment does not exists
        // show error message then redirect
        redirect($dashboard_home . '/comments.php', '<div class="alert alert-danger" role="alert">
        This comment does not exist, You will be redirected in 3 seconds
    </div>', 3);
    }
    

        } else { // commentid is not given
            redirect($dashboard_home);
        }

    } // delete ends here


    elseif($do == "edit") {

        if(isset($_GET['commentid'])) {

            $commentid = $_GET['commentid'];
            

            // first check if articleid exists in db
            $stmt = $conn->prepare("SELECT comment_id, post_id, comment, addedBy, publish_date, commentStatus FROM `comments` WHERE comment_id = ?");
            $stmt->execute(array($commentid));
            $count = $stmt->rowCount();

            if($count > 0) { // if article's id exists

                $row = $stmt->fetch();

                if($_SESSION['usertype'] < 3 || $_SESSION['id'] == $row['addedBy']) {
                ?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?do=update'; ?>" method="POST">
        <input type="hidden" name="commentid" value="<?php echo $row['comment_id']; ?>">
        <div class="form-group row">
            <label for="comment" class="col-sm-2 col-form-label">Comment:</label>
            <div class="col-sm-10">
                <textarea name="comment" class="form-control" id="comment"><?php echo $row['comment']; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="comment-status">Comment status:</label>
            <?php
                    if($row['commentStatus'] == 1) {
                    echo '<p class="text-info">Comment is published</p>';
                    } elseif($row['commentStatus'] == 2) {
                        echo '<p class="text-info">Comment is in review</p>';
                    }
                    ?>
            <select class="form-control" id="comment-status" name="commentstatus">
                <option value="1">Published</option>
                <option value="2">In review</option>
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

            } else { // This comemnt does not exists
              redirect($dashboard_home . '/articles.php', '<div class="alert alert-danger" role="alert">
              This comment does not exist, You will be redirected in 3 seconds
            </div>', 3);
            }



        } else { // commentid is not given
            redirect($dashboard_home);
        }
        

    } // edit ends here


    elseif($do == "update") {

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $commentid = $_POST['commentid'];

            $comment = $_POST['comment'];
            $comment_status = $_POST['commentstatus'];

            $stmt = $conn->prepare("UPDATE `comments` SET comment = :comment, commentStatus = :commentstatus WHERE comment_id = :commentid");
            $stmt->execute(array(":comment" => $comment, ":commentstatus" => $comment_status, ":commentid" => $commentid));

            redirect($dashboard_home . '/comments.php', '<div class="alert alert-success" role="alert">
                Successfully Updated the comment\'s info, You will be redirected in 3 seconds
                </div>', 3);


        } else { // request method is not post
            redirect($dashboard_home);
        }


    } // update ends here

    // To add a comemnt, you must go to the article you want to comemnt on and scroll down then add your comment
    



    include "includes/footer.php";

} else { // user is not logged in

    redirect('/blog/login.php');

}