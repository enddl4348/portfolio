<?
//�׽�Ʈ
if($oper_info->pay_test=='Y') {
	$MID		= 'testpay01m';
	$MerchantKey= 'Ma29gyAFhvv/+e4/AHpV6pISQIvSKziLIbrNoXPbRS5nfTx2DOs8OJve+NzwyoaQ8p9Uy1AN4S1I0Um5v7oNUg==';
}
//�ǰŷ�
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
//������� ���//
///////////////
switch($order_info->pay_method){
	case "PC"://�ſ�ī��
		$_paymethod = "CARD";break;
	case "PN"://������ü
		$_paymethod = "BANK";break;
	case "PV"://�������
		$_paymethod = "VBANK";break;
}
?>
<!-- InnoPay �������� ��ũ��Ʈ(�ʼ�) -->
<script type="text/javascript" src="https://pg.innopay.co.kr/ipay/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="https://pg.innopay.co.kr/ipay/js/innopay-2.0.js" charset="utf-8"></script>
<script type="text/javascript">
<!--
function goPay(){
	var frm = document.payForm;

	// ������û �Լ�
	innopay.goPay({
		//// �ʼ� �Ķ����
		PayMethod		: frm.PayMethod.value,		// ��������(CARD,BANK,VBANK,CARS,CSMS,DSMS,EPAY,EBANK)
		MID				: frm.MID.value,			// ������ MID
		MerchantKey		: frm.MerchantKey.value,	// ������ ���̼���Ű
		GoodsName		: frm.GoodsName.value,		// ��ǰ��
		Amt				: frm.Amt.value,			// �����ݾ�(����)
		BuyerName		: frm.BuyerName.value,		// ����
		BuyerTel		: frm.BuyerTel.value,		// ����ȭ��ȣ
		BuyerEmail		: frm.BuyerEmail.value,		// ���̸���
		ResultYN		: frm.ResultYN.value,		// �������â �������
		Moid			: frm.Moid.value,			// ���������� ������ �ֹ���ȣ ����
		//// ���� �Ķ����
		ReturnURL		: frm.ReturnURL.value,		// ������� ���� URL(���� ��� �Ʒ� innopay_result �Լ��� ��������� ���۵�)
		EncodingType	: frm.EncodingType.value,	// ������ ���� ���ڵ� Ÿ�� (utf-8, euc-kr)
		MallIP			: frm.MallIP.value,			// ������ ���� IP
		UserIP			: frm.UserIP.value,			// �� PC IP
		mallUserID		: frm.mallUserID.value,		// ������ ��ID
//		ArsConnType:'02', 							// ARS ���� ������ �ʼ� 01:ȣ��ȯ, 02(�����ȣ), 03:��ǥ��ȣ
		FORWARD:'X',								// ����â ������� (X:���̾�, �⺻��)
//		GoodsCnt:'',								// ��ǰ���� (������ �����)
//		MallReserved:'',							// ������ ������
//		OfferingPeriod:'',							// �����Ⱓ
//		DutyFreeAmt:'',								// �����ݾ�(���հ���/�鼼 �������� ��� �ݾ׼���)
//		User_ID:'',									// Innopay�� ��ϵ� �������ID
		Currency:''									// ��ȭ�ڵ尡 ��ȭ�� �ƴ� ��츸 ���(KRW/USD)
	});
}

/**
 * ������� ���� Javascript �Լ�
 * ReturnURL�� ���� ��� �Ʒ� �Լ��� ����� ���ϵ˴ϴ� (�Լ��� ����Ұ�!)
 */
function innopay_result(data){
	var a			= JSON.stringify(data);
	// Sample
	var mid			= data.MID;				// ������ MID
	var tid			= data.TID;				// �ŷ�������ȣ
	var amt			= data.Amt;				// �ݾ�
	var moid		= data.MOID;			// �ֹ���ȣ
	var authdate	= data.AuthDate;		// ��������
	var authcode	= data.AuthCode;		// ���ι�ȣ
	var resultcode	= data.ResultCode;		// ����ڵ�(PG)
	var resultmsg	= data.ResultMsg;		// ����޼���(PG)
	var errorcode	= data.ErrorCode;		// �����ڵ�(�������)
	var errormsg	= data.ErrorMsg;		// �����޼���(�������)
	var EPayCl		= data.EPayCl;
	alert("["+resultcode+"]"+resultmsg);
}
//-->
</script>

<form method="post" name="payForm" accept-charset="UTF-8">
<input type="hidden" name="PayMethod"	value="<?=$_paymethod?>">	<!-- �������� -->
<input type="hidden" name="MID"			value="<?=$MID?>">			<!-- ���� MID -->
<input type="hidden" name="MerchantKey"	value="<?=$MerchantKey?>">	<!-- ���� ���̼���Ű -->
<input type="hidden" name="GoodsName"	value="<?=$GoodsName?>">	<!-- ��ǰ�� -->
<input type="hidden" name="Amt"			value="<?=$Amt?>">			<!-- �����ݾ�(����) -->
<input type="hidden" name="BuyerName"	value="<?=$BuyerName?>">	<!-- �����ڸ� -->
<input type="hidden" name="BuyerTel"	value="<?=$BuyerTel?>">		<!-- ������ ����ó -->
<input type="hidden" name="BuyerEmail"	value="<?=$BuyerEmail?>">	<!-- ������ �̸��� �ּ� -->
<input type="hidden" name="ResultYN"	value="<?=$ResultYN?>">		<!-- PG�������â ����(N:�������â ����, ������ ReturnURL�� �������) -->
<input type="hidden" name="ReturnURL"	value="<?=$ReturnURL?>">	<!-- ����������� URL -->
<input type="hidden" name="Moid"		value="<?=$Moid?>">			<!-- ������ �ֹ���ȣ -->
<input type="hidden" name="EncodingType"value="<?=$EncodingType?>">	<!-- ������ ���� ���ڵ� Ÿ�� (utf-8, euc-kr) -->
<input type="hidden" name="MallIP"		value="<?=$MallIP?>">		<!-- ������ ���� IP -->
<input type="hidden" name="UserIP"		value="<?=$UserIP?>">		<!-- �� PC IP -->
<input type="hidden" name="mallUserID"	value="<?=$mallUserID?>">	<!-- ���ð������� -->

<div class="ord__payment">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="ord__payment__tb">
		<tr>
			<th>�������</th>
			<td><?=pay_method($pay_method)?></td>
		</tr>
		<tr>
			<th>�����ݾ�</th>
			<td><span class="price_a"><?=number_format($order_info->total_price)?>��</span></td>
		</tr>
	</table>
</div>

<div class="button_common">
	<button type="button" class="btn_grat_big" onclick="goPay();">�����ϱ�</button>
</div>
</form>