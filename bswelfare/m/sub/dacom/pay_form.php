<?
	$oper_info->pay_test="Y";
	$oper_info->pay_id="smt_nbm2013";
	$oper_info->pay_key="5859a2b4d6f5b97b0023d913066995df";
	if(!strcmp($oper_info->pay_test, "Y")) {//�׽�Ʈ
		$oper_info->pay_id = "".$oper_info->pay_id;
		$platform	= "test";             //LG������ �������� ����(test:�׽�Ʈ, service:����)
		$mid = $oper_info->pay_id;
		$pay_key = $oper_info->pay_key;
	}else{//�ǰŷ�
		$platform	= "service";
		$mid = $oper_info->pay_id;
		$pay_key = $oper_info->pay_key;
	}

	/////////////////
	//������� ���//
	/////////////////
	switch($order_info->pay_method){
		case "PC"://�ſ�ī��
			$_paymethod = "SC0010";break;
		case "PN"://������ü
			$_paymethod = "SC0030";break;
		case "PV"://�������
			$_paymethod = "SC0040";break;
		case "PH";//�޴���
			$_paymethod = "SC0060";break;
	}

	/*
	 * [���� ������û ������(STEP2-1)]
	 *
	 * ���������������� �⺻ �Ķ���͸� ���õǾ� ������, ������ �ʿ��Ͻ� �Ķ���ʹ� �����޴����� �����Ͻþ� �߰� �Ͻñ� �ٶ��ϴ�.
	 */

	/*
	 * 1. �⺻���� ������û ���� ����
	 *
	 * �⺻������ �����Ͽ� �ֽñ� �ٶ��ϴ�.(�Ķ���� ���޽� POST�� ����ϼ���)
	 */
	$CST_PLATFORM               = $platform;      //LG���÷��� ���� ���� ����(test:�׽�Ʈ, service:����)
	$CST_MID                    = $mid;           //�������̵�(LG���÷������� ���� �߱޹����� �������̵� �Է��ϼ���)
	                                                                    				//�׽�Ʈ ���̵�� 't'�� �ݵ�� �����ϰ� �Է��ϼ���.
	$LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;  //�������̵�(�ڵ�����)
	$LGD_OID                    = $order_info->orderid;           //�ֹ���ȣ(�������� ����ũ�� �ֹ���ȣ�� �Է��ϼ���)
	$LGD_AMOUNT                 = $order_info->total_price;        //�����ݾ�("," �� ������ �����ݾ��� �Է��ϼ���)
	$LGD_BUYER                  = $order_info->send_name;         //�����ڸ�
	$LGD_PRODUCTINFO            = $payment_prdname;   //��ǰ��
	$LGD_BUYEREMAIL             = $order_info->send_email;    //������ �̸���
	$LGD_CUSTOM_FIRSTPAY        = $_paymethod;    //�������� �ʱ��������
	$LGD_CUSTOM_USABLEPAY				= $_paymethod;    //�������� �������ɼ���

	$LGD_TIMESTAMP              = date(YmdHms);                         //Ÿ�ӽ�����
	$LGD_CUSTOM_SKIN            = "blue";                               //�������� ����â ��Ų (red, blue, cyan, green, yellow)

	$configPath 								= $_SERVER['DOCUMENT_ROOT']."/".$mobile_path."/sub/dacom/lgdacom"; 						//LG���÷������� ������ ȯ������("/conf/lgdacom.conf") ��ġ ����.

	/*
	 * �������(������) ���� ������ �Ͻô� ��� �Ʒ� LGD_CASNOTEURL �� �����Ͽ� �ֽñ� �ٶ��ϴ�.
	 */
	$LGD_CASNOTEURL				= "http://".$_SERVER["HTTP_HOST"]."/".$mobile_path."/sub/dacom/order_update_vir.php";

	/*
	 * LGD_RETURNURL �� �����Ͽ� �ֽñ� �ٶ��ϴ�. �ݵ�� ���� �������� ������ ����Ʈ�� ��  ȣ��Ʈ�̾�� �մϴ�. �Ʒ� �κ��� �ݵ�� �����Ͻʽÿ�.
	 */
	$LGD_RETURNURL				= "http://".$_SERVER["HTTP_HOST"]."/".$mobile_path."/sub/dacom/order_update.php";

	/*
	 * ISP ī����� ������ �����ISP���(�������� ���������ʴ� �񵿱���)�� ���, LGD_KVPMISPNOTEURL/LGD_KVPMISPWAPURL/LGD_KVPMISPCANCELURL�� �����Ͽ� �ֽñ� �ٶ��ϴ�.
	 */
	$LGD_KVPMISPNOTEURL       	= "http://".$_SERVER["HTTP_HOST"]."/".$mobile_path."/sub/dacom/order_update.php";
	$LGD_KVPMISPWAPURL					= "http://".$_SERVER["HTTP_HOST"]."/".$mobile_path."/sub/order_ok.php";
	$LGD_KVPMISPCANCELURL     	= "http://".$_SERVER["HTTP_HOST"]."/".$mobile_path."/sub/order_ok.php?orderid=".$LGD_OID."&pay_method=".$order_info->pay_method."&rescode=1111&resmsg=".urlencode("����ڰ� ISP(����/BC) ī������� �ߴ��Ͽ����ϴ�.");

	/*
	 *************************************************
	 * 2. MD5 �ؽ���ȣȭ (�������� ������) - BEGIN
	 *
	 * MD5 �ؽ���ȣȭ�� �ŷ� �������� �������� ����Դϴ�.
	 *************************************************
	 *
	 * �ؽ� ��ȣȭ ����( LGD_MID + LGD_OID + LGD_AMOUNT + LGD_TIMESTAMP + LGD_MERTKEY )
	 * LGD_MID          : �������̵�
	 * LGD_OID          : �ֹ���ȣ
	 * LGD_AMOUNT       : �ݾ�
	 * LGD_TIMESTAMP    : Ÿ�ӽ�����
	 * LGD_MERTKEY      : ����MertKey (mertkey�� ���������� -> ������� -> ���������������� Ȯ���ϽǼ� �ֽ��ϴ�)
	 *
	 * MD5 �ؽ������� ��ȣȭ ������ ����
	 * LG���÷������� �߱��� ����Ű(MertKey)�� ȯ�漳�� ����(lgdacom/conf/mall.conf)�� �ݵ�� �Է��Ͽ� �ֽñ� �ٶ��ϴ�.
	 */
	require_once("./dacom/lgdacom/XPayClient.php");
	$xpay = &new XPayClient($configPath, $LGD_PLATFORM);
	$xpay->Init_TX($LGD_MID);
	$LGD_HASHDATA = md5($LGD_MID.$LGD_OID.$LGD_AMOUNT.$LGD_TIMESTAMP.$xpay->config[$LGD_MID]);
	$LGD_CUSTOM_PROCESSTYPE = "TWOTR";
	/*
	 *************************************************
	 * 2. MD5 �ؽ���ȣȭ (�������� ������) - END
	 *************************************************
	 */
