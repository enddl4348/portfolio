<?php
include "../../inc/common.inc";			// DB컨넥션, 접속자 파악
include "../../inc/util.inc"; 			// 유틸 라이브러리
include "../../inc/oper_info.inc"; 		// 운영 정보

@extract($_GET);
@extract($_POST);
@extract($_SERVER);

/**********************************************************************************/
//이부분에 로그파일 경로를 수정해주세요.
$LogPath	= $_SERVER['DOCUMENT_ROOT']."/shop/INNOPAY/pglog";
/**********************************************************************************/

$TEMP_IP	= getenv("REMOTE_ADDR");
$PG_IP		= substr($TEMP_IP,0, 13);

/*******************************************************************************
 * 변수명           한글명
 *--------------------------------------------------------------------------------
 ********************************************************************************
 * 공통
 ********************************************************************************
 * transSeq			거래번호
 * userId			사용자아이디
 * userName			사용자이름
 * userPhoneNo		사용자휴대폰번호
 * moid				주문번호
 * goodsName		상품명
 * goodsAmt			상품금액
 * buyerName		구매자명
 * buyerPhoneNo		구매자휴대폰번호
 * pgCode			PG코드 ( 01:NICE / 02:KICC / 03:INFINISOFT / 04:KSNET / 05:KCP / 06:SMATRO )
 * pgName			PG명
 * payMethod		결제수단( 01:현금결제 / 02:신용카드 / 03:신용카드ARS )
 * payMethodName	결제수단명
 * pgMid			PG아이디
 * pgSid			PG서비스아이디
 * status			거래상태 ( 25:결제완료 / 85:결제취소 )
 * statusName		거래상태명
 * pgResultCode		PG결과코드
 * pgResultMsg		PG결과메세지
 * pgAppDate		PG승인일자
 * pgAppTime		PG승인시간
 * pgTid			PG거래번호
 * approvalAmt		승인금액
 * approvalNo		승인번호
 * stateCd			거래상태값 ( 0:승인 / 1:매입전취소 / 2:매입후취소 )
 ********************************************************************************
 * 현글결제(현금영수증)
 ********************************************************************************
 * cashReceiptType			증빙구분 ( 1:소득공제 / 2:지출증빙 )
 * cashReceiptTypeName		증빙구분명
 * cashReceiptSupplyAmt		공급가
 * cashReceiptVat			부가세
 ********************************************************************************
 * 신용카드결제
 ********************************************************************************
 * cardNo					카드번호
 * cardQuota				할부개월
 * cardIssueCode			발급사코드 ( 메뉴얼참조 )
 * cardIssueName			발급사명
 * cardAcquireCode			매입사코드 ( 메뉴얼참조 )
 * cardAcquireName			매입사명
 ********************************************************************************
 * 계좌이체결제
 ********************************************************************************
 * bankCd					은행코드
 * accntNo					계좌번호
 ********************************************************************************
 * 가상계좌결제
 ********************************************************************************
 * vacctNo					가상계좌번호
 * vbankBankCd				가상계좌은행코드
 * vbankAcctNm				송금자명
 * vbankRefundAcctNo		환불계좌번호
 * vbankRefundBankCd		수취인연락처
 * vbankRefundAcctNm		환불계좌주명
 ********************************************************************************
 * 결제취소
 ********************************************************************************
 * cancelAmt				취소요청금액
 * cancelMsg				취소요청메세지
 * cancelResultCode			취소결과코드
 * cancelResultMsg			취소결과메세지
 * cancelAppDate			취소승인일자
 * cancelAppTime			취소승인시간
 * cancelPgTid				PG거래번호
 * cancelApprovalAmt		승인금액
 * cancelApprovalNo			승인번호
*******************************************************************************/

