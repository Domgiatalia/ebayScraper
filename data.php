<?php
set_time_limit(0);
$action = $_POST['action'];

$commandStart = 'https://www.ebay.co.uk/sch/i.html?_from=R40&_nkw=';
$commandMid = '';
$commandEnd = '&_sacat=0&_ipg=25';
$commandMid = str_replace(' ', '+', $action);
$scr = $commandStart . $commandMid . $commandEnd;

$command = escapeshellcmd("C:\Users\domzt\AppData\Local\Programs\Python\Python39\python.exe script.py $scr");
$output = shell_exec($command);



?>