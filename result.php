<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport", initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RAC challenge 2.0</title>
    <style>
        #resultok{
        width:400px;
        margin:auto;
        padding:20px 10px;
        color: white;
        font-size:1.3em;
        border-radius: 10px;
        text-align: center;
        text-decoration: none;
        display: block;
        background-color:green;
        margin-bottom:30px;
        }
        #resultf{
        width:400px;
        margin:auto;
        padding:20px 10px;
        color: white;
        font-size:1.3em;
        border-radius: 10px;
        text-align: center;
        text-decoration: none;
        display: block;
        background-color:red;
        margin-bottom:30px;
    }
    ol{
    font-size:1.4em;
    line-height:1.5;
    margin-left:20vw;
}
#description{
    font-size:1.6em;
    text-align:center;
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
$con = mysqli_connect($host, $user, $password,$dbname);
$ses=$_COOKIE["session"];
$ses=mysqli_real_escape_string($con,$ses);
$query="select * from attempt_data where cookie = '".$ses."'";
$sql=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($sql);
$then=strtotime($row["time"]);
$now= time();
$diff=$now-$then;
if ($diff<=6)
{
    $soln=$_REQUEST["ans"];
    $soln=rtrim($soln," }");
    $soln=ltrim($soln,"{ ");
    $sub_words=explode(" ",$soln);
    $words=unserialize($row["words"]);
    $passed=TRUE;
    for($i=0;$i<10;$i++)
    {
        if ($words[$i]!=$sub_words[$i])
        {
            $passed=FALSE;
            break;
        }
    }
}
else $passed=FALSE;
?>
<?php if($passed): ?>
<h2 id="resultok">Congratulations you have successfully earned bragging right !!</h2>
<?php 
if (isset($_REQUEST["name"]) && isset($_REQUEST["roll"]))
{
    $name=mysqli_real_escape_string($con,$_REQUEST["name"]);
    $roll=mysqli_real_escape_string($con,$_REQUEST["roll"]);
    $result = mysqli_query($con,"SELECT * FROM hall_of_fame WHERE name='$name' and rollno='$roll'");
    if( mysqli_num_rows($result) > 0) {
    mysqli_query($con,"UPDATE hall_of_fame SET attempts_count=attempts_count+1,successful_yet=True WHERE (name='$name' AND rollno='$roll')");
    }
    else
    {
        mysqli_query($con,"INSERT INTO hall_of_fame (name,rollno,attempts_count,successful_yet) VALUES ('$name','$roll','1',True)");
    }
}
?>
<?php else : ?>
<h2 id="resultf">sorry you are still a noob!</h2>
<div id='description'>
The correct unshuffled words were:
</div>
<ol>
<?php foreach($words as $word) echo "<li>$word</li>"; ?>
</ol>
<?php 
if (isset($_REQUEST["name"]) and isset($_REQUEST["roll"]))
{
    $name=mysqli_real_escape_string($con,$_REQUEST["name"]);
    $roll=mysqli_real_escape_string($con,$_REQUEST["roll"]);
    $result = mysqli_query($con,"SELECT * FROM hall_of_fame WHERE name='$name' and rollno='$roll'");
    if( mysqli_num_rows($result) > 0) {
    mysqli_query($con,"UPDATE hall_of_fame SET attempts_count=attempts_count+1,successful_yet=False WHERE (name='$name' AND rollno='$roll')");
    }
    else
    {
        mysqli_query($con,"INSERT INTO hall_of_fame (name,rollno,attempts_count,successful_yet) VALUES ('$name','$roll','1',FALSE)");
    }
}
?>
<?php endif ;?>
<br>
<br>
<footer style="text-align:center; font-size=1.3em;color:gray">
&copy;2019 Pukar Giri
</footer>
</body>
</html>