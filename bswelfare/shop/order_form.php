<?
include $_SERVER["DOCUMENT_ROOT"]."/inc/common.inc"; 			// DB���ؼ�, ������ �ľ�

// �α��� ���� ������� �α��� �������� �̵�
if(empty($wiz_session[id]) && empty($order_guest)){
	echo "<script>document.location='/member/login.php?prev=$PHP_SELF&order=true';</script>";
	exit;
}
$now_position = "<a href=/>Home</a> &gt; �ֹ��ϱ� &gt; �ֹ����� �Է�";
$page_type = "join";

include $_SERVER["DOCUMENT_ROOT"]."/inc/util.inc"; 		   	// ��ƿ ���̺귯��
include $_SERVER["DOCUMENT_ROOT"]."/inc/shop_info.inc"; 	// ���� ����
include $_SERVER["DOCUMENT_ROOT"]."/inc/oper_info.inc"; 	// � ����
include $_SERVER["DOCUMENT_ROOT"]."/inc/mem_info.inc"; 		// ȸ�� ����
include $_SERVER["DOCUMENT_ROOT"]."/inc/page_info.inc"; 	// ������ ����
include $SKIN_DIR."/inc/header.php"; 			// ��ܵ�����

// ȸ�������� ������� ���(=�����ڰ� �α��� �� ���)
if(empty($mem_info) && $wiz_session['id'] == $wiz_admin['id']){
	$sql = "SELECT * FROM wiz_admin WHERE sid='".$SID."' and id = '".$wiz_session['id']."'";
	$result = mysql_query($sql) or error(mysql_error());
	$mem_info = mysql_fetch_object($result);

	$mem_tphone = explode("-", $mem_info->tphone);
	$mem_hphone = explode("-", $mem_info->hphone);
	$mem_fax = explode("-", $mem_info->fax);
	$mem_post = explode("-", $mem_info->post);

	$mem_com_post = explode("-", $mem_info->com_post);

	$mem_birthday = explode("-", $mem_info->birthday);
	$mem_memorial = explode("-", $mem_info->memorial);

	$mem_email = explode("@", $mem_info->email);
}

// ȸ�������� ��������
if($oper_info->reserve_use == "Y" && $wiz_session[id] != ""){

	$sql = "select sum(reserve) as reserve from wiz_reserve where memid = '$wiz_session[id]'";
	$result = mysql_query($sql) or error(mysql_error());
	$row = mysql_fetch_object($result);
	if($row->reserve == "") $mem_info->reserve = 0;
	else $mem_info->reserve = $row->reserve;

}else{
	$mem_info->reserve = 0;
}
?>
<body onUnload="cuponClose();">

<div class="container sub-cntainer clearfix">
	<div class="content-body">

<? $step2="on"; include "./basket_step.php"; ?>

<div class="bbs_wrap">
<!-- �Խ��� -->

<? include "basket_listing.inc"; ?>

<form name="frm" action="<?=$ssl?>/shop/order_save.php" method="post" enctype="multipart/form-data" onSubmit="return inputCheck(this)">
<input type="hidden" name="selidx" value="<?=$selidx?>">
<input type="hidden" name="total_price" value="<?=$total_price?>">
<input type="hidden" name="coupon_idx" value="">
<input type="hidden" name="basket_exist" value="<?=$basket_exist?>">
<input type="hidden" name="gifticon_bsk" value="<?=$gifticon_bsk?>">

