<?php session_start() ?>
<?php require_once('../inc/connection.php'); ?>

<?php 
//checking if a user is loged
if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
}

$user_list = ''; 
$query = "SELECT * FROM user WHERE is_deleted=0 ORDER BY first_name"; 
$users = mysqli_query($connection, $query);

if ($users){
    
    while($user = mysqli_fetch_assoc($users)){
        $user_list .= "<tr>";
        $user_list .= "<td>{$user['first_name']}</td>";
        $user_list .= '<td>' . $user['last_name'] . '</td>';
        $user_list .= "<td>{$user['last_login']}</td>";
        $user_list .= "<td><a href=\"modify_user.php?user_id={$user['id']}\">Edit</a></td>";
        $user_list .= "<td><a href=\"delete_user.php?user_id={$user['id']}\">Delete</a></td>";
        $user_list .= "</tr>";
    }
    //echo "success";


}else{
    echo "Database Query Failed";
}

?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="../css/user.css">

</head>
<body>
    <header>
        <div class="appname">User Management System</div>
        <div class="loggedin">Welcome <?php echo $_SESSION['name']; ?> <br>
        <a href="Logout.php">Log Out</a></div> 

    </header>
    <main>
    <h1>users</h1><spain><a href="add_user.php"> Add user</a></spain>

    <table class="masterlist">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Last Login</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php echo $user_list; ?>

    </table>



    </main>
    
</body>
</html>