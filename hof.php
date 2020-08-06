<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport", initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RAC challenge 2.0</title>
    <style>
    table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
    </style>
</head>
<body>
<header id="mn-hdr">
<h1 style="text-align:center;font-size:5em;font-weight:300;margin:0;margin-bottom:50px;padding:0">RAC challenge 2.0</h1>
</header>

<?php
$host = "localhost";
$user = "25517"; 
$password = "123abc456"; 
$dbname = "25517";

$conn = mysqli_connect($host, $user, $password,$dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT name,rollno,attempts_count FROM hall_of_fame where successful_yet=True";
$result = mysqli_query($conn, $sql);
?>

<?php if (mysqli_num_rows($result) > 0) : ?> 
<h2>successful ones:</h2>
<table>
<tr>
    <th>Name</th>
    <th>Roll no</th>
    <th>no of attempts</th>
</tr>
<?php
    while($row = mysqli_fetch_assoc($result)) {
        $name=$row["name"];
        $roll=$row["rollno"];
        $at_count=$row["attempts_count"];
        echo "<tr><td>$name</td><td>$roll</td><td>$at_count</td></tr>";
    }
?>
</table>
<?php else : ?>
    echo "0 results";
<?php endif ?>

<?php
$sql = "SELECT name,rollno,attempts_count FROM hall_of_fame where successful_yet=False";
$result = mysqli_query($conn, $sql);
?>

<?php if (mysqli_num_rows($result) > 0) : ?> 
<h2>unsuccessful ones:</h2>
<table>
<tr>
    <th>Name</th>
    <th>Roll no</th>
    <th>no of attempts</th>
</tr>
<?php
    while($row = mysqli_fetch_assoc($result)) {
        $name=$row["name"];
        $roll=$row["rollno"];
        $at_count=$row["attempts_count"];
        echo "<tr><td>$name</td><td>$roll</td><td>$at_count</td></tr>";
    }
?>
</table>
<?php else : ?>
    echo "0 results";
<?php endif ?>

<?php
mysqli_close($conn);
?>
</body>
</html>