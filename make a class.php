<!DOCTYPE html>
<html lang='en'>
<head>
    <title>Add Class</title>
    <link rel='stylesheet' href='mstyle.css'>
    <script>
        function change()
        {
            
            if(document.getElementById('level').innerHTML==='ADVANCED LEVEL')
            {
                document.getElementById('alevel').style = "visibility: hidden;";
               
                document.getElementById('olevel').style = "visibility: visible;";
                document.getElementById('level').innerHTML = "ORDINARY LEVEL";
                document.getElementById('toggle').style = "text-align: right;";
            }
            else if(document.getElementById('level').innerHTML==='ORDINARY LEVEL')
            {
                document.getElementById('alevel').style = "visibility: visible;";
                document.getElementById('olevel').style = "visibility: hidden;";
                document.getElementById('level').innerHTML = "ADVANCED LEVEL";
                document.getElementById('toggle').style = "text-align: left;";
            }
        }
        function hid()
        {
            document.getElementById('sub').style = "visibility: hidden;";
            //document.getElementById('sub2').style = "visibility: hidden;";
            document.getElementById('')
        }
        function shw()
        {
            if(document.getElementById('ol').value!=="")
            {
            
                document.getElementById('sub2').style = "visibility: visible";
            }
            else
            {
                document.getElementById('sub2').style = "visibility: hidden";
            }
            if((document.getElementById('combination').value).length!=0)
            {
                document.getElementById('sub').style = "visibility: visible;";
                document.getElementById('sample').style = "visibility: hidden";
            }
           
        }
        function ext()
        {
            
            if((document.getElementById('combination').value).length>0)
            {
                var xhr = new XMLHttpRequest;
            var abbr = document.getElementById('combination').value;
            xhr.open("GET","get_combination.php?abbr=".concat(abbr),true);
            xhr.send(null);
            xhr.onreadystatechange = function()
            {
                if(xhr.readyState===4)
                {
                    document.getElementById('sample').style = "visibility: visible;";
                    document.getElementById('sample').innerHTML = xhr.responseText;
                }
            }}
            else
            {
                document.getElementById('sample').style = "visibility: hidden;";
                document.getElementById('sample').innerHTML = "";
                document.getElementById('sub').style = "visibility: hidden";
                document.getElementById('sub2').style = "visibility: hidden";
            }
            
        }
    </script>
</head>

   
   <?php
   session_start();
