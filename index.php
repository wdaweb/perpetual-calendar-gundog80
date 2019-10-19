<?php
// 要顯示的是什麼時候? 取得代表 要顯示/今天 時間的秒數 $showTime
    //_GET _POST是否有東西傳入?
    //取得現在的時間直接用strtotime("now")就可以了，但每秒都在變化，不利後續作業，要如何取整?
if(!empty($_GET)){
    $showMoonSta=$_GET["showtime"];
    $showTime=0;
    $month=date('m',$showMoonSta);
}else{
    if(!empty($_POST)){
        $year=$_POST['year'];
        $month=$_POST['month'];
        $day=$_POST['date'];
        $showTime=strtotime("$year-$month-$day");
    }else{
        $showTime=strtotime(date("Y-m-d",strtotime("now")));
        $month=date('m',$showTime);
    }
    //要顯示的月分，從哪個時間開始? 取得顯示月的第一天的秒數 $showMoonSta
        //今天是幾號?要如何取得第一天?  (方法一 我們拿到的是秒數，每天有多少秒? 方法二 strtotime有針對時間計算的方法，要如何寫進函式中?)
    $showTday=date('d',$showTime);
    $showMoonSta=$showTime-(($showTday-1)*24*60*60);
    
}
        if($month>=1 && $month <= 3){
            $season="winter";
        }elseif($month>=4 && $month <= 6){
            $season="spring";
        }elseif($month>=7 && $month <= 9){
            $season="summer";
        }elseif($month>=10 && $month <= 12){
            $season="autumn";
        }
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    .spring{
        background-color:rgba(140, 201, 143, 0.76);
    }
    .summer{
        background-color:rgba(209, 139, 192, 0.76);
    }
    .autumn{
        background-color:rgba(207, 194, 75, 0.76);
    }
    .winter{
        background-color:rgba(143, 185, 212, 0.76);
    }
    .claender{
        margin:0px auto;
        width:600px;
        text-align:center;
    }
    .table{
        margin:0px auto;
        border-spacing: 0px;
        border-style:solid   ;
        border-width:3px;
        border-color:black;
        font-size:30px;
        text-align: center;
        font-weight:600;
    }
    .tabletitle{
        background-color: rgb(93, 209, 238);
    }
    .table td{
        display:table-cell;
        width:70px;
        height:50px;
        border-style:solid   ;
        border-width:1px;
        border-color:black;
        vertical-align: center;
        min-width:2.8em;
        
    }
   
    .table .notinmoon{
        color:rgba(0, 0, 0, 0.200);
    }
    .table .holiday{
        color:red;
        font-size:20px;
    }
    .table .target{
        color:red;
        font-size:20px;
    }
    .table .premonth{
        /* font-size:20px; */
        border-right:0px;
        /* background-color:white; */
    }
    .table .nextmonth{
        /* font-size:20px; */
        border-left:0px;
        /* background-color:white; */
    }
    .table .form{
        border-right:0px;
        border-left:0px;
        font-size:25px;
    }
    .datetr>td:nth-child(1) , .datetr>td:nth-child(7){
        background-color:#df8484;
    }
    .title{
        margin:20px auto 10px;
        text-align: center;
        font-size : 40px;
    }
    .arrowDiv{
        height:100%;
        width:100%;
        background:rgba(255, 255, 0, 0);
    }
    .leftArrow{
        height:25px;
        width:65%;
        left:30%;
        top:calc((100% - 20px)/2);
        /* top:20px; */
        position:relative;
        background-color:rgb(0, 200, 240);
        text-align: left;
        font-size:15px;
        z-index:1;
    }
    .leftArrow::after {
        content:"";
        width:24px;
        height:24px;
        background-color:rgb(0, 200, 240);
        position:relative;
        left:-20%;
        top:-24px;
        display:inline-block;
        transform:rotate(45deg);
        z-index:-1;
    }
    .rightArrow{
        height:25px;
        width:65%;
        left:5%;
        top:calc((100% - 20px)/2);
        /* top:20px; */
        position:relative;
        background-color:rgb(0, 200, 240);
        text-align: left;
        font-size:15px;
        z-index:2;
    }
    .rightArrow::after {
        content:"";
        width:24px;
        height:24px;
        background-color:rgb(0, 200, 240);
        position:relative;
        right:-75%;
        top:-24px;
        display:inline-block;
        transform:rotate(45deg);
        z-index:-1;
    }
    
    </style>
    