?>
<!--script language="javascript" src="<?= $_SERVER['SERVER_PORT']!=443?"http":"https" ?>://xpay.lgdacom.net<?=($platform == "test")?":7080":""?>/xpay/js/xpay_crossplatform.js" type="text/javascript"></script-->
<script language="javascript" src="http://xpay.lgdacom.net/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>
<script language = 'javascript'>
<!--

/*
* iframe���� ����â�� ȣ���Ͻñ⸦ ���Ͻø� iframe���� ���� (������ ���� �Ұ�)
*/
	var LGD_window_type = "iframe";
/*
* �����Ұ�
*/
function launchCrossPlatform(){
      lgdwin = open_paymentwindow(document.getElementById('LGD_PAYINFO'), '<?= $CST_PLATFORM ?>', LGD_window_type);
}
/*
* FORM ��  ���� ����
*/
function getFormObject() {
        return document.getElementById("LGD_PAYINFO");
}
/*
* �Ϲݿ� ��������(�Լ����� ���� �Ұ�)
*/
function setLGDResult(){
	if( LGD_window_type == 'iframe' ){
		document.getElementById('LGD_PAYMENTWINDOW').style.display = "none";
		document.getElementById('LGD_RESPCODE').value = lgdwin.contentWindow.document.getElementById('LGD_RESPCODE').value;
		document.getElementById('LGD_RESPMSG').value = lgdwin.contentWindow.document.getElementById('LGD_RESPMSG').value;
		if(lgdwin.contentWindow.document.getElementById('LGD_PAYKEY') != null){
			document.getElementById('LGD_PAYKEY').value = lgdwin.contentWindow.document.getElementById('LGD_PAYKEY').value;
		}
	}  else {
		document.getElementById('LGD_RESPCODE').value = lgdwin.document.getElementById('LGD_RESPCODE').value;
		document.getElementById('LGD_RESPMSG').value = lgdwin.document.getElementById('LGD_RESPMSG').value;
		if(lgdwin.document.getElementById('LGD_PAYKEY') != null){
			document.getElementById('LGD_PAYKEY').value = lgdwin.document.getElementById('LGD_PAYKEY').value;
		}
	}

	if(document.getElementById('LGD_RESPCODE').value == '0000' ){
		getFormObject().target = "_self";
		getFormObject().action = "order_update.php";
		getFormObject().submit();
	} else {
		alert(document.getElementById('LGD_RESPMSG').value);
	}

}
/*
* ����Ʈ���� ��������(�Լ����� ���� �Ұ�)
*/

