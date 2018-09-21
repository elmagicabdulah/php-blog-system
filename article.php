<?php

session_start();
include "init.php";
include "includes/header.php";

if(isset($_GET['articleid'])) {



    $articleid = $_GET['articleid'];

    // first check if this id exists in db
    $stmt = $conn->prepare("SELECT * FROM `articles` WHERE id = ?");
    $stmt->execute(array($articleid));
    $row = $stmt->fetch();

    if($row['articleStatus'] == 1) {

        $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
        $stmt->execute(array($row['addedBy']));
        $added_by = $stmt->fetch()['username'];

        $page_title = $row['title']; 

        // show the article
        ?>

        <div class="container">
            <article class="article">
                <h2 class="article-title"><?php echo $row['title']; ?></h2>
                <div class="article-info">
                    <p><?php echo $added_by; ?></p>
                    <p><?php echo $row['publish_date']; ?></p>
                </div>
                <p class="article-body"><?php echo $row['body']; ?></p>
            </article>
        </div>

        <?php

        

        $stmt = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
        $stmt->execute(array($articleid));
        $comments = $stmt->fetchAll();

        if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['usertype'])) {

             // check if user added a comment or not

             if($_SERVER['REQUEST_METHOD'] == "POST") {
                $comment = $_POST['comment'];

                $stmt = $conn->prepare("INSERT INTO `comments`(post_id, addedBy, comment) VALUES(:postid, :addedby, :comment)");
                $stmt->execute(array(":postid" => $articleid, ":addedby" => $_SESSION['id'], ":comment" => $comment));
                redirect($_SERVER['PHP_SELF'] . '?articleid=' . $articleid);
            }

            // show textarea to post a comment
            ?>
            <div class="container">
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?articleid=' . $articleid; ?>" method="POST">
                    <textarea name="comment" class="form-control" placeholder="Comment.."></textarea>
                    <div class="right-align">
                        <input class="btn btn-primary" type="submit" value="Add Comment">
                    </div>
                </form>
            </div>

            <?php


            


            
        }

        // show comemnts

        
        echo '<div class="comments">
        <div class="container">';
        foreach($comments as $comment) {

            if($comment['commentStatus'] == 1) { // if comment is published

                // show comment

            $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
            $stmt->execute(array($comment['addedBy']));
            $added_by = $stmt->fetch()['username'];

            ?>

            <div class="comment">
                <h3 class="comment-added-by"><?php echo $added_by; ?></h3>
                <p class="comment-publish-date"><?php echo $comment['publish_date']; ?></p>
                <p class="comment"><?php echo $comment['comment']; ?></p>
                <?php

                if(isset($_SESSION['id'])) {

                    if($_SESSION['id'] == $comment['addedBy'] || $_SESSION['usertype'] < 3) { // if the user who is logged in is the comment owner or admin or mod
                        
                        // show edit button
                        echo '<a href="' . $dashboard_home . '/comments.php?do=edit&commentid=' . $comment['comment_id'] . '">Edit comment</a>';


                    }


                }
                
                ?>


            </div>

            <?php

            }
        }


        echo '</div>
        </div>';

        


    } else { // if article's status is not published or the article doesn't exist
        echo '<div class="alert alert-danger" role="alert">
        This Article does not exist
      </div>';
    }


} else {

    if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['usertype'])) { // create an article
        redirect($dashboard_home . '/articles.php?do=add');
    } else {
        echo '<div class="alert alert-danger" role="alert">
        This Article does not exist
      </div>';
    }

}

?>

<?php
include "includes/footer.php";