<div class="join_ttl" style="margin:30px 0 0;">�ֹ��Ͻô� ��</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="join_form">
	<tr>
		<td width="15%" class="tit">�ֹ��Ͻô� ��</td>
		<td class="val"><input type=text name="send_name" value="<?=$mem_info->name?>" size=25 class="input"></td>
	</tr>
	<tr>
		<td class="tit">��ȭ��ȣ</td>
		<td class="val">
			<input type=text name="send_tphone" value="<?=$mem_tphone[0]?>" size=3 class="input"> -
			<input type=text name="send_tphone2" value="<?=$mem_tphone[1]?>" size=4 class="input"> -
			<input type=text name="send_tphone3" value="<?=$mem_tphone[2]?>" size=4 class="input">
		</td>
	</tr>
	<tr>
		<td class="tit">�޴���ȭ��ȣ</td>
		<td class="val">
			<input type=text name="send_hphone" value="<?=$mem_hphone[0]?>" size=3 class="input"> -
			<input type=text name="send_hphone2" value="<?=$mem_hphone[1]?>" size=4 class="input"> -
			<input type=text name="send_hphone3" value="<?=$mem_hphone[2]?>" size=4 class="input">
		</td>
	</tr>
	<tr>
		<td class="tit">�̸���</td>
		<td class="val"><input type=text name="send_email" value="<?=$mem_info->email?>" size=30 class="input"></td>
	</tr>
	<tr>
		<td class="tit">�� ��</td>
		<td class="val">
			<input type=text name="send_post" value="<?=$mem_post[0]?>" size=7 class="input">
			<button type="button" class="post_btn" onclick="zipSearch();">�ּ�ã��</button><br />
			<input type=text name="send_address" value="<?=$mem_info->address?>" size=70 class="input">
			<input type=text name="send_address2" value="<?=$mem_info->address2?>" size=70 class="input">
		</td>
	</tr>
<table>

<div class="join_ttl" style="margin:30px 0 0;">��ǰ ������ ��</div>
<? if($gifticon_bsk == 'Y'){ ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="join_form">
	<tr>
		<td width="15%" class="tit">�޴���ȭ��ȣ</td>
		<td class="val">
			<input type=text name="rece_hphone" size=3 class="input"> -
			<input type=text name="rece_hphone2" size=4 class="input"> -
			<input type=text name="rece_hphone3" size=4 class="input">
		</td>
	</tr>
</table>
<? }else{ ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="join_form">
	<caption>
		<? if($wiz_session['level']=='24') { ?>
		<label><input type="checkbox" name="recefile" onClick="receFile(this);" value="Y" /> �뷮����� ���</label>
		<? } ?>
		<label><input type="checkbox" name="same_check" onClick="sameCheck(this.form);" /> �ֹ��� ������ �����մϴ�.</label>
	</caption>
	<? if($wiz_session['level']=='24') { ?>
	<tr class="rece_file" style="display:none;">
		<td width="15%" class="tit">�뷮�����</td>
		<td class="val">
			<input name="print_upfile1" type="file">
			<a href="/admin/bbs/bbs_down.php?code=reference&idx=445&no=2">[��� �ٿ�ε�]</a>
		</td>
	</tr>
	<? } ?>
	<tr class="rece_input">
		<td width="15%" class="tit">�����ô� ��</td>
		<td class="val">
			<input type=text name="rece_name" size=25 class="input">
			<button type="button" class="post_btn" onclick="popMyAddr();">����� ���</button>
			<a href="javascript:void(0);" onclick="addDeliver();" class="post_btn">�ű� �����</a>
		</td>
	</tr>
	<tr class="rece_input">
		<td class="tit">��ȭ��ȣ</td>
		<td class="val">
			<input type=text name="rece_tphone" size=3 class="input"> -
			<input type=text name="rece_tphone2" size=4 class="input"> -
			<input type=text name="rece_tphone3" size=4 class="input">
		</td>
	</tr>
	<tr class="rece_input">
		<td class="tit">�޴���ȭ��ȣ</td>
		<td class="val">
			<input type=text name="rece_hphone" size=3 class="input"> -
			<input type=text name="rece_hphone2" size=4 class="input"> -
			<input type=text name="rece_hphone3" size=4 class="input">
		</td>
	</tr>
	<tr class="rece_input">
		<td class="tit">�� ��</td>
		<td class="val">
			<input type=text name="rece_post" size=7 class="input">
			<button type="button" class="post_btn" onclick="zipSearch2();">�ּ�ã��</button><br />
			<input type=text name="rece_address" size=70 class="input">
			<input type=text name="rece_address2" size=70 class="input">
		</td>
	</tr>
	<? if($receive_wish){ ?>
	<tr>
		<td class="tit">���������</td>
		<td class="val"><input class="input datepicker2" name="want_receive_date"></td>
	</tr>
	<? } ?>
	<tr>
		<td class="tit">��û����</td>
		<td class="val"><textarea name="demand" cols="80" rows="4" class="input"></textarea></td>
	</tr>
</table>
<? } ?>

