<?
include $_SERVER["DOCUMENT_ROOT"]."/inc/common.inc"; 			// DB컨넥션, 접속자 파악
include $_SERVER["DOCUMENT_ROOT"]."/inc/util.inc"; 		   	// 유틸 라이브러리
include $_SERVER["DOCUMENT_ROOT"]."/inc/oper_info.inc"; 	// 운영 정보

///////////////////////////////////////////
/// PG사 결제 완료시 꼭 반환되어야할 값들//
///////////////////////////////////////////
/* $orderid : 주문번호
/* $resmsg : 오류 및 반환 메세지
/* $rescode : 성공반환 메세지
/* $pay_method : wizshop 결제종류
*//////////////////////////////////////////

//if($pay_method != "PB"){
	//Pay_result($oper_info->pay_agent);
	$presult=Pay_result($oper_info->pay_agent, $rescode);

	//////// 쓰레기 장바구니 데이터 삭제 ////////////
	//@mysql_query("delete from wiz_basket_tmp WHERE wdate < (now()- INTERVAL 10 DAY)");
//}

$now_position = "<a href=/>Home</a> &gt; 주문하기 &gt; 주문완료";
$page_type = "ordercom";

include $_SERVER["DOCUMENT_ROOT"]."/inc/page_info.inc"; 	// 페이지 정보
include $SKIN_DIR."/inc/header.php"; 						// 상단디자인
?>
<script language="JavaScript">
<!--
function orderPrint(orderid){
	var url = "/shop/order_print.php?orderid=" + orderid + "&print=ok";
	window.open(url, "orderPrint", "height=650, width=736, menubar=no, scrollbars=yes, resizable=yes, toolbar=no, status=no, left=0, top=0");
}
//-->
</script>

<body onUnload="cuponClose();">

<div class="sub-container container clearfix">
	<div class="content-body">

<div class="bbs_wrap">

<? $step4="on"; include "./basket_step.php"; ?>

<?
// 주문정보
$sql = "SELECT * FROM wiz_order WHERE orderid = '$presult[orderid]'";
$result = mysql_query($sql) or error(mysql_error());
$order_info = mysql_fetch_object($result);

//echo $orderid;

// 주문성공
if($presult[rescode] == "0000" && strlen($presult[rescode]) == 4){

	// 주문완료 메일/sms발송
	include "./order_mail.inc";		// 메일발송내용

	$re_info[name] = $order_info->send_name;
	$re_info[email] = $order_info->send_email;
	$re_info[hphone] = $order_info->send_hphone;

	// email, sms 발송 체크
	$sql = "update wiz_order set send_mailsms = 'Y' where orderid = '$order_info->orderid'";
	mysql_query($sql) or error(mysql_error());

	if($order_info->send_mailsms != "Y"){
		// 고객+관리자 수신
		send_mailsms("order_com", $re_info, $ordmail);

		// 공급처수신
		$b_sql		= "select distinct mallid from wiz_basket where orderid = '$order_info->orderid'";
		$b_result	= mysql_query($b_sql);
		while($b_row= mysql_fetch_assoc($b_result)){
			$mallid	= $b_row['mallid'];
			include "./order_mail_mall.inc";		// 메일발송내용
			send_mailsms_mall("order_com", $mallid, $ordmail);
		}

		// 결제승인권자 수신(거래명세서 거래시)
		if($order_info->pay_method == 'ST'){
			$re_sql	= "SELECT name, email3 AS email FROM wiz_member WHERE id = '$order_info->send_id'";
			$re_res	= mysql_query($re_sql);
			$re_info= mysql_fetch_assoc($re_res);

			// 주문완료 메일/sms발송
			$use_approval = 'Y';
			include "./order_mail.inc";		// 메일발송내용
			send_mailsms("order_com", $re_info, $ordmail);
		}
	}
?>

<? include "./order_info.inc"; ?>

<div class="basket_btn">
    <a href="javascript:orderPrint('<?=$presult[orderid]?>');" class="btn">프린트 하기</a>
</div>
<?
// 주문실패
}else{
?>
<div class="order_fail">
	<strong>결제시 에러가 발생하였습니다.</strong>
	<?if($presult[rescode]){?>
	<span>오류코드 : <?=$presult[rescode]?></span>
	<?}?>
	<span>결과메세지 : <?=$presult[resmsg]?></span>

	<a href="order_pay.php?orderid=<?=$presult[orderid]?>&pay_method=<?=$order_info->pay_method?>">다시결제</a>
</div><!-- .order_fail -->
<? } ?>

</div><!-- .bbs_wrap -->

	</div><!-- .content-body -->
</div><!-- .sub-container -->

<? include $SKIN_DIR."/inc/footer.php"; 		// 하단디자인 ?>