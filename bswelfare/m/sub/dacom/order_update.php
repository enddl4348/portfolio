<?php
include "../../../inc/common.inc"; 				// DB���ؼ�, ������ �ľ�
include "../../../inc/util.inc"; 					// ��ƿ ���̺귯��
include "../../../inc/oper_info.inc"; 		// � ����

if(!strcmp($oper_info->pay_test, "Y")) {//�׽�Ʈ
	$oper_info->pay_id = "t".$oper_info->pay_id;
	$platform	= "test";             //LG������ �������� ����(test:�׽�Ʈ, service:����)
	$mid = $oper_info->pay_id;
	$pay_key = $oper_info->pay_key;
}else{//�ǰŷ�
	$platform	= "service";
	$mid = $oper_info->pay_id;
	$pay_key = $oper_info->pay_key;
}

    /*
     * [����������û ������(STEP2-2)]
     *
     * LG���÷������� ���� �������� LGD_PAYKEY(����Key)�� ������ ���� ������û.(�Ķ���� ���޽� POST�� ����ϼ���)
     */

		$configPath	= $_SERVER['DOCUMENT_ROOT']."/".$mobile_path."/sub/dacom/lgdacom"; 						//LG���÷������� ������ ȯ������("/conf/lgdacom.conf") ��ġ ����.

    /*
     *************************************************
     * 1.�������� ��û - BEGIN
     *  (��, ���� �ݾ�üũ�� ���Ͻô� ��� �ݾ�üũ �κ� �ּ��� ���� �Ͻø� �˴ϴ�.)
     *************************************************
     */

		/*
    $CST_PLATFORM               = $HTTP_POST_VARS["CST_PLATFORM"];
    $CST_MID                    = $HTTP_POST_VARS["CST_MID"];
    $LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
    */
    $LGD_PAYKEY                 = $HTTP_POST_VARS["LGD_PAYKEY"];

    $CST_PLATFORM               = $platform;
    $LGD_MID										= $mid;
		/*
    echo "<pre>";
    print_r($HTTP_POST_VARS);
    echo "</pre>";

    echo $configPath."<br>";

		echo "CST_MID - ".$HTTP_POST_VARS["CST_MID"]."<Br>";
    echo "LGD_MID - ".$HTTP_POST_VARS["LGD_MID"]."<Br>";

		echo "CST_MID - ".$CST_MID."<Br>";
    echo "LGD_MID - ".$LGD_MID."<Br>";
		*/

    require_once("./lgdacom/XPayClient.php");
    $xpay = &new XPayClient($configPath, $CST_PLATFORM);
    $xpay->Init_TX($LGD_MID);

    //echo $LGD_MID."<Br>";

    $xpay->Set("LGD_TXNAME", "PaymentByKey");
    $xpay->Set("LGD_PAYKEY", $LGD_PAYKEY);

		$orderid = $LGD_OID;
    $sql = "select * from wiz_order where orderid = '".$orderid."'";
    $result = mysql_query($sql) or error(mysql_error());
    $order_info = mysql_fetch_object($result);

    //echo "orderid = ".$orderid." - ".$xpay->Response("LGD_OID",0)."<br>";

    $pay_method = $order_info->pay_method;

    //�ݾ��� üũ�Ͻñ� ���ϴ� ��� �Ʒ� �ּ��� Ǯ� �̿��Ͻʽÿ�.
		$DB_AMOUNT = $order_info->total_price; //�ݵ�� �������� �Ұ����� ��(DB�� ����)���� �ݾ��� �������ʽÿ�.
		$xpay->Set("LGD_AMOUNTCHECKYN", "Y");
		$xpay->Set("LGD_AMOUNT", $DB_AMOUNT);

		echo $xpay->Response_Code()."<br>";
		echo $xpay->Response_Msg()."<br>";

    /*
     *************************************************
     * 1.�������� ��û(�������� ������) - END
     *************************************************
     */

    /*
     * 2. �������� ��û ���ó��
     *
     * ���� ������û ��� ���� �Ķ���ʹ� �����޴����� �����Ͻñ� �ٶ��ϴ�.
     */
    if ($xpay->TX()) {
    	/*
        //1)������� ȭ��ó��(����,���� ��� ó���� �Ͻñ� �ٶ��ϴ�.)
        echo "������û�� �Ϸ�Ǿ����ϴ�.  <br>";
        echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
        echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";

        echo "�ŷ���ȣ : " . $xpay->Response("LGD_TID",0) . "<br>";
        echo "�������̵� : " . $xpay->Response("LGD_MID",0) . "<br>";
        echo "�����ֹ���ȣ : " . $xpay->Response("LGD_OID",0) . "<br>";
        echo "�����ݾ� : " . $xpay->Response("LGD_AMOUNT",0) . "<br>";
        echo "����ڵ� : " . $xpay->Response("LGD_RESPCODE",0) . "<br>";
        echo "����޼��� : " . $xpay->Response("LGD_RESPMSG",0) . "<p>";

        $keys = $xpay->Response_Names();
        foreach($keys as $name) {
            echo $name . " = " . $xpay->Response($name, 0) . "<br>";
        }

        echo "<p>";
			*/
				// �ֹ�����
				$sql = "SELECT * FROM wiz_order WHERE orderid = '$LGD_OID'";
				$result = mysql_query($sql) or error(mysql_error());
				$order_info = mysql_fetch_object($result);

        if( "0000" == $xpay->Response_Code() ) {
         	//����������û ��� ���� DBó��
          //echo "����������û ��� ���� DBó���Ͻñ� �ٶ��ϴ�.<br>";

					////////////////////////////////////////////////////////////////////////////
					/////////////////////// �ֹ����� ������Ʈ //////////////////////////////////
					////////////////////////////////////////////////////////////////////////////

					$_Payment[status] = "OY"; //��������
					$_Payment[orderid] = $LGD_OID; //�ֹ���ȣ
					$_Payment[paymethod] = $order_info->pay_method; //��������
					$_Payment[ttno] = $LGD_TID; //�ŷ���ȣ
					$_Payment[bankkind] = $LGD_FINANCECODE; //�����ڵ�(��������ϰ��)
					$_Payment[accountno] = $LGD_ACCOUNTNUM; //���¹�ȣ(��������ϰ��)
					$_Payment[pgname] = "dacom";//PG�� ����
					$_Payment[es_check]	= $oper_info->pay_escrow;//����ũ�� ��뿩��
					$_Payment[es_stats]	= "IN";//����ũ�� ����(���������� �⺻���� �߼�)
					$_Payment[tprice]		=	$LGD_AMOUNT; //�����ݾ�
					foreach($_Payment as $key => $value){
								$logs .="$key : $value\r";
							}
					//@make_log("dacom_log.txt","\r---------------------------order_update.php start----------------------------------\r".$logs."\r---------------------------order_update.php END----------------------------------\r");
					//����ó��(���º���,�ֹ� ������Ʈ)
					Exe_payment($_Payment);
					// ������ ó�� : ������ ���� ������ ����
					Exe_reserve();
					// ���ó��
					Exe_stock();
					// ��ٱ��� ����
					Exe_delbasket();
					$resultMSG ="OK";

          //����������û ��� ���� DBó�� ���н� Rollback ó��
        	$isDBOK = true; //DBó�� ���н� false�� ������ �ּ���.
        	if( !$isDBOK ) {
         		echo "<p>";
         		$xpay->Rollback("���� DBó�� ���з� ���Ͽ� Rollback ó�� [TID:" . $xpay->Response("LGD_TID",0) . ",MID:" . $xpay->Response("LGD_MID",0) . ",OID:" . $xpay->Response("LGD_OID",0) . "]");

              echo "TX Rollback Response_code = " . $xpay->Response_Code() . "<br>";
              echo "TX Rollback Response_msg = " . $xpay->Response_Msg() . "<p>";

              if( "0000" == $xpay->Response_Code() ) {
                	echo "�ڵ���Ұ� ���������� �Ϸ� �Ǿ����ϴ�.<br>";
              }else{
        			echo "�ڵ���Ұ� ���������� ó������ �ʾҽ��ϴ�.<br>";
              }
        	}
        }else{
          	//����������û ��� ���� DBó��
         	echo "����������û ��� ���� DBó���Ͻñ� �ٶ��ϴ�.<br>";
        }
    }else {
        //2)API ��û���� ȭ��ó��
        echo "������û�� �����Ͽ����ϴ�.  <br>";
        echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
        echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";

        //����������û ��� ���� DBó��
        echo "����������û ��� ���� DBó���Ͻñ� �ٶ��ϴ�.<br>";
    }
?>
<form name="frm" action="/<?=$mobile_path?>/sub/order_ok.php" method="post" target="_parent">
<input type="hidden" name="orderid" value="<?=$orderid?>">
<input type="hidden" name="rescode" value="<?=$xpay->Response_Code()?>">
<input type="hidden" name="resmsg" value="<?=$xpay->Response_Msg()?>">
<input type="hidden" name="pay_method" value="<?=$pay_method?>">
</form>
<script>document.frm.submit();</script>