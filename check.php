<?php
//時間
date_default_timezone_set('Asia/Taipei');
$today = getdate();
date("Y/m/d H:i");  //日期格式化
$year = $today["year"]; //年 
$month = $today["mon"]; //月
$day = $today["mday"];  //日
if (strlen($month) == '1') $month = '0' . $month;
if (strlen($day) == '1') $day = '0' . $day;
$today = $year . "-" . $month . "-" . $day;
//print("<p>$today</p>");
$choice = $_POST['choice'];
if ($choice == 1) {//log out
    print('<form id = "form1">
            accountnumber<br><input type="text" name="accountnumber" id="accountnumber" required><br>
            password<br><input type="password" name="password" id="password" required>
            <p><input id="submit" type="button" value="login" onclick="login()"></p>
            <p><a href="createAccount.html"><input id="submit" type="button" value="create account"></a></p>
            </form>');
} else {
    //登入者帳密
    session_start();
    $accountnumber = $_POST["accountnumber"];
    $_SESSION['accountNum'] = $accountnumber;
    $password = $_POST["password"];
    $_SESSION['passwordNum'] = $password;
    //

    $query = "SELECT `password` FROM `userAccount` WHERE `accountnumber` LIKE '" . $accountnumber . "';";
    if (!($database = mysqli_connect("localhost", "hunter yang", "hunter1115")))
        die("Could not connect to database </body></html>");
    if (!mysqli_select_db($database, "finalProject"))
        die("Could not open products database </body></html>");
    if (!($result = mysqli_query($database, $query))) {
        print("<p>Could not execute query!</p>");
    } else {
        $row = mysqli_fetch_row($result);
        if ($row == "") {
            print('<form id = "form1">
            accountnumber<br><input type="text" name="accountnumber" id="accountnumber" required><br>
            password<br><input type="password" name="password" id="password" required>
            <p style="color: red;">The account not exist or password is wrong!</p>
            <p><input id="submit" type="button" value="login" onclick="login()"></p>
            <p><a href="createAccount.html"><input id="submit" type="button" value="create account"></a></p>
            </form>');
        } else {
            foreach ($row as $value);
            $inputpassword = intval($value);
            if ($inputpassword == $password) {
                print('<div id="userbutton" onclick = "USER()"><strong>USER</strong></div>
            <div id="Logbutton" onclick = "LogOut()"><strong>LOG&nbspOUT</strong></div>
            <div id="box1" class="Box" onclick="storeData(this)" data-space="1"></div>
            <div id="box2" class="Box" onclick="storeData(this)" data-space="2"></div>
            <div id="box3" class="Box" onclick="storeData(this)" data-space="3"></div>
            <div id="box4" class="Box" onclick="storeData(this)" data-space="4"></div>');
            } else {
                print('<form id = "form1">
            accountnumber<br><input type="text" name="accountnumber" id="accountnumber" required><br>
            password<br><input type="password" name="password" id="password" required>
            <p style="color: red;">The account not exist or password is wrong!</p>
            <p><input id="submit" type="button" value="login" onclick="login()"></p>
            <p><a href="createAccount.html"><input id="submit" type="button" value="create account"></a></p>
            </form>');
            }
        }
    }

    mysqli_close($database);
}