<?/*<div class="join_ttl" style="margin:30px 0 0;">��Ÿ</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="join_form">
	<tr>
		<td class="tit" width="15%">÷������1</td>
		<td class="val"><input type="file" name="print_upfile1" class="input"></td>
	</tr>
	<tr>
		<td class="tit">÷������2</td>
		<td class="val"><input type="file" name="print_upfile2" class="input"></td>
	</tr>
	<tr>
		<td class="tit">�μ⹮��</td>
		<td class="val"><textarea name="print_str" cols="80" rows="4" class="input"></textarea></td>
	</tr>
	<tr>
		<td class="tit">Ư�����</td>
		<td class="val"><textarea name="print_memo" cols="80" rows="4" class="input"></textarea></td>
	</tr>
</table>*/?>

<div class="join_ttl" style="margin:30px 0 0;">��������</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="join_form">
	<? if($shop_info->shop_type2 == '02'){ ?>
	<caption>��ǰ��� �Աݰ��´� ������ ���θ� �����̸�, ���ݰ�꼭�� ���θ����� ����˴ϴ�.</caption>
	<? } ?>

	<? if($oper_info->coupon_use == "Y"){ ?>
	<tr>
		<td class="tit">�������</td>
		<td class="val">
			<input type="text" name="coupon_use" style="text-align:right"  size="15" class="input" readonly>&nbsp;��
			<a href="javascript:couponUse();" class="post_btn">������ȸ �� ����</a>
		</td>
	</tr>
	<? }else{ ?>
	<input type="hidden" name="coupon_use">
	<? } ?>

	<? if($oper_info->reserve_use == "Y"){ ?>
	<tr>
		<td class="tit">����Ʈ���</td>
		<td class="val">
			<input type="text" name="reserve_use" style="text-align:right"  size="15" class="input" onchange="reserveUse(this.form);">&nbsp;��&nbsp;&nbsp;
			<label><input type="checkbox" name="reserve_useall" value="Y" onclick="resesrveAll(this, this.form);"> ���׻��</label>
			(��������Ʈ : <?=number_format($mem_info->reserve)?>��)<?/*<br />
			<font color=red>(�������� <?=number_format($oper_info->reserve_min)?>������ <?=number_format($oper_info->reserve_max)?>������ ����� �����մϴ�)</font>*/?>
		</td>
	</tr>
	<? }else{ ?>
	<input type="hidden" name="reserve_use">
	<? } ?>

	<tr>
		<td class="tit" width="15%">�������</td>
		<td class="val">
			<input type="radio" name="pay_method" value="" style="display:none">
			<?
			if($wiz_session['level']=='24') $oper_info->pay_method = 'ST/';	// ���Ŵ���ڴ� �ŷ����� �ŷ� �߰�
			$pay_method = explode("/",$oper_info->pay_method);

			for($ii=0; $ii<count($pay_method)-1; $ii++){

				$pay_title = pay_method($pay_method[$ii]);

				if($ii == 0) $checked = "checked";
				else $checked = "";

				if($oper_info->pay_escrow == "Y" && ($pay_method[$ii] == "PN" || $pay_method[$ii] == "PV")) $pay_title .= " (����ũ��)";

				echo "<label><input type='radio' name='pay_method' value='$pay_method[$ii]' onClick='pclick()' $checked> $pay_title</label>";
			}
			?>
		</td>
	</tr>

	<? if(!strcmp($oper_info->tax_use, "Y")) { ?>
	<tr>
		<td class="tit">���ݰ�꼭</td>
		<td class="val">
			<label><input type="radio" name="tax_type" value="N" checked onClick="qclick('');"> �������</label>
			<label><input type="radio" name="tax_type" value="T" onClick="qclick('01');"> ���ݰ�꼭 ��û</label>
			<label><input type="radio" name="tax_type" value="C" onClick="qclick('02');"> ���ݿ����� ��û</label>
			<? if($wiz_session['level']=='24') { ?>
			<button type="button" class="post_btn" onclick="printEstimate();" style="margin-left:10px;">������ ���</button>
			<? } ?>

			<div id="tax01" style="display:none;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="join_form">
					<tr>
						<td class="tit" width="15%">����� ��ȣ</td>
						<td class="val" colspan="3"><input type="text" name="com_num" value="<?//=$mem_info->com_num?>" class="input" size="20"></td>
					</tr>
					<tr>
						<td class="tit" width="15%">�� ȣ</td>
						<td class="val" width="30%"><input type="text" name="com_name" value="<?//=$mem_info->com_name?>" class="input"></td>
						<td class="tit" width="15%">��ǥ��</td>
						<td class="val"><input type="text" name="com_owner" value="<?//=$mem_info->com_owner?>" class="input"></td>
					</tr>
					<tr>
						<td class="tit">����� ������</td>
						<td class="val" colspan="3"><input type="text" name="com_address" value="<?//=$mem_info->com_address?>" class="input" size="50"></td>
					</tr>
					<tr>
						<td class="tit">�� ��</td>
						<td class="val"><input type="text" name="com_kind" value="<?//=$mem_info->com_kind?>" class="input"></td>
						<td class="tit">�� ��</td>
						<td class="val"><input type="text" name="com_class" value="<?//=$mem_info->com_class?>" class="input"></td>
					</tr>
					<tr>
						<td class="tit">��ȭ��ȣ</td>
						<td class="val"><input type="text" name="com_tel" value="<?=$mem_info->tphone?>" class="input"></td>
						<td class="tit">�̸���</td>
						<td class="val"><input type="text" name="com_email" value="<?=$mem_info->email?>" class="input"></td>
					</tr>
				</table>
			</div><!-- .tax01 -->

			<div id="tax02" style="display:none;">
				<p style="margin:15px 0 5px 0; color:red;">�� "����" ���� �����Ͽ� ����â �˾����� ������ �Է����ּ���.</p>
				<!--<table width="100%" border="0" cellspacing="0" cellpadding="0" class="join_form">
					<tr>
						<td width="15%" class="tit">�߱޻���</td>
						<td class="val">
							<label><input type="radio" name="cash_type" value="C" onClick="qclick2('01');"> ����� ����������</label>
							<label><input type="radio" name="cash_type" value="P" onClick="qclick2('02');"> ���μҵ� ������</label>
						</td>
					</tr>
					<tr>
						<td class="tit">��û����</td>
						<td class="val">
							<div id="cash_info01"></div>
							<div id="cash_info02" style="padding:3px;"></div>
						</td>
					</tr>
					<tr>
						<td class="tit">��û�ڸ�</td>
						<td class="val">
							<input type="text" name="cash_name" value="" class="input">
						</td>
					</tr>
				</table>-->
			</div><!-- .tax01 -->


		</td>
	</tr>
	<? } ?>
