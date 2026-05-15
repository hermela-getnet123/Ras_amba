<?php

include("db.php");

$id = $_GET['id'];

$getBooking = "SELECT * FROM bookings WHERE id='$id'";
$result = mysqli_query($conn, $getBooking);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['updateBtn'])){

    $fullname = $_POST['fullname'];
    $newRoom = $_POST['room'];
    $nights = $_POST['nights'];

    // old room
    $oldRoom = $row['room'];

    // get new room price
    $priceQuery = "SELECT price FROM rooms
                   WHERE room_number='$newRoom'";

    $priceResult = mysqli_query($conn, $priceQuery);

    $priceData = mysqli_fetch_assoc($priceResult);

    $price = $priceData['price'];

    $total = $price * $nights;

    // update booking
    $update = "UPDATE bookings
               SET fullname='$fullname',
                   room='$newRoom',
                   nights='$nights',
                   total='$total'
               WHERE id='$id'";

    mysqli_query($conn, $update);

    // if room changed
    if($oldRoom != $newRoom){

        // old room available
        mysqli_query($conn,
        "UPDATE rooms
         SET status='Available'
         WHERE room_number='$oldRoom'");

        // new room booked
        mysqli_query($conn,
        "UPDATE rooms
         SET status='Booked'
         WHERE room_number='$newRoom'");
    }

    header("Location: admin.php");
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Booking</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

<div class="card p-4">

<h2>Edit Booking</h2>

<form method="POST">

<div class="mb-3">

<label>Customer Name</label>

<input type="text"
name="fullname"
class="form-control"
value="<?php echo $row['fullname']; ?>">

</div>

<div class="mb-3">

<label>Room</label>

<select name="room" class="form-select">

<?php

$rooms = mysqli_query($conn,
"SELECT * FROM rooms");

while($room = mysqli_fetch_assoc($rooms)){

?>

<option value="<?php echo $room['room_number']; ?>"

<?php
if($room['room_number'] == $row['room']){
    echo "selected";
}
?>

>

Room <?php echo $room['room_number']; ?>

</option>

<?php
}
?>

</select>

</div>

<div class="mb-3">

<label>Nights</label>

<input type="number"
name="nights"
class="form-control"
value="<?php echo $row['nights']; ?>">

</div>

<button type="submit"
name="updateBtn"
class="btn btn-primary">

Update Booking

</button>

</form>

</div>

</div>

</body>
</html>