<?php
require "php/config.php";
require "classes/DataBase.class.php";

if(isset($_SESSION['chat'])){
	$arquivo = "logs/".$_SESSION['chat']['id'].".txt";
	file_put_contents($arquivo, $_POST['message']."--|--".$_POST['type']."\r\n", FILE_APPEND);
}
else{
	$conversa = $m->find("last", "conversa");
	$arquivo = "logs/".$conversa['id'].".txt";
	file_put_contents($arquivo, $_POST['message']."--|--".$_POST['type']."\r\n", FILE_APPEND);
}
clearstatcache();
$modifiedAt = filemtime( $dataFileName );
echo $modifiedAt;

?>