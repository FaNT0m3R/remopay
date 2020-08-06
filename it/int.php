<?php
/*******    ÈÍÈÖÈÀËÈÇÀÖÈß    ***************************************************************/
/**** $serv_table  **********/	
	$resl_serv = $db->query("SELECT * FROM services;");
	if ($resl_serv != false)
	{
		$size = $resl_serv->num_rows;
		for($i=0; $i<$size; $i++)
			$serv_table[$i] = $resl_serv->fetch_array();
	}
	else
		$error = "error 1";
		
/**** $castes_table  **********/
	$resl_serv = $db->query("SELECT * FROM castes;");
	if ($resl_serv != false)
	{
		$size = $resl_serv->num_rows;
		for($i=0; $i<$size; $i++)
			$castes_table[$i] = $resl_serv->fetch_array();
	}
	else
		$error = "error 2";
	
/**********  $cost_table  ***********/		
	$resl_serv = $db->query("SELECT * FROM serv_cost;");
	if ($resl_serv != false)
	{
		$size = $resl_serv->num_rows;
		for($i=0; $i<$size; $i++)
			$cost_table[$i] = $resl_serv->fetch_array();
	}
	else
		$error = "error 3";
	
	
/**********  $info_table  ***********/		
	$resl_serv = $db->query("SELECT * FROM infos;");
	if ($resl_serv != false)
	{
		$size = $resl_serv->num_rows;
		for($i=0; $i<$size; $i++){
			$line = $resl_serv->fetch_array();
			$info_table[$line[0]] = $line[1];
		}
	}
	else
		$error = "error 4";
/**********  $time_table  ***********/		
	$resl_serv = $db->query("SELECT * FROM timelist;");
	if ($resl_serv != false)
	{
		$size = $resl_serv->num_rows;
		for($i=0; $i<$size; $i++)
			$time_table[$i] = $resl_serv->fetch_array();
	}
	else
		$error = "error 5";		
?>