</table>

<div class="basket_btn">
    <button type="submit" class="on">����</button>
    <button type="button" class="back" onclick="javascript:history.go(-1);">����ϱ�</button>
</div>
</form>
</div><!-- .bbs_wrap -->
<!-- �Խ��� -->

</div><!-- .content-body -->
</div><!-- .Sub-Container -->

<script language="JavaScript" src="/js/util_lib.js"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script language="JavaScript">
<!--
function sameCheck(frm){

	if(frm.same_check.checked == true){
		frm.rece_name.value = frm.send_name.value;

		frm.rece_tphone.value = frm.send_tphone.value;
		frm.rece_tphone2.value = frm.send_tphone2.value;
		frm.rece_tphone3.value = frm.send_tphone3.value;

		frm.rece_hphone.value = frm.send_hphone.value;
		frm.rece_hphone2.value = frm.send_hphone2.value;
		frm.rece_hphone3.value = frm.send_hphone3.value;

		frm.rece_post.value = frm.send_post.value;
		frm.rece_address.value = frm.send_address.value;
		frm.rece_address2.value = frm.send_address2.value;

	}else{

		frm.rece_name.value = "";
		frm.rece_tphone.value = "";
		frm.rece_tphone2.value = "";
		frm.rece_tphone3.value = "";
		frm.rece_hphone.value = "";
		frm.rece_hphone2.value = "";
		frm.rece_hphone3.value = "";
		frm.rece_post.value = "";
		frm.rece_address.value = "";
		frm.rece_address2.value = "";

	}

}

