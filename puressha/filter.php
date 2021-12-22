<?php

function danhsach($p){
	$i=0;
	while($r = $p->fetch_assoc()){
		$list[$i] = $r['MO_TA'];
		$i++;
	}
	return $list;
}
?>