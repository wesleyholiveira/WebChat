<?php

require "php/config.php";
require "classes/DataBase.class.php";
 
// arquivo cujo conteúdo será enviado ao cliente
if(isset($_SESSION['chat']))
	$dataFileName = "logs/".$_SESSION['chat']['id'].".txt";
else if($_POST['type'] == "adm"){
	$conversa = $m->find("last", "conversa");
	$dataFileName = "logs/".$conversa['id'].".txt";
}
 
while ( true )
{
	$requestedTimestamp = isset ( $_POST [ 'timestamp' ] ) ? (int)$_POST [ 'timestamp' ] : null;
 
	// o PHP faz cache de operações "stat" do filesystem. Por isso, devemos limpar esse cache
	clearstatcache();
	$modifiedAt = filemtime( $dataFileName );
 
	if ( $requestedTimestamp == null || $modifiedAt > $requestedTimestamp )
	{
		$data = file_get_contents( $dataFileName );
 
		$arrData = array(
			'content' => $data,
			'timestamp' => $modifiedAt
		);
 
		$json = json_encode( $arrData );
 
		echo $json;
 
		break;
	}
	else
	{
		sleep( 2 );
		continue;
	}
}