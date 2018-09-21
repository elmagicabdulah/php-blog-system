<?php

session_start();
include "init.php";
$page_title = "Sign Up";
include "includes/header.php";

if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    redirect($dashboard_home);
} else {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPassword = sha1($password);
        $hashedConfirmedPassword = sha1($_POST['confirmpassword']);
    
        $stmt = $conn->prepare("SELECT `username` FROM `users` WHERE username = ?");
        $stmt->execute(array($username));
        $usernameCount = $stmt->rowCount();

        $stmt = $conn->prepare("SELECT `email` FROM `users` WHERE email = ?");
        $stmt->execute(array($email));
        $emailCount = $stmt->rowCount();

        $errArr = array();
        if($usernameCount > 0) { // username exists.. duplicate and can't signup
            $errArr[] = 'Username is already taken';
        }
        if($emailCount > 0) { // email exists.. duplicate and can't signup
            $errArr[] = 'Email is already taken';
        }

        if(empty($errArr)) { // username or email don't exist, so he can use the username and email
            if($hashedPassword == $hashedConfirmedPassword) {
                $stmt = $conn->prepare("INSERT INTO `users`(username, email, password) VALUES(:username, :email, :password)");
                $stmt->execute(array(":username" => $username, ":email" => $email, ":password" => $hashedPassword));
                $stmt = $conn->prepare("SELECT id FROM `users` WHERE username = ?");
                $stmt->execute(array($username));
                $id = $stmt->fetch()['id'];
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['usertype'] = 3;
                redirect($dashboard_home, '<div class="alert text-center alert-success" role="alert">
                You are now registerd. Welcome ' . $username . '! &nbsp; You will be redirected in 5 seconds
              </div>', 5);
            } else {
                $errArr[] = "Password and confirmed password are not the same";
            }

        }
    } else { // request method is not post
        // do nothing and show signup form
    }
}


?>

<div class="login-wrapper">
    <p>Already have an acoount? <a href="login.php">Login</a></p>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="login-form">
        <input type="text" name="username" placeholder="Username">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="confirmpassword" placeholder="Confirm Password">
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
