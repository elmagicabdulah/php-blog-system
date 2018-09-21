<?php

session_start();
include '../init.php';

if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['usertype'])) {

    /* admins: control users, articles and everything. note: you can't remove or change the absolute admin(id=1) by the script, you have to do it in db.
     * mods: they approve articles, edit them and delete them.
     * authors: they only publish articles.
    */



    if($_SESSION['usertype'] == 1) { // if user is admin 
        // he can access the page


    include "includes/header.php";
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if($do == 'manage') {

        // check if you want to get a specific user
        if(isset($_GET['userid'])) {
            $userid = $_GET['userid'];

            // first check if userid exists in db
            $stmt = $conn->prepare("SELECT id, username, email, userStatus, userPermission FROM `users` WHERE id = ?");
            $stmt->execute(array($userid));
            $count = $stmt->rowCount();

        if($count > 0) { // if user's id exists
            $row = $stmt->fetch();

            // Then Show user's info
            ?>
<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">User Status</th>
                <th scope="col">User type</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $user_status = $row['userStatus'] == 1 ? 'Active' : 'Need Activation';
            if($row['userPermission'] == 1) {
                $user_type = 'Adminstrator';
            } elseif($row['userPermission'] == 2) {
                $user_type = 'Moderator';
            } elseif($row['userPermission'] == 3) {
                $user_type = 'Author';
            } 
            echo '<tr scope="row">
            <td>' . $row['id'] . '</td>
            <td>' . $row['username'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $user_status . '</td>
            <td>' . $user_type . '</td>
            <td>';
            if($row['id'] != 1) { // if user is not admin, you can edit him or remove him
                echo '<a href="users.php?do=edit&userid=' . $row['id'] . '">Edit</a>
                <a href="users.php?do=delete&userid=' . $row['id'] . '">Delete</a>';
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
        } else { // This user does not exists
          redirect($dashboard_home . '/users.php', '<div class="alert alert-danger" role="alert">
          This user does not exist, You will be redirected in 3 seconds
        </div>', 3);
        }

        } elseif(isset($_GET['orderby'])) { // get a specific type of users
            $orderby = $_GET['orderby'];

            if($orderby == "unactive") {
                $stmt = $conn->prepare("SELECT id, username, email, userStatus, userPermission FROM `users` WHERE userStatus = ?");
                $stmt->execute(array(0));
                $rows = $stmt->fetchAll();

                ?>

<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">User Status</th>
                <th scope="col">User type</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
        foreach($rows as $row) {
            $user_status = $row['userStatus'] == 1 ? 'Active' : 'Need Activation';
            if($row['userPermission'] == 1) {
                $user_type = 'Adminstrator';
            } elseif($row['userPermission'] == 2) {
                $user_type = 'Moderator';
            } elseif($row['userPermission'] == 3) {
                $user_type = 'Author';
            }
            echo '<tr scope="row">
            <td>' . $row['id'] . '</td>
            <td>' . $row['username'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $user_status . '</td>
            <td>' . $user_type . '</td>
            <td>';
            if($row['id'] != 1) { // if user is not admin, you can edit him or remove him
                echo '<a href="users.php?do=edit&userid=' . $row['id'] . '">Edit</a>
                <a href="users.php?do=delete&userid=' . $row['id'] . '">Delete</a>';
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



            } elseif($orderby == "active") {

                $stmt = $conn->prepare("SELECT id, username, email, userStatus, userPermission FROM `users` WHERE userStatus = ?");
                $stmt->execute(array(1));
                $rows = $stmt->fetchAll();

                ?>

<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">User Status</th>
                <th scope="col">User type</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
        foreach($rows as $row) {
            $user_status = $row['userStatus'] == 1 ? 'Active' : 'Need Activation';
            if($row['userPermission'] == 1) {
                $user_type = 'Adminstrator';
            } elseif($row['userPermission'] == 2) {
                $user_type = 'Moderator';
            } elseif($row['userPermission'] == 3) {
                $user_type = 'Author';
            }
            echo '<tr scope="row">
            <td>' . $row['id'] . '</td>
            <td>' . $row['username'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $user_status . '</td>
            <td>' . $user_type . '</td>
            <td>';
            if($row['id'] != 1) { // if user is not admin, you can edit him or remove him
                echo '<a href="users.php?do=edit&userid=' . $row['id'] . '">Edit</a>
                <a href="users.php?do=delete&userid=' . $row['id'] . '">Delete</a>';
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

        } else { // You don't want a specific user, so fetch(get) all users

            
        // get all users from database
        $stmt = $conn->prepare("SELECT id, username, email, userStatus, userPermission FROM `users`");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $total_users = $stmt->rowCount();
        $active_users = 0;
        $unactive_users = 0;
        foreach($rows as $row) {
            if($row['userStatus'] == 0) {
                $unactive_users += 1;
            } else {
                $active_users += 1;
            }



        }


?>

<div class="site-stats">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                    <h1 class="display-4">Total users:</h1>
                    <p class="lead"><a href="<?php echo $dashboard_home . '/users.php'; ?>">
                            <?php echo $total_users; ?></a></p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                    <h1 class="display-4">Active users:</h1>
                    <p class="lead"><a href="<?php echo $dashboard_home . '/users.php?orderby=active'; ?>">
                            <?php echo $active_users; ?></a></p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="jumbotron text-center">
                    <h1 class="display-4">Unactive users:</h1>
                    <p class="lead"><a href="<?php echo $dashboard_home . '/users.php?orderby=unactive'; ?>">
                            <?php echo $unactive_users; ?></a></p>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="control-users">
    <div class="container">
        <a href="users.php?do=add" class="btn btn-success">Add user</a>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="number" min="1" name="userid" placeholder="User's id">
            <input type="submit" value="Search">
        </form>
    </div>
</div>


<div class="container table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">User Status</th>
                <th scope="col">User type</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
        foreach($rows as $row) {
            $user_status = $row['userStatus'] == 1 ? 'Active' : 'Need Activation';
            if($row['userPermission'] == 1) {
                $user_type = 'Adminstrator';
            } elseif($row['userPermission'] == 2) {
                $user_type = 'Moderator';
            } elseif($row['userPermission'] == 3) {
                $user_type = 'Author';
            }
            echo '<tr scope="row">
            <td>' . $row['id'] . '</td>
            <td>' . $row['username'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $user_status . '</td>
            <td>' . $user_type . '</td>
            <td>';
            if($row['id'] != 1) { // if user is not admin, you can edit him or remove him
                echo '<a href="users.php?do=edit&userid=' . $row['id'] . '">Edit</a>
                <a href="users.php?do=delete&userid=' . $row['id'] . '">Delete</a>';
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
    } // manage end here

    elseif($do == "delete") {
        if(isset($_GET['userid'])) {

            $userid = $_GET['userid'];
            if($userid != 1) { // if the user is not the admin

            // first check if userid exists in db
            $stmt = $conn->prepare("SELECT id FROM `users` WHERE id = ?");
            $stmt->execute(array($userid));
            $count = $stmt->rowCount();

            if($count > 0) { // if user's id exists

                // Then delete it from db
                $stmt = $conn->prepare("DELETE FROM `users` WHERE id = ?");
                $stmt->execute(array($userid));
                redirect($dashboard_home . '/users.php', '<div class="alert alert-success" role="alert">
                Successfully deleted the user, You will be redirected in 3 seconds
              </div>', 3);
            } else { // This user does not exists
              redirect($dashboard_home . '/users.php', '<div class="alert alert-danger" role="alert">
              This user does not exist, You will be redirected in 3 seconds
            </div>', 3);
            }

        } else { // if user is admin

            // you cant delete admin, so redirect
            redirect($dashboard_home);
        }

        } else { // userid is not given
            redirect($dashboard_home);
        }

    } // delete end here

    elseif($do == "edit") {

        if(isset($_GET['userid'])) {

            $userid = $_GET['userid'];
            if($userid != 1) { // if the user is not the admin

            // first check if userid exists in db
            $stmt = $conn->prepare("SELECT id, username, email, userStatus, userPermission FROM `users` WHERE id = ?");
            $stmt->execute(array($userid));
            $count = $stmt->rowCount();

            if($count > 0) { // if user's id exists

                // Then show the form that let you able to change
                $row = $stmt->fetch();
                ?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?do=update'; ?>" method="POST">
        <input type="hidden" name="userid" value="<?php echo $row['id']; ?>">
        <div class="form-group row">
            <label for="username" class="col-sm-2 col-form-label">Username:</label>
            <div class="col-sm-10">
                <input type="text" name="username" class="form-control" id="username" value="<?php echo $row['username']; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input type="text" name="email" class="form-control" id="email" value="<?php echo $row['email']; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="password" placeholder="Leave it blank if you don't want to change it">
            </div>
        </div>
        <div class="form-group">
            <label for="user-status">User's Status:</label>
            <?php
                    if($row['userStatus'] == 1) {
                    echo '<p class="text-info">User is Activated</p>
                    <select class="form-control" id="user-status" name="userstatus">
                            
                                <option value="1">Activated</option>
                                <option value="0">Need Activation</option>';
                            } else {
                                echo '<p class="text-info">User Needs Activation</p>
                                <select class="form-control" id="user-status" name="userstatus">

                                <option value="0">Need Activation</option>
                                <option value="1">Activated</option>';
                            }
                        ?>
            </select>
        </div>
        <div class="form-group">
            <label for="user-type">User's Type:</label>
            <?php
                    if($row['userPermission'] == 1) {
                    echo '<p class="text-info">User is an Adminstrator</p>';
                    } elseif($row['userPermission'] == 2) {
                        echo '<p class="text-info">User is a Moderator</p>';
                    } elseif($row['userPermission'] == 3) {
                            echo '<p class="text-info">User is an Author</p>';
                    }
                    ?>

            <select class="form-control" id="user-type" name="usertype">
                <option value="1">Adminstrator</option>
                <option value="2">Moderator</option>
                <option value="3">Author</option>
            </select>
        </div>
        <input type="submit" value="Edit">
    </form>
</div>

<?php

            } else { // This user does not exists
              redirect($dashboard_home . '/users.php', '<div class="alert alert-danger" role="alert">
              This user does not exist, You will be redirected in 3 seconds
            </div>', 3);
            }

        } else { // if user is admin

            // you cant edit admin, so redirect
            redirect($dashboard_home);
        }

        } else { // userid is not given
            redirect($dashboard_home);
        }
        

    } // edit end here

    elseif($do == "update") {
        
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            
            $userid = $_POST['userid'];

            // fetch all new data
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? sha1($_POST['password']) : '';
            $user_status = $_POST['userstatus'];
            $user_type = $_POST['usertype'];

            $stmt = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();


            if($password == '') {
                $password = $row['password']; // DON'T FORGET: it is already hashed
            }

            // first, check if username is not taken
            $stmt = $conn->prepare("SELECT id, username FROM `users` WHERE username = ?");
            $stmt->execute(array($username));
            $row = $stmt->fetch();
            
            if($row['id'] != $userid) { // different ids (users) and same usernames.. duplicate
                $errArr[] = 'This userame is already taken';
            }

            // Then, check if email is not taken
            $stmt = $conn->prepare("SELECT id, email FROM `users` WHERE email = ?");
            $stmt->execute(array($email));
            $row = $stmt->fetch();
            
            if($row['id'] != $userid) { // different ids (users) and same emails.. duplicate
                $errArr[] = 'This email is already taken';
            }


            if(!isset($errArr)) { // if there are no errors, then update the user
                $stmt = $conn->prepare("UPDATE `users` SET username = :username, email = :email, password = :password, userStatus = :userstatus, userPermission = :userpermission WHERE id = :id");
                $stmt->execute(array(":username" => $username, ":email" => $email, ":password" => $password, ":userstatus" => $user_status, ":userpermission" => $user_type, ":id" => $userid));
                redirect($dashboard_home . '/users.php', '<div class="alert alert-success" role="alert">
                Successfully Updated the user\'s info, You will be redirected in 3 seconds
                </div>', 3);
            } else { // errors exist, so show them
                if(isset($errArr)) {
                    foreach($errArr as $err) {
                        echo '<div class="alert alert-danger" role="alert">' . $err . '</div>';
                    }
                    redirect($dashboard_home . '/users.php?do=edit&userid=' . $userid, '<div class="alert alert-danger" role="alert">You will be redirected in 3 seconds</div>', 3);
                }
            }
            
            

            

        } else { // if request method is not post 
            redirect($dashboard_home);
        }

    } // update ends here

    elseif($do == "add") {
        ?>

<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?do=insert'; ?>" method="POST">
        <div class="form-group row">
            <label for="username" class="col-sm-2 col-form-label">Username:</label>
            <div class="col-sm-10">
                <input type="text" name="username" class="form-control" id="username">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input type="text" name="email" class="form-control" id="email">
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="password">
            </div>
        </div>
        <div class="form-group">
            <label for="user-status">User's Status:</label>
            <select class="form-control" id="user-status" name="userstatus">
                <option value="1">Activated</option>
                <option value="0">Need Activation</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user-type">User's Type:</label>
            <select class="form-control" id="user-type" name="usertype">
                <option value="1">Adminstrator</option>
                <option value="2">Moderator</option>
                <option value="3">Author</option>
            </select>
        </div>
        <input type="submit" value="Add">
    </form>
</div>



<?php
    } // add ends here

    elseif($do == "insert") {

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            // fetch data
            $username = $_POST['username'];
            $email = $_POST['email'];
            $unsecure_password = $_POST['password'];
            $password = sha1($unsecure_password);
            $user_status = $_POST['userstatus'];
            $user_type = $_POST['usertype'];

            // check if input fields are not empty
            if($username != '' && $email != '' && $password != '') {

                // first, check if username is not taken
                $stmt = $conn->prepare("SELECT username FROM `users` WHERE username = ?");
                $stmt->execute(array($username));
                $count = $stmt->rowCount();
                
                if($count > 0) { // username is taken .. duplicate
                    $errArr[] = 'This userame is already taken';
                }

                // Then, check if email is not taken
                $stmt = $conn->prepare("SELECT email FROM `users` WHERE email = ?");
                $stmt->execute(array($email));
                $count = $stmt->rowCount();
                
                if($count > 0) { // email is taken.. duplicate
                    $errArr[] = 'This email is already taken';
                }


                if(!isset($errArr)) { // if there are no errors, then update the user
                    $stmt = $conn->prepare("INSERT INTO `users`(username, email, password, userStatus, userPermission) VALUES(:username, :email, :password, :userstatus, :userpermission)");
                    $stmt->execute(array(":username" => $username, ":email" => $email, ":password" => $password, ":userstatus" => $user_status, ":userpermission" => $user_type));
                    redirect($dashboard_home . '/users.php', '<div class="alert alert-success" role="alert">
                    Successfully Added the user\'s info, You will be redirected in 3 seconds
                    </div>', 3);
                } else { // errors exist, so show them
                    if(isset($errArr)) {
                        foreach($errArr as $err) {
                            echo '<div class="alert alert-danger" role="alert">' . $err . '</div>';
                        }
                        redirect($dashboard_home . '/users.php?do=add', '<div class="alert alert-danger" role="alert">You will be redirected in 3 seconds</div>', 3);
                    }
                }



        } else { // some input fields were empty
            redirect($dashboard_home . '/users.php?do=add', '<div class="alert alert-danger" role="alert">some input fields were empty, You will be redirected in 3 seconds</div>', 3);
        }



        } else { // request method is not post
            redirect($dashboard_home);
        }



    } // insert ends here




    include "includes/footer.php";

} else { // if the user is not admin or mod

    redirect($dashboard_home);

}


} else { // if user is not logged in
    redirect('/blog/login.php');
}