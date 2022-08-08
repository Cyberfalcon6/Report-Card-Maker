var tit ;

function test1()
{
   var inss = document.getElementsByName('input');
   for(p=0;p<inss.length;p++)
   {
       inss[p].ondblclick = function()
       {
           this.removeAttribute('disabled');
       }
   }
}
function subm()
{
    
    var abbr = String(tit).substr((tit.length)-3,3);
    var params = "table=".concat(tit).concat("&abbr=").concat(abbr).concat("&");
    var lengt = parseInt(document.getElementById('lengt').value);
    var inputs = [];
    var i = 100;
    lengt += 100;
    clearInterval(shake);
    //alert(lengt);
    while (i!=lengt){
        //alert(document.getElementById(i).value);
        inputs[i-100] = document.getElementById(i).value;
        i++;
    }
    
    if(!(inputs[0]))
    {
        var c = 0;
        document.getElementById('reserved').style = "color: red;visibility: visible;opacity: 1;";
        document.getElementById('reserved').innerHTML = "Please Enter the name of the student";
        var shake = setInterval(() => {
            if(c==10)
            {
                document.getElementById('reserved').style = "visibility: hidden";
                return 0;
            }
            if(document.getElementById('shaker').checked)
            {
                document.getElementById('reserved').style = "color: red;left: 25%";
                document.getElementById('shaker').checked = false;
            }
            else
            {
                document.getElementById('reserved').style = "color: red;left: 45%";
                document.getElementById('shaker').checked = true;
            }
            c++;
        }, 200);
        document.getElementById('comment').style = "visibility: hidden";
        return 0;
    }
    
    if(inputs.length>10)
    {
        params += "level=olevel";
    }
    else
    {
        params +="level=alevel";
    }

    for(j=0;j<inputs.length;j++)
    {
        params += "&l".concat(j).concat("=").concat(inputs[j]);
    }
    var xhr = new XMLHttpRequest;
    xhr.open("POST","add_student.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.setRequestHeader("content-length",params.length);
    xhr.send(params);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState===4)
        {
            document.getElementById('reserved').style = "color: teal;";
            document.getElementById('reserved').innerHTML = this.responseText;
            document.getElementById('comment').innerHTML = "";
            
            
        }
        var timer = setTimeout(() => {
            document.getElementById('refresh').click();
        }, 10000);
    }
    
    
    
}
function create_student(id)
{
    tit = id;
    document.getElementById(id).style = "visibility: hidden";
    var newdiv = document.createElement('div');
    newdiv.id = "newdiv";
    var params = "class=".concat(id);
    var xhr =new  XMLHttpRequest;
    xhr.open("POST","add_container.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.setRequestHeader("content-length",params.length);
    xhr.send(params);
    xhr.onreadystatechange = function()
    {
        if(this.readyState===4)
        {
               newdiv.innerHTML = String(this.responseText);
               document.getElementsByTagName('table')[0].innerHTML += (newdiv.innerHTML);
             
        }
    }
}

function get_table(id)
{
    
    //the code snippet for automatically hiding sidebar when class is choosen ...........
    document.getElementById('menu').style = "left: -20%;width: 0%; height: fit-content;transition: .5s ease-in-out;";
        document.getElementById('user').style = "visibility: hidden";
        for(var i = 0;i<document.getElementsByName('line').length;i++)
        {
            document.getElementsByName('line')[i].style = "visibility: hidden";
        }
        document.getElementById('menu_button').style = "position: fixed; left: 0%;transform: rotate(0deg);transition: .5s ease-in-out;";
        
        for(i=0;i<document.getElementsByName('container').length;i++)
        {
            document.getElementsByName('container')[i].style = "left: 20%;";
        }
        document.getElementById('expanded').checked = false;  //it ends here







       
    var level = "alevel";
    var clas = (document.getElementById(id).firstElementChild.innerHTML).replace(" ","");
    var comb = (document.getElementById(id).lastElementChild.innerHTML).replace(" ","");
    
    if(comb==="olevel")
    {
        level = "olevel";
    }
    var maximum = "false";
    var rank = "false";
    var norm = "false";
    var tot = "false";
    if(clas.includes("maximum"))
    {
        maximum = "true";
        document.getElementById('report_maker').hidden = true;
    }
    
    else if(String(clas).includes("rank"))
    {
        rank = "true";
        document.getElementById('report_maker').hidden = true;
    }
    else if(!(String(clas).includes("total") || String(clas).includes("exam")))
    {
        norm = "true";
        document.getElementById('cl').hidden = false;
        document.getElementById('report_maker').hidden = false;
    }
    else
    {
        tot = "true";
        document.getElementById('report_maker').hidden = true;
    }
    var params = "clas=".concat(clas).concat("&level=").concat(level).concat("&combination=").concat(comb).concat("&is_maximum=").concat(maximum).concat("&is_rank=").concat(rank).concat("&is_norm=").concat(norm);
    var xhr = new XMLHttpRequest;
    xhr.open("POST","get_table.php",true);
    
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xhr.setRequestHeader('Content-length',params.length);
    xhr.send(params);
    
    xhr.onreadystatechange = function()
    {
        
        if(xhr.readyState===4)
        {
            
            
            document.getElementById('container').innerHTML = xhr.responseText;
            if(rank=='true')
            {
                update_rank();
            }
            update_total();
        }
    }
}
function expand()
{
    if(document.getElementById('expanded').checked)
    {
        document.getElementById('menu').style = "left: -20%;width: 0%;height: fit-content;transition: .5s ease-in-out;";
        document.getElementById('user').style = "visibility: hidden";
        document.getElementById('prof').style = "position: fixed;left: 5%;top: 1%;border-radius: 360px;width: 6%;transition .5s ;";
        for(var i = 0;i<document.getElementsByName('line').length;i++)
        {
            document.getElementsByName('line')[i].style = "visibility: hidden";
        }
        document.getElementById('menu_button').style = "position: fixed; left: 0%;transform: rotate(0deg);transition: .5s ease-in-out;";
        for(i=0;i<document.getElementsByName('container').length;i++)
        {
            document.getElementsByName('container')[i].style = "left: 20%;";
        }
        document.getElementById('expanded').checked = false;
    }
    else
    {
        document.getElementById('prof').style = "position: absolute;top: 5%;left: 50%;border: 1px solid white;border-radius: 360px;transition .4s;";
        for(var i = 0;i<document.getElementsByName('line').length;i++)
        {
            document.getElementsByName('line')[i].style = "visibility: visible";
        }
        document.getElementById('user').style = "visibility: visible";
        document.getElementById('menu').style = "left: 0%;width: 100%;height:fit-content;transition: .5s ease-in-out;";
        document.getElementById('menu_button').style = "position: fixed; left: 0%;top: 0%;transform: rotate(135deg);transition: .5s ease-in-out;";
        for(i=0;i<document.getElementsByName('container').length;i++)
        {
            document.getElementsByName('container')[i].style = "left: 45%;";
        }
        document.getElementById('expanded').checked = true;
    }
}
function enable()
{
    if(document.getElementById('editable').checked)
    {
        document.getElementById('editable').checked = false;
    }
    else
    {
        document.getElementById('editable').checked = true;
    }
}
function editable(x)
{
    var username= document.getElementById('username').value;
    var password= document.getElementById('password').value;
    if(document.getElementById('editable').checked)
    {
        
        document.getElementById(x).focus();
    }
    else
    {
        document.getElementById(x).blur();
    }
}
function setup()
{
    document.getElementById('editable').checked = false;
}
function sb()
{
    document.forms[0].submit;
}
function delet(d)
{
    var name_to_be_removed = document.getElementById('chooser').value; 
    var tabl = String(d).substring(0,(String(d.length))-1);
    var params = "name=".concat(name_to_be_removed).concat("&table=").concat(tabl);
    var xhr = new XMLHttpRequest;
    xhr.open("POST","delete_student.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.setRequestHeader("content-length",params.length);
    xhr.send(params);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState)
        {
            if((this.responseText).includes("no"))
            {
                document.getElementById('reserved').style = "visibility: visible";
                document.getElementById('reserved').style = "opacity: 1";
                document.getElementById('reserved').innerHTML = this.responseText;
            }
            else
            {
                var refresher = setTimeout(() => {
                    document.getElementById('refresh2').click();
                }, 1000);
            }
        }
    }
     

}