$transSeq      	= $transSeq;
$userId        	= $userId;
$userName      	= $userName;
$userPhoneNo   	= $userPhoneNo;
$moid          	= $moid;
$goodsName     	= $goodsName;
$goodsAmt      	= $goodsAmt;
$buyerName     	= $buyerName;
$buyerPhoneNo  	= $buyerPhoneNo;
$pgCode        	= $pgCode;
$pgName        	= $pgName;
$payMethod     	= $payMethod;
$payMethodName 	= $payMethodName;
$pgMid         	= $pgMid;
$pgSid         	= $pgSid;
$status        	= $status;
$statusName    	= $statusName;
$pgResultCode  	= $pgResultCode;
$pgResultMsg   	= $pgResultMsg;
$pgAppDate     	= $pgAppDate;
$pgAppTime     	= $pgAppTime;
$pgTid         	= $pgTid;
$approvalAmt   	= $approvalAmt;
$approvalNo    	= $approvalNo;
$stateCd       	= $stateCd;

//현금결제(현금영수증)
if($payMethod == '01'){
	$cashReceiptType		= $cashReceiptType;
	$cashReceiptTypeName	= $cashReceiptTypeName;
	$cashReceiptSupplyAmt	= $cashReceiptSupplyAmt;
	$cashReceiptVat			= $cashReceiptVat;
}
//신용카드 & 신용카드ARS
else if($payMethod == '02' || $payMethod == '03'){
	$cardNo				= $cardNo;
	$cardQuota			= $cardQuota;
	$cardIssueCode		= $cardIssueCode;
	$cardIssueName		= $cardIssueName;
	$cardAcquireCode	= $cardAcquireCode;
	$cardAcquireName	= $cardAcquireName;
}
//계좌이체결제
else if($payMethod == '07'){
	$bankCd				= $bankCd;
	$accntNo			= $accntNo;
}
//가상계좌결제
else if($payMethod == '08'){
	$vacctNo			= $vacctNo;
	$vbankBankCd		= iconv('utf-8', 'eic-kr', $vbankBankCd);
	$vbankAcctNm		= $vbankAcctNm;
	$vbankRefundAcctNo	= $vbankRefundAcctNo;
	$vbankRefundBankCd	= $vbankRefundBankCd;
	$vbankRefundAcctNm	= $vbankRefundAcctNm;

	if($status == '25'){

		// 주문정보
		$sql		= "SELECT * FROM wiz_order WHERE orderid = '$moid'";
		$result		= mysql_query($sql) or error(mysql_error());
		$order_info	= mysql_fetch_object($result);

		$_Payment['status']		= "OY";						//결제상태
		$_Payment['orderid']	= $moid;					//주문번호
		$_Payment['paymethod']	= $order_info->pay_method;	//결제종류
		$_Payment['ttno']		= $pgTid;					//거래번호
		$_Payment['bankkind']	= $vbankBankCd;				//은행코드
		$_Payment['accountno']	= $vacctNo;					//계좌번호
		$_Payment['pgname']		= "INNOPAY";				//PG사 종류
		$_Payment['es_check']	= $oper_info->pay_escrow;	//에스크로 사용여부
		$_Payment['es_stats']	= "IN";						//에스크로 상태(데이콤으로 기본정보 발송)
		$_Payment['tprice']		= $approvalAmt;				//결제금액
		$_Payment['cash_num']	= $LGD_CASHRECEIPTNUM;		//현금영수증 승인번호
		$_Payment['cash_type']	= $LGD_CASHRECEIPTKIND;		//현금영수증 종류
		$_Payment['cash_segno']	= $LGD_CASSEQNO;			//가상계좌 입금순서

		//결제처리(상태변경,주문 업데이트)
		Exe_payment($_Payment);
		// 적립금 처리 : 적립금 사용시 적립금 감소
		Exe_reserve();
		// 재고처리
		Exe_stock();
		// 장바구니 삭제
		Exe_delbasket($order_info->orderid);
	}
}

if($status == '85'){
	//결제취소
	$cancelAmt			= $cancelAmt;
	$cancelMsg			= $cancelMsg;
	$cancelResultCode	= $cancelResultCode;
	$cancelResultMsg	= $cancelResultMsg;
	$cancelAppDate		= $cancelAppDate;
	$cancelAppTime		= $cancelAppTime;
	$cancelPgTid		= $cancelPgTid;
	$cancelApprovalAmt	= $cancelApprovalAmt;
	$cancelApprovalNo	= $cancelApprovalNo;
}

