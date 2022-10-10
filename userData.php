<?php

$accountnumber = $_POST["accountnumber"];
$password = $_POST["password"];
if ($accountnumber == "") {
    print("accountnumber<br><input type='text' name='accountnumber' id='accountnumber'><br>
                        password<br><input type='password' name='password' id='password' value = '".$password."'>
                        <p style='color: red;'>accountnumber is empty!</p>
                        <p><input id='submit' type='button' value='create account' onclick='create()'></p>
                        <p><a href='login.html'><input id='submit' type='button' value='Have account login now'></a></p>");
} else if ($password == "") {
    print("accountnumber<br><input type='text' name='accountnumber' id='accountnumber' value = '".$accountnumber."'><br>
                        password<br><input type='password' name='password' id='password'>
                        <p style='color: red;'>password is empty!</p>
                        <p><input id='submit' type='button' value='create account' onclick='create()'></p>
                        <p><a href='login.html'><input id='submit' type='button' value='Have account login now'></a></p>");
} else {
    $query = "SELECT * FROM `userAccount`";
    if (!($database = mysqli_connect("localhost", "hunter yang", "hunter1115")))
        die("Could not connect to database </body></html>");
    if (!mysqli_select_db($database, "finalProject"))
        die("Could not open products database </body></html>");
    if (!($result = mysqli_query($database, $query))) {
        print("<p>Could not execute query!</p>");
    }

    $newaccount = mysqli_fetch_row($result);
    if ($newaccount == "") {
        $query = "INSERT INTO `userAccount` (`userID`, `accountnumber`, `password`) VALUES (NULL, '" . $accountnumber . "', '" . $password . "');";
        if (!($result = mysqli_query($database, $query))) {
            print("<p>Could not execute query!</p>");
        } else {
            print("accountnumber<br><input type='text' name='accountnumber' id='accountnumber'><br>
                        password<br><input type='password' name='password' id='password'>
                        <p style='color: green;'>Creating account successfully!</p>
                        <p><input id='submit' type='button' value='create account' onclick='create()'></p>
                        <p><a href='login.html'><input id='submit' type='button' value='Have account login now'></a></p>");
        }
    } else {
        $query = "SELECT `accountnumber` FROM `userAccount` WHERE `accountnumber` LIKE '" . $accountnumber . "'";
        if (!($result = mysqli_query($database, $query))) {
            print("<p>Could not execute query!</p>");
        } else {
            $newaccount = mysqli_fetch_row($result);
            if ($newaccount != "") {
                print("accountnumber<br><input type='text' name='accountnumber' id='accountnumber'><br>
                    password<br><input type='password' name='password' id='password'>
                    <p style='color: red;'>The account has already existed!</p>
                    <p><input id='submit' type='button' value='create account' onclick='create()'></p>
                    <p><a href='login.html'><input id='submit' type='button' value='Have account login now'></a></p>");
            } else {
                $NEWACCOUNT = "INSERT INTO `userAccount` (`userID`,`accountnumber`,`password`)VALUES(NULL,'$accountnumber','$password')";
                if (!($account = mysqli_query($database, $NEWACCOUNT))) {
                    print("<p>Could not execute query!</p>");
                } else {
                    print("accountnumber<br><input type='text' name='accountnumber' id='accountnumber'><br>
                        password<br><input type='password' name='password' id='password'>
                        <p style='color: green;'>Creating account successfully!</p>
                        <p><input id='submit' type='button' value='create account' onclick='create()'></p>
                        <p><a href='login.html'><input id='submit' type='button' value='Have account login now'></a></p>");
                }
            }
        }
    }
    mysqli_close($database);
}
