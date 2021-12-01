<?php
include "$_SERVER[DOCUMENT_ROOT]/inc/shop_info.inc";
include "$_SERVER[DOCUMENT_ROOT]/inc/oper_info.inc";
if(!strcmp($oper_info->pay_test, "Y")) {
	$oper_info->pay_id = "2999199999";
}

?>
<!--
    /* ============================================================================== */
    /* =   PAGE : 결제 시작 PAGE                                                    = */
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
		// sndReply는 kspay_wh_rcv.php (결제승인 후 결과값들을 본창의 KSPayWeb Form에 넘겨주는 페이지)의 절대경로를 넣어줍니다. 
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
   $temp_pay_method = "1000000000";       // 신용카드
   $pay_method_name = "신용카드";
}else if($pay_method == "PN"){
   $temp_pay_method = "0010000000";       // 계좌이체
   $pay_method_name = "계좌이체";
}else if($pay_method == "PV"){
   $temp_pay_method = "0100000000";       // 가상계좌
   $pay_method_name = "가상계좌";
}else if($pay_method == "PH"){
   $temp_pay_method = "0000010000";       // 휴대폰
   $pay_method_name = "휴대폰";
}
?>
<input type="hidden" name="sndPaymethod" value="<?=$temp_pay_method?>">                           <!-- 결제방법 -->
<input type='hidden' name='sndGoodname' value='<?=$payment_prdname?>' size='30'>        <!-- 상품명 -->
<!--<input type='hidden' name='sndAmount' value='<?=$order_info->total_price?>' size='10'>-->     <!-- 결제금액 -->
<input type='hidden' name='sndAmount' value='1000' size='10'>     <!-- 결제금액 -->
<input type='hidden' name='sndOrdername' value='<?=$order_info->send_name?>' size='20'>      <!-- 주문자명 -->
<input type='hidden' name='sndEmail' value='<?=$order_info->send_email?>' size='25'>     <!-- E-Mail -->
<input type='hidden' name='sndMobile' value='<?=$order_info->send_hphone?>' size='20'>    <!-- 휴대폰번호 -->

<input type='hidden' name='sndStoreid' value='<?=$oper_info->pay_id?>' size='15' maxlength='10'>
<input type='hidden' name='sndOrdernumber' value='<?=$order_info->orderid?>' size='30'>

<!----------------------------------------------- <Part 2. 추가설정항목(메뉴얼참조)>  ----------------------------------------------->

	<!-- 0. 공통 환경설정 -->
	<input type=hidden	name=sndReply value="">
	<input type=hidden  name=sndGoodType value="1"> 	<!-- 상품유형: 실물(1),디지털(2) -->
	
	<!-- 1. 신용카드 관련설정 -->
	
	<!-- 신용카드 결제방법  -->
	<!-- 일반적인 업체의 경우 ISP,안심결제만 사용하면 되며 다른 결제방법 추가시에는 사전에 협의이후 적용바랍니다 -->
	<input type=hidden  name=sndShowcard value="I,M"> <!-- I(ISP), M(안심결제), N(일반승인:구인증방식), A(해외카드), W(해외안심)-->
	
	<!-- 신용카드(해외카드) 통화코드: 해외카드결제시 달러결제를 사용할경우 변경 -->
	<input type=hidden	name=sndCurrencytype value="WON"> <!-- 원화(WON), 달러(USD) -->
	
	<!-- 할부개월수 선택범위 -->
	<!--상점에서 적용할 할부개월수를 세팅합니다. 여기서 세팅하신 값은 결제창에서 고객이 스크롤하여 선택하게 됩니다 -->
	<!--아래의 예의경우 고객은 0~12개월의 할부거래를 선택할수있게 됩니다. -->
	<input type=hidden	name=sndInstallmenttype value="ALL(0:2:3:4:5:6:7:8:9:10:11:12)">
	
	<!-- 가맹점부담 무이자할부설정 -->
	<!-- 카드사 무이자행사만 이용하실경우  또는 무이자 할부를 적용하지 않는 업체는  "NONE"로 세팅  -->
	<!-- 예 : 전체카드사 및 전체 할부에대해서 무이자 적용할 때는 value="ALL" / 무이자 미적용할 때는 value="NONE" -->
	<!-- 예 : 전체카드사 3,4,5,6개월 무이자 적용할 때는 value="ALL(3:4:5:6)" -->
	<!-- 예 : 삼성카드(카드사코드:04) 2,3개월 무이자 적용할 때는 value="04(3:4:5:6)"-->
	<!-- <input type=hidden	name=sndInteresttype value="10(02:03),05(06)"> -->
	<input type=hidden	name=sndInteresttype value="NONE">

	<!-- 2. 온라인입금(가상계좌) 관련설정 -->
	<input type=hidden	name=sndEscrow value="1"> 			<!-- 에스크로사용여부 (0:사용안함, 1:사용) -->
	
	<!-- 3. 월드패스카드 관련설정 -->
	<input type=hidden	name=sndWptype value="1">  			<!--선/후불카드구분 (1:선불카드, 2:후불카드, 3:모든카드) -->
	<input type=hidden	name=sndAdulttype value="1">  		<!--성인확인여부 (0:성인확인불필요, 1:성인확인필요) -->
	
	<!-- 4. 계좌이체 현금영수증발급여부 설정 -->
    <input type=hidden  name=sndCashReceipt value="0">          <!--계좌이체시 현금영수증 발급여부 (0: 발급안함, 1:발급) -->
	
<!----------------------------------------------- <Part 3. 승인응답 결과데이터>  ----------------------------------------------->
<!-- 결과데이타: 승인이후 자동으로 채워집니다. (*변수명을 변경하지 마세요) -->

	<input type=hidden name=reWHCid 	value="">
	<input type=hidden name=reWHCtype 	value="">
	<input type=hidden name=reWHHash 	value="">
<!--------------------------------------------------------------------------------------------------------------------------->

<!--업체에서 추가하고자하는 임의의 파라미터를 입력하면 됩니다.-->
<!--이 파라메터들은 지정된결과 페이지(kspay_result.php)로 전송됩니다.-->
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
				 <td width="20%" class="tit">결제방법</td>
				 <td width="80%" class="val"><?=pay_method($pay_method)?></td>
				</tr>
			  <tr>
	      	<td height="1" colspan="2" bgcolor="d7d7d7" ></td>
	    	</tr>
			  <tr>
				 <td class="tit">결제금액</td>
				 <td class="val"><span class="price_a"><?=number_format($order_info->total_price)?>원</span></td>
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
