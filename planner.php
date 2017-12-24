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

function pad2($n){
    $n = "".$n;
    while(strlen($n)<2){$n="0".$n;}
    return $n;
}

function format_time($t){
    $out = pad2(floor($t));
    $out .= ":";
    $out .= pad2(floor(.5+60*($t-floor($t))));
    return $out;
}

function format_time_mins_before($t,$m){
    return format_time($t-$m/60);
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

    //print_r($_POST);
    //echo("<br /><br />");

    $eat = $_POST['eat-time'];

    add_essential($eat,0,"Eat Christmas dinner");

    for($i=1;isset($_POST['meatt'.$i]);$i++){
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
        }
        if($t=="pork2"){
            add_essential($eat,20 + 45/450 * $w,"Turn ".$name." down to ".temp(180));
            add_essential($eat,20 + 20 + 45/450 * $w,"Put ".$name." in oven at ".temp(245));
            add_variable($eat,20,"Check the ".$name.". If cooked, take it out and rest it");
        }
        if($t=="chicken"){
            add_variable($eat,20 + 20 + 20/450 * $w,"Stuff the ".$name);
            add_essential($eat,20 + 20/450 * $w,"Put ".$name." in oven at ".temp(190));
            add_variable($eat,20,"Check the ".$name.". If cooked, take it out and rest it");
        }
        if($t=="turkey"){
            $cook = $w/1000 * 20 + 70;
            if($w>=4000){$cook += 20;}
            add_variable($eat,$cook+40,"Stuff the ".$name);
            add_essential($eat,$cook+20,"Put ".$name." in oven at ".temp(190));
            add_variable($eat,20,"Check the ".$name.". If cooked, take it out and rest it");
        }
        if($t=="ham"){
            add_essential($eat,90 + 20/450 * $w,"Put ".$name." on to boil");
            add_essential($eat,90,"Turn ".$name." off and leave in water to cool");
            add_essential($eat,30,"Put ".$name." in oven to warm");
        }
        if($t=="lamb"){
            add_essential($eat, 30 + 30/450 * $w, "Put ".$name." in the oven at ".temp(230));
            add_essential($eat, 30/450 * $w, "Turn ".$name." down to ".temp(190));
        }
        if($t=="beef"){
            if($r=="rare"){$cook = 15/450 * $w;}
            if($r=="medium"){$cook = 30/450 * $w;}
            if($r=="well-done"){$cook = 45/450 * $w;}
            add_essential($eat, 20 + $cook, "Put ".$name." in the oven at ".temp(230));
            add_essential($eat, $cook, "Turn ".$name." down to ".temp(190));
        }
    }

    if(on("pigs")){
        add_variable($eat, 90, "Wrap sausages in bacon");
        add_essential($eat, 60, "Put pigs in blankets in the oven");
    }


    for($i=1;isset($_POST['nonmeatt'.$i]);$i++){
        $t = $_POST['nonmeatt'.$i];
        if($t=="bread"){
            add_essential($eat,60,"Put koulibiaca in oven");
        }
    }

    if(on("roast-potatoes")){
        add_variable($eat, 180, "Peel and chop roast potatoes");
        add_variable($eat, 150, "Put roast potatoes on to boil");
        add_variable($eat, 135, "Once the roast potatoes are almost completely cooked through, drain them");
        add_essential($eat, 120, "Put roast potatoes in oven");
    }
    if(on("new-potatoes")){
        add_essential($eat, 25, "Put new potatoes on to boil");
    }
    if(on("parsnips")){
        add_variable($eat, 80, "Put parsnips on to boil");
        add_essential($eat, 60, "Put parsnips in oven");
    }
    $fry = Array();
    if(on("carrots")){$fry[] = "carrots";}
    if(on("leeks")){$fry[] = "leeks";}
    if(on("mushrooms")){$fry[] = "mushrooms";}
    if(count($fry)>0){
        add_essential($eat, 30, "Put ".custom_join($fry)." on to fry in butter");
    }
    if(on("peas")){
        add_essential($eat, 20, "Put water for peas on to boil");
        add_essential($eat, 8, "Put peas in their boiling water");
    }
    if(on("broccoli")){
        add_essential($eat, 20, "Put water for broccoli on to boil");
        add_essential($eat, 8, "Put broccoli in their boiling water");
    }
    if(on("cauliflower")){
        add_essential($eat, 20, "Put water for cauliflower on to boil");
        add_essential($eat, 8, "Put cauliflower in their boiling water");
    }
    if(on("brussels")){
        add_essential($eat, 15, "Put water for brussels sprouts on to boil");
        add_essential($eat, 5, "Put brussels sprouts in their boiling water");
    }

    if(on("gravy")){
        add_essential($eat, 30, "Make gravy");
    }

    $k = array_keys($times);
    sort($k);
    echo("<table class='xmas-timetable'>");
    echo("<thead><td>Time</td><td>Activity</td></thead>");
    foreach($k as $i){
        echo("<tr><td>".$i."</td><td>".join("<br />",$times[$i])."</td></tr>");

    }
    echo("</table>");

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
    echo("<option value='Cfan' selected>&deg;C fan oven</option>");
    echo("<option value='F' selected>&deg;F</option>");
    echo("<option value='gas' selected>gas oven</option>");
    echo("<option value='desc' selected>a descriptive oven</option>");
    echo("</select></label>");
    echo("<br /><br /><input name='make' value='Make timetable' type='submit'>");
    echo("</form>");

    echo("<script type='text/javascript' src='planner.js'></script>");
}
?>