function receFile(o){
	var checked = $(o).prop('checked');
	if(checked==true){
		$(".rece_file").show();
		$(".rece_file input").prop('disabled', false);
		$(".rece_input").hide();
		$(".rece_input input").prop('disabled', true).val('');
	}
	else{
		$(".rece_file").hide();
		$(".rece_file input").prop('disabled', true).val('');
		$(".rece_input").show();
		$(".rece_input input").prop('disabled', false);
	}
}

function inputCheck(frm){

	if(!frm.basket_exist.value) {
		alert("�ֹ��� ��ǰ�� �����ϴ�.");
		return false;
	}

	if(frm.send_name.value == ""){
		alert("�� ������ �Է��ϼ���");
		frm.send_name.focus();
		return false;
	}

	if(frm.send_email.value == ""){
		alert("�� �̸����� �Է��ϼ���.");
		frm.send_email.focus();
		return false;
	}else if(!check_Email(frm.send_email.value)){
		return false;
	}

	if(frm.recefile.checked == true){
		if(frm.print_upfile1.value == ""){
			alert("�뷮����� ������ �����ϼ���");
			frm.print_upfile1.focus();
			return false;
		}
	}
	else{
		if(frm.rece_name.value == ""){
			alert("�����ôº� ������ �Է��ϼ���");
			frm.rece_name.focus();
			return false;
		}

		if(frm.rece_address.value == ""){
			alert("�����ôº� �ּҸ� �Է��ϼ���");
			frm.rece_address.focus();
			return false;
		}
		if(frm.rece_address2.value == ""){
			alert("�����ôº� ���ַθ� �Է��ϼ���");
			frm.rece_address2.focus();
			return false;
		}
	}

	var pay_checked = false;
	var pay_checked_val = "";
	for(ii=0;ii<frm.pay_method.length;ii++){
		if(frm.pay_method[ii].checked == true){
			pay_checked = true;
			pay_checked_val = frm.pay_method[ii].value;
		}
	}

	if(pay_checked == false){
		alert("��������� �����ϼ���");
		return false;
	}

	<? if(!strcmp($oper_info->tax_use, "Y")) { ?>

	if(pay_checked_val == "PC" && frm.tax_type[0].checked != true) {
		alert("�ſ�ī�� ���� �� ���ݰ�꼭 �� ���ݿ����� �߱��� �Ұ����մϴ�.");
		frm.tax_type[0].checked = true;
		qclick("");
		return false;
	}

	// ���ݰ�꼭
	if(frm.tax_type[1].checked == true) {

		if(frm.com_num.value == ""){
			alert("����� ��ȣ�� �Է��ϼ���");
			frm.com_num.focus();
			return false;
		}
		if(frm.com_name.value == ""){
			alert("��ȣ�� �Է��ϼ���");
			frm.com_name.focus();
			return false;
		}
		if(frm.com_owner.value == ""){
			alert("��ǥ�ڸ� �Է��ϼ���");
			frm.com_owner.focus();
			return false;
		}
		if(frm.com_address.value == ""){
			alert("����� �������� �Է��ϼ���");
			frm.com_address.focus();
			return false;
		}
		if(frm.com_kind.value == ""){
			alert("���¸� �Է��ϼ���");
			frm.com_kind.focus();
			return false;
		}
		if(frm.com_class.value == ""){
			alert("������ �Է��ϼ���");
			frm.com_class.focus();
			return false;
		}
		if(frm.com_tel.value == ""){
			alert("��ȭ��ȣ�� �Է��ϼ���");
			frm.com_tel.focus();
			return false;
		}
		if(frm.com_email.value == ""){
			alert("�̸����� �Է��ϼ���");
			frm.com_email.focus();
			return false;
		}
	}

	// ���ݿ�����
	if(frm.tax_type[2].checked == true) {

		/*var cash_type_check = false;
		for(ii = 0; ii < frm.cash_type.length; ii++) {
			if(frm.cash_type[ii].checked == true) {
				cash_type_check = true;
				break;
			}
		}
		if(cash_type_check == false) {
			alert("�߱޻����� �����ϼ���.");
			return false;
		}

		var cash_type2_check = false;
		for(ii = 0; ii < frm.cash_type2.length; ii++) {
			if(frm.cash_type2[ii].checked == true) {
				cash_type2_check = true;
				break;
			}
		}
		if(cash_type2_check == false) {
			alert("��û������ �����ϼ���.");
			return false;
		}

		for(ii = 0; ii < document.forms["frm"].elements["cash_info_arr[]"].length; ii++) {
			if(document.forms["frm"].elements["cash_info_arr[]"][ii].value == "") {
				alert("��û������ �Է��ϼ���.");
				document.forms["frm"].elements["cash_info_arr[]"][ii].focus();
				return false;
			}
		}

		if(frm.cash_name.value == "") {
			alert("��û�ڸ��� �Է��ϼ���.");
			frm.cash_name.focus();
			return false;
		}
		*/
	}

	<? } ?>
	if(!reserveUse(frm)){
		return false;
	}
}

