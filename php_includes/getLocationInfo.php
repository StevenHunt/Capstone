<?php
$q = intval($_GET['q']);

$con = mysqli_connect('localhost','uname','password','test');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

$sql="SELECT * FROM mytable WHERE zip = '".$q."'";
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    echo $row['city'] . '-' . $row['state'];
}
mysqli_close($con);
?>
