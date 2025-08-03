<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>

<?php 
    //check submition
    if(isset($_POST['submit'])){

            $errors = array();

        //check username and password enterd
        if(!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1){
            $errors = 'Username is missing / Invalid';
        }

        if(!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1){
            $errors = 'password is missing / Invalid';
        }

        //check if there are any errors in the form
        if(empty($errors)){
            //save udername and password in variable
            $email    = mysqli_real_escape_string($connection, $_POST['email']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $hashed_password = sha1($password);

        //prepare database query

            $query = "SELECT * FROM user
                      WHERE email = '{$email}'
                      AND password = '{$hashed_password}'
                      LIMIT 1 ";

        $result_set = mysqli_query($connection, $query);

            if($result_set){

                if(mysqli_num_rows($result_set) ==1){
                
                  // $user = mysqli_fetct_assoc($result_set);
                    $user = mysqli_fetch_assoc($result_set);


                    //create session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['first_name'];

                    //update last loggin
                    $query2 = "UPDATE user SET last_login = now()";
                    $query2 .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";

                    $result_set2 = mysqli_query($connection, $query2);

                    if(!$result_set2){
                        die("Database Query Faied.");
                    }



                    header('location: users.php');
                    //header('Location: users.php');
                    
                    
                }else{
                    //username and password invalid
                    $errors[] = 'Invalid Username / Password';
                }

            }else{
                $errors[] = 'Database query failed';
            }

         }

    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div class ="login">
        

        <form action="index.php" method="post">

            <fieldset><legend><h1>Login</h1></legend>

                <?php 
                    if(isset($errors) && !empty($errors)){
                        echo '<p class="error">Incorrect username or password</p>'  ;
                    }
                ?>
                    <!---->
                    <p class="para">
                        <lable >Username :</lable> 
                        <input type="text" name="email" id="" placeholder="Email Address">
                    </p>

                    <p class="para">
                        <lable for="">Password &nbsp:</lable>
                        <input type="password" name="password" id="" placeholder="password">
                    </p>

                    <p class="para"><br>
                        <button type="submit" name="submit">Log In</button>
                    </p>

                    <?php
                        if(isset($_GET['logout'])){
                            echo '<p class="info">You have succesfully loged out from the system</p>';
                        }
                    ?>


            
            </fieldset>

        </form>

    </div>
    
</body>
</html>
<?php mysqli_close($connection) ?>