<?php

$times = Array();

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
    $out .= pad2(floor(60*($t-floor($t))));
    return $out;
}

function format_time_mins_before($t,$m){
    return format_time($t-$m/60);
}

function temp($n){
    return $n."&deg;C";
}

if(isset($_POST['make'])){

    print_r($_POST);
    echo("<br /><br />");

    $eat = $_POST['eat-time'];

    _add($eat,0,"Eat Christmas dinner");

    for($i=1;isset($_POST['meatt'.$i]);$i++){
        $t = $_POST['meatt'.$i];
        $w = $_POST['meatw'.$i];
        $u = $_POST['meatu'.$i];
        $r = $_POST['meatr'.$i];
        echo($t." ".$w." ".$u." ".$r."<br />");
        $name = $w.$u." ";
        if($t=="pork2"){$name.="pork";} else {$name.=$t;}

        if($u=="oz"){$w *= 28.35;}
        if($u=="kg"){$w *= 1000;}
        if($t=="pork"){
            _add($eat,20 + 35/450 * $w,"Turn ".$name." down to ".temp(190));
            _add($eat,20 + 20 + 35/450 * $w,"Put ".$name." in oven at ".temp(245));
            _add($eat,20,"Check the ".$name.". If cooked, take it out and rest it");
        }
        if($t=="pork2"){
            _add($eat,20 + 45/450 * $w,"Turn ".$name." down to ".temp(180));
            _add($eat,20 + 20 + 45/450 * $w,"Put ".$name." in oven at ".temp(245));
            _add($eat,20,"Check the ".$name.". If cooked, take it out and rest it");
        }
        if($t=="chicken"){
            _add($eat,20 + 20 + 20/450 * $w,"Stuff the ".$name);
            _add($eat,20 + 20/450 * $w,"Put ".$name." in oven at ".temp(190));
            _add($eat,20,"Check the ".$name.". If cooked, take it out and rest it");
        }
        if($t=="ham"){
            //_add($eat,20,"Take ".$name."out and rest it");
            //_add($eat,20,"Take ".$name."out and rest it");
        }
        if($t=="lamb"){
            _add($eat, 30 + 30/450 * $w, "Put ".$name." in the oven at ".temp(230));
            _add($eat, 30/450 * $w, "Put ".$name." in the oven at ".temp(180));
        }
        if($t=="beef"){
            if($r=="rare"){$cook = 15/450 * $w;}
            if($r=="medium"){$cook = 30/450 * $w;}
            if($r=="well-done"){$cook = 45/450 * $w;}
            _add($eat, 20 + $cook, "Put ".$name." in the oven at ".temp(230));
            _add($eat, $cook, "Turn ".$name." down to ".temp(190));
        }
    }
    $k = array_keys($times);
    sort($k);
    echo("<table>");
    echo("<thead><td>Time</td><td>Activity</td></thead>");
    foreach($k as $i){
        echo("<tr><td>".$i."</td><td>".join("<br />",$times[$i])."</td></tr>");

    }

} else {

    echo("<form method='post'>");

    echo("<h2>Meat</h2>");
    echo("<span id='meatinputs1'></span>");
    echo("<button onclick='return addMeat()' type='button'>+</button>");

    echo("<h2>Vegetables</h2>");
    echo("<span id='veginputs'></span>");

    echo("<h2>Options</h2>");
    echo("Eating time:<input type='time' name='eat-time'>");
    echo("<br /><br /><input name='make' value='Make timetable' type='submit'>");
    echo("</form>");

    echo("<script type='text/javascript' src='planner.js'></script>");
}
?>