if(isset($_SESSION['username'],$_SESSION['password']))
{
    if(isset($_POST['teacher']))
    {

        $teacher = $_POST['teacher'];
    }
    echo "<body onload='ext()'>
    <h1>Create a class</h1><br><br>
   <div id='a'>A'level</div> <div id='toggle' onclick='change()'> <img src='circle.png' id='ball' width='30px' alt=''> </div><div id='o'>O'level </div> ";
    $conn = mysqli_connect('localhost','root','');
    mysqli_select_db($conn, 'temp');
    $username = mysqli_real_escape_string($conn, stripslashes(htmlentities($_SESSION['username'])));
    
    $password =mysqli_real_escape_string($conn, stripslashes(htmlentities( $_SESSION['password'])));
    
    
    if(isset($_POST['classname'],$_POST['combination']))
     {
         $category = "";
     if($_POST['level']=='alevel'){    
            $real_combos = []; //where full word for received abbreviation will be kept before inserting them into the databAse 
            $j = 0;   //the variable to track index of the above array
            $combination = mysqli_real_escape_string($conn, stripslashes(htmlentities($_POST['combination'])));
            $class = mysqli_real_escape_string($conn, stripslashes(htmlentities($_POST['classname'])));
            $lessons = mysqli_query($conn,"SELECT first_lesson,second_lesson,third_lesson FROM combinations WHERE abbr='$combination'"); //getting full word for received abbreviation
            $category_in_matrix = mysqli_query($conn,"SELECT category FROM combinations WHERE abbr='$combination'"); 
            $counter = 0;
            foreach($category_in_matrix as $cat)
            {
                foreach($cat as $c)
                {
                    if($counter ==0)
                    {
                        $category = $c;
                        $counter++;
                    }
                    else
                    {
                        continue;
                    }
                }
            }
            foreach($lessons as $constituent)
              {
        
                   foreach($constituent as $item)
               {
         $real_combos[$j] = $item;
         $j = $j + 1;
        }


    }
    try {
        $exam = str_replace(" ","",$class."_exam");      //the name of the class in  class table
        $exam_table = str_replace(" ","",$class."_exam".$combination);      //the name of the table for the class
        $maximum = str_replace(" ","",$class."_maximum");      //maximum for this class
        $rank = str_replace(" ","",$class."_rank");      //rank for this class
        $maximum_table = str_replace(" ","",$class."_maximum".$combination);      //maximum for this class
        $rank_table = str_replace(" ","",$class."_rank".$combination);      //maximum for this class
        $total_table = str_replace(" ","",$class."_total".$combination);      //maximum for this class
        if(!(strcasecmp($category,"Science"))){
            mysqli_query($conn,"CREATE TABLE $class$combination(`Names` varchar(40),`$real_combos[0]` DOUBLE,`$real_combos[1]` DOUBLE,`$real_combos[2]` DOUBLE,`Entrepreneurship` DOUBLE,`General Studies` DOUBLE,`Sports` DOUBLE,`Religious` DOUBLE,`kinyarwanda` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
            mysqli_query($conn,"CREATE TABLE $exam_table(`Names` varchar(40),`$real_combos[0]` DOUBLE,`$real_combos[1]` DOUBLE,`$real_combos[2]` DOUBLE,`Entrepreneurship` DOUBLE,`General Studies` DOUBLE,`Sports` DOUBLE,`Religious` DOUBLE,`kinyarwanda` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
            mysqli_query($conn,"CREATE TABLE $maximum_table(`Names` varchar(40),`$real_combos[0]` DOUBLE,`$real_combos[1]` DOUBLE,`$real_combos[2]` DOUBLE,`Entrepreneurship` DOUBLE,`General Studies` DOUBLE,`Sports` DOUBLE,`Religious` DOUBLE,`kinyarwanda` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
            mysqli_query($conn,"CREATE TABLE $rank_table(`Names` varchar(40),`$real_combos[0]` int,`$real_combos[1]` int,`$real_combos[2]` int,`Entrepreneurship` int,`General Studies` int,`Sports` int,`Religious` int,`kinyarwanda` int,`General Rank` int, PRIMARY KEY(`Names`))");
            mysqli_query($conn,"CREATE TABLE $total_table(`Names` varchar(40),`$real_combos[0]` Double,`$real_combos[1]` Double,`$real_combos[2]` Double,`Entrepreneurship` Double,`General Studies` Double,`Sports` Double,`Religious` Double,`kinyarwanda` Double,`Total` Double, PRIMARY KEY(`Names`))");
            mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$class','$username','$combination')");
            mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$exam','$username','$combination')");
            mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$maximum','$username','$combination')");
            mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$rank','$username','$combination')");
            header("refresh:10,index.php?comment=Class Created Successfully!");
            mysqli_query($conn, "INSERT INTO $maximum_table(`Names`) VALUES('maximum')");
       }
        elseif(!(strcasecmp($category,"Languages")))
        {
            mysqli_query($conn,"CREATE TABLE $class$combination(`Names` varchar(40),`$real_combos[0]` DOUBLE,`$real_combos[1]` DOUBLE,`$real_combos[2]` DOUBLE,`Entrepreneurship` DOUBLE,`General Studies` DOUBLE,`Sports` DOUBLE,`kiswahili` DOUBLE,`Religious` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
            mysqli_query($conn,"CREATE TABLE $exam_table(`Names` varchar(40),`$real_combos[0]` DOUBLE,`$real_combos[1]` DOUBLE,`$real_combos[2]` DOUBLE,`Entrepreneurship` DOUBLE,`General Studies` DOUBLE,`Sports` DOUBLE,`kiswahili` DOUBLE,`Religious` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
            mysqli_query($conn,"CREATE TABLE $maximum_table(`Names` varchar(40),`$real_combos[0]` DOUBLE,`$real_combos[1]` DOUBLE,`$real_combos[2]` DOUBLE,`Entrepreneurship` DOUBLE,`General Studies` DOUBLE,`Sports` DOUBLE,`kiswahili` DOUBLE,`Religious` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
            mysqli_query($conn,"CREATE TABLE $rank_table(`Names` varchar(40),`$real_combos[0]` int,`$real_combos[1]` int,`$real_combos[2]` int,`Entrepreneurship` int,`General Studies` int,`Sports` int,`kiswahili` int,`Religious` int,`General Rank` int, PRIMARY KEY(`Names`))");
            mysqli_query($conn,"CREATE TABLE $total_table(`Names` varchar(40),`$real_combos[0]` Double,`$real_combos[1]` Double,`$real_combos[2]` Double,`Entrepreneurship` Double,`General Studies` Double,`Sports` Double,`kiswahili` Double,`Religious` Double,`Total` Double, PRIMARY KEY(`Names`))");
        mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$class','$username','$combination')");
        mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$exam','$username','$combination')");
        mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$maximum','$username','$combination')");
        mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$rank','$username','$combination')");
        header("refresh:10,index.php?comment=Class Created Successfully!");
        mysqli_query($conn, "INSERT INTO $maximum_table(`Names`) VALUES('maximum')");
        }
        
        else {
              mysqli_query($conn,"CREATE TABLE $class$combination(`Names` varchar(40),`$real_combos[0]` DOUBLE,`$real_combos[1]` DOUBLE,`$real_combos[2]` DOUBLE,`Entrepreneurship` DOUBLE,`General Studies` DOUBLE,`Sports` DOUBLE,`Religious` DOUBLE,`kinyarwanda` DOUBLE,`sub-mathematics` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
              mysqli_query($conn,"CREATE TABLE $exam_table(`Names` varchar(40),`$real_combos[0]` DOUBLE,`$real_combos[1]` DOUBLE,`$real_combos[2]` DOUBLE,`Entrepreneurship` DOUBLE,`General Studies` DOUBLE,`Sports` DOUBLE,`Religious` DOUBLE,`kinyarwanda` DOUBLE,`sub-mathematics` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
              mysqli_query($conn,"CREATE TABLE $maximum_table(`Names` varchar(40),`$real_combos[0]` DOUBLE,`$real_combos[1]` DOUBLE,`$real_combos[2]` DOUBLE,`Entrepreneurship` DOUBLE,`General Studies` DOUBLE,`Sports` DOUBLE,`Religious` DOUBLE,`kinyarwanda` DOUBLE,`sub-mathematics` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
              mysqli_query($conn,"CREATE TABLE $rank_table(`Names` varchar(40),`$real_combos[0]` int,`$real_combos[1]` int,`$real_combos[2]` int,`Entrepreneurship` int,`General Studies` int,`Sports` int,`Religious` int,`kinyarwanda` int,`sub-mathematics` int,`General Rank` int, PRIMARY KEY(`Names`))");
              mysqli_query($conn,"CREATE TABLE $total_table(`Names` varchar(40),`$real_combos[0]` Double,`$real_combos[1]` Double,`$real_combos[2]` Double,`Entrepreneurship` Double,`General Studies` Double,`Sports` Double,`Religious` Double,`kinyarwanda` Double,`sub-mathematics` Double,`Total` Double, PRIMARY KEY(`Names`))");
              mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$class','$username','$combination')");
              mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$exam','$username','$combination')");
              mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$maximum','$username','$combination')");
              mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$rank','$username','$combination')");
              header("refresh:10,index.php?comment=Class Created Successfully!");
              mysqli_query($conn, "INSERT INTO $maximum_table(`Names`) VALUES('maximum')");
        }
        mysqli_select_db($conn,"payment");
        mysqli_query($conn,"CREATE TABLE $class$combination(`Names` varchar(40),`Amount Paid` int,`Amount Remaining` int)");
        mysqli_query($conn,"INSERT INTO `classes`(`class_name`, `class_teacher`, `combination`) VALUES ('$class','$teacher','$combination')");
    } catch (Exception $e) {
        echo $e;
        header("refresh:10,index.php?comment=Class Not Created Maybe It Already Exists!");
    }

}
else
{
    $combination = mysqli_real_escape_string($conn, stripslashes(htmlentities($_POST['combination'])));
    $class = mysqli_real_escape_string($conn, stripslashes(htmlentities($_POST['classname'])));
    try {
        $exam = $class."_exam";      //the name of the class in  class table
        $maximum = $class."_maximum";      //maximum for this class
        $rank = $class."_rank";      //rank for this class
        $total = $class."_total";      //total for this class
    mysqli_query($conn,"CREATE TABLE $class(`Names` varchar(40),`Mathematics` DOUBLE,`Physics` DOUBLE,`Chemistry` DOUBLE,`Biology` DOUBLE,`History` DOUBLE,`Geography` DOUBLE,`English` DOUBLE,`French` DOUBLE,`Kiswahili` DOUBLE,`Farming` DOUBLE,`ICT` DOUBLE,`Entrepreneurship` DOUBLE,`Sports` DOUBLE,`Religious` DOUBLE,`kinyarwanda` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
    mysqli_query($conn,"CREATE TABLE $exam(`Names` varchar(40),`Mathematics` DOUBLE,`Physics` DOUBLE,`Chemistry` DOUBLE,`Biology` DOUBLE,`History` DOUBLE,`Geography` DOUBLE,`English` DOUBLE,`French` DOUBLE,`Kiswahili` DOUBLE,`Farming` DOUBLE,`ICT` DOUBLE,`Entrepreneurship` DOUBLE,`Sports` DOUBLE,`Religious` DOUBLE,`kinyarwanda` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
    mysqli_query($conn,"CREATE TABLE $maximum(`Names` varchar(40),`Mathematics` DOUBLE,`Physics` DOUBLE,`Chemistry` DOUBLE,`Biology` DOUBLE,`History` DOUBLE,`Geography` DOUBLE,`English` DOUBLE,`French` DOUBLE,`Kiswahili` DOUBLE,`Farming` DOUBLE,`ICT` DOUBLE,`Entrepreneurship` DOUBLE,`Sports` DOUBLE,`Religious` DOUBLE,`kinyarwanda` DOUBLE,`Total` DOUBLE, PRIMARY KEY(`Names`))");
    mysqli_query($conn,"CREATE TABLE $rank(`Names` varchar(40),`Mathematics` int,`Physics` int,`Chemistry` int,`Biology` int,`History` int,`Geography` int,`English` int,`French` int,`Kiswahili` int,`Farming` int,`ICT` int,`Entrepreneurship` int,`Sports` int,`Religious` int,`kinyarwanda` int,`General Rank` int, PRIMARY KEY(`Names`))");
    mysqli_query($conn,"CREATE TABLE $total(`Names` varchar(40),`Mathematics` Double,`Physics` Double,`Chemistry` Double,`Biology` Double,`History` Double,`Geography` Double,`English` Double,`French` Double,`Kiswahili` Double,`Farming` Double,`ICT` Double,`Entrepreneurship` Double,`Sports` Double,`Religious` Double,`kinyarwanda` Double,`Total` Double, PRIMARY KEY(`Names`))");
    mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$class','$username','$combination')");
    mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$exam','$username','$combination')");
    mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$maximum','$username','$combination')");
    mysqli_query($conn,"INSERT INTO classes(`class_name`,`teacher`,`combination`) VALUES('$rank','$username','$combination')");
    mysqli_query($conn, "INSERT INTO $maximum(`Names`) VALUES('maximum')");
    header("refresh:10,index.php?comment=Class Created Successfully!");
    mysqli_select_db($conn,"payment");
    $teacher = $_POST['teacher'];
    mysqli_query($conn,"CREATE TABLE $class(`Names` varchar(40),`Amount Paid` int,`Amount Remaining` int)");
    mysqli_query($conn,"INSERT INTO `classes`(`class_name`, `class_teacher`, `combination`) VALUES ('$class','$teacher','olevel')");
    } catch (Exception $e) {
        header("refresh:10,index.php?comment=Class Not Created Maybe It Already Exists!");
    }
}

}


echo "<button id='level' onclick='change()' hidden>ADVANCED LEVEL</button> <div id='alevel'><form action='make a class.php' method='POST' autocomplete='off'>


   <br>
   <input type='hidden' name='level' value='alevel'>
   <select name='classname' id='' >
   <option value='j'>Select Class</option>
    <option value='FOUR'>Senior Four</option>
    <option value='FIVE'>Senior Five</option>
    <option value='SIX'>Senior Six</option>


    </select><br><br><br><br>
    <input type='text' name='combination' onfocus='hid()' onblur='shw()' oninput='ext()' id='combination' placeholder='Enter the combination' >
    <div id='sample'></div>
    <!--<input type='text' name= id=''>--><br><br><br>
    <input type='text' name='teacher' placeholder='Enter the teacher name' id=''>
<input type='submit' value='Create ' id='sub'>

    </form></div> <br><br><br><br>
    
<div id='olevel'>

    <form action='make a class.php' method='POST' autocomplete='off'>
     
        <br>
        <input type='hidden' name='combination' value='olevel'>
        <input type='hidden' name='level' value='olevel'>
         <select name='classname' id='ol' onchange='shw()'>
             <option value=''>Select Class</option>
             <option value='SENIOR_ONE_A'>Senior One A</option>
             <option value='SENIOR_ONE_B'>Senior One B</option>
             <option value='SENIOR_ONEC'>Senior One C</option>
             <option value='SENIOR_ONE_D'>Senior One D</option>
             <option value='SENIOR_TWO_A'>Senior Two A</option>
             <option value='SENIOR_TWO_B'>Senior Two B</option>
             <option value='SENIOR_TWO_C'>Senior Two C</option>
             <option value='SENIOR_TWO_D'>Senior Two D</option>
             <option value='SENIOR_THREE_A'>Senior Three A</option>
             <option value='SENIOR_THREE_B'>Senior Three B</option>
             <option value='SENIOR_THREE_C'>Senior Three C</option>
             <option value='SENIOR_THREE_D'>Senior Three D</option>

         </select><br><br> <input type='text' name='teacher' placeholder='Enter the teacher name' id=''> <br><br>
    
     <input type='submit' value='Create ' id='sub2'>
     
         </form>
</div>

    ";
}
else
{
      header("refresh:10,login.php?error=You have to Login first!");
}?>
</body>
</html>