function comment_remover()
{
    var c = 1;
    var noo = setInterval(() => {
        c++;
        if(c==2)
        {
            document.getElementById('comment').inn = "opacity: 0";
            document.getElementById('reserved').style = "opacity: 0";
            document.getElementById('comment').style = "visibility: hidden";
            document.getElementById('reserved').style = "visibility: hidden";
            return 0;
        }
    }, 1000);
}
function edit()
{
    
    document.getElementById('pen_editor').hidden = true;
    var abbr = document.getElementById('table_keeper').value;
    var params = "table=".concat(abbr).concat("&");
    var lengt = parseInt(document.getElementById('lengt').value);
    var i = 0;
    var level = 'alevel';
    
    if(lengt>10)
    {
        level = 'olevel';
    }
    while (i<lengt){
        if(i==0)
        {
            document.getElementById('table').innerHTML += "<div id='searcher'><form id='fomu' action='edit_student.php' autocomplete='off' method='POST' onsubmit='exist()'><td><input type='text' oninput='get_part_for_edit();' required style='border:1px solid teal;outline: none;width: 225px;' id='".concat(i).concat("t").concat("' ").concat(" name='").concat(i).concat("t").concat("'></td>");
        }
        else
        {
            document.getElementById('fomu').innerHTML += "<td><input type='text' style='border:1px solid teal;outline: none;width: 5%;' id='".concat(i).concat("t").concat("' ").concat(" name='").concat(i).concat("t").concat("'></td>");
        }
        i++;
    }
    document.getElementById('fomu').innerHTML += "<input type='hidden' name='level' value='".concat(level).concat("'><input type='submit' hidden value='Edit' id='edit_button'><input type='hidden' name='tabb' value='".concat(document.getElementById('table_keeper').value).concat("'>"));
    document.getElementById('table').innerHTML += "</div><div id='edit_list' style='width: 220px;visibility: hidden;'></div>";
    
}
function get_part()
{
    if(document.getElementById('chooser').value==="")
    {
        document.getElementById('fail').innerHTML = "";
        document.getElementById('fail').style = "visibility: hidden";
    }
    else
    {
    var xhr = new XMLHttpRequest;
    var other = document.createElement('div');
    other.style = "background-color: wheat;";
    var parameters = "name=";
    parameters += document.getElementById('chooser').value;
    var tabl = document.getElementById('table_keeper').value;
    parameters += "&table=".concat(tabl);
    xhr.open("POST","give_part.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.setRequestHeader("content-length",parameters.length);
    xhr.send(parameters);
    
    xhr.onreadystatechange = function()
    
    {
        if(this.readyState===4)
        {
            document.getElementById('fail').style = "visibility: visible";
            document.getElementById('fail').innerHTML = this.responseText;
        }
    }
    }
}
function fil(h)
{
    document.getElementById('chooser').value = h;
    document.getElementById((document.getElementById('table_keeper').value).concat("d")).click();
    alert((document.getElementById('table_keeper').value).concat("d"));
}
function get_part_for_edit()
{
    if(document.getElementById('0t').value==="")
    {
        
        document.getElementById('edit_list').innerHTML = "";
        document.getElementById('edit_list').style = "visibility: hidden";
    }
    else
    {
        document.getElementById('edit_list').hidden = false;
    var xhr = new XMLHttpRequest;
    var parameters = "name=";
    parameters += document.getElementById('0t').value;
    var tabl = document.getElementById('table_keeper').value;
    parameters += "&table=".concat(tabl);
    xhr.open("POST","give_part_for_edit.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.setRequestHeader("content-length",parameters.length);
    xhr.send(parameters);
    
    xhr.onreadystatechange = function()
    
    {
        if(this.readyState===4)
        {
            document.getElementById('edit_list').style = "visibility: visible";
            document.getElementById('edit_list').innerHTML = this.responseText;
        }
    }
    }
}
function fill_editor(h)
{
    var lengt = document.getElementById('lengt').value;
    for(e=0;e<lengt;e++)
    {
        document.getElementById(String(e).concat('t')).value = "";
    }
    var xhr = new XMLHttpRequest;
    document.getElementById('0t').value = h;
    document.getElementById('edit_list').hidden =true;
    var name = document.getElementById('0t').value;
    var locator = 0;
    var tabl = document.getElementById('table_keeper').value;
    var parameters = "name=".concat(name);
    parameters += "&table=".concat(tabl);
    xhr.open("POST","data_fetcher.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.setRequestHeader("content-length",parameters.length);
    xhr.send(parameters);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState==4)
        {
            var resp = String(this.responseText);
            if(this.responseText==0)
            {
                document.getElementById('crea').innerHTML = "<img src='no.png' width='45%'>";
                document.getElementById('edit_button').hidden = true;
            }
            else
            {
                document.getElementById('edit_button').hidden = false;
            for(i=0;i<resp.length;i++)
            {
                document.getElementById('crea').innerHTML = "<img src='yes.png' width='45%'>";
                if((resp.substr(i,1)===" ") && i>(name.length)-1)
                {
                     locator++;
                }
                if(locator!==0)
                {
                    document.getElementById(String(locator).concat('t')).value += resp.substr(i,1);
                }
                
            }
        }
        }
    }   
}
function update_rank()
{
    
    document.getElementById('updater').hidden = true;
    var table = document.getElementById('table_keeper').value;
    //alert(table);
    var params = "table=".concat(table);
    var xhr = new XMLHttpRequest;
    xhr.open("POST","Rank_updater.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.setRequestHeader("Content-length",params.length);
    xhr.send(params);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState===4)
        {
            
        }
    }

}
function update_total()
{
    
    var table = document.getElementById('table_keeper').value;
    //alert(table);
    var params = "table=".concat(table);
    var xhr = new XMLHttpRequest;
    xhr.open("POST","total_updater.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.setRequestHeader("Content-length",params.length);
    xhr.send(params);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState===4)
        {
        }
    }
}
function show_tbox()
{
    if(document.getElementById('tbox_check').checked)
    {
        
        document.getElementById('delete_class_pane').style = "left: 95%;transition: .5s ease-in-out;";
        document.getElementById('tbox_check').click();
        document.getElementById('tbox').hidden = true;
        document.getElementById('su').hidden = true;
    }
    else
    {
        document.getElementById('tbox').hidden = false;
        document.getElementById('su').hidden = false;
        document.getElementById('tbox').style = "background-color: white;color: black;border-style: dotted;border-radius: 10px;border: 1px solid magenta;"
        document.getElementById('delete_class_pane').style = "left: 80%;transition: .5s ease-in-out;";
        document.getElementById('tbox_check').click();
    }
}
function make_report()
{
    var clas = document.getElementById('table_keeper').value;
    var name = document.getElementById('rbox').value;
    document.getElementById('classs').value = clas;
    var xhr = new XMLHttpRequest;
    var params = "class=".concat(clas).concat("&name=").concat(name);
    xhr.open("POST","available.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.setRequestHeader("content-length",params.length);
    xhr.send(params);
    xhr.onreadystatechange = function()
    {
        if(this.readyState===4)
        {
        if(String(this.responseText).includes("yes"))
        {
            document.forms[0].submit();
        }
        else
        {
            document.getElementById('comment').innerHTML = "No data for this student Please check your name";
            alert("This Student does not exist check your name");
        }
    }
    }


}
/*function show_rbox()
{
    if(document.getElementById('rcheck').checked)
    {
        document.getElementById('rbox').hidden = true;
        document.getElementById('make').hidden = true;
        document.getElementById('report_maker').style = "left: 94.5%;";
        document.getElementById('make').style = "width: 40px;"; 
        document.getElementById('book').style = "width: 40px;display: inline;"; 

        document.getElementById('rcheck').click();
    }
    else
    {
        document.getElementById('rbox').hidden = false;
        document.getElementById('make').hidden = false;
        document.getElementById('report_maker').style = "left: 70%;";
        document.getElementById('make').style = "background-color: teal;color: black;border-radius: 10px;width: 40px;";
        document.getElementById('rcheck').click();
        document.getElementById('book').style = "width: 40px;display: inline;";

    }
}*/
function get_suggestions()
{
    var sht = document.getElementById('rbox').value;
    if(sht.length<1)
    {
        document.getElementById('suggestions').innerHTML = "";
    }
    else
    {
    var clas = document.getElementById('table_keeper').value;
    var params = "short=".concat(sht).concat("&class=").concat(clas);
    var xhr = new XMLHttpRequest;
    xhr.open("POST","give_suggestions.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.setRequestHeader("content-length",params.length);
    xhr.send(params);
    xhr.onreadystatechange = function()
    {
        if(this.responseText)
        {
            document.getElementById('suggestions').innerHTML = this.responseText;
        }
    }
}
}
function report(d)
{
    document.getElementById('rbox').value = d;
    document.getElementById('suggestions').innerHTML = "";
}
function s()
{
    document.getElementById('se').value = document.getElementById('table_keeper').value;
    document.forms[2].submit();
}