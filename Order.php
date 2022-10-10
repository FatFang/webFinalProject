<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//user
date_default_timezone_set('Asia/Taipei');
session_start();
$accountnumber = $_SESSION['accountNum'];
$password = $_SESSION['passwordNum'];
//訂單資訊
$name = $_POST['name'];
$phone = $_POST['phone'];
$gmail = $_POST['mail'];
$goodsKind = $_POST['goodsKind'];

$formNum = $_POST['formNum'];
$spaceNum = $_POST['spaceNum']; //店家代號（1 ~ 4）
$sendWay = $_POST['sendWay']; //1 -> 直接下訂  2 -> 配對

$store = "";
if ($spaceNum == 1) {
    $store = "麥當勞";
} else if ($spaceNum == 2) {
    $store = "星巴克";
} else if ($spaceNum == 3) {
    $store = "ABC-Mart";
} else if ($spaceNum == 4) {
    $store = "GU";
}

$storeMail = "";
if ($spaceNum == 1) {
    $storeMail  = "ryan601006@gmail.com"; //麥當勞
} else if ($spaceNum == 2) {
    $storeMail = "puma8807@gmail.com"; //星巴克
} else if ($spaceNum == 3) {
    $storeMail  = "gbossfamily2@gmail.com"; //ABC-Mart
} else if ($spaceNum == 4) {
    $storeMail  = "ekids178413@gmail.com"; //GU
}


$discount = "";
$money = 0;
if ($formNum == 1) {
    $discount = "買1送1";
    $money = 70;
} else if ($formNum == 2) {
    $discount = "加1元多1份";
    $money = 61;
} else if ($formNum == 3) {
    $discount = "第二杯8折";
    $money = 176;
} else if ($formNum == 4) {
    $discount = "第二杯半價";
    $money = 210;
} else if ($formNum == 5) {
    $discount = "指定款式 任兩雙鞋 打8折";
    $money = 2880;
} else if ($formNum == 6) {
    $discount = "襪子 兩捆7折";
    $money = 84;
} else if ($formNum == 7) {
    $discount = "第二件衣服 打75折";
    $money = 1330;
} else if ($formNum == 8) {
    $discount = "第二件9折";
    $money = 1824;
}
$moneytemp = $money;

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

