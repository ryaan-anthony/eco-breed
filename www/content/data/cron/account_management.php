<?php

//	function remove_entry($id){
//		global $link;
//		mysql_query("DELETE FROM breed WHERE id='".$id."'",$link);
//	}
//	$link = mysql_connect("localhost","takecopy", "devTR1420");
//	if(!mysql_select_db("takecopy_eco",$link)){die(mysql_error());}
//	$result=mysql_query("select * from cleanup", $link);
//	while($row=mysql_fetch_array($result)){
//		$user=$row['name'];
//		$inactive_remove=(int)$row['inactive_remove'];
//		$dead_remove=(int)$row['dead_remove'];
//		if($inactive_remove || $dead_remove){
//			$breed_result=mysql_query("select * from breed where breed_creator='$user'", $link);
//			if($breed_result){
//				while($breed_row=mysql_fetch_array($breed_result)){
//					$breed_update=(int)$breed_row['breed_update'];
//					$breed_dead=(int)$breed_row['breed_dead'];
//					if($inactive_remove!=0 && $breed_update<time()-$inactive_remove){remove_entry($breed_row['id']);}
//					elseif($dead_remove!=0 && $breed_dead!=0 && $breed_dead<time()-$dead_remove){remove_entry($breed_row['id']);}
//				}
//			}
//		}
//		elseif(!$inactive_remove && !$dead_remove){
//			mysql_query("DELETE FROM cleanup WHERE id='".$row['id']."'",$link);
//		}
//	}
?>
