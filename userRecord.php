<?php

session_start();
$accountnumber = $_SESSION['accountNum'];
$password = $_SESSION['passwordNum'];

$query = "SELECT `userID` FROM `userAccount` WHERE `accountnumber` LIKE '" . $accountnumber . "' AND `password` LIKE '" . $password . "'";
if (!($database = mysqli_connect("localhost", "hunter yang", "hunter1115")))
    die("Could not connect to database </body></html>");
if (!mysqli_select_db($database, "finalProject"))
    die("Could not open products database </body></html>");
if (!($result = mysqli_query($database, $query))) {
    print("<p>Could not execute query!</p>");
}

$id = mysqli_fetch_row($result);
foreach ($id as $userid);
$userID = intval($userid); //userID

$query = "SELECT `store`,`goodsKind`,`discount`,`price`,`time`,`method` FROM `userOrderDetail` WHERE `userID` LIKE '" . $userID . "'";
if (!($result = mysqli_query($database, $query))) {
    print("<p>userRecord Error</p>");
}
print('<div id="Logbutton" onclick="PrePage(this)"><strong>previous page</strong></div>');
print("<table class='userBuy'>");
print('<tr><td class = "td1">店家</td><td class = "td1">商品</td><td class = "td1">優惠方案</td><td class = "td1">金額(元)</td><td class = "td1">時間</td><td class = "td1">訂購方式</td></tr>');
while($list = mysqli_fetch_row($result)){
    print('<tr>');
    foreach($list as $value){
        print('<td class = "td2">'.$value.'</td>');
    }
    print('<tr>');
}

print("</table>");