if ($sendWay == 1) {
    $mail = new PHPMailer();

    // Server 資訊
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->CharSet = "utf-8";

    // 登入
    $mail->Username = "test09090808s@gmail.com"; //帳號
    $mail->Password = "test1234test"; //密碼

    // 寄件者
    $mail->From = "test09090808s@gmail.com"; //寄件者信箱
    $mail->FromName = "test1234test"; //寄件者姓名
    // 郵件資訊
    $mail->Subject = "直接下訂成功！"; //設定郵件標題
    $mail->IsHTML(true); //設定郵件內容為HTML

    $mail->Body = "
        <p><strong>以下是您的個人資料及訂單：</strong></p>
        <p>姓名:" . $name . "</p>
        <p>行動電話:" . $phone . "</p>
        <p>信箱:" . $gmail . "</p>
        <p>商品:" . $goodsKind . "</p>
        <p>優惠方案:" . $discount . "</p>
        <p>價錢:" . $money . "</p>
        <p>店家:" . $store . "</p>" . date('Y-m-d H:i:s');
    $mail->addAddress($gmail, $name);
    $mail->addReplyTo($gmail, 'test09090808s@gmail.com');

    $mail->send();

    //將訂單傳給店家
    $mail->clearAddresses();

    $mail->Subject = "顧客訂單(直接下單)"; //設定郵件標題
    $mail->Body = "
        <p><strong>以下是顧客的個人資料及訂單：</strong></p>
        <p>姓名:" . $name . "</p>
        <p>行動電話:" . $phone . "</p>
        <p>信箱:" . $gmail . "</p>
        <p>商品:" . $goodsKind . "</p>
        <p>優惠方案:" . $discount . "</p>
        <p>應付金額:" . $money . "元</p>
        <p>店家:" . $store . "</p>" . date('Y-m-d H:i:s');
    $mail->addAddress($storeMail, $store);
    $mail->addReplyTo($storeMail, 'test09090808s@gmail.com');

    if ($mail->send()) {
        $query = "INSERT INTO `userOrderDetail` (`space`, `userID`, `store`, `goodsKind`, `discount`, `price`, `time`,`method`) VALUES (NULL, '" . $userID . "', '" . $store . "', '" . $goodsKind . "', '" . $discount . "', '".$money."','" . date('Y-m-d H:i:s') . "' , '直接下單')";
        if (!($result = mysqli_query($database, $query))) {
            print("<p>error4</p>");
        }
        print('<div id="Logbutton" onclick="PrePage(this)"><strong>previous page</strong></div>
            <div class="orderData" data-space="1">
                <div class="orderDetail">名字 : ' . $name . '
                </div>
                <div class="orderDetail">電話 : ' . $phone . '
                </div>
                <div class="orderDetail">Mail: ' . $gmail . '
                </div>
                <div class="orderDetail">商品 : ' . $goodsKind . '
                </div>
                <div class="orderDetail">店家 : ' . $store . '
                </div>
                <div class="orderDetail">折扣方案: ' . $discount . '
                </div>
                <div class="orderDetail">應付金額:' . $money . '
                元</div>
            </div>');
    } else {
        print('<p>mail fail</p>');
    }
} else if ($sendWay == 2) {
    $query = "SELECT * FROM `mealOrder` WHERE `storeNum` LIKE '" . $store . "' AND `discount` LIKE '" . $discount . "'";
    if (!($result = mysqli_query($database, $query))) {
        print("<p>error1</p>");
    } else {
        $money = $moneytemp / 2;
        $row = mysqli_fetch_row($result);
        if ($row == "") { //如果沒有其他訂單 -> 直接插入
            $query = "INSERT INTO `mealOrder` (`space`, `userID`, `name`, `phone`, `mail`, `storeNum`, `goodsKind`, `discount`) VALUES (NULL, '" . $userID . "', '" . $name . "', '" . $phone . "', '" . $gmail . "', '" . $store . "', '" . $goodsKind . "', '" . $discount . "')";
            if (!($result = mysqli_query($database, $query))) {
                print("<p>error2</p>");
            } else {
                //將訂單儲存到集中管理的備份處
                $query = "INSERT INTO `userOrderDetail` (`space`, `userID`, `store`, `goodsKind`, `discount`, `price`, `time` , `method`) VALUES (NULL, '" . $userID . "', '" . $store . "', '" . $goodsKind . "', '" . $discount . "', '".$money."', '" . date('Y-m-d H:i:s') . "' , '優惠配對中' )";
                if (!($result = mysqli_query($database, $query))) {
                    print("<p>error3</p>");
                }
                print('<div id="Logbutton" onclick="PrePage(this)"><strong>previous page</strong></div>
            <div class="orderData" data-space="1">
                <div class="orderDetail">名字 : ' . $name . '
                </div>
                <div class="orderDetail">電話 : ' . $phone . '
                </div>
                <div class="orderDetail">Mail: ' . $gmail . '
                </div>
                <div class="orderDetail">商品 : ' . $goodsKind . '
                </div>
                <div class="orderDetail">店家 : ' . $store . '
                </div>
                <div class="orderDetail">折扣方案:' . $discount . '
                </div>
                <div class="orderDetail">應付金額:' . $money . '
                元</div>
            </div>');
            }
        } else { //配對
            $query = "SELECT `userID` FROM `mealOrder` WHERE `storeNum` LIKE '" . $store . "' AND `discount` LIKE '" . $discount . "'";
            if (!($result = mysqli_query($database, $query))) {
                print("<p>Could not execute query!</p>");
            }
            $id = mysqli_fetch_row($result);
            foreach ($id as $userid);
            $OrderID = intval($userid); //OrderID
            if ($userID == $OrderID) {
                print('<div id="Logbutton" onclick="PrePage(this)"><strong>previous page</strong></div>
                <div class="warning">
                    <div class="warnText">您已在此商品配對中</div>
                </div>');
            } else {
                $query = "INSERT INTO `userOrderDetail` (`space`, `userID`, `store`, `goodsKind`, `discount`, `price`, `time` ,`method`) VALUES (NULL, '" . $userID . "', '" . $store . "', '" . $goodsKind . "', '" . $discount . "', '".$money."', '" . date('Y-m-d H:i:s') . "' , '優惠配對成功')";
                if (!($result = mysqli_query($database, $query))) {
                    print("<p>error5</p>");
                }

                $query = "SELECT `space` FROM `mealOrder` WHERE `storeNum` LIKE '" . $store . "' AND `discount` LIKE '" . $discount . "'";
                if (!($result = mysqli_query($database, $query))) {
                    print("<p>error6</p>");
                }
                $s = mysqli_fetch_row($result);
                foreach ($s as $ss);
                $space = intval($ss); //訂單編號

                $query = "SELECT `mail` FROM `mealOrder` WHERE `storeNum` LIKE '" . $store . "' AND `discount` LIKE '" . $discount . "'";
                if (!($result = mysqli_query($database, $query))) {
                    print("<p>error8</p>");
                }
                $m = mysqli_fetch_row($result);
                foreach ($m as $gmail2); //配對者mail

                $query = "SELECT `name` FROM `mealOrder` WHERE `storeNum` LIKE '" . $store . "' AND `discount` LIKE '" . $discount . "'";
                if (!($result = mysqli_query($database, $query))) {
                    print("<p>error9</p>");
                }
                $n = mysqli_fetch_row($result);
                foreach ($n as $name2); //配對者name

                $query = "SELECT `goodsKind` FROM `mealOrder` WHERE `storeNum` LIKE '" . $store . "' AND `discount` LIKE '" . $discount . "'";
                if (!($result = mysqli_query($database, $query))) {
                    print("<p>error10</p>");
                }
                $g = mysqli_fetch_row($result);
                foreach ($g as $goodsKind2); //配對者name

                $query = "SELECT `userID` FROM `mealOrder` WHERE `storeNum` LIKE '" . $store . "' AND `discount` LIKE '" . $discount . "'";
                if (!($result = mysqli_query($database, $query))) {
                    print("<p>error11</p>");
                }
                $i = mysqli_fetch_row($result);
                foreach ($i as $userid2); //配對者ID
                $userID2 = intval($userid2); //userID2

                $query = "SELECT `space` FROM `userOrderDetail` WHERE `store` LIKE '" . $store . "' AND `discount` LIKE '" . $discount . "' AND `userID` LIKE '" . $userID2 . "' AND `method` LIKE '優惠配對中'";
                if (!($result = mysqli_query($database, $query))) {
                    print("<p>error6</p>");
                }
                $s2 = mysqli_fetch_row($result);
                foreach ($s2 as $ss2);
                $space2 = intval($ss2); //訂單編號

                $query = "UPDATE `userOrderDetail` SET `method` = '優惠配對成功' WHERE `userOrderDetail`.`space` = '" . $space2 . "'";
                if (!($result = mysqli_query($database, $query))) {
                    print("<p>error7</p>");
                }

                //delete配對完的帳號
                $query = "DELETE FROM `mealOrder` WHERE `mealOrder`.`space` = '" . $space . "'";
                if (!($result = mysqli_query($database, $query))) {
                    print("<p>error11</p>");
                }

                //print('<p>'.$gmail2.'</p>');
                //print('<p>'.$space.'</p>');
                //print('<p>'.$gmail.'</p>');
                $mail = new PHPMailer();

                // Server 資訊
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "ssl";
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 465;
                $mail->CharSet = "utf-8";

                // 登入
                $mail->Username = "test09090808s@gmail.com"; //帳號
                $mail->Password = "test1234test"; //密碼

                // 寄件者
                $mail->From = "test09090808s@gmail.com"; //寄件者信箱
                $mail->FromName = "test1234test"; //寄件者姓名
                // 郵件資訊
                $mail->Subject = "優惠配對成功！"; //設定郵件標題
                $mail->IsHTML(true); //設定郵件內容為HTML

                $mail->Body = "
                <p><strong>以下是您的配對訂單：</strong></p>
                <p>商品:" . $goodsKind . "</p>
                <p>優惠方案:" . $discount . "</p>
                <p>應付金額:" . $money . "元</p>
                <p>店家:" . $store . "</p>" . date('Y-m-d H:i:s');
                $mail->addAddress($gmail, $name);
                $mail->addReplyTo($gmail, 'test09090808s@gmail.com');
                $mail->send();

                $mail->clearAddresses(); //------------------------store mail

                $mail->Subject = "顧客訂單(優惠配對)"; //設定郵件標題
                $mail->Body = "
                    <p><strong>以下是顧客的個人資料及訂單：</strong></p>
                    <p>顧客(1) :</p>
                    <p>姓名:" . $name . "</p>
                    <p>信箱:" . $gmail . "</p>
                    <p>商品:" . $goodsKind . "</p>
                    <p>優惠方案:" . $discount . "</p>
                    <p>應付金額:" . $money . "元</p>
                    <br>
                    <p>顧客(2) :</p>
                    <p>姓名:" . $name2 . "</p>
                    <p>信箱:" . $gmail2 . "</p>
                    <p>商品:" . $goodsKind . "</p>
                    <p>優惠方案:" . $discount . "</p>
                    <p>應付金額:" . $money . "元</p>
                    <br>
                    <p>店家:" . $store . "</p>" . date('Y-m-d H:i:s');
                $mail->addAddress($storeMail, $store);
                $mail->addReplyTo($storeMail, 'test09090808s@gmail.com');

                if(!($mail->send())){
                    print('<p>rrrrr</p>');
                } //

                $mail->clearAddresses(); //------------------------end

                $mail->Subject = "優惠配對成功！"; //設定郵件標題

                $mail->Body = "
                <p><strong>以下是您的配對訂單：</strong></p>
                <p>商品:" . $goodsKind2 . "</p>
                <p>優惠方案:" . $discount . "</p>
                <p>應付金額:" . $money . "元</p>
                <p>店家:" . $store . "</p>" . date('Y-m-d H:i:s');

                $mail->addAddress($gmail2, $name2);
                $mail->addReplyTo($gmail2, 'test09090808s@gmail.com');

                if ($mail->send()) {
                    print('<div id="Logbutton" onclick="PrePage(this)"><strong>previous page</strong></div>
                <div class="warning">
                    <div class="warnText">恭喜！您優惠配對成功</div>
                </div>');
                }
            }
        }
    }
}
