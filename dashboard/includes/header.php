<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Abdo Blog | Dashboard</title>
  <link rel="stylesheet" <?php echo "href=" . $css . "bootstrap.min.css"; ?>>
  <link rel="stylesheet" <?php echo "href=" . $css ."style.css" ?>>
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="<?php echo $blog_home; ?>">Abdo Blog</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $dashboard_home; ?>">Dashboard</a>
          </li>
          <?php
          if(isset($_SESSION['usertype'])) {
            if($_SESSION['usertype'] == 1) {
              echo '<li class="nav-item">
              <a class="nav-link" href="' . $dashboard_home . '/users.php">Users</a>
            </li>';
            }
          }
          ?>
          <li class="nav-item">
          <a class="nav-link" href="<?php echo $dashboard_home; ?>/articles.php">Articles</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $dashboard_home; ?>/comments.php">Comments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $dashboard_home; ?>/logout.php">Log Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>