<?php

session_start();
include "init.php";
include "includes/header.php";


if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['usertype'])) {
    echo '<a href="' . $dashboard_home . '/articles.php?do=add" class="btn btn-success">Add Article</a>';
}


?>



<section class="articles">
    <div class="container">
        <div class="row">
        <?php
            $stmt = $conn->prepare("SELECT * FROM `articles` WHERE articleStatus = ?"); // where this article status is published
            $stmt->execute([1]);
            $articles = $stmt->fetchAll();
            foreach($articles as $article) {
                $body = strlen($article['body']) > 400 ? substr($article['body'], 0, 500) . '....' : $article['body'];

                $stmt = $conn->prepare("SELECT username FROM `users` WHERE id = ?");
                $stmt->execute(array($article['addedBy']));
                $added_by = $stmt->fetch()['username'];
        ?>
            <article class="col-12">
                <h2 class="articles-title"><a href="article.php?articleid=<?php echo $article['id']; ?>"><?php echo $article['title']; ?></a></h2>
                <p class="articles-body"><?php echo $body ?></p>
                <div class="right-align">
                    <a href="article.php?articleid=<?php echo $article['id']; ?>"<?php ?>" class="read-more-btn btn btn-primary">Read More</a>
                </div>
                <div class="articles-info">
                    <p>By: <?php echo $added_by; ?></p>
                    <p><?php echo $article['publish_date']; ?></p>
                </div>
            </article>

            <?php } ?>

        </div>
    </div>
</section>

<?php
includeFooter();
include "includes/footer.php";