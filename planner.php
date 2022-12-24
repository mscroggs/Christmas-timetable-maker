<style type='text/css'>

table.xmas-timetable,
table.xmas-timetable td,
table.xmas-timetable thead,
table.xmas-timetable tr {border:none;vertical-align:top;border-collapse:collapse}
table.xmas-timetable td {border-bottom:2px solid gray;padding:10px}

label {
  display: inline-block;
}

</style>

<?php

$times = Array();

function add_essential($eat, $m, $n){
    _add($eat, $m, "<b>".$n."</b>");
}
function add_variable($eat, $m, $n){
    _add($eat, $m, $n);
}
function _add($eat, $m, $n){
    global $times;
    $a = format_time_mins_before($eat, $m);
    if(!isset($times[$a])){$times[$a]=Array();}
    $times[$a][] = $n;
}

$blocks = Array();
$ganttn = 0;

function add_essential_gantt($eat, $start, $end, $n){
    _add_gantt($eat, $start, $end, $end, $n);
}
function add_variable_gantt($eat, $start, $end, $end2, $n){
    _add_gantt($eat, $start, $end, $end2, $n);
}
function _add_gantt($eat, $start, $end, $end2, $n){
    global $blocks;
    global $ganttn;
    $a = mins_before($eat, $start);
    $b = mins_before($eat, $end);
    $c = mins_before($eat, $end2);
    $blocks[] = Array($a, $b, $c, $n, $ganttn);
}

function on($thing){
     return (isset($_POST[$thing]) && $_POST[$thing]=="on");
}

function custom_join($a){
    $out = "";
    for($i=0;$i<count($a);$i++){
        $out.=$a[$i];
        if($i<count($a)-2){
            $out.=", ";
        } else if($i<count($a)-1){
            $out.=" and ";
        }
    }
    return $out;
}

function pad2($n){
    $n = "".$n;
    while(strlen($n)<2){$n="0".$n;}
    return $n;
}

function format_time($t){
    $out = pad2(intdiv($t, 60));
    $out .= ":";
    $out .= pad2($t%60);
    return $out;
}

function format_time_mins_before($t,$m){
    return format_time(mins_before($t, $m));
}

function mins_before($t,$m){
    if(count(explode(":",$t))!=2){
        $hr = 13;
        $min = 0;
    } else {
        $hr = explode(":", $t)[0];
        $min = explode(":", $t)[1];
    }
    return $hr*60 + $min - $m;
}

function temp($n){
    if(isset($_POST['oven-type'])){
        if($_POST['oven-type'] == "C"){
            return $n."&deg;C";
        }
        if($_POST['oven-type'] == "Cfan"){
            return ($n-20)."&deg;C";
        }
        if($_POST['oven-type'] == "F"){
            return (floor(($n*9/5+32)/5)*5)."&deg;F";
        }
        if($_POST['oven-type'] == "gas"){
            if($n>=240){$mark=9;}
            else if($n>=230){$mark=8;}
            else if($n>=220){$mark=7;}
            else if($n>=200){$mark=6;}
            else if($n>=190){$mark=5;}
            else if($n>=180){$mark=4;}
            else if($n>=170){$mark=3;}
            else if($n>=150){$mark=2;}
            else if($n>=140){$mark=1;}
            else {$mark=0;}
            return "gas mark ".$mark;
        }
        if($_POST['oven-type'] == "desc"){
            if($n>=240){return "very hot";}
            else if($n>=220){return "hot";}
            else if($n>=190){return "moderately hot";}
            else if($n>=170){return "moderate";}
            else if($n>=140){return "slow";}
            else {return "very slow";}
        }
    }
    return $n."&deg;C";
}

