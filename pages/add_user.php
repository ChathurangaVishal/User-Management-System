<?php session_start() ?>
<?php require_once('../inc/connection.php'); ?>

<?php 
//checking if a user is loged
if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
}
?>
<?php 

$erros = array();

$first_name = '';
$last_name = '';
$email = '';
$password = '';

if(isset($_POST['submit'])){

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    //FORM VALIDATION 
    $req_fields = array('first_name', 'last_name', 'email', 'password');

    foreach($req_fields as $field) {
        if(empty(trim($_POST[$field]))){
            $erros[] = $field . ' is required';
        }
    }

/*
    //checking required first name
    if(empty(trim($_POST['first_name']))){
        $erros[] = 'First Name is required';
    }

    //cheching requird last name
    if(empty(trim($_POST['last_name']))){
        $erros[] = 'Last name is required';
    }

    //cheching requird email
    if(empty(trim($_POST['email']))){
        $erros[] = 'Email is required';
    }

    //checking requird password
    if(empty(trim($_POST['password']))){
        $erros[] = 'Password is required';
    }

   // $erros[4]= ' ';
   */


     //MAX LENGTH CHECK
     $max_length_feilds = array('first_name' => 50, 'last_name' => 50, 'email' => 100, 'password' => 40);

     foreach($max_length_feilds as $field => $max_length) {
         if(strlen(trim($_POST[$field])) >= $max_length){
             $erros[] = $field . ' must be less than ' . $max_length . ' characters';
         }
     }
 
     
     // Function to validate email address
     function validate_email($email) {
         // Remove leading and trailing whitespace
         $email = trim($email);
         // Validate email address
         if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
             return true; // Valid email
         } else {
             return false; // Invalid email
         }
     }

     //check if email address alredy exists
     $email = mysqli_real_escape_string($connection, $_POST['email']);

     $query = "SELECT * FROM user WHERE email = '{$email}' LIMIT 1";

     $result_set = mysqli_query($connection, $query);

     if($result_set){

        if(mysqli_num_rows($result_set) == 1){
            $erros[] = 'Email address allready exist';
        }
     }

    // header('Location: index.php');

     if(empty($erros)){
        //no error found... adding new record

        $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        //email address is alredy sanitized

        $hashed_password = sha1($password);

        /*
        //SQL query
        $query = "INSERT INTO user(";
        $query .= "first_name, last_name, email, password, is_deleted";
        $query .= ")VALUES(";
        $query .= "'{$first_name}', '{$last_name}', '{$email}','{$hashed_password}',0";
        $query .= ")";
        */
        $query = "INSERT INTO user (first_name, last_name, email, password, is_deleted) VALUES ('{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}', 0)";

        $result = mysqli_query($connection, $query);

        if($result){
            //query successfull...
            header('Location: users.php?user_added=true');
        }else{
            $erros[] = 'Failed to add the new record';
        }

     }





}
?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new Users</title>
    <link rel="stylesheet" href="../css/user.css">
   <!-- <link rel="stylesheet" href="../css/main.css">-->

</head>
<body>
    <header>
        <div class="appname">User Management System</div>
        <div class="loggedin">Welcome <?php echo $_SESSION['name']; ?> <br>
        <a href="Logout.php">Log Out</a></div> 

    </header>
    <main>
    <h1>Add new users</h1><spain><a href="users.php"> Back to users page</a></spain>

        <?php
        
            if(!empty($erros)){
                echo '<div class = "errmsg">';
                echo '<b>There were error(s) on your form.</b><br>';
                foreach ($erros as $error){
                    echo $error . '<br>';
                }
                echo '</div>';
            }
        
        ?>


        <form action="add_user.php" name="add_user" method="post" class="userform">

            <p>
                <lable for="">First Name :</lable>
                <input type="text" name="first_name" <?php echo 'value = "' . $first_name .'"'; ?>>
                
            </p>

            <p>
                <lable for="">Last Name :</lable>
                <input type="text" name="last_name" <?php echo 'value = "' . $last_name .'"'; ?>>
               
            </p>

            <p>
                <lable for="">email :</lable>
                <input type="email" name="email" <?php echo 'value = "' . $email .'"'; ?>>
                
            </p>

            <p>
                <lable for="">Password :</lable>
                <input type="password" name="password">
                
            </p>

            <p>
                <lable for="">&nbsp;</lable>
                <button type="submit" name="submit">Save</botton>
            </p>




        
        </form>



    </main>
    
</body>
</html>