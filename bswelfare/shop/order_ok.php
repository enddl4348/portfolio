<?
include $_SERVER["DOCUMENT_ROOT"]."/inc/common.inc"; 			// DB���ؼ�, ������ �ľ�
include $_SERVER["DOCUMENT_ROOT"]."/inc/util.inc"; 		   	// ��ƿ ���̺귯��
include $_SERVER["DOCUMENT_ROOT"]."/inc/oper_info.inc"; 	// � ����

///////////////////////////////////////////
/// PG�� ���� �Ϸ�� �� ��ȯ�Ǿ���� ����//
///////////////////////////////////////////
/* $orderid : �ֹ���ȣ
/* $resmsg : ���� �� ��ȯ �޼���
/* $rescode : ������ȯ �޼���
/* $pay_method : wizshop ��������
*//////////////////////////////////////////

//if($pay_method != "PB"){
	//Pay_result($oper_info->pay_agent);
	$presult=Pay_result($oper_info->pay_agent, $rescode);

	//////// ������ ��ٱ��� ������ ���� ////////////
	//@mysql_query("delete from wiz_basket_tmp WHERE wdate < (now()- INTERVAL 10 DAY)");
//}

$now_position = "<a href=/>Home</a> &gt; �ֹ��ϱ� &gt; �ֹ��Ϸ�";
$page_type = "ordercom";

include $_SERVER["DOCUMENT_ROOT"]."/inc/page_info.inc"; 	// ������ ����
include $SKIN_DIR."/inc/header.php"; 						// ��ܵ�����
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
// �ֹ�����
$sql = "SELECT * FROM wiz_order WHERE orderid = '$presult[orderid]'";
$result = mysql_query($sql) or error(mysql_error());
$order_info = mysql_fetch_object($result);

//echo $orderid;

// �ֹ�����
if($presult[rescode] == "0000" && strlen($presult[rescode]) == 4){

	// �ֹ��Ϸ� ����/sms�߼�
	include "./order_mail.inc";		// ���Ϲ߼۳���

	$re_info[name] = $order_info->send_name;
	$re_info[email] = $order_info->send_email;
	$re_info[hphone] = $order_info->send_hphone;

	// email, sms �߼� üũ
	$sql = "update wiz_order set send_mailsms = 'Y' where orderid = '$order_info->orderid'";
	mysql_query($sql) or error(mysql_error());

	if($order_info->send_mailsms != "Y"){
		// ��+������ ����
		send_mailsms("order_com", $re_info, $ordmail);

		// ����ó����
		$b_sql		= "select distinct mallid from wiz_basket where orderid = '$order_info->orderid'";
		$b_result	= mysql_query($b_sql);
		while($b_row= mysql_fetch_assoc($b_result)){
			$mallid	= $b_row['mallid'];
			include "./order_mail_mall.inc";		// ���Ϲ߼۳���
			send_mailsms_mall("order_com", $mallid, $ordmail);
		}

		// �������α��� ����(�ŷ����� �ŷ���)
		if($order_info->pay_method == 'ST'){
			$re_sql	= "SELECT name, email3 AS email FROM wiz_member WHERE id = '$order_info->send_id'";
			$re_res	= mysql_query($re_sql);
			$re_info= mysql_fetch_assoc($re_res);

			// �ֹ��Ϸ� ����/sms�߼�
			$use_approval = 'Y';
			include "./order_mail.inc";		// ���Ϲ߼۳���
			send_mailsms("order_com", $re_info, $ordmail);
		}
	}
?>

<? include "./order_info.inc"; ?>

<div class="basket_btn">
    <a href="javascript:orderPrint('<?=$presult[orderid]?>');" class="btn">����Ʈ �ϱ�</a>
</div>
<?
// �ֹ�����
}else{
?>
<div class="order_fail">
	<strong>������ ������ �߻��Ͽ����ϴ�.</strong>
	<?if($presult[rescode]){?>
	<span>�����ڵ� : <?=$presult[rescode]?></span>
	<?}?>
	<span>����޼��� : <?=$presult[resmsg]?></span>

	<a href="order_pay.php?orderid=<?=$presult[orderid]?>&pay_method=<?=$order_info->pay_method?>">�ٽð���</a>
</div><!-- .order_fail -->
<? } ?>

</div><!-- .bbs_wrap -->

	</div><!-- .content-body -->
</div><!-- .sub-container -->

<? include $SKIN_DIR."/inc/footer.php"; 		// �ϴܵ����� ?>