// �ֹ��� �����ȣ
function zipSearch(){

	kind = 'send_';
	new daum.Postcode({
		oncomplete: function(data) {
			// �˾����� �˻���� �׸��� Ŭ�������� ������ �ڵ带 �ۼ��ϴ� �κ�.
			// �����ȣ�� �ּ� ������ �ش� �ʵ忡 �ְ�, Ŀ���� ���ּ� �ʵ�� �̵��Ѵ�.
			eval('document.frm.'+kind+'post').value = data.zonecode;
			eval('document.frm.'+kind+'address').value = data.address;

			//��ü �ּҿ��� ���� ���� �� ()�� ���� �ִ� �ΰ������� �����ϰ��� �� ���,
			//�Ʒ��� ���� ���Խ��� ����ص� �ȴ�. ���Խ��� �������� ������ �°� �����ؼ� ��� �����ϴ�.
			//var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
			//document.getElementById('addr').value = addr;

			if(eval('document.frm.'+kind+'address2') != null){
				eval('document.frm.'+kind+'address2').value = '';
				eval('document.frm.'+kind+'address2').focus();
			}
		}
	}).open();

}

// ������ �����ȣ
function zipSearch2(){

	kind = 'rece_';
	new daum.Postcode({
		oncomplete: function(data) {
			// �˾����� �˻���� �׸��� Ŭ�������� ������ �ڵ带 �ۼ��ϴ� �κ�.
			// �����ȣ�� �ּ� ������ �ش� �ʵ忡 �ְ�, Ŀ���� ���ּ� �ʵ�� �̵��Ѵ�.
			eval('document.frm.'+kind+'post').value = data.zonecode;
			eval('document.frm.'+kind+'address').value = data.address;

			//��ü �ּҿ��� ���� ���� �� ()�� ���� �ִ� �ΰ������� �����ϰ��� �� ���,
			//�Ʒ��� ���� ���Խ��� ����ص� �ȴ�. ���Խ��� �������� ������ �°� �����ؼ� ��� �����ϴ�.
			//var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
			//document.getElementById('addr').value = addr;

			if(eval('document.frm.'+kind+'address2') != null){
				eval('document.frm.'+kind+'address2').value = '';
				eval('document.frm.'+kind+'address2').focus();
			}
		}
	}).open();

}

