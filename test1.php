<?php
$student = "Niyogakiza Japhet";
echo substr($student,0,strpos($student," "));
echo substr($student,strpos($student," ")+1);

?>