function xmas_error(txt) {
    return "<span style='color:red;font-weight:bold'>! " + txt + " !</span>";
}

function rarity(v, id){
    if(v=="beef"){
        document.getElementById(id).style.display = "inline-block"
    } else {
        document.getElementById(id).style.display = "none"
    }
}

function makeMeat(n){
    out = "<select id='xmas-meatt"+n+"' onchange=\"rarity(this.value, 'xmas-meatr"+n+"');updateTimetable()\">"
    out += "<option value='' selected></option>"
    out += "<option value='turkey'>Turkey</option>"
    out += "<option value='chicken'>Chicken</option>"
    out += "<option value='pork'>Pork (leg or loin)</option>"
    out += "<option value='pork2'>Pork (other)</option>"
    out += "<option value='ham'>Ham</option>"
    out += "<option value='lamb'>Lamb</option>"
    out += "<option value='beef'>Beef</option>"
    out += "</select>"
    out += "<select id='xmas-meatr"+n+"' style='display:none' onchange='updateTimetable()'>"
    out += "<option value='rare'>rare</option>"
    out += "<option value='medium' selected>medium</option>"
    out += "<option value='well-done'>well done</option>"
    out += "</select>"
    out += "&nbsp;Weight:<input id='xmas-meatw"+n+"' size=4 onchange='updateTimetable()'>"
    out += "<select id='xmas-meatu"+n+"' onchange='updateTimetable()'>"
    out += "<option value='kg' selected>kg</option>"
    out += "<option value='g'>g</option>"
    out += "<option value='oz'>oz</option>"
    out += "</select>"
    return out
}

function show_non_info(n){
    v = document.getElementById("xmas-nonmeatt"+n).value
    if(v == "bread"){
        document.getElementById("xmas-nonmeatinfo"+n).innerHTML = "<a href='http://oxmas.xyz/recipe.php?what=koulibiaca' target='new'>click here for recipe</a>"
    }
}

function makeNonMeat(n){
    out = "<select id='xmas-nonmeatt"+n+"' onchange='show_non_info("+n+");updateTimetable()'>"
    out += "<option value='' selected></option>"
    out += "<option value='bread'>Christmas Koulibiaca</option>"
    out += "</select><span id='xmas-nonmeatinfo"+n+"' style='margin-left:5px'></span>"
    return out
}

function makeVeg(){
    join = " &nbsp; "
    out = ""
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-roast-potatoes'>Roast potatoes</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-new-potatoes'>New potatoes</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-parsnips'>Parsnips</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-peas'>Peas</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-broccoli'>Broccoli</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-cauliflower'>Cauliflower</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-carrots'>Carrots</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-leeks'>Leeks</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-mushrooms'>Mushrooms</label>"
    out += join
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-brussels'>Brussels sprouts</label>"
    return out
}

function makeOther(){
    join = " &nbsp; "
    out = ""
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-gravy'>Gravy</label>"
    return out
}

function makeMeatTicks(){
    join = " &nbsp; "
    out = ""
    out += "<label><input onchange='updateTimetable()' type='checkbox' id='xmas-pigs'>Pigs in blankets</label>"
    return out
}


meatN = 0
nonmeatN = 0


function addMeat(){
    meatN += 1
    document.getElementById("meatinputs"+meatN).innerHTML += makeMeat(meatN) + "<br />"+"<span id='meatinputs"+(meatN+1)+"'></span>"
    return false
}
function addNonMeat(){
    nonmeatN += 1
    document.getElementById("nonmeatinputs"+nonmeatN).innerHTML += makeNonMeat(nonmeatN) + "<br />"+"<span id='nonmeatinputs"+(nonmeatN+1)+"'></span>"
    return false
}
function showVeg(){
    document.getElementById("veginputs").innerHTML = makeVeg()
}
function showOther(){
    document.getElementById("otherinputs").innerHTML = makeOther()
}
function showMeat(){
    document.getElementById("meatticks").innerHTML = makeMeatTicks()
}

var aim_hours = -1
var aim_minutes = -1

function pad2(n) {
    n = Math.floor(n + 0.5);
    if (n < 10) {
        return "0" + n
    } else {
        return n
    }
}