// ������ ���׻��
function resesrveAll(o, frm){

	var reserve_use = 0;

	if(o.checked == true && frm.reserve_use != null){

		var total_price	= frm.total_price.value;
		var coupon_use	= frm.coupon_use.value;
		if(total_price) total_price	= parseInt(total_price);
		if(coupon_use)	coupon_use	= parseInt(coupon_use);
		total_price		= total_price - coupon_use;

		var mem_reserve	= <?=$mem_info->reserve?>;

		if(total_price < mem_reserve)	reserve_use	= total_price;
		else							reserve_use	= mem_reserve;

		alert("������ۺ� �߻��� ���� ����Ʈ�� �ִ� ��� ����Ʈ�� �����մϴ�.");
	}

	frm.reserve_use.value = reserve_use;
}

// ������ ���
function reserveUse(frm){

	if(frm.reserve_use != null){

		var reserve_use = frm.reserve_use.value;
		var total_price = frm.total_price.value;

		if(reserve_use != ""){

		   if(reserve_use != "" && !Check_Num(reserve_use)){

		      alert("�������� ���ڸ� �����մϴ�.");
		      frm.reserve_use.value = "";
		      frm.reserve_use.focus();
		      return false;

		   }else{

		      reserve_use = eval(reserve_use);
		      total_price = eval(total_price);
		   }

		   if(reserve_use > <?=$mem_info->reserve?>){

		      alert("��밡�ɾ� ���� �����ϴ�.");
		      frm.reserve_use.value = "";
		      frm.reserve_use.focus();
		      return false;

		   }else if(reserve_use > total_price){

			alert("�ֹ��ݾ� ���� �����ϴ�.");
			frm.reserve_use.value = "";
			frm.reserve_use.focus();
			return false;

		   <?/*}else if(reserve_use < <?=$oper_info->reserve_min?>){

		   	alert("�ּһ�� ������ ���� �۽��ϴ�. <?=number_format($oper_info->reserve_min)?>�� �̻� ��밡���մϴ�.");
		      frm.reserve_use.value = "";
		      return false;

		   }else if(reserve_use > <?=$oper_info->reserve_max?>){

		   	alert("�ִ��� ������ ���� Ů�ϴ�. <?=number_format($oper_info->reserve_max)?>�� ���� ��밡���մϴ�.");
		      frm.reserve_use.value = "";
		      return false;
			*/?>
		   }
		}
	}

	return true;
}

var couponWin;

// �������
function couponUse(){

	if(couponWin != null) couponWin.close();

	var url = "./coupon_list.php";
	couponWin = window.open(url, "couponUse", "height=450, width=930, menubar=no, scrollbars=yes, resizable=no, toolbar=no, status=no, left=50, top=50");
}

function cuponClose() {

	if(couponWin != null) couponWin.close();
}

