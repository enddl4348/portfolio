<?php
//include $_SERVER["DOCUMENT_ROOT"]."/inc/common.inc";
//include $_SERVER["DOCUMENT_ROOT"]."/inc/util.inc";

/******************************************************************************
* 데이타 베이스 접속
******************************************************************************/
include $_SERVER["DOCUMENT_ROOT"]."/admin/dbcon.php";
$connect = @mysql_connect($db_host, $db_user, $db_pass) or error("DB 접속시 에러가 발생했습니다.");
@mysql_select_db($db_name, $connect) or error("DB Select 에러가 발생했습니다");
mysql_query("set names euckr");

/******************************************************************************
* 분양몰 아이디 파악
******************************************************************************/
$shop_host = str_replace("www.","",$_SERVER['HTTP_HOST']);

$sql = "select sid,shop_name from wiz_shopinfo where shop_url = '$shop_host' or shop_url2 = '$shop_host' or punycode = '".$shop_host."'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

$SID = $row['sid'];

include $_SERVER["DOCUMENT_ROOT"]."/inc/oper_info.inc";

if($_REQUEST['mode']=='pay' && $_REQUEST['orderid']){
	$orderid	= $_REQUEST['orderid'];

	// 주문정보
	$sql		= "select * from wiz_order where orderid='".$orderid."'";
	$result		= mysql_query($sql) or error(mysql_error());
	$order_info	= mysql_fetch_object($result);

	// 주문상품 정보
	$sql		= "select * from wiz_basket where orderid='".$orderid."'";
	$result		= mysql_query($sql) or error(mysql_error());
	$total		= mysql_num_rows($result);
	while($row	= mysql_fetch_object($result)){

		if($total>1){//1개 이상일경우
			$payment_prdname = iconv('euc-kr', 'utf-8', $row->prdname)." 외".($total-1)."개";
		}else{//한개일경우
			$payment_prdname = mb_substr(iconv('euc-kr', 'utf-8', $row->prdname), 0, 10);
		}
	}

	//테스트
	if($oper_info->pay_test=='Y') {
		$arr['MID']			= 'testpay01m';
		$arr['MerchantKey']	= 'Ma29gyAFhvv/+e4/AHpV6pISQIvSKziLIbrNoXPbRS5nfTx2DOs8OJve+NzwyoaQ8p9Uy1AN4S1I0Um5v7oNUg==';
	}
	//실거래
	else{
		$arr['MID']			= $oper_info->pay_id;
		$arr['MerchantKey']	= $oper_info->pay_key;
	}

	$arr['Amt']				= $order_info->total_price;
	$arr['BuyerName']		= iconv('euc-kr', 'utf-8', $order_info->send_name);
	$GoodsName				= $payment_prdname;
	$GoodsName				= $GoodsName;
	$arr['GoodsName']		= $GoodsName;
	$arr['BuyerTel']		= $order_info->send_hphone;
	$arr['BuyerEmail']		= $order_info->send_email;
	$arr['ResultYN']		= 'Y';
	$arr['ReturnURL']		= "http://".$_SERVER["HTTP_HOST"]."/shop/INNOPAY/order_update.php";
	$arr['Moid']			= $order_info->orderid;
	$arr['EncodingType']	= 'euc-kr';
	$arr['MallIP']			= $_SERVER['SERVER_ADDR'];
	$arr['UserIP']			= $_SERVER['REMOTE_ADDR'];
	$arr['mallUserID']		= $order_info->send_id;

	switch($order_info->pay_method){
		case "PC"://신용카드
			$_paymethod = "CARD";break;
		case "PN"://계좌이체
			$_paymethod = "BANK";break;
		case "PV"://가상계좌
			$_paymethod = "VBANK";break;
	}

	$arr['PayMethod']		= $_paymethod;

	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($arr);
}
?>