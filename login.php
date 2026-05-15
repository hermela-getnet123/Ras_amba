<?php
session_start();
include("db.php");

if(isset($_POST['loginBtn'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admins
              WHERE username='$username'
              AND password='$password'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        $_SESSION['admin'] = $username;

        header("Location: admin.php");
        exit();

    }else{

        echo "<script>alert('Invalid Login');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark">

<div class="container">

<div class="row justify-content-center align-items-center vh-100">

<div class="col-md-4">

<div class="card shadow p-4">

<h2 class="text-center mb-4">Admin Login</h2>

<form method="POST">

<div class="mb-3">

<label>Username</label>

<input type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input type="password"
name="password"
class="form-control"
required>

</div>

<button type="submit"
name="loginBtn"
class="btn btn-dark w-100">

Login

</button>

</form>

</div>

</div>

</div>

</div>

</body>
</html>