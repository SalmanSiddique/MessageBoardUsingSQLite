<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Message Listings</title>
    </head>
    <body>
            <table border="1" align="center" style="width: 70%">
             <tr><td colspan="2"><div style="text-align: center; width: 100%; margin: 0 auto;font-size: xx-large"><b>Message Board</b></div></td></tr>
             <tr>
                 <td style="vertical-align: central;padding: 10px;width: 50%" align="center">
                     <form action="Page3.php" method="post">
                        <input type="submit" name="newmsg" value="New Message"/>
                     </form>
                 </td>
                 <td style="vertical-align: central;padding: 10px" align="center">
                    <form action="board.php" method="post">
                    <input type="submit" name="logout" value="Logout"/>
                    </form>
                 </td>
                 </tr>
        </table><hr></br>
        <div style="text-align: center;width: 100%; margin: 0 auto;font-size:x-large"><b>Messages</b></div></br></br>
        <?php
function displayPosts()
{
    try {
    $dbname = dirname($_SERVER["SCRIPT_FILENAME"]) . "/MessageBoardDB.sqlite";
    $dbh = new PDO("sqlite:$dbname");
    $dbh->beginTransaction();
    $stmt = $dbh->prepare('select * from posts');
    $stmt->execute();
    $posts = $stmt->fetchAll();
    $txt = '';
    foreach($posts as $post)
    {
       $stmt = $dbh->prepare('select fullname from users where username = ?');
       $stmt->execute(array($post['postedby']));
       $val = $stmt->fetchAll();
       $replyid=trim($post['follows']);
       $midtxt ='';
       $rs=5;
       if($replyid!="")
       {
            $midtxt = '<tr><td align="center" style="font-weight: bold">Reply for MessageID:</td><td align="center">'.$post['follows'].'</td></tr>';
            $rs=6;
       }
       $txt.='<table align="center" width="80%" border="1"><tr><td align="center" style="font-weight: bold;width:20%">MessageID:</td><td align="center">'.$post['id'].'</td><td rowspan="'.$rs.'" align="center" style="width:10%"><input type="button" onclick=location.href="Page3.php?originalmsgid='.$post['id'].'" value="Reply"></td></tr>'.$midtxt.'<tr><td align="center" style="font-weight: bold;width:20%">Username:</td><td align="center">'.$post['postedby'].'</td></tr><tr><td align="center" style="font-weight: bold;width:20%">Full Name:</td><td align="center">'.$val[0][0].'</td></tr><tr><td style="font-weight: bold;width:20%" align="center">DateTime:</td><td align="center">'.$post['datetime'].'</td></tr><tr><td style="font-weight: bold;width:20%" align="center">Message:</td><td align="center">'.$post['message'].'</td></tr></table></br></br>';
        }
        echo $txt;
    } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
    }
}

if(isset($_POST["uname"],$_POST["passwd"]) and trim($_POST["passwd"])!="" and trim($_POST["uname"])!="")
{
    $uname = trim($_POST["uname"]);
    $pass =  trim($_POST["passwd"]);

    //DBLogic
    try {
    $dbname = dirname($_SERVER["SCRIPT_FILENAME"]) . "/MessageBoardDB.sqlite";
    $dbh = new PDO("sqlite:$dbname");
    $dbh->beginTransaction();
    $stmt = $dbh->prepare('select * from users where username = ? AND password = ?');
    $stmt->execute(array($uname,md5($pass)));
    $val = $stmt->fetchAll();
    if(count($val) == 1)
    {
        $_SESSION["uname"] = $uname;
        $_SESSION["passwd"] = $pass;
        displayPosts();
    }
    else
    {
        header("Location:board.php");
    }
    } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
    }
}
else if(isset($_POST["newmsgtxt"]) and trim($_POST["newmsgtxt"])!="")
{
    $msgtxt = trim($_POST["newmsgtxt"]);
    $uname = trim($_SESSION["uname"]);
    try {
    $dbname = dirname($_SERVER["SCRIPT_FILENAME"]) . "/MessageBoardDB.sqlite";
    $dbh = new PDO("sqlite:$dbname");
    $dbh->beginTransaction();
    $stmt = $dbh->prepare("SELECT datetime('NOW')");
    $stmt->execute();
    $data = $stmt->fetchAll();
    $now_SQLite = trim($data[0][0]);
    $stmt = $dbh->prepare('insert into posts values(?,?,?,?,?)');
    $stmt->execute(array(uniqid(),$uname,$_SESSION["originalmsgid"],$now_SQLite,$msgtxt));
    $dbh->commit();
    displayPosts(); 
    } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
    }
}
else
{
    header("Location:board.php");
}
?>
    </body>
</html>