function doSmartXpay(){

        var LGD_RESPCODE        = dpop.getData('LGD_RESPCODE');       //����ڵ�
        var LGD_RESPMSG         = dpop.getData('LGD_RESPMSG');        //����޼���

        if( "0000" == LGD_RESPCODE ) { //��������
            var LGD_PAYKEY      = dpop.getData('LGD_PAYKEY');         //LG���÷��� ����KEY
            document.getElementById('LGD_PAYKEY').value = LGD_PAYKEY;
            getFormObject().submit();
        } else { //��������
            alert("������ �����Ͽ����ϴ�. " + LGD_RESPMSG);
        }

}

//-->
</script>

<!--  ���� �Ұ�(IFRAME ��Ľ� ���)   -->
<div id="LGD_PAYMENTWINDOW" style="position:absolute; display:none; width:100%; height:100%; z-index:100 ;background-color:#D3D3D3; font-size:small; ">
     <iframe id="LGD_PAYMENTWINDOW_IFRAME" name="LGD_PAYMENTWINDOW_IFRAME" height="100%" width="100%" scrolling="no" frameborder="0">
     </iframe>
</div>

<form method="post" id="LGD_PAYINFO" action="order_update.php">

<input type="hidden" name="CST_PLATFORM"                value="<?= $CST_PLATFORM ?>">                   <!-- �׽�Ʈ, ���� ���� -->
<input type="hidden" name="CST_MID"                     value="<?= $CST_MID ?>">                        <!-- �������̵� -->
<input type="hidden" name="LGD_MID"                     value="<?= $LGD_MID ?>">                        <!-- �������̵� -->
<input type="hidden" name="LGD_OID"                     value="<?= $LGD_OID ?>">                        <!-- �ֹ���ȣ -->
<input type="hidden" name="LGD_BUYER"                   value="<?= $LGD_BUYER ?>">           			<!-- ������ -->
<input type="hidden" name="LGD_PRODUCTINFO"             value="<?= $LGD_PRODUCTINFO ?>">     			<!-- ��ǰ���� -->
<input type="hidden" name="LGD_AMOUNT"                  value="<?= $LGD_AMOUNT ?>">                     <!-- �����ݾ� -->
<input type="hidden" name="LGD_BUYEREMAIL"              value="<?= $LGD_BUYEREMAIL ?>">                 <!-- ������ �̸��� -->
<input type="hidden" name="LGD_CUSTOM_SKIN"             value="<?= $LGD_CUSTOM_SKIN ?>">                <!-- ����â SKIN -->
<input type="hidden" name="LGD_CUSTOM_PROCESSTYPE"      value="<?= $LGD_CUSTOM_PROCESSTYPE ?>">         <!-- Ʈ����� ó����� -->
<input type="hidden" name="LGD_TIMESTAMP"               value="<?= $LGD_TIMESTAMP ?>">                  <!-- Ÿ�ӽ����� -->
<input type="hidden" name="LGD_HASHDATA"                value="<?= $LGD_HASHDATA ?>">                   <!-- MD5 �ؽ���ȣ�� -->
<input type="hidden" name="LGD_RETURNURL"   						value="<?= $LGD_RETURNURL ?>">      			<!-- �������������-->
<input type="hidden" name="LGD_VERSION"         				value="PHP_SmartXPay_1.0">				   	    <!-- �������� (�������� ������) -->
<input type="hidden" name="LGD_CUSTOM_FIRSTPAY"  				value="<?= $LGD_CUSTOM_FIRSTPAY ?>">								    <!-- ����Ʈ �������� -->
<input type="hidden" name="LGD_CUSTOM_USABLEPAY"  			value="<?= $LGD_CUSTOM_USABLEPAY ?>">								    <!-- �������� �������� -->