</head>
<body class=<?=$season;?> >  
    <?php
    //顯示表上的第一天是什麼時候?   取得顯示表上的第一天 $showTableSta
        //同上，但如何取得1號是星期幾?取出來的數字是否要微調?
    $showMSweek=date('w',$showMoonSta);
    $showTableSta=$showMoonSta-$showMSweek*24*60*60;
    //總共要顯示幾週? $weeks
        //總共要顯示的天數有幾天? 從表格開始的$showTableSta 到月底
    $showMoonDays=date("t",$showMoonSta);
    $weeks=($showMoonDays+$showMSweek)/7;
   
    ?>
    <div class="claender">
    <p class="title">
    <?php
    echo date ("Y年m月",$showMoonSta) . "<br>";
    ?>
    </p>
        <table class="table">
            <tr class=tabletitle>
                <td>日</td>
                <td>一</td>
                <td>二</td>
                <td>三</td>
                <td>四</td>
                <td>五</td>
                <td>六</td>
            </tr>
            <?php
            $holiday=[["元旦",'01-01'],["228紀念日",'02-28'],["兒童節",'04-04'],["清明節",'04-05'],["國慶日",'10-08']];
            $temp=$showTableSta;
            for($i=0;$i<$weeks;$i++){
                echo "<tr class=datetr>";
                for($j=0;$j<7;$j++){
                    $isHoliday=0;
                    for($k=0;$k<count($holiday);$k++){          //判斷是否為節日並預留變數
                        if(date('m-d',$temp)==$holiday[$k][1]){
                            $isHoliday=1;
                            $holidayNumber=$k;
                        }
                    }
                    if($temp==$showTime){   //判斷是否是指定日，並指定CSS
                        $isTarget="targer";
                    }else{$isTarget="";}
                    if($isHoliday==1){
                        $isHoliday2="holiday";     //判斷是否為假日
                    }else{$isHoliday2="";}
                    if($temp<$showMoonSta || $temp>=strtotime('+1 month',$showMoonSta)){
                        $isInMonth="notinmoon";     //判斷是否不在月內
                    }else{$isInMonth="";}

                    // echo "<td" .  $isTarget . ">";
                    // echo "<td class=$spday" . $isTarget . ">";
                    echo "<td> <div class=$isHoliday2> <div class=$isInMonth> <div class=$isTarget>";
                    echo date('d',$temp);
                    if($isHoliday){echo "<br>" . $holiday[$holidayNumber][0];}
                    echo "<div><div><div></td>";
                    $temp=$temp+(24*60*60);
                }
                echo "</tr>";
            }
            $preMoonSta=strtotime("-1 month",$showMoonSta);
            $nextMoonSta=strtotime("+1 month",$showMoonSta);
            
            ?>
            <tr>
            
            <!-- <td><a href="./萬年曆.php?showtime=<?php echo $preMoonSta;?>">上個月</a></td> -->
            <td class=premonth>
                <div class=arrowDiv >
                    <div class=leftArrow >
                        <a style="display:inline-block; margin: 3px 0px ;" href="?showtime=<?=$preMoonSta?>">上個月</a>
                    </div>
                </div>
            </td>
            <td class=form colspan=5>
                <form action="?" method="POST">
                    西元 <input type="text" name="year" size=3 >
                    年 <input type="text" name="month" size=1>
                    月 <input type="text" name="date" size=1>
                    日 <br>
                    <input type="submit" value=依日期查詢>
                </form>
            </td>
            <td class=nextmonth>
                <div class=arrowDiv >
                    <div class=rightArrow >
                <a style="display:inline-block; margin: 3px 0px ;" href="?showtime=<?=$nextMoonSta?>">下個月</a>
                    </div>
                </div>
            </td>
            </tr>
        </table>
    </div>

</body>
</html>