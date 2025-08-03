<?php session_start() ?>
<?php require_once('../inc/connection.php'); ?>

<?php /*
//checking if a user is loged
if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
}*/
?>
<?php 

$erros = array();

if(isset($_POST['submit'])){

    //checking required first name
    if(empty(trim($_POST['first_name']))){
        $erros[0] = 'First Name is required';
    }

    //cheching requird last name
    if(empty(trim($_POST['last_name']))){
        $erros[1] = 'Last name is required';
    }

    //cheching requird email
    if(empty(trim($_POST['email']))){
        $erros[2] = 'Email is required';
    }

    //checking requird password
    if(empty(trim($_POST['password']))){
        $erros[3] = 'Password is required';
    }

    $erros[4]= ' ';
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

        <form action="add_user.php" name="add_user" method="post" class="userform">

            <p>
                <lable for="">First Name :</lable>
                <input type="text" name="first_name">
                <?php 
                    if(!empty($erros)){
                        echo  $erros[0];
                    }else{
                        echo $erros[0];
                    }
                ?>
            </p>

            <p>
                <lable for="">Last Name :</lable>
                <input type="text" name="last_name">
                <?php 
                    if(!empty($erros)){
                        echo $erros[1];
                    }else{
                        echo '';
                    }
                ?>
            </p>

            <p>
                <lable for="">email :</lable>
                <input type="email" name="email">
                <?php
                    if(!empty($erros)){
                        echo $erros[2];
                    }else{
                        echo " ";
                    }
                ?>
            </p>

            <p>
                <lable for="">Password :</lable>
                <input type="password" name="password">
                <?php
                    if(!empty($erros)){
                        echo $erros[3];
                    }else{
                        echo '';
                    }
                ?>
            </p>

            <p>
                <lable for="">&nbsp;</lable>
                <button type="submit" name="submit">Save</botton>
            </p>




        
        </form>



    </main>
    
</body>
</html>