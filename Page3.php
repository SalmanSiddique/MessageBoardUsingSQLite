<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
if(isset($_GET["originalmsgid"]) and trim($_GET["originalmsgid"])!="")
{
    $_SESSION["originalmsgid"] = trim($_GET["originalmsgid"]);
}
else
{
    $_SESSION["originalmsgid"] = NULL;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Post New Message</title>
    </head>
    <body>
        <table border="1" align="center" style="width: 70%">
             <tr><td colspan="2"><div style="text-align: center; width: 100%; margin: 0 auto;font-size: x-large"><b>Post New Message</b></div></td></tr>
             <tr>
                 <td>
                     <form action="Page2.php" method="post">
                        <table align="center"><tbody><tr><td>
                            <label style="vertical-align: central">Enter Message: </label>
                        </td>
                        <td><textarea name="newmsgtxt" rows="4" cols="50"></textarea></td>
                        <td><input type="submit" value="Post Message"/></td>
                        </tr></tbody></table>
                    </form>
                 </td>
                 </tr>
        </table>
    </body>
</html>
