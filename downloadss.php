<?php 



ob_start();

$fullPath = $_GET["path"];
header("Content-type: application/x-file-to-save"); 
header("Content-Disposition: attachment; filename=".basename($fullPath));
ob_end_clean();
readfile($fullPath);

/*
$out = $_GET['text'];
header("Content-Type: plain/text");
header("Content-Disposition: Attachment; filename=testfile_".$out.".txt");
header("Pragma: no-cache");
echo "$out";

*/

?>