//상품 정보가 추가될 경우 (주석제거)
//$goodsSize			= $goodsSize;
//$goodsCodeArray		= $goodsCodeArray;
//$goodsNameArray		= $goodsNameArray;
//$goodsAmtArray		= $goodsAmtArray;
//$goodsCntArray		= $goodsCntArray;
//$totalAmtArray		= $totalAmtArray;

//배송지 정보가 추가될 경우 (주석제거)
//$zoneCode				= $zoneCode;
//$address				= $address;
//$addressDetail		= $addressDetail;
//$recipientName		= $recipientName;
//$recipientPhoneNo		= $recipientPhoneNo;
//$comment				= $comment;


$PageCall = date("Y-m-d [H:i:s]",time());
$logfile = fopen( $LogPath . "/".date('Ymd').".txt", "a+" );

fwrite( $logfile,"************************************************\r\n");
fwrite( $logfile,"PageCall time     : ".$PageCall."\r\n");
fwrite( $logfile,"transSeq          : ".$transSeq."\r\n");
fwrite( $logfile,"userId            : ".$userId."\r\n");
fwrite( $logfile,"userName          : ".$userName."\r\n");
fwrite( $logfile,"userPhoneNo       : ".$userPhoneNo."\r\n");
fwrite( $logfile,"moid              : ".$moid."\r\n");
fwrite( $logfile,"goodsName         : ".$goodsName."\r\n");
fwrite( $logfile,"goodsAmt          : ".$goodsAmt."\r\n");
fwrite( $logfile,"buyerName         : ".$buyerName."\r\n");
fwrite( $logfile,"buyerPhoneNo      : ".$buyerPhoneNo."\r\n");
fwrite( $logfile,"pgCode            : ".$pgCode."\r\n");
fwrite( $logfile,"pgName            : ".$pgName."\r\n");
fwrite( $logfile,"payMethod         : ".$payMethod."\r\n");
fwrite( $logfile,"payMethodName     : ".$payMethodName."\r\n");
fwrite( $logfile,"pgMid             : ".$pgMid."\r\n");
fwrite( $logfile,"pgSid             : ".$pgSid."\r\n");
fwrite( $logfile,"status            : ".$status."\r\n");
fwrite( $logfile,"statusName        : ".$statusName."\r\n");
fwrite( $logfile,"pgResultCode      : ".$pgResultCode."\r\n");
fwrite( $logfile,"pgResultMsg       : ".$pgResultMsg."\r\n");
fwrite( $logfile,"pgAppDate         : ".$pgAppDate."\r\n");
fwrite( $logfile,"pgAppTime         : ".$pgAppTime."\r\n");
fwrite( $logfile,"pgTid             : ".$pgTid."\r\n");
fwrite( $logfile,"approvalAmt       : ".$approvalAmt."\r\n");
fwrite( $logfile,"approvalNo        : ".$approvalNo."\r\n");
fwrite( $logfile,"stateCd           : ".$stateCd."\r\n");