function xmas_time(minutes_before) {
    var m = aim_minutes - minutes_before;
    var h = aim_hours;
    if (m <= 0) {
        n = -Math.floor(m / 60);
        h -= n;
        m += 60 * n;
    }
    while(h < 0) {h += 24;}
    return pad2(h) + ":" + pad2(m);
}

function temp(n){
    var ot = document.getElementById("xmas-oven-type").value;
    if(ot == "C"){
        return n + "&deg;C";
    }
    if(ot == "Cfan"){
        return (n-20) + "&deg;C";
    }
    if(ot == "F"){
        return (Math.floor((n*9/5+32)/5)*5) + "&deg;F";
    }
    if(ot == "gas"){
        if(n>=240){mark=9;}
        else if(n>=230){mark=8;}
        else if(n>=220){mark=7;}
        else if(n>=200){mark=6;}
        else if(n>=190){mark=5;}
        else if(n>=180){mark=4;}
        else if(n>=170){mark=3;}
        else if(n>=150){mark=2;}
        else if(n>=140){mark=1;}
        else {mark=0;}
        return "gas mark " + mark;
    }
    if(ot == "desc"){
        if(n>=240){return "very hot";}
        else if(n>=220){return "hot";}
        else if(n>=190){return "moderately hot";}
        else if(n>=170){return "moderate";}
        else if(n>=140){return "slow";}
        else {return "very slow";}
    }
    return n + "&deg;C";
}

function custom_join(things) {
    if (things.length == 0) {
        return "ERROR";
    }
    if (things.length == 1) {
        return things[0];
    }
    if (things.length == 2) {
        return things[0] + " and " + things[1];
    }
    return things.shift() + ", " + custom_join(things);
}

