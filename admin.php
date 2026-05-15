<?php
session_start();
include("db.php");

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $getRoom = "SELECT room FROM bookings WHERE id='$id'";
    $roomResult = mysqli_query($conn, $getRoom);

    $roomData = mysqli_fetch_assoc($roomResult);

    $roomNumber = $roomData['room'];

    mysqli_query($conn,
    "UPDATE rooms
     SET status='Available'
     WHERE room_number='$roomNumber'");

    mysqli_query($conn,
    "DELETE FROM bookings WHERE id='$id'");

    header("Location: admin.php");
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

<h1 class="mb-4">Hotel Booking Management</h1>

<a href="logout.php"
class="btn btn-dark mb-3">

Logout

</a>

<form method="GET" class="mb-4">

<div class="row">

<div class="col-md-10">

<input type="text"
name="search"
class="form-control"
placeholder="Search customer or room number">

</div>

<div class="col-md-2">

<button type="submit"
class="btn btn-dark w-100">

Search

</button>

<a href="admin.php"
class="btn btn-secondary w-100 mt-2">

Show All

</a>

</div>

</div>

</form>

<table class="table table-bordered table-hover bg-white">

<thead class="table-dark">

<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Room</th>
    <th>Nights</th>
    <th>Total</th>
    <th>Date</th>
    <th>Action</th>
</tr>

</thead>

<tbody>

<?php

if(isset($_GET['search'])){

    $search = $_GET['search'];

    $query = "SELECT * FROM bookings
              WHERE fullname LIKE '%$search%'
              OR room LIKE '%$search%'
              ORDER BY id DESC";

}else{

    $query = "SELECT * FROM bookings
              ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['room']; ?></td>

<td><?php echo $row['nights']; ?></td>

<td>$<?php echo $row['total']; ?></td>

<td><?php echo $row['created_at']; ?></td>

<td>

<a href="admin.php?delete=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm">

Delete

</a>

<a href="edit.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary btn-sm">

Edit

</a>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

</div>

</body>
</html>