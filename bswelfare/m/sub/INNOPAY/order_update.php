<?php
include "../../../inc/common.inc";			// DB���ؼ�, ������ �ľ�
include "../../../inc/util.inc"; 			// ��ƿ ���̺귯��
include "../../../inc/oper_info.inc"; 		// � ����

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

// �ֹ�����
$sql		= "SELECT * FROM wiz_order WHERE orderid = '$MOID'";
$result		= mysql_query($sql) or error(mysql_error());
$order_info	= mysql_fetch_object($result);

// ��������
if($ResultCode == "3001" || $ResultCode == "4000" || $ResultCode == "4100"){

	if($order_info->pay_method=='PV')	$status = 'OR';
	else								$status = 'OY';

	$_Payment['status']		= $status;					//��������
	$_Payment['orderid']	= $MOID;					//�ֹ���ȣ
	$_Payment['paymethod']	= $order_info->pay_method;	//��������
	$_Payment['ttno']		= $TID;						//�ŷ���ȣ
	$_Payment['bankkind']	= $VbankName;				//�����ڵ�(��������ϰ��)
	$_Payment['accountno']	= $VbankNum;				//���¹�ȣ(��������ϰ��)
	$_Payment['pgname']		= "INNOPAY";				//PG�� ����
	$_Payment['es_check']	= $oper_info->pay_escrow;	//����ũ�� ��뿩��
	$_Payment['es_stats']	= "IN";						//����ũ�� ����(���������� �⺻���� �߼�)
	$_Payment['tprice']		= $Amt;						//�����ݾ�

	foreach($_Payment as $key => $value){
		$logs .="$key : $value\r";
	}
	@make_log("log/".date('Ymd').".txt","\r-----order_update.php start-----\r".$logs."\r-----order_update.php END-----\r");

	//����ó��(���º���,�ֹ� ������Ʈ)
	Exe_payment($_Payment);
	// ������ ó�� : ������ ���� ������ ����
	Exe_reserve();
	// ���ó��
	$stock_out = Exe_stock(); // $stock_out == true > ������ ����ʿ�
	// ��ٱ��� ����
	Exe_delbasket($order_info->orderid);

	$ResultCode	= '0000';
	$ResultMsg	= '';

	// ���� ��� ������ ��� ó��
	if($stock_out == true){
		$status		= 'OC';
		$cancelmsg	= '������ �ڵ����';
		$ResultCode	= '9999';
		$ResultMsg	= $cancelmsg;

		// [�ſ�ī��/������ü]+�����Ϸ� ���½� ��� ���
		if($order_info->pay_method=='PC' || $order_info->pay_method=='PN'){
			$res = cancelInnoPay($order_info->orderid, $cancelmsg);

			if($res==true){
				cancelOrder($order_info, $status, $cancelmsg);
			}
		}

		// ������� or ������� ���н� ��ǰ��û ó��
		if($order_info->pay_method='PV' || $res!=true){

			$sql = "UPDATE wiz_order SET cancelmsg='$cancelmsg', status='RD' WHERE orderid='$order_info->orderid' AND status NOT IN('OC', 'RC')";
			mysql_query($sql);
		}
	}
}

// ��������
else{
	//echo $ResultCode . " " . $ResultMsg;
}
?>
<script>
document.location.replace('/m/sub/order_ok.php?orderid=<?=$MOID?>&rescode=<?=$ResultCode?>&resmsg=<?=$ResultMsg?>');
</script>