function generate_times() {
    var times = [];
    times[times.length] = [true, 0, "Eat " + document.getElementById("xmas-event").value + " dinner"];
    var gantt = [];

    // Meat
    for (var i = 1; document.getElementById("xmas-meatt" + i) != null; i++) {
        var t = document.getElementById("xmas-meatt" + i).value;
        var w = document.getElementById("xmas-meatw" + i).value;
        var u = document.getElementById("xmas-meatu" + i).value;
        var r = document.getElementById("xmas-meatr" + i).value;
        var name = w + u + " ";
        if (!(w > 0)) {
            continue;
        }
        if (t=="pork2"){ name+="pork";} else {name+=t;}
        if(u=="oz"){w *= 28.35;}
        if(u=="kg"){w *= 1000;}
        if(t=="pork"){
            times[times.length] = [true,20 + 20 + 35/450 * w,"Put " + name + " in oven at " + temp(245)];
            times[times.length] = [true,20 + 35/450 * w,"Turn " + name + " down to " + temp(190)];
            times[times.length] = [false,20,"Check the " + name + ". If cooked, take it out and rest it"];
            gantt[gantt.length] = [
                [20 + 20 + 35/450 * w, 20,0, "Roast " + name + " at " + temp(245)],
                [20 + 35/450 * w, 35/450 * w,0, "Roast " + name + " at " + temp(190)],
                [20,15,5,"Rest " + name]
            ];
        }
        if(t=="pork2"){
            times[times.length] = [true,20 + 20 + 45/450 * w,"Put " + name + " in oven at " + temp(245)];
            times[times.length] = [true,20 + 45/450 * w,"Turn " + name + " down to " + temp(180)];
            times[times.length] = [false,20,"Check the " + name + ". If cooked, take it out and rest it"];
            gantt[gantt.length] = [
                [20 + 20 + 45/450 * w, 20,0, "Roast " + name + " at " + temp(245)],
                [20 + 45/450 * w, 45/450 * w,0, "Roast " + name + " at " + temp(180)],
                [20,15,5,"Rest " + name]
            ];
        }
        if(t=="chicken"){
            times[times.length] = [false,20 + 20 + 20/450 * w,"Stuff the " + name];
            times[times.length] = [true,20 + 20/450 * w,"Put " + name + " in oven at " + temp(190)];
            times[times.length] = [false,20,"Check the " + name + ". If cooked, take it out and rest it"];
            gantt[gantt.length] = [
                [30 + 20 + 20/450 * w, 20,10, "Stuff the " + name],
                [20 + 20/450 * w, 20/450 * w,0, "Roast " + name + " at " + temp(190)],
                [20,15,5,"Rest " + name]
            ];
        }
        if(t=="turkey"){
            var cook = w/1000 * 20 + 70;
            if(w>=4000){cook += 20;}
            times[times.length] = [false,cook+40,"Stuff the " + name];
            times[times.length] = [true,cook+20,"Put " + name + " in oven at " + temp(190)];
            times[times.length] = [false,20,"Check the " + name + ". If cooked, take it out and rest it"];
            gantt[gantt.length] = [
                [50 + cook, 20,10, "Stuff the " + name],
                [20 + cook, cook,0, "Roast " + name + " at " + temp(190)],
                [20,15,5,"Rest " + name]
            ];
        }
        if(t=="ham"){
            times[times.length] = [true,90 + 20/450 * w,"Put " + name + " on to boil"];
            times[times.length] = [true,90,"Turn " + name + " off and leave in water to cool"];
            times[times.length] = [true,30,"Put " + name + " in oven to warm"];
            gantt[gantt.length] = [
                [120 + 20/450 * w, 20/450 * w,30, "Boil " + name],
                [120, 60, 30, "Leave " + name + " in water to cool"],
            ];
        }
        if(t=="lamb"){
            times[times.length] = [true, 50 + 30/450 * w, "Put " + name + " in the oven at " + temp(230)];
            times[times.length] = [true, 20 + 30/450 * w, "Turn " + name + " down to " + temp(190)];
            times[times.length] = [false,20,"Check the " + name + ". If cooked, take it out and rest it"];
            gantt[gantt.length] = [
                [50 + 30/450 * w, 30,0, "Roast " + name + " at " + temp(230)],
                [20 + 30/450 * w, 30/450 * w,0, "Roast " + name + " at " + temp(190)],
                [20,15,5,"Rest " + name]
            ];
        }
        if(t=="beef"){
            var cook = 0;
            if(r=="rare"){cook = 15/450 * w;}
            if(r=="medium"){cook = 30/450 * w;}
            if(r=="well-done"){cook = 45/450 * w;}
            times[times.length] = [true, 40 + cook, "Put " + name + " in the oven at " + temp(230)];
            times[times.length] = [true, 20 + cook, "Turn " + name + " down to " + temp(190)];
            times[times.length] = [false,20,"Check the " + name + ". If cooked, take it out and rest it"];
            gantt[gantt.length] = [
                [40 + cook, 20,0, "Roast " + name + " at " + temp(230)],
                [20 + cook, cook,0, "Roast " + name + " at " + temp(190)],
                [20,15,5,"Rest " + name]
            ];
        }
    }

    // pigs
    if(document.getElementById("xmas-pigs").checked) {
        times[times.length] = [false, 90, "Wrap sausages in bacon"];
        times[times.length] = [true, 60, "Put pigs in blankets in the oven"];
        gantt[gantt.length] = [
            [100, 20,20, "Wrap sausages in bacon"],
            [60, 60,0, "Pigs in blankets in oven"]
        ];
    }

    // vegetarian
    for (var i = 1; document.getElementById("xmas-nonmeatt" + i) != null; i++) {
        var t = document.getElementById("xmas-nonmeatt" + i).value;
        if(t=="bread") {
            times[times.length] = [false, 180, "Make koulibiaca"];
            times[times.length] = [true, 60, "Put koulibiaca in oven"];
            gantt[gantt.length] = [
                [180,50,70, "Make koulibiaca"],
                [60, 60,0, "Koulibiaca in oven"]
            ];
        }
    }

    // vegetables
    if(document.getElementById("xmas-roast-potatoes").checked) {
        times[times.length] = [false, 180, "Peel and chop roast potatoes"];
        times[times.length] = [false, 150, "Put roast potatoes on to boil"];
        times[times.length] = [false, 135, "Once the roast potatoes are close to crumbling, drain them and shake them in pan to make them flaky"];
        times[times.length] = [true, 120, "Put roast potatoes in oven"];
        gantt[gantt.length] = [
            [210,30,30, "Peel and chop roast potatoes"],
            [180,15,45, "Boil potatoes"],
            [120,120,0, "Roast potatoes"]
        ];
    }
    if(document.getElementById("xmas-new-potatoes").checked) {
        times[times.length] = [true, 25, "Put new potatoes on to boil"];
        gantt[gantt.length] = [[25,25,0, "Boil new potatoes"]]
    }
    if(document.getElementById("xmas-parsnips").checked) {
        times[times.length] = [false, 160, "Peel and cut parsnips"];
        times[times.length] = [false, 115, "Boil parsnips"];
        times[times.length] = [false, 100, "Once the parsnips are soft, drain them"];
        times[times.length] = [true, 90, "Put parsnips in oven"];
        gantt[gantt.length] = [
            [160,20,25, "Peel and cut parsnips"],
            [115,10,15, "Boil parsnips"],
            [90,90,0, "Roast parsnips"]
        ];
    }
    if(document.getElementById("xmas-peas").checked) {
        times[times.length] = [true, 20, "Put water for peas on to boil"];
        times[times.length] = [true, 8, "Put peas in their boiling water"];
        gantt[gantt.length] = [
            [30,12,10, "Heat water for peas"],
            [8,8,0, "Boil peas"]
        ];
    }
    if(document.getElementById("xmas-broccoli").checked) {
        times[times.length] = [false, 40, "Cut up broccoli"];
        times[times.length] = [true, 20, "Put water for broccoli on to boil"];
        times[times.length] = [true, 8, "Put broccoli in their boiling water"];
        gantt[gantt.length] = [
            [50,20,10, "Cut up broccoli"],
            [30,12,10, "Heat water for broccoli"],
            [8,8,0, "Boil broccoli"]
        ];
    }
    if(document.getElementById("xmas-cauliflower").checked) {
        times[times.length] = [false, 40, "Cut up cauliflower"];
        times[times.length] = [true, 20, "Put water for cauliflower on to boil"];
        times[times.length] = [true, 8, "Put cauliflower in their boiling water"];
        gantt[gantt.length] = [
            [50,20,10, "Cut up cauliflower"],
            [30,12,10, "Heat water for cauliflower"],
            [8,8,0, "Boil cauliflower"]
        ];
    }
    if(document.getElementById("xmas-brussels").checked) {
        times[times.length] = [false, 40, "Peel and cut bottoms off brussels sprouts"];
        times[times.length] = [true, 10, "Fry brussels sprouts in saucepan with lid"];
        times[times.length] = [true, 5, "Add a little water to sprouts and bring to boil"];
        gantt[gantt.length] = [
            [50,20,15, "Prep brussels sprouts"],
            [15,10,0, "Fry brussels sprouts with lid"],
            [5,5,0, "Steam sprouts with a little water"]
        ];
    }
    var fry = [];
    if(document.getElementById("xmas-carrots").checked) {
        fry[fry.length] = "carrots"
    }
    if(document.getElementById("xmas-leeks").checked) {
        fry[fry.length] = "leeks"
    }
    if(document.getElementById("xmas-mushrooms").checked) {
        fry[fry.length] = "mushrooms"
    }
    if(fry.length > 0) {
        var fry_n = fry.length;
        var frying = custom_join(fry);
        times[times.length] = [false, 40+10*fry_n, "Prep " + frying];
        times[times.length] = [true, 30, "Put " + frying + " on to fry in butter"];
        times[times.length] = [true, 25, "Put lid on " + frying];
        gantt[gantt.length] = [
            [70+10*fry_n,20+10*fry_n,20, "Prep " + frying],
            [30,30,0, "Fry " + frying + " in butter"]
        ];
    }

    // Gravy
    if(document.getElementById("xmas-gravy").checked) {
        times[times.length] = [true, 30, "Make gravy"];
        gantt[gantt.length] = [[30,30,0,"Make gravy"]]
    }

    times.sort((a, b) => b[1] - a[1]);
    return [times, gantt]
}