<!-- �������(������) ���������� �Ͻô� ���  �Ҵ�/�Ա� ����� �뺸�ޱ� ���� �ݵ�� LGD_CASNOTEURL ������ LG �ڷ��޿� �����ؾ� �մϴ� . -->
<input type="hidden" name="LGD_CASNOTEURL"          	value="<?= $LGD_CASNOTEURL ?>">			<!-- ������� NOTEURL -->

<!--
****************************************************
* �ȵ���̵��� �ſ�ī�� ISP(����/BC)�������� ���� (����)*
****************************************************

(����)LGD_CUSTOM_ROLLBACK �� ����  "Y"�� �ѱ� ���, LG U+ ���ڰ������� ���� ISP(����/��) ���������� �������� note_url���� ���Ž�  "OK" ������ �ȵǸ�  �ش� Ʈ�������  ������ �ѹ�(�ڵ����)ó���ǰ�,
LGD_CUSTOM_ROLLBACK �� �� �� "C"�� �ѱ� ���, �������� note_url���� "ROLLBACK" ������ �� ���� �ش� Ʈ�������  �ѹ�ó���Ǹ�  �׿��� ���� ���ϵǸ� ���� ���οϷ� ó���˴ϴ�.
����, LGD_CUSTOM_ROLLBACK �� ���� "N" �̰ų� null �� ���, �������� note_url����  "OK" ������  �ȵɽ�, "OK" ������ �� ������ 3�а������� 2�ð�����  ���ΰ���� �������մϴ�.
-->

<input type="hidden" name="LGD_CUSTOM_ROLLBACK"         value="">				   	   				   <!-- �񵿱� ISP���� Ʈ����� ó������ -->
<input type="hidden" name="LGD_KVPMISPNOTEURL"  		value="<?= $LGD_KVPMISPNOTEURL ?>">			   <!-- �񵿱� ISP(ex. �ȵ���̵�) ���ΰ���� �޴� URL -->
<input type="hidden" name="LGD_KVPMISPWAPURL"  			value="<?= $LGD_KVPMISPWAPURL ?>">			   <!-- �񵿱� ISP(ex. �ȵ���̵�) ���οϷ��� ����ڿ��� �������� ���οϷ� URL -->
<input type="hidden" name="LGD_KVPMISPCANCELURL"  		value="<?= $LGD_KVPMISPCANCELURL ?>">		   <!-- ISP �ۿ��� ��ҽ� ����ڿ��� �������� ��� URL -->

<!--
****************************************************
* �ȵ���̵��� �ſ�ī�� ISP(����/BC)�������� ����    (��) *
****************************************************
-->

<!-- input type="hidden" name="LGD_KVPMISPAUTOAPPYN"         value="Y"> -->
<!-- Y: ���������� ISP�ſ�ī�� ������, ���翡�� 'App To App' ������� ����, BCī��翡�� ���� ���� ������ �ް� ������ ���� �����ϰ��� �Ҷ� ���-->


<!-- ���� �Ұ� ( ���� �� �ڵ� ���� ) -->
<input type="hidden" name="LGD_RESPCODE" id="LGD_RESPCODE">
<input type="hidden" name="LGD_RESPMSG" id="LGD_RESPMSG">
<input type="hidden" name="LGD_PAYKEY"  id="LGD_PAYKEY">

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
  <button type="button" class="btn_grat_big" onClick="launchCrossPlatform()" >�����ϱ�</button>
	<!-- <input type="button" class="btn_grat_big" value="�����ϱ�" onClick="launchCrossPlatform()" /> -->
	
</div>

</form>