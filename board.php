<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
$_SESSION["uname"] = "";
$_SESSION["passwd"] = "";
?>
<!DOCTYPE html>
<html>
<head><title>Message Board Login</title></head>
<body>
    <div style="text-align: center;font-size: 20px">
    <div style="width: 100%; margin: 0 auto;font-size: larger"><b>Programming Assignment 4: A Message Board using PHP & Database </b></div><div style="margin: 6px"><b>(Developed by: Salman V. Siddique, UTA ID: 1001115361)</b></div>
     <hr>
    </div>
    <div style="text-align: center;width: 100%; margin: 0 auto;font-size: x-large"><b>Login</b></div></br></br>
    <table align="center">
        <tr><td align="center"><form action="Page2.php" method="post">
        <div align="center"><label>Username: <input type="text" id="uname" name="uname"></label></div><br/>
        <div align="center"><label>Password: <input type="password" id="passwd" name="passwd"></label></div><br/>
        <input type="submit"  value="Login">
    </form></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><form action="Page4.php" method="post">
        <input type="submit" value="New users must register here">
    </form></td></tr>
    </table>
</body>
</html>