function updateTimetable() {
    var aim = document.getElementById("xmas-eat-time").value
    aim_hours = aim.split(":")[0] / 1;
    aim_minutes = aim.split(":")[1] / 1;

    var format = document.getElementById("xmas-format").value;
    var timetable = "";
    var [times, gantt] = generate_times();
    if (gantt.length == 0) {
    /* ----------------------------- LIST OF TASKS ---------------------------- */
    } else if (format == "table") {
        timetable = "<h2>Timetable</h2>";
        timetable += "<table class='xmas-timetable'>";
        timetable += "<thead><td>Time</td><td>Activity</td></thead>";
        var prev = -1;
        for(var t in times) {
            var important = times[t][0];
            var minutes = times[t][1];
            var desc = times[t][2];
            if (prev != minutes) {
                if (t != 0) {
                    timetable += "</td></tr>";
                }
                timetable += "<tr><td><b>" + xmas_time(minutes) + "</b></td><td>";
            } else {
                timetable += "<br />";
            }
            prev = minutes;
            if (important) {
                timetable += "<b>" + desc + "</b>";
            } else {
                timetable += desc;
            }
        }
        timetable += "</td></tr></table>";
    /* ------------------------------ GANTT CHART ----------------------------- */
    } else if (format == "gantt") {
        timetable += "<h2>Gantt chart</h2>";
        var earliest = 0;
        for (var i = 0; i < gantt.length; i++) {
            for (var j = 0; j < gantt[i].length; j++) {
                earliest = Math.max(earliest, gantt[i][j][0]);
            }
        }

        function gx(x) { return 30 + 6 * (earliest - x); }
        function gy(y) { return 60 + 58 * y; }

        timetable += "<div class='xmas-gantt' style='position:relative;background:white;";
        timetable += "left:" + ((700-gx(0)+gx(earliest))/2-20) + "px;";
        timetable += "height:" + (gy(gantt.length)+80) + "px;";
        timetable += "width:" + (70+gx(0)-gx(earliest)) + "px'>";

        for (var t = earliest - earliest % 10; t>0; t -= 10) {
            timetable += "<div style='position:absolute;border-left:1px solid #999999;left:" + gx(t) + "px; width:2px;top:5px;height:" + (gy(gantt.length) + 30) + "px'>&nbsp;</div>";
            timetable += "<div style='position:absolute;text-align:center;left:" + (gx(t)-30) + "px;width:60px;top:5px;background-color:white;color:#999999'><small>" + xmas_time(t) + "</small></div>";
        }
        timetable += "<div style='position:absolute;border-left:1px solid #00A300;left:" + gx(t) + "px; width:2px;top:5px;height:" + (gy(gantt.length) + 30) + "px'>&nbsp;</div>";
        timetable += "<div style='position:absolute;text-align:center;left:" + (gx(t)-30) + "px; width:60px;top:5px;background-color:white;color:#00A300'><small>Eat (" + xmas_time(t) + ")</small></div>";

        for (var i = 0; i < gantt.length; i++) {
            for (var j = 0; j < gantt[i].length; j++) {
                var b = gantt[i][j];
                if (b[2] != 0){
                    timetable += "<div style='position:absolute;border:2px dashed #999999;height:50px;top:" + gy(i) + "px;left:" + (gx(b[0])+1) + "px;width:" + (gx(b[0] - b[1] - b[2]) - gx(b[0]) - 4) + "px'>&nbsp;</div>";
                }
                timetable += "<div style='position:absolute;overflow:hidden;background:#FFFFFFEE;padding:2px;border:2px solid ";
                if (b[2] == 0){
                    timetable += "black";
                } else {
                    timetable += "#999999";
                }
                timetable += ";height:46px;top:" + gy(i) + "px;left:" + (gx(b[0])+1) + "px;width:" + (gx(b[0] - b[1]) - gx(b[0]) - 7) + "px;'><small>" + b[3] + "</small></div>";
            }
        }

        timetable += "</div>";
    /* ------------------------------------------------------------------------ */
    } else {
        document.getElementById("xmas-timetable-area").innerHTML = xmas_error("INVALID FORMAT");
    }
    document.getElementById("xmas-timetable-area").innerHTML = timetable;
}

addMeat();

showVeg();
showOther();
showMeat();

updateTimetable();
