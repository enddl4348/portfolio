<?php
include "$_SERVER[DOCUMENT_ROOT]/inc/shop_info.inc";
include "$_SERVER[DOCUMENT_ROOT]/inc/oper_info.inc";
if(!strcmp($oper_info->pay_test, "Y")) {
	$oper_info->pay_id = "2999199999";
}

?>
<!--
    /* ============================================================================== */
    /* =   PAGE : ���� ���� PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2006   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */
//-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
<link href="css/sample.css" rel="stylesheet" type="text/css">

<script language="javascript">

	function _pay(_frm) 
	{
		// sndReply�� kspay_wh_rcv.php (�������� �� ��������� ��â�� KSPayWeb Form�� �Ѱ��ִ� ������)�� �����θ� �־��ݴϴ�. 
 		_frm.sndReply.value           = getLocalUrl("KSPAY/order_update.php") ;

		var agent = navigator.userAgent;
		var midx		= agent.indexOf("MSIE");
		var out_size	= (midx != -1 && agent.charAt(midx+5) < '7');
		_frm.action ='http://kspay.ksnet.to/store/mb2/KSPayPWeb.jsp';
		_frm.submit();
    }

	function getLocalUrl(mypage) 
	{ 
		var myloc = location.href; 
		return myloc.substring(0, myloc.lastIndexOf('/')) + '/' + mypage;
	} 
	
</script>
</head>
<body>
<form name=authFrmFrame method=post>


<?
if($pay_method == "PC"){
   $temp_pay_method = "1000000000";       // �ſ�ī��
   $pay_method_name = "�ſ�ī��";
}else if($pay_method == "PN"){
   $temp_pay_method = "0010000000";       // ������ü
   $pay_method_name = "������ü";
}else if($pay_method == "PV"){
   $temp_pay_method = "0100000000";       // �������
   $pay_method_name = "�������";
}else if($pay_method == "PH"){
   $temp_pay_method = "0000010000";       // �޴���
   $pay_method_name = "�޴���";
}
?>
<input type="hidden" name="sndPaymethod" value="<?=$temp_pay_method?>">                           <!-- ������� -->
<input type='hidden' name='sndGoodname' value='<?=$payment_prdname?>' size='30'>        <!-- ��ǰ�� -->
<!--<input type='hidden' name='sndAmount' value='<?=$order_info->total_price?>' size='10'>-->     <!-- �����ݾ� -->
<input type='hidden' name='sndAmount' value='1000' size='10'>     <!-- �����ݾ� -->
<input type='hidden' name='sndOrdername' value='<?=$order_info->send_name?>' size='20'>      <!-- �ֹ��ڸ� -->
<input type='hidden' name='sndEmail' value='<?=$order_info->send_email?>' size='25'>     <!-- E-Mail -->
<input type='hidden' name='sndMobile' value='<?=$order_info->send_hphone?>' size='20'>    <!-- �޴�����ȣ -->

<input type='hidden' name='sndStoreid' value='<?=$oper_info->pay_id?>' size='15' maxlength='10'>
<input type='hidden' name='sndOrdernumber' value='<?=$order_info->orderid?>' size='30'>

