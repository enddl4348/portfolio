<?
include_once $_SERVER["DOCUMENT_ROOT"]."/inc/common.inc";
include_once $_SERVER["DOCUMENT_ROOT"]."/inc/util.inc";

$param = "code=$code&searchopt=$searchopt&searchkey=$searchkey";
$param .= "&page=$page";

if($mode == "insert") {
	
	$wdate = date('Y-m-d H:i:s');

	$sql = "INSERT INTO wiz_bbs SET
				sid = '$SID',
				memid = '".$wiz_admin['id']."',
				memgrp = '".$wiz_admin['id']."',
				name = '".$wiz_admin['name']."',
				email = '".$wiz_admin['email']."',
				hphone = '".$wiz_admin['hphone']."',
				prdinfo1 = '$prdinfo1',
				prdinfo2 = '$prdinfo2',
				prdinfo3 = '$prdinfo3',
				prdinfo4 = '$prdinfo4',
				prdinfo5 = '$prdinfo5',
				prdinfo6 = '$prdinfo6',
				wdate = unix_timestamp('$wdate'),
				code = 'new_mall',
				status = '요청',
				depart_code = '".$wiz_admin['depart_code']."'";
	mysql_query($sql) or error(mysql_error());

	complete("신규공급사등록이 요청되었습니다.","new_mall.php?code=new_mall");

} else if($mode == "update") {

	$sql = "UPDATE wiz_bbs SET
				prdinfo1 = '$prdinfo1',
				prdinfo2 = '$prdinfo2',
				prdinfo3 = '$prdinfo3',
				prdinfo4 = '$prdinfo4',
				prdinfo5 = '$prdinfo5',
				prdinfo6 = '$prdinfo6',
				status = '$status'
			WHERE idx = '$idx'";
	mysql_query($sql) or error(mysql_error());

	complete("수정되었습니다.","new_mall_input.php?mode=update&idx=$idx&$param");

} else if($mode == "delbbs") {

	$array_selbbs = explode("|", substr($selbbs, 0, -1));
	
	foreach($array_selbbs as $idx) {
		$sql = "DELETE FROM wiz_bbs WHERE idx = '$idx'";
		mysql_query($sql) or error(mysql_error());
	}

	complete("신규공급사등록요청이 삭제되었습니다.","new_mall.php?$param");

}
?>