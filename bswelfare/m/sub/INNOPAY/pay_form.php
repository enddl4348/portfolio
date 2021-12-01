<?
//테스트
if($oper_info->pay_test=='Y') {
	$MID		= 'testpay01m';
	$MerchantKey= 'Ma29gyAFhvv/+e4/AHpV6pISQIvSKziLIbrNoXPbRS5nfTx2DOs8OJve+NzwyoaQ8p9Uy1AN4S1I0Um5v7oNUg==';
}
//실거래
else{
	$MID		= $oper_info->pay_id;
	$MerchantKey= $oper_info->pay_key;
}

$Amt			= $order_info->total_price;
$BuyerName		= $order_info->send_name;
$GoodsName		= $payment_prdname;
$GoodsName		= cut_str($GoodsName, 15);
$GoodsName		= str_replace('...', '', $GoodsName);
$BuyerTel		= $order_info->send_hphone;
$BuyerEmail		= $order_info->send_email;
$ResultYN		= 'N';
$ReturnURL		= "http://".$_SERVER["HTTP_HOST"]."/m/sub/INNOPAY/order_update.php";
$Moid			= $order_info->orderid;
$EncodingType	= 'utf-8';
$MallIP			= $_SERVER['SERVER_ADDR'];
$UserIP			= $_SERVER['REMOTE_ADDR'];
$mallUserID		= $order_info->send_id;

////////////////
//결제방법 출력//
///////////////
switch($order_info->pay_method){
	case "PC"://신용카드
		$_paymethod = "CARD";break;
	case "PN"://계좌이체
		$_paymethod = "BANK";break;
	case "PV"://가상계좌
		$_paymethod = "VBANK";break;
}
?>
<!-- InnoPay 결제연동 스크립트(필수) -->
<script type="text/javascript" src="https://pg.innopay.co.kr/ipay/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="https://pg.innopay.co.kr/ipay/js/innopay-2.0.js" charset="utf-8"></script>
<script type="text/javascript">
<!--
function goPay(){
	var frm = document.payForm;

	// 결제요청 함수
	innopay.goPay({
		//// 필수 파라미터
		PayMethod		: frm.PayMethod.value,		// 결제수단(CARD,BANK,VBANK,CARS,CSMS,DSMS,EPAY,EBANK)
		MID				: frm.MID.value,			// 가맹점 MID
		MerchantKey		: frm.MerchantKey.value,	// 가맹점 라이센스키
		GoodsName		: frm.GoodsName.value,		// 상품명
		Amt				: frm.Amt.value,			// 결제금액(과세)
		BuyerName		: frm.BuyerName.value,		// 고객명
		BuyerTel		: frm.BuyerTel.value,		// 고객전화번호
		BuyerEmail		: frm.BuyerEmail.value,		// 고객이메일
		ResultYN		: frm.ResultYN.value,		// 결제결과창 출력유뮤
		Moid			: frm.Moid.value,			// 가맹점에서 생성한 주문번호 셋팅
		//// 선택 파라미터
		ReturnURL		: frm.ReturnURL.value,		// 결제결과 전송 URL(없는 경우 아래 innopay_result 함수에 결제결과가 전송됨)
		EncodingType	: frm.EncodingType.value,	// 가맹점 서버 인코딩 타입 (utf-8, euc-kr)
		MallIP			: frm.MallIP.value,			// 가맹점 서버 IP
		UserIP			: frm.UserIP.value,			// 고객 PC IP
		mallUserID		: frm.mallUserID.value,		// 가맹점 고객ID
//		ArsConnType:'02', 							// ARS 결제 연동시 필수 01:호전환, 02(가상번호), 03:대표번호
		FORWARD:'X',								// 결제창 연동방식 (X:레이어, 기본값)
//		GoodsCnt:'',								// 상품갯수 (가맹점 참고용)
//		MallReserved:'',							// 가맹점 데이터
//		OfferingPeriod:'',							// 제공기간
//		DutyFreeAmt:'',								// 결제금액(복합과세/면세 가맹점의 경우 금액설정)
//		User_ID:'',									// Innopay에 등록된 영업사원ID
		Currency:''									// 통화코드가 원화가 아닌 경우만 사용(KRW/USD)
	});
}

/**
 * 결제결과 수신 Javascript 함수
 * ReturnURL이 없는 경우 아래 함수로 결과가 리턴됩니다 (함수명 변경불가!)
 */
function innopay_result(data){
	var a			= JSON.stringify(data);
	// Sample
	var mid			= data.MID;				// 가맹점 MID
	var tid			= data.TID;				// 거래고유번호
	var amt			= data.Amt;				// 금액
	var moid		= data.MOID;			// 주문번호
	var authdate	= data.AuthDate;		// 승인일자
	var authcode	= data.AuthCode;		// 승인번호
	var resultcode	= data.ResultCode;		// 결과코드(PG)
	var resultmsg	= data.ResultMsg;		// 결과메세지(PG)
	var errorcode	= data.ErrorCode;		// 에러코드(상위기관)
	var errormsg	= data.ErrorMsg;		// 에러메세지(상위기관)
	var EPayCl		= data.EPayCl;
	alert("["+resultcode+"]"+resultmsg);
}
//-->
</script>

<form method="post" name="payForm" accept-charset="UTF-8">
<input type="hidden" name="PayMethod"	value="<?=$_paymethod?>">	<!-- 결제수단 -->
<input type="hidden" name="MID"			value="<?=$MID?>">			<!-- 상점 MID -->
<input type="hidden" name="MerchantKey"	value="<?=$MerchantKey?>">	<!-- 상점 라이센스키 -->
<input type="hidden" name="GoodsName"	value="<?=$GoodsName?>">	<!-- 상품명 -->
<input type="hidden" name="Amt"			value="<?=$Amt?>">			<!-- 결제금액(과세) -->
<input type="hidden" name="BuyerName"	value="<?=$BuyerName?>">	<!-- 구매자명 -->
<input type="hidden" name="BuyerTel"	value="<?=$BuyerTel?>">		<!-- 구매자 연락처 -->
<input type="hidden" name="BuyerEmail"	value="<?=$BuyerEmail?>">	<!-- 구매자 이메일 주소 -->
<input type="hidden" name="ResultYN"	value="<?=$ResultYN?>">		<!-- PG결제결과창 유무(N:결제결과창 없음, 가맹점 ReturnURL로 결과전송) -->
<input type="hidden" name="ReturnURL"	value="<?=$ReturnURL?>">	<!-- 결제결과전송 URL -->
<input type="hidden" name="Moid"		value="<?=$Moid?>">			<!-- 가맹점 주문번호 -->
<input type="hidden" name="EncodingType"value="<?=$EncodingType?>">	<!-- 가맹점 서버 인코딩 타입 (utf-8, euc-kr) -->
<input type="hidden" name="MallIP"		value="<?=$MallIP?>">		<!-- 가맹점 서버 IP -->
<input type="hidden" name="UserIP"		value="<?=$UserIP?>">		<!-- 고객 PC IP -->
<input type="hidden" name="mallUserID"	value="<?=$mallUserID?>">	<!-- 선택결제수단 -->

<div class="ord__payment">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="ord__payment__tb">
		<tr>
			<th>결제방법</th>
			<td><?=pay_method($pay_method)?></td>
		</tr>
		<tr>
			<th>결제금액</th>
			<td><span class="price_a"><?=number_format($order_info->total_price)?>원</span></td>
		</tr>
	</table>
</div>

<div class="button_common">
	<button type="button" class="btn_grat_big" onclick="goPay();">결제하기</button>
</div>
</form>