function rarity(v, id){
    if(v=="beef"){
        document.getElementById(id).style.display = "inline-block"
    } else {
        document.getElementById(id).style.display = "none"
    }
}

function makeMeat(n){
    out = "<select id='meatt"+n+"' name='meatt"+n+"' onchange=\"rarity(this.value, 'meatr"+n+"')\">"
    out += "<option value='' selected></option>"
//    out += "<option value='turkey'>Turkey</option>"
    out += "<option value='chicken'>Chicken</option>"
    out += "<option value='pork'>Pork (leg or loin)</option>"
    out += "<option value='pork2'>Pork (other)</option>"
    out += "<option value='ham'>Ham</option>"
    out += "<option value='lamb'>Lamb</option>"
    out += "<option value='beef'>Beef</option>"
    out += "</select>"
    out += "<select id='meatr"+n+"' name='meatr"+n+"' style='display:none'>"
    out += "<option value='rare'>rare</option>"
    out += "<option value='medium' selected>medium</option>"
    out += "<option value='well-done'>well done</option>"
    out += "</select>"
    out += "&nbsp;Weight:<input id='meatw"+n+"' name='meatw"+n+"' size=1>"
    out += "<select id='meatu"+n+"' name='meatu"+n+"'>"
    out += "<option value='g' selected>g</option>"
    out += "<option value='kg'>kg</option>"
    out += "<option value='oz'>oz</option>"
    out += "</select>"
    return out
}

function makeVeg(){
    out = ""
    out += "<label><input type='checkbox' id='roast-potatoes' name='roast-potatoes'> Roast potatoes</label>"
    out += " &nbsp; "
    out += "<label><input type='checkbox' id='new-potatoes' name='new-potatoes'> New potatoes</label>"
    return out
}


meatN = 0


function addMeat(){
    meatN += 1
    document.getElementById("meatinputs"+meatN).innerHTML += makeMeat(meatN) + "<br />"+"<span id='meatinputs"+(meatN+1)+"'></span>"
    return False
}
function showVeg(){
    document.getElementById("veginputs").innerHTML = makeVeg()
}

showVeg()
addMeat()

