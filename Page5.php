<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
if(isset($_POST["newuname"],$_POST["newpasswd"],$_POST["fullname"],$_POST["email"]) and $_POST["newuname"].trim()!="")
{
    $uname = $_POST["newuname"].trim();
    $dbname = dirname($_SERVER["SCRIPT_FILENAME"]) . "/MessageBoardDB.sqlite";
    $dbh = new PDO("sqlite:$dbname");
    $dbh->beginTransaction();
    $stmt = $dbh->prepare('select * from users where username = ?');
    $stmt->execute(array($uname));
    $val = $stmt->fetchAll();
    if(count($val) == 0)
    {
        $stmt = $dbh->prepare('insert into users values(?,?,?,?)');
        $stmt->execute(array($uname,md5($_POST["newpasswd"].trim()),$_POST["fullname"].trim(),$_POST["email"].trim()));
        $dbh->commit();
        header("Location:board.php");
    }
    else
    {
        header("Location:Page4.php");
    }
}
else
{   
    header("Location:Page4.php");
}
?>