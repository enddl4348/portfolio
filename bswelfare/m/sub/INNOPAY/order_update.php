<?php
include "../../../inc/common.inc";			// DB컨넥션, 접속자 파악
include "../../../inc/util.inc"; 			// 유틸 라이브러리
include "../../../inc/oper_info.inc"; 		// 운영 정보

@extract($_GET);
@extract($_POST);
@extract($_SERVER);

$TEMP_IP = getenv("REMOTE_ADDR");
$PG_IP  = substr($TEMP_IP,0, 13);

$PayMethod			= $PayMethod;
$MID				= $MID;
$TID				= $TID;
$mallUserID			= $mallUserID;
$Amt				= $Amt;
$name				= $name;
$GoodsName			= $GoodsName;
$OID				= $OID;
$MOID				= $MOID;
$AuthDate			= $AuthDate;
$AuthCode			= $AuthCode;
$ResultCode			= $ResultCode;
$ResultMsg			= $ResultMsg;
$MerchantReserved	= $MerchantReserved;
$MallReserved		= $MallReserved;
$SUB_ID				= $SUB_ID;
$fn_cd				= $fn_cd;
$fn_name			= $fn_name;
$CardQuota			= $CardQuota;
$BuyerEmail			= $BuyerEmail;
$BuyerAuthNum		= $BuyerAuthNum;
$ErrorCode			= $ErrorCode;
$ErrorMsg			= $ErrorMsg;
$AcquCardCode		= $AcquCardCode;
$AcquCardName		= $AcquCardName;
$FORWARD			= $FORWARD;
$VbankNum			= $VbankNum;
$VbankName			= iconv('utf-8', 'euc-kr', $VbankName);
$VbankExpDate       = $VbankExpDate;
$VBankAccountName   = $VBankAccountName;

// 주문정보
$sql		= "SELECT * FROM wiz_order WHERE orderid = '$MOID'";
$result		= mysql_query($sql) or error(mysql_error());
$order_info	= mysql_fetch_object($result);

// 결제성공
if($ResultCode == "3001" || $ResultCode == "4000" || $ResultCode == "4100"){

	if($order_info->pay_method=='PV')	$status = 'OR';
	else								$status = 'OY';

	$_Payment['status']		= $status;					//결제상태
	$_Payment['orderid']	= $MOID;					//주문번호
	$_Payment['paymethod']	= $order_info->pay_method;	//결제종류
	$_Payment['ttno']		= $TID;						//거래번호
	$_Payment['bankkind']	= $VbankName;				//은행코드(가상계좌일경우)
	$_Payment['accountno']	= $VbankNum;				//계좌번호(가상계좌일경우)
	$_Payment['pgname']		= "INNOPAY";				//PG사 종류
	$_Payment['es_check']	= $oper_info->pay_escrow;	//에스크로 사용여부
	$_Payment['es_stats']	= "IN";						//에스크로 상태(데이콤으로 기본정보 발송)
	$_Payment['tprice']		= $Amt;						//결제금액

	foreach($_Payment as $key => $value){
		$logs .="$key : $value\r";
	}
	@make_log("log/".date('Ymd').".txt","\r-----order_update.php start-----\r".$logs."\r-----order_update.php END-----\r");

	//결제처리(상태변경,주문 업데이트)
	Exe_payment($_Payment);
	// 적립금 처리 : 적립금 사용시 적립금 감소
	Exe_reserve();
	// 재고처리
	$stock_out = Exe_stock(); // $stock_out == true > 재고부족 취소필요
	// 장바구니 삭제
	Exe_delbasket($order_info->orderid);

	$ResultCode	= '0000';
	$ResultMsg	= '';

	// 최종 재고 부족시 취소 처리
	if($stock_out == true){
		$status		= 'OC';
		$cancelmsg	= '재고부족 자동취소';
		$ResultCode	= '9999';
		$ResultMsg	= $cancelmsg;

		// [신용카드/계좌이체]+결제완료 상태시 즉시 취소
		if($order_info->pay_method=='PC' || $order_info->pay_method=='PN'){
			$res = cancelInnoPay($order_info->orderid, $cancelmsg);

			if($res==true){
				cancelOrder($order_info, $status, $cancelmsg);
			}
		}

		// 가상계좌 or 승인취소 실패시 반품요청 처리
		if($order_info->pay_method='PV' || $res!=true){

			$sql = "UPDATE wiz_order SET cancelmsg='$cancelmsg', status='RD' WHERE orderid='$order_info->orderid' AND status NOT IN('OC', 'RC')";
			mysql_query($sql);
		}
	}
}

// 결제실패
else{
	//echo $ResultCode . " " . $ResultMsg;
}
?>
<script>
document.location.replace('/m/sub/order_ok.php?orderid=<?=$MOID?>&rescode=<?=$ResultCode?>&resmsg=<?=$ResultMsg?>');
</script>