if($payMethod == '01'){
	fwrite( $logfile,"cashReceiptType      : ".$cashReceiptType."\r\n");
	fwrite( $logfile,"cashReceiptTypeName  : ".$cashReceiptTypeName."\r\n");
	fwrite( $logfile,"cashReceiptSupplyAmt : ".$cashReceiptSupplyAmt."\r\n");
	fwrite( $logfile,"cashReceiptVat       : ".$cashReceiptVat."\r\n");
}
else if($payMethod == '02' || $payMethod == '03'){
	fwrite( $logfile,"cardNo            : ".$cardNo."\r\n");
	fwrite( $logfile,"cardQuota         : ".$cardQuota."\r\n");
	fwrite( $logfile,"cardIssueCode     : ".$cardIssueCode."\r\n");
	fwrite( $logfile,"cardIssueName     : ".$cardIssueName."\r\n");
	fwrite( $logfile,"cardAcquireCode   : ".$cardAcquireCode."\r\n");
	fwrite( $logfile,"cardAcquireName   : ".$cardAcquireName."\r\n");
}
else if($payMethod == '07'){
	fwrite( $logfile,"bankCd            : ".$bankCd."\r\n");
	fwrite( $logfile,"accntNo           : ".$accntNo."\r\n");
}
else if($payMethod == '08'){
	fwrite( $logfile,"vacctNo           : ".$vacctNo."\r\n");
	fwrite( $logfile,"vbankBankCd       : ".$vbankBankCd."\r\n");
	fwrite( $logfile,"vbankAcctNm       : ".$vbankAcctNm."\r\n");
	fwrite( $logfile,"vbankRefundAcctNo : ".$vbankRefundAcctNo."\r\n");
	fwrite( $logfile,"vbankRefundBankCd : ".$vbankRefundBankCd."\r\n");
	fwrite( $logfile,"vbankRefundAcctNm : ".$vbankRefundAcctNm."\r\n");
}

if($status == '85'){
	fwrite( $logfile,"cancelAmt         : ".$cancelAmt."\r\n");
	fwrite( $logfile,"cancelMsg         : ".$cancelMsg."\r\n");
	fwrite( $logfile,"cancelResultCode  : ".$cancelResultCode."\r\n");
	fwrite( $logfile,"cancelResultMsg   : ".$cancelResultMsg."\r\n");
	fwrite( $logfile,"cancelAppDate     : ".$cancelAppDate."\r\n");
	fwrite( $logfile,"cancelAppTime     : ".$cancelAppTime."\r\n");
	fwrite( $logfile,"cancelPgTid       : ".$cancelPgTid."\r\n");
	fwrite( $logfile,"cancelApprovalAmt : ".$cancelApprovalAmt."\r\n");
	fwrite( $logfile,"cancelApprovalNo  : ".$cancelApprovalNo."\r\n");
}

//상품 정보가 추가될 경우 (주석제거)
//fwrite( $logfile,"goodsSize  		: ".$goodsSize."\r\n");
//fwrite( $logfile,"goodsCodeArray  : ".$goodsCodeArray."\r\n");
//fwrite( $logfile,"goodsNameArray  : ".$goodsNameArray."\r\n");
//fwrite( $logfile,"goodsAmtArray  	: ".$goodsAmtArray."\r\n");
//fwrite( $logfile,"goodsCntArray  	: ".$goodsCntArray."\r\n");
//fwrite( $logfile,"totalAmtArray  	: ".$totalAmtArray."\r\n");

//배송지 정보가 추가될 경우 (주석제거)
//fwrite( $logfile,"zoneCode  		: ".$zoneCode."\r\n");
//fwrite( $logfile,"address  		: ".$address."\r\n");
//fwrite( $logfile,"addressDetail  	: ".$addressDetail."\r\n");
//fwrite( $logfile,"recipientName  	: ".$recipientName."\r\n");
//fwrite( $logfile,"recipientPhoneNo: ".$recipientPhoneNo."\r\n");
//fwrite( $logfile,"comment  		: ".$comment."\r\n");

fwrite( $logfile,"************************************************");
fclose( $logfile );

//************************************************************************************

//위에서 상점 데이터베이스에 등록 성공유무에 따라서 성공시에는 "0000"를 인피니로
//리턴하셔야합니다. 아래 조건에 데이터베이스 성공시 받는 FLAG 변수를 넣으세요
//(주의) "0000"를 리턴하지 않으시면 인피니 지불 서버는 "0000"를 수신할때까지 계속 재전송(최대지정횟수)을 시도합니다
//기타 다른 형태의 PRINT( echo )는 하지 않으시기 바랍니다

//if (데이터베이스 등록 성공 유무 조건변수 = true)
//{

echo "0000"; // 절대로 지우지마세요

//}

//*************************************************************************************
?>