// ���ݰ�꼭����
function pclick(){

	var frm = document.frm;
	for(ii=0;ii<frm.pay_method.length;ii++){
		if(frm.pay_method[ii].checked) pval = frm.pay_method[ii].value;
	}
	if(pval == "PC" || pval == "PH"){
		if(!frm.tax_type[0].checked){
			alert("�ſ�ī��,�޴��� ������ ���������� ���ݰ�꼭�� ��ü�մϴ�.");
			frm.tax_type[0].checked = true;
			tax01.style.display='none';
			tax02.style.display='none';
			return false;
		}
	}
	return true;

}

// ���ݰ�꼭����
function qclick(idnum) {

	if(!pclick()) return;

	tax01.style.display='none';
	tax02.style.display='none';

	if(idnum != ""){
		tax=eval("tax"+idnum+".style");
		tax.display='block';
	}
}

// ���ݿ��������� - �߱޻���
function qclick2(idnum) {

	var type1 = "<label><input type=\"radio\" name=\"cash_type2\" value=\"CARDNUM\" onclick=\"qclick3('01')\"> ���ݿ����� ī���ȣ</label>";
	var type2 = "<label><input type=\"radio\" name=\"cash_type2\" value=\"COMNUM\" onclick=\"qclick3('02')\"> ����� ��Ϲ�ȣ</label>";
	var type3 = "<label><input type=\"radio\" name=\"cash_type2\" value=\"HPHONE\" onclick=\"qclick3('03')\"> �޴���ȭ��ȣ</label>";
	var type4 = "<label><input type=\"radio\" name=\"cash_type2\" value=\"RESNO\" onclick=\"qclick3('04')\"> �ֹε�Ϲ�ȣ</label>";

	// ����� ����������
	if(idnum == "01") {
		document.getElementById("cash_info01").innerHTML = type1 + " " + type2;
	// ���μҵ� ������
	} else if(idnum == "02") {
		document.getElementById("cash_info01").innerHTML = type1 + " " + type3 + " " + type4;
	}

	document.getElementById("cash_info02").innerHTML = "";

}

// ���ݿ��������� - ��û����
function qclick3(idnum) {

	var cash_info01 = "<input type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"4\" class=\"input\"> - <input type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"4\" class=\"input\"> - <input type=\"password\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"4\" class=\"input\"> - <input type=\"password\" name=\"cash_info_arr[]\" size=\"7\" maxlength=\"7\" class=\"input\">";
	var cash_info02 = "<input type=\"text\" name=\"cash_info_arr[]\" size=\"3\" maxlength=\"3\" class=\"input\"> - <input type=\"text\" name=\"cash_info_arr[]\" size=\"2\" maxlength=\"2\" class=\"input\"> - <input type=\"text\" name=\"cash_info_arr[]\" size=\"7\" maxlength=\"7\" class=\"input\">";
	var cash_info03 = "<input type=\"text\" name=\"cash_info_arr[]\" size=\"3\" maxlength=\"3\" class=\"input\"> - <input type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"4\" class=\"input\"> - <input type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"4\" class=\"input\">";
	var cash_info04 = "<input type=\"text\" name=\"cash_info_arr[]\" size=\"6\" maxlength=\"6\" class=\"input\"> - <input type=\"password\" name=\"cash_info_arr[]\" size=\"7\" maxlength=\"7\" class=\"input\">";

	var cash_info = eval("cash_info"+idnum);
	document.getElementById("cash_info02").innerHTML = cash_info;

}

function popMyAddr(){
	var url = 'my_address.php';
	window.open(url, 'popMyAddr', "height=650, width=700, menubar=no, scrollbars=yes, resizable=yes, toolbar=no, status=no, left=200, top=100");
}

function addDeliver(){
	popupX = (window.screen.width / 2) - (1250 / 2);
	popupY = (window.screen.height / 2) - (900 / 2);
	window.open('/member/my_address_input.php', 'adddeliver', 'width=590, height=500,  left='+ popupX + ', top='+ popupY );
}
//-->
</script>
<? include $SKIN_DIR."/inc/footer.php"; 		// �ϴܵ����� ?>