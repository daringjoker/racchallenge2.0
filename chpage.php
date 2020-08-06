<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport", initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RAC challenge 2.0</title>
    <style>
    input[type=text], select, textarea {
  width: 75vw;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: none;
}

label {
    font-size:1.4em;
  padding: 12px 12px 12px 0;
  display: inline-block;
}
input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top:20px;
}

input[type=submit]:hover {
  background-color: #45a049;
}
input[type=submit]:disabled {
  background-color: gray;
}
#instruction{
    font-size:1.6em;
    text-align:center;
}
ol{
    font-size:1.4em;
    line-height:1.5;
    margin-left:20vw;
}
form{
    width:75vw;
    margin:auto;
}
p{
        width:350px;
        margin:auto;
        padding:20px 10px;
        color: white;
        font-size:1.3em;
        border-radius: 10px;
        text-align: center;
        text-decoration: none;
        display: block;
        background-color:green;
    }
</style>
</head>
<body>
<header id="mn-hdr">
<h1 style="text-align:center;font-size:5em;font-weight:300;margin:0;margin-bottom:50px;padding:0">RAC challenge 2.0</h1>
</header>
<div id="instruction">
unscrammble these words and give me the result in the form {word1 word2 word3...word10} within 6 seconds
</div>
<ol>
<?php
$file_arr = file("wordlist.txt");
$last_arr_index = count($file_arr)-1;
$words=array();
for($x=0;$x<10;$x++)
{
    $rword = $file_arr[rand(0, $last_arr_index)];
    $rword=rtrim($rword);
    $rword=ltrim($rword);
    array_push($words,$rword);
    echo "<li> ".str_shuffle($rword)." </li>";
}
$host = "localhost";
$user = "25517"; 
$password = "123abc456"; 
$dbname = "25517";
$random=md5(rand(0,10000));
$ck=$random.md5(time());
setcookie("session",$ck);
$con = mysqli_connect($host, $user, $password,$dbname);
$sql = "INSERT INTO attempt_data(cookie,words) VALUES('".$ck."','".serialize($words)."')";
mysqli_query($con,$sql);
?>
</ol>
<p id="timer">You have 6 seconds left.</p>
<form action="./result.php" method="post">
<label for="soln">My solution</label> <br>
<textarea rows=5 name="ans" id="soln">{word1 word2 word3...word10}</textarea> <br>
<label for="name">Engineer's name</label> <br>
<input type="text" name="name" id="name" placeholder="your name here"> <br>
<label for="roll">Rollno</label> <br>
<input type="text" name="roll" id="roll" placeholder="your full campus roll no here eg THA074BEX025"> <br>
<input type="submit" id="sbmt" value="submit">
</form>
<script type="text/javascript">
    var timeleft = 6;
    var Timer = setInterval(function(){
    timeleft--;
    document.getElementById("timer").textContent = "You have "+timeleft+" seconds left.";
    if(timeleft <= 0){
        clearInterval(Timer);
        document.getElementById("timer").textContent = "Sorry too late ..";
        document.getElementById("sbmt").disabled=true;
        }
    },1000);
</script>
<br>
<br>
<footer style="text-align:center; font-size=1.3em;color:gray">
&copy;2019 Pukar Giri
</footer>

</body>
</html>