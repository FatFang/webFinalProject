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

session_start();
$accountnumber = $_SESSION['accountNum'];
$password = $_SESSION['passwordNum'];
$choice = $_POST['choice'];
if ($choice == 1) {
    $spaceNum = $_POST['spaceNum']; //商店編號
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
    print('<div id="Logbutton" onclick="PrePage()"><strong>previous page</strong></div>
    <div id="box' . $spaceNum . '" class="store" data-space="' . $spaceNum . '">
    <div class="storeName">' . $store . '</div>');
    if ($spaceNum == 1) {
        print('<div class="discount1" data-discount = "1" onclick="formData(this)">單點 雙層牛肉吉事堡 買1送1');
        print('</div>
            <div class="discount2" data-discount = "2" onclick="formData(this)">');
        print('大薯 加1元多1份');
    } else if ($spaceNum == 2) {
        print('<div class="discount1" data-discount = "3" onclick="formData(this)">大杯美式咖啡 第二杯8折');
        print('</div>
            <div class="discount2" data-discount = "4" onclick="formData(this)">');
        print('拿鐵 第二杯半價');
    } else if ($spaceNum == 3) {
        print('<div class="discount1" data-discount = "5" onclick="formData(this)">指定款式 任兩雙鞋 打8折');
        print('</div>
            <div class="discount2" data-discount= "6" onclick="formData(this)">');
        print('襪子 兩捆7折');
    } else if ($spaceNum == 4) {
        print('<div class="discount1" data-discount= "7" onclick="formData(this)">冬天系列大學T 第二件衣服 打75折');
        print('</div>
            <div class="discount2" data-discount= "8" onclick="formData(this)">');
        print('長褲 第二件9折 ');
    }
    print('</div>
    </div>');
} else if ($choice == 2) {
    print('<div id="userbutton" onclick = "USER()"><strong>USER</strong></div>
            <div id="Logbutton" onclick = "LogOut()"><strong>LOG&nbspOUT</strong></div>
            <div id="box1" class="Box" onclick="storeData(this)" data-space="1"></div>
            <div id="box2" class="Box" onclick="storeData(this)" data-space="2"></div>
            <div id="box3" class="Box" onclick="storeData(this)" data-space="3"></div>
            <div id="box4" class="Box" onclick="storeData(this)" data-space="4"></div>');
} else if ($choice == 3) {
    $formNum = $_POST['formNum'];
    $storeNum = $_POST['storeNum'];
    $store = "";
    if ($storeNum == 1) {
        $store = "麥當勞";
    } else if ($storeNum == 2) {
        $store = "星巴克";
    } else if ($storeNum == 3) {
        $store = "ABC-Mart";
    } else if ($storeNum == 4) {
        $store = "GU";
    }
    $product = "";
    if($formNum == 1){
        $product = "雙層牛肉吉事堡";
    }else if($formNum == 2){
        $product = "大薯";
    }else if($formNum == 3){
        $product = "大杯美式咖啡";
    }else if($formNum == 4){
        $product = "拿鐵";
    }else if($formNum == 5){
        $product = "鞋子";
    }else if($formNum == 6){
        $product = "襪子";
    }else if($formNum == 7){
        $product = "冬天系列大學T";
    }else if($formNum == 8){
        $product = "長褲";
    }
    print('<div id="Logbutton" onclick="PrePage()"><strong>previous page</strong></div>
    <div id="box' . $storeNum . '" class="store" data-space="' . $storeNum . '">
    <div class="storeName">' . $store . '</div>');
    if ($storeNum == 1) {
        print('<div class="discount1" data-discount = "1" onclick="formData(this)">單點 雙層牛肉吉事堡 買1送1');
        print('</div>
            <div class="discount2" data-discount= "2" onclick="formData(this)">');
        print('大薯 加1元多1份');
    } else if ($storeNum == 2) {
        print('<div class="discount1" data-discount = "3" onclick="formData(this)">大杯美式咖啡 第二杯8折');
        print('</div>
            <div class="discount2" data-discount= "4" onclick="formData(this)">');
        print('拿鐵 第二杯半價');
    } else if ($storeNum == 3) {
        print('<div class="discount1" data-discount = "5" onclick="formData(this)">指定款式 任兩雙鞋 打8折');
        print('</div>
            <div class="discount2" data-discount = "6" onclick="formData(this)">');
        print('襪子 兩捆7折');
    } else if ($storeNum == 4) {
        print('<div class="discount1" data-discount = "7" onclick="formData(this)">冬天系列大學T 第二件衣服 打75折');
        print('</div>
            <div class="discount2" data-discount = "8" onclick="formData(this)">');
        print('長褲 第二件9折 ');
    }
    print('</div><div id="buy">
    <span style="font-size:25px; color: #808080; top: 15px;left: 30px;position: relative;">訂單資訊:</span>
    <br>
    <span style="font-size:25px; color: #808080; top: 15px;left: 30px;position: relative;">商品:&nbsp'.$product.'</span>
    <p></p>
    <form method="post" action="#" style="position: relative; left: 75px; top: 15px;" data-goods= "'.$formNum.'">
        <div>
            <p>
                <label>聯絡人姓名:
                    <input  type="text" size="20" style= "width: 100px;" id = "name">
                </label>
            </p>
        </div>
        <div>
            <p>
                聯絡人電話:
                    <input type="tel" placeholder="09##-###-###" pattern="09\d{2}-\d{3}-\d{3}"id = "phone"/>
                
            </p>
        </div>
        <div>
            <p>
                <label> Email:
                    <input type="email" placeholder="xxxxxxxx@domain.com" id = "mail"/>
                </label>
            </p>
        </div>');
    if ($storeNum == 3 || $storeNum == 4) {
        if ($formNum == 5) {
            print('<div><p><label>商品顏色:<select name="Choice" id="goodsKind">');
            print('<option selected value = "鞋子(紅色)">紅色</option>
                    <option value = "鞋子(黑色)">黑色</option></select></label></p></div>');
        }else if ($formNum == 6) {
            print('<div><p><label>商品顏色:<select name="Choice" id="goodsKind">');
            print('<option selected value = "襪子(白色)">白色</option>
                    <option value = "襪子(黑色)">黑色</option></select></label></p></div>');
        }else if ($formNum == 7) {
            print('<div><p><label>商品顏色:<select name="Choice" id="goodsKind">');
            print('<option selected value = "冬天系列大學T(灰色)">灰色</option>
                    <option value = "冬天系列大學T(黑色)">黑色</option></select></label></p></div>');
        }else if ($formNum == 8) {
            print('<div><p><label>商品種類:<select name="Choice" id="goodsKind">');
            print('<option selected value = "長褲(棉褲)">棉褲</option>
                    <option value = "長褲(牛仔褲)">牛仔褲</option></select></label></p></div>');
        }
    }
    
    print('
        <br>
        <input type="button" style="background-color:#d6a83c ;color:white; width: 150px; height: 40px; border-radius: 10px;" value="直接下訂" data-send="1" onclick="Order(this)"/>
        <input type="button" style="background-color:#d6a83c;color:white ;width: 150px; height: 40px; border-radius: 10px;" value="優惠配對" data-send="2" onclick="Order(this)"/>
    </form>
</div>
    </div>');
}

/**/