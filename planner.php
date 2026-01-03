<style type='text/css'>

table.xmas-timetable,
table.xmas-timetable td,
table.xmas-timetable thead,
table.xmas-timetable tr {border:none;vertical-align:top;border-collapse:collapse}
table.xmas-timetable td {border-bottom:2px solid gray;padding:10px}

#xmas-timetable-area {
    margin-top:50px;
}

table.xmas-input-table,
table.xmas-input-table tr,
table.xmas-input-table td {
    border: 0px;
}
table.xmas-input-table tr td {
    text-align:left;
    width:50%;
    padding:4px;
}
table.xmas-input-table tr td:first-of-type {
    text-align:right;
}

label {
  display: inline-block;
}

</style>

<?php

if(isset($_POST['make'])){

    if($format == "gantt"){
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
}
    echo("
<div id='xmas-edit'>
    <$h2>Options</$h2>
    <table class='xmas-input-table'>
    <tr><td>Eating time:</td><td><input type='time' id='xmas-eat-time' value='13:00' onchange='updateTimetable()'></td></tr>
    <tr><td>Oven type:</td><td><select id='xmas-oven-type' onchange='updateTimetable()'>
    <option value='C' selected>&deg;C</option>
    <option value='Cfan'>&deg;C fan oven</option>
    <option value='F'>&deg;F</option>
    <option value='gas'>gas oven</option>
    <option value='desc'>a descriptive oven</option>
    </select></td></tr>
    <tr><td>Format:</td><td><select id='xmas-format' onchange='updateTimetable()'>
    <option value='table' selected>table</option>
    <option value='gantt'>Gantt chart</option>
    </select></td></tr>
    <tr><td>Event name:</td><td><input id='xmas-event' value='Christmas' onchange='updateTimetable()'></td></tr>
    </table>

    <$h2>Meat</$h2>
    <span id='meatinputs1'></span>
    <button onclick='return addMeat()' type='button'>+</button>
    <br /><span id='meatticks'></span>

    <$h2>Vegetarian</$h2>
    <span id='nonmeatinputs1'></span>
    <button onclick='return addNonMeat()' type='button'>+</button>

    <$h2>Vegetables</$h2>
    <span id='veginputs'></span>

    <$h2>Other</$h2>
    <span id='otherinputs'></span>
</div>

<div id='xmas-timetable-area'>
</div>

<script type='text/javascript' src='planner.js'></script>");
?>
