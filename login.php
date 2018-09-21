<?php

session_start();
include "init.php";
$page_title = "Login";
include "includes/header.php";

if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    redirect($dashboard_home);
} else {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPassword = sha1($password);
    
        $stmt = $conn->prepare("SELECT `id`, `username`, `userPermission` FROM users WHERE username = ? AND password = ?");
        $stmt->execute(array($username, $hashedPassword));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        $errArr = array();
        if($count > 0) { // user exists
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $row['userPermission'];
            redirect($dashboard_home);
        } else { // user does not exist
            $errArr[] = 'Username or password were wrong';
        }
    } else { // request method is not post
        // do nothing and show login form
    }
}


?>
<div class="login-wrapper">
    <p>New member? <a href="signup.php">Sign Up</a></p>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="login-form">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <?php
            if(isset($errArr)) {
                foreach($errArr as $err) {
                    echo '<p style="color: red;">' . $err . '</p>';
                }
            }
        ?>
        <input type="submit" value="Login">
    </form>
</div>

<?php
include "includes/footer.php";