<!----------------------------------------------- <Part 2. �߰������׸�(�޴�������)>  ----------------------------------------------->

	<!-- 0. ���� ȯ�漳�� -->
	<input type=hidden	name=sndReply value="">
	<input type=hidden  name=sndGoodType value="1"> 	<!-- ��ǰ����: �ǹ�(1),������(2) -->
	
	<!-- 1. �ſ�ī�� ���ü��� -->
	
	<!-- �ſ�ī�� �������  -->
	<!-- �Ϲ����� ��ü�� ��� ISP,�Ƚɰ����� ����ϸ� �Ǹ� �ٸ� ������� �߰��ÿ��� ������ �������� ����ٶ��ϴ� -->
	<input type=hidden  name=sndShowcard value="I,M"> <!-- I(ISP), M(�Ƚɰ���), N(�Ϲݽ���:���������), A(�ؿ�ī��), W(�ؿܾȽ�)-->
	
	<!-- �ſ�ī��(�ؿ�ī��) ��ȭ�ڵ�: �ؿ�ī������� �޷������� ����Ұ�� ���� -->
	<input type=hidden	name=sndCurrencytype value="WON"> <!-- ��ȭ(WON), �޷�(USD) -->
	
	<!-- �Һΰ����� ���ù��� -->
	<!--�������� ������ �Һΰ������� �����մϴ�. ���⼭ �����Ͻ� ���� ����â���� ���� ��ũ���Ͽ� �����ϰ� �˴ϴ� -->
	<!--�Ʒ��� ���ǰ�� ���� 0~12������ �Һΰŷ��� �����Ҽ��ְ� �˴ϴ�. -->
	<input type=hidden	name=sndInstallmenttype value="ALL(0:2:3:4:5:6:7:8:9:10:11:12)">
	
	<!-- �������δ� �������Һμ��� -->
	<!-- ī��� ��������縸 �̿��Ͻǰ��  �Ǵ� ������ �Һθ� �������� �ʴ� ��ü��  "NONE"�� ����  -->
	<!-- �� : ��üī��� �� ��ü �Һο����ؼ� ������ ������ ���� value="ALL" / ������ �������� ���� value="NONE" -->
	<!-- �� : ��üī��� 3,4,5,6���� ������ ������ ���� value="ALL(3:4:5:6)" -->
	<!-- �� : �Ｚī��(ī����ڵ�:04) 2,3���� ������ ������ ���� value="04(3:4:5:6)"-->
	<!-- <input type=hidden	name=sndInteresttype value="10(02:03),05(06)"> -->
	<input type=hidden	name=sndInteresttype value="NONE">

	<!-- 2. �¶����Ա�(�������) ���ü��� -->
	<input type=hidden	name=sndEscrow value="1"> 			<!-- ����ũ�λ�뿩�� (0:������, 1:���) -->
	
	<!-- 3. �����н�ī�� ���ü��� -->
	<input type=hidden	name=sndWptype value="1">  			<!--��/�ĺ�ī�屸�� (1:����ī��, 2:�ĺ�ī��, 3:���ī��) -->
	<input type=hidden	name=sndAdulttype value="1">  		<!--����Ȯ�ο��� (0:����Ȯ�κ��ʿ�, 1:����Ȯ���ʿ�) -->
	
	<!-- 4. ������ü ���ݿ������߱޿��� ���� -->
    <input type=hidden  name=sndCashReceipt value="0">          <!--������ü�� ���ݿ����� �߱޿��� (0: �߱޾���, 1:�߱�) -->
	
<!----------------------------------------------- <Part 3. �������� ���������>  ----------------------------------------------->
<!-- �������Ÿ: �������� �ڵ����� ä�����ϴ�. (*�������� �������� ������) -->

	<input type=hidden name=reWHCid 	value="">
	<input type=hidden name=reWHCtype 	value="">
	<input type=hidden name=reWHHash 	value="">
<!--------------------------------------------------------------------------------------------------------------------------->

<!--��ü���� �߰��ϰ����ϴ� ������ �Ķ���͸� �Է��ϸ� �˴ϴ�.-->
<!--�� �Ķ���͵��� �����Ȱ�� ������(kspay_result.php)�� ���۵˴ϴ�.-->
	<input type=hidden name="temp_pay_method"        value="<?=$temp_pay_method?>">
	<input type=hidden name=b        value="b1">
	<input type=hidden name=c        value="c1">
	<input type=hidden name=d        value="d1">
<!--------------------------------------------------------------------------------------------------------------------------->





<table border=0 cellpadding=0 cellspacing=0 width=100%>
	<tr>
    <td style="padding:15px 0 10px 0">
			<table border=0 cellpadding=6 cellspacing=0 width=100% class="order_form">
				<tr><td colspan="2" bgcolor="#a9a9a9" height="2"></td></tr>
			  <tr>
				 <td width="20%" class="tit">�������</td>
				 <td width="80%" class="val"><?=pay_method($pay_method)?></td>
				</tr>
			  <tr>
	      	<td height="1" colspan="2" bgcolor="d7d7d7" ></td>
	    	</tr>
			  <tr>
				 <td class="tit">�����ݾ�</td>
				 <td class="val"><span class="price_a"><?=number_format($order_info->total_price)?>��</span></td>
			  </tr>
			  <tr>
	      	<td height="1" colspan="2" bgcolor="d7d7d7" ></td>
	    	</tr>
			</table>
    </td>
  </tr>
  <tr>
    <td align=center>
	    <img src="/images/shop/but_pay.gif" onClick="javascript:_pay(document.authFrmFrame);" style="cursor:hand"> <a href="/"><img src="/images/shop/but_cancel.gif" border=0></a>
		</td>
  </tr>
</table>
</form>