if(isset($_POST['make'])){

    $format = "table";
    if(isset($_POST['format'])){
        $format = $_POST['format'];
    }

    $eat = $_POST['eat-time'];

    add_essential($eat,0,"Eat Christmas dinner");

    for($i=1;isset($_POST['meatt'.$i]);$i++){if($_POST['meatt'.$i]!=""){
        $t = $_POST['meatt'.$i];
        $w = $_POST['meatw'.$i];
        $u = $_POST['meatu'.$i];
        $r = $_POST['meatr'.$i];
        //echo($t." ".$w." ".$u." ".$r."<br />");
        $name = $w.$u." ";
        if($t=="pork2"){$name.="pork";} else {$name.=$t;}

        if($u=="oz"){$w *= 28.35;}
        if($u=="kg"){$w *= 1000;}
        if($t=="pork"){
            add_essential($eat,20 + 35/450 * $w,"Turn ".$name." down to ".temp(190));
            add_essential($eat,20 + 20 + 35/450 * $w,"Put ".$name." in oven at ".temp(245));
            add_variable($eat,20,"Check the ".$name.". If cooked, take it out and rest it");
            add_essential_gantt($eat,20 + 20 + 35/450 * $w,20 + 35/450 * $w,"Roast ".$name." at ".temp(245));
            add_essential_gantt($eat,20 + 35/450 * $w,20,"Roast ".$name." at ".temp(190));
            add_variable_gantt($eat,20, 5, 0,"Rest ".$name);
            $ganttn++;
        }
        if($t=="pork2"){
            add_essential($eat,20 + 45/450 * $w,"Turn ".$name." down to ".temp(180));
            add_essential($eat,20 + 20 + 45/450 * $w,"Put ".$name." in oven at ".temp(245));
            add_variable($eat,20,"Check the ".$name.". If cooked, take it out and rest it");
            add_essential_gantt($eat,20 + 20 + 45/450 * $w,20 + 45/450 * $w,"Roast ".$name." at ".temp(245));
            add_essential_gantt($eat,20 + 45/450 * $w,20,"Roast ".$name." at ".temp(180));
            add_variable_gantt($eat,20, 5, 0,"Rest ".$name);
            $ganttn++;
            }
        if($t=="chicken"){
            add_variable($eat,20 + 20 + 20/450 * $w,"Stuff the ".$name);
            add_essential($eat,20 + 20/450 * $w,"Put ".$name." in oven at ".temp(190));
            add_variable($eat,20,"Check the ".$name.". If cooked, take it out and rest it");
            add_variable_gantt($eat,20 + 20 + 20/450 * $w, 10 + 20 + 20/450 * $w, 20 + 20/450 * $w,"Stuff ".$name);
            add_essential_gantt($eat,20 + 20/450 * $w,20,"Roast ".$name." at ".temp(190));
            add_variable_gantt($eat,20, 5, 0,"Rest ".$name);
            $ganttn++;
        }
        if($t=="turkey"){
            $cook = $w/1000 * 20 + 70;
            if($w>=4000){$cook += 20;}
            add_variable($eat,$cook+40,"Stuff the ".$name);
            add_essential($eat,$cook+20,"Put ".$name." in oven at ".temp(190));
            add_variable($eat,20,"Check the ".$name.". If cooked, take it out and rest it");
            add_variable_gantt($eat,$cook+40,$cook+30,$cook+20,"Stuff ".$name);
            add_essential_gantt($eat,$cook+20,20,"Roast ".$name." at ".temp(190));
            add_variable_gantt($eat,20, 5, 0,"Rest ".$name);
            $ganttn++;
        }
        if($t=="ham"){
            add_essential($eat,90 + 20/450 * $w,"Put ".$name." on to boil");
            add_essential($eat,90,"Turn ".$name." off and leave in water to cool");
            add_essential($eat,30,"Put ".$name." in oven to warm");
            add_variable_gantt($eat,60+90 + 20/450 * $w, 90+60, 30, "Boil ".$name);
            add_variable_gantt($eat,90+60, 90, 30, "Leave ".$name." in water to cool");
            add_essential_gantt($eat,30,0,"Put ".$name." in oven to warm");
            $ganttn++;
        }
        if($t=="lamb"){
            add_essential($eat, 30 + 30/450 * $w, "Put ".$name." in the oven at ".temp(230));
            add_essential($eat, 30/450 * $w, "Turn ".$name." down to ".temp(190));
            add_essential_gantt($eat,30 + 30/450 * $w,30/450 * $w, "Roast ".$name." at ".temp(230));
            add_essential_gantt($eat,30/450 * $w, 0, "Roast ".$name." at ".temp(190));
            $ganttn++;
        }
        if($t=="beef"){
            if($r=="rare"){$cook = 15/450 * $w;}
            if($r=="medium"){$cook = 30/450 * $w;}
            if($r=="well-done"){$cook = 45/450 * $w;}
            add_essential($eat, 20 + $cook, "Put ".$name." in the oven at ".temp(230));
            add_essential($eat, $cook, "Turn ".$name." down to ".temp(190));
            add_essential_gantt($eat,20+$cook,$cook, "Roast ".$name." at ".temp(230));
            add_essential_gantt($eat,$cook, 0, "Roast ".$name." at ".temp(190));
            $ganttn++;
        }
    }}

    if(on("pigs")){
        add_variable($eat, 90, "Wrap sausages in bacon");
        add_essential($eat, 60, "Put pigs in blankets in the oven");
        add_variable_gantt($eat, 100, 80, 60, "Wrap sausages in bacon");
        add_essential_gantt($eat, 60, 0, "Put pigs in blankets in the oven");
        $ganttn++;
    }


    for($i=1;isset($_POST['nonmeatt'.$i]);$i++){
        $t = $_POST['nonmeatt'.$i];
        if($t=="bread"){
            add_essential($eat,60,"Put koulibiaca in oven");
            add_variable_gantt($eat,180,130,60,"Make koulibiaca");
            add_essential_gantt($eat,60,0,"Put koulibiaca in oven");
            $ganttn++;
        }
    }

    if(on("roast-potatoes")){
        add_variable($eat, 180, "Peel and chop roast potatoes");
        add_variable($eat, 150, "Put roast potatoes on to boil");
        add_variable($eat, 135, "Once the roast potatoes are almost completely cooked through, drain them");
        add_essential($eat, 120, "Put roast potatoes in oven");
        add_variable_gantt($eat,210, 180, 120, "Peel and chop roast potatoes");
        add_variable_gantt($eat, 180, 165, 120, "Boil potatoes");
        add_essential_gantt($eat, 120, 0, "Roast potatoes");
        $ganttn++;
    }
    if(on("new-potatoes")){
        add_essential($eat, 25, "Put new potatoes on to boil");
        add_essential_gantt($eat, 25, 0, "Boil new potatoes");
        $ganttn++;
    }
    if(on("parsnips")){
        if(on("carrots")){
            $name = "carrots and parsnips";
        } else {
            $name = "parsnips";
        }
        add_variable($eat, 110, "Peel ".$name);
        add_essential($eat, 90, "Put ".$name." in oven");
        add_variable_gantt($eat, 130, 110, 90, "Peel ".$name);
        add_essential_gantt($eat, 90, 0, "Roast ".$name);
        $ganttn++;
    }
    $fry = Array();
    if(on("carrots")){$fry[] = "carrots";}
    if(on("leeks")){$fry[] = "leeks";}
    if(on("mushrooms")){$fry[] = "mushrooms";}
    if(count($fry)>0){
        add_variable($eat, 40+10*count($fry), "Prep ".custom_join($fry));
        add_essential($eat, 30, "Put ".custom_join($fry)." on to fry in butter");
        add_variable_gantt($eat, 70+10*count($fry), 60, 30, "Prep ".custom_join($fry));
        add_essential_gantt($eat, 30, 0, "Fry ".custom_join($fry)." in butter");
        $ganttn++;
    }
    if(on("peas")){
        add_essential($eat, 20, "Put water for peas on to boil");
        add_essential($eat, 8, "Put peas in their boiling water");
        add_variable_gantt($eat, 30, 18, 8, "Heat water for peas");
        add_essential_gantt($eat, 8, 0, "Boil peas");
        $ganttn++;
    }
    if(on("broccoli")){
        add_variable($eat, 40, "Prep broccoli sprouts");
        add_essential($eat, 20, "Put water for broccoli on to boil");
        add_essential($eat, 8, "Put broccoli in their boiling water");
        add_variable_gantt($eat, 50, 30, 8, "Prep broccoli");
        add_variable_gantt($eat, 30, 18, 8, "Heat water for broccoli");
        add_essential_gantt($eat, 8, 0, "Boil broccoli");
        $ganttn++;
    }
    if(on("cauliflower")){
        add_variable($eat, 40, "Prep cauliflower sprouts");
        add_essential($eat, 20, "Put water for cauliflower on to boil");
        add_essential($eat, 8, "Put cauliflower in their boiling water");
        add_variable_gantt($eat, 50, 30, 8, "Prep cauliflower");
        add_variable_gantt($eat, 30, 18, 8, "Heat water for cauliflower");
        add_essential_gantt($eat, 8, 0, "Boil cauliflower");
        $ganttn++;
    }
    if(on("brussels")){
        add_variable($eat, 40, "Prep brussels sprouts");
        add_essential($eat, 15, "Put water for brussels sprouts on to boil");
        add_essential($eat, 5, "Put brussels sprouts in their boiling water");
        add_variable_gantt($eat, 47, 27, 5, "Prep brussels sprouts");
        add_variable_gantt($eat, 27, 15, 5, "Heat water for brussels sprouts");
        add_essential_gantt($eat, 5, 0, "Boil brussels sprouts");
        $ganttn++;
    }

    if(on("gravy")){
        add_essential($eat, 30, "Make gravy");
        add_essential_gantt($eat, 30, 0, "Make gravy");
        $ganttn++;
    }

    if($format == "table"){
        $k = array_keys($times);
        sort($k);
        echo("<table class='xmas-timetable'>");
        echo("<thead><td>Time</td><td>Activity</td></thead>");
        foreach($k as $i){
            echo("<tr><td>".$i."</td><td>".join("<br />",$times[$i])."</td></tr>");

        }
        echo("</table>");
    } else if($format == "gantt"){
        $earliest = mins_before($eat, 0);
        foreach($blocks as $b){
            $earliest = min($earliest, $b[0]);
        }

        function gx($x){
            global $earliest;
            return 30+6 * ($x - $earliest);
        }
        function gy($y){
            return 60 + 58 * $y;
        }

        function draw_line($x, $text="default", $color="#999999"){
            global $ganttn;
            if($text == "default"){
                $text = format_time($x);
            }
            echo("<div style='position:absolute;border-left:1px solid ".$color.";left:".gx($x)."px; width:2px;top:5px;height:".(gy($ganttn) + 30)."px'>&nbsp;</div>");
            echo("<div style='position:absolute;left:".(gx($x)-20)."px; width:40px;top:5px;background-color:white;color:".$color."'><small>".$text."</small></div>");
        }

        $eatn = mins_before($eat, 0);
        echo("<div class='xmas-gantt' style='position:relative;background:white;left:".((700-gx($eatn)+gx($earliest))/2-20)."px;height:".(gy($ganttn)+80)."px;width:".(70+gx($eatn)-gx($earliest))."px'>");
        for($t=$earliest - $earliest%10;$t<$eatn;$t+=10){
            draw_line($t);
        }
        draw_line($eatn, "Eat (".format_time($eatn).")", "#00A300");
        foreach($blocks as $i=>$b){
            if ($b[2] != $b[1]){
                echo("<div style='position:absolute;border:2px dashed #999999;height:50px;top:".gy($b[4])."px;left:".(gx($b[0])+1)."px;width:".(gx($b[2]) - gx($b[0])-4)."px'>&nbsp;</div>");
            }
            echo("<div style='position:absolute;overflow:hidden;background:#FFFFFFEE;padding:2px;border:2px solid ");
            if ($b[2] != $b[1]){
                echo("#999999");
            } else {
                echo("black");
            }
            echo(";height:46px;top:".gy($b[4])."px;left:".(gx($b[0])+1)."px;width:".(gx($b[1]) - gx($b[0])-7)."px;'><small>".$b[3]."</small></div>");
        }
        echo("</div>");
    } else {
        echo("Unknown format");
    }
} else {

    echo("<form method='post'>");

    echo("<$h2>Meat</$h2>");
    echo("<span id='meatinputs1'></span>");
    echo("<button onclick='return addMeat()' type='button'>+</button>");
    echo("<br /><span id='meatticks'></span>");

    echo("<$h2>Vegetarian</$h2>");
    echo("<span id='nonmeatinputs1'></span>");
    echo("<button onclick='return addNonMeat()' type='button'>+</button>");

    echo("<$h2>Vegetables</$h2>");
    echo("<span id='veginputs'></span>");

    echo("<$h2>Other</$h2>");
    echo("<span id='otherinputs'></span>");

    echo("<$h2>Options</$h2>");
    echo("<label>Eating time:<input type='time' name='eat-time'></label>");
    echo(" &nbsp; ");
    echo("<label>Oven type:<select name='oven-type'>");
    echo("<option value='C' selected>&deg;C</option>");
    echo("<option value='Cfan'>&deg;C fan oven</option>");
    echo("<option value='F'>&deg;F</option>");
    echo("<option value='gas'>gas oven</option>");
    echo("<option value='desc'>a descriptive oven</option>");
    echo("</select></label>");
    echo(" &nbsp; ");
    echo("<label>Format:<select name='format'>");
    echo("<option value='table' selected>table</option>");
    echo("<option value='gantt'>Gantt chart</option>");
    echo("</select></label>");
    echo("<br /><br /><input name='make' value='Make timetable' type='submit'>");
    echo("</form>");

    echo("<script type='text/javascript' src='planner.js'></script>");
}
?>
