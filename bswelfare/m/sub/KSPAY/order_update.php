<?
include "$_SERVER[DOCUMENT_ROOT]/inc/common.inc"; 				// DB���ؼ�, ������ �ľ�
include "$_SERVER[DOCUMENT_ROOT]/inc/util.inc"; 					// ��ƿ ���̺귯��
include "$_SERVER[DOCUMENT_ROOT]/inc/oper_info.inc"; 		// � ����
?>
<? include "./KSPayWebHost.inc"; ?>
<?


    $rcid       = $_POST["reCommConId"];
    $rctype     = $_POST["reCommType"];
    $rhash      = $_POST["reHash"];

	$ipg = new KSPayWebHost($rcid, null);

	$authyn		= "";
	$trno		= "";
	$trddt		= "";
	$trdtm		= "";
	$amt		= "";
	$authno		= "";
	$msg1		= "";
	$msg2		= "";
	$ordno		= "";
	$isscd		= "";
	$aqucd		= "";
	$temp_v		= "";
	$result		= "";
	$halbu		= "";
	$cbtrno		= "";
	$cbauthno		= "";
  
	$resultcd =  "";

	//��ü���� �߰��Ͻ� ���ڰ��� �޴� �κ��Դϴ�
	$temp_pay_method =  $_POST["temp_pay_method"]; 
	$b =  $_POST["b"]; 
	$c =  $_POST["c"]; 
	$d =  $_POST["d"];


	if ($ipg->kspay_send_msg("1"))
	{
		$authyn	 = $ipg->kspay_get_value("authyn"); //��������
		$trno	 = $ipg->kspay_get_value("trno"  ); //�ŷ���ȣ
		$trddt	 = $ipg->kspay_get_value("trddt" ); //�ŷ�����
		$trdtm	 = $ipg->kspay_get_value("trdtm" ); //�ŷ��ð�
		$amt	 = $ipg->kspay_get_value("amt"   ); //�ݾ�
		$authno	 = $ipg->kspay_get_value("authno"); //ī��� ���ι�ȣ
		$msg1	 = $ipg->kspay_get_value("msg1"  ); //�޽���1
		$msg2	 = $ipg->kspay_get_value("msg2"  ); //�޽���2
		$ordno	 = $ipg->kspay_get_value("ordno" ); //�ֹ���ȣ
		$isscd	 = $ipg->kspay_get_value("isscd" ); //�߱޻��ڵ�/������¹�ȣ/������ü��ȣ
		$aqucd	 = $ipg->kspay_get_value("aqucd" ); //���Ի��ڵ�
		$temp_v	 = ""; //��������
		$result	 = $ipg->kspay_get_value("result"); //���
		$halbu	 = $ipg->kspay_get_value("halbu"); //�Һ�
		$cbtrno	 = $ipg->kspay_get_value("cbtrno"); //��������� ��츸 ���������: ������ü�� ��츸 ����
		$cbauthno	 = $ipg->kspay_get_value("cbauthno"); //��������

		if (!empty($authyn) && 1 == strlen($authyn))
		{
			if ($authyn == "O")
			{
				$resultcd = "0000";
			}else
			{
				$resultcd = trim($authno);
			}

			//$ipg->kspay_send_msg("3"); // ����ó���� �Ϸ�Ǿ��� ��� ȣ���մϴ�.(�� ������ ������ �Ͻ������� kspay_send_msg("1")�� ȣ���Ͽ� �ŷ����� ��ȸ�� �����մϴ�.)
		}
	}

    if ( $authyn == "O" )
    {
        if( $resultcd == "0000" )
        {
						// �ֹ�����
						$sql = "SELECT * FROM wiz_order WHERE orderid = '$ordno'";
						$result = mysql_query($sql) or error(mysql_error());
						$order_info = mysql_fetch_object($result);

				    /* = -------------------------------------------------------------------------- = */
				    /* =   05-1. �ſ�ī�� ���� ��� ó��                                            = */
				    /* = -------------------------------------------------------------------------- = */
            if ( $temp_pay_method == "1000000000" )
            {

	     					////////////////////////////////////////////////////////////////////////////
	     				 	// �ֹ����� ������Ʈ
	     				 	////////////////////////////////////////////////////////////////////////////
	     				 	$_Payment[status] = "OY"; //��������
	     					$_Payment[orderid] = $ordno; //�ֹ���ȣ
	     					$_Payment[paymethod] = "PC"; //��������
	     					$_Payment[ttno] = $trno; //�ŷ���ȣ
	     					$_Payment[bankkind] = ""; //�����ڵ�(��������ϰ��)
	     					$_Payment[accountno] = ""; //���¹�ȣ(��������ϰ��)
	     					$_Payment[pgname] = "KSPAY";//PG�� ����
	     					$_Payment[tprice]		=	$amt; //�����ݾ�

	     					//����ó��(���º���,�ֹ� ������Ʈ)
	     					Exe_payment($_Payment);
	     					// ������ ó�� : ������ ���� ������ ����
	     					Exe_reserve();
	     					// ���ó��
	     					Exe_stock();
	     					// ��ٱ��� ����
	     			    Exe_delbasket();
            }

				    /* = -------------------------------------------------------------------------- = */
				    /* =   05-2. ������ü ���� ��� ó��                                            = */
				    /* = -------------------------------------------------------------------------- = */
            if ( $temp_pay_method == "0010000000" )
            {

		            $Payment[status] = "OY"; //��������
								$Payment[orderid] = $ordno; //�ֹ���ȣ
								$Payment[paymethod] = "PN"; //��������
								$Payment[ttno] = $trno; //���ι�ȣ
								$Payment[bankkind] = $authno; //�����ڵ�(�Ա��� �����)
								$Payment[accountno] = ""; //���¹�ȣ(��������ϰ��)
								$Payment[accountname] = ""; //������(��������ϰ��)
								$Payment[pgname] = "KSPAY";//PG�� ����
								$Payment[es_check]	= $oper_info->pay_escrow;//����ũ�� ��뿩��
								$Payment[es_stats]	= "IN";//����ũ�� ����(���������� �⺻���� �߼�)
								$Payment[tprice]		=	$amt; //�����ݾ�

								//����ó��(���º���,�ֹ� ������Ʈ)
								Exe_payment($Payment);
								// ������ ó�� : ������ ���� ������ ����
								Exe_reserve();
								// ���ó��
								Exe_stock();
								// ��ٱ��� ����
				    		Exe_delbasket();
            }

				    /* = -------------------------------------------------------------------------- = */
				    /* =   05-3. ������� ���� ��� ó��                                            = */
				    /* = -------------------------------------------------------------------------- = */
            if ( $temp_pay_method == "0100000000" )
            {

                $Payment[status] = "OR"; //��������
								$Payment[orderid] = $ordno; //�ֹ���ȣ
								$Payment[paymethod] = "PV"; //��������
								$Payment[ttno] = $trno; //���ι�ȣ
								$Payment[bankkind] = $authno; //�����ڵ�(��������ϰ��)
								$Payment[accountno] = $isscd; //���¹�ȣ(��������ϰ��)
								$Payment[accountname] = $account; //������(��������ϰ��)
								$Payment[pgname] = "KSPAY";//PG�� ����
								$Payment[es_check]	= $oper_info->pay_escrow;//����ũ�� ��뿩��
								$Payment[es_stats]	= "IN";//����ũ�� ����(���������� �⺻���� �߼�)
								$Payment[tprice]		=	$amt; //�����ݾ�
								//����ó��(���º���,�ֹ� ������Ʈ)
	     					Exe_payment($Payment);
	     					// ������ ó�� : ������ ���� ������ ����
	     					Exe_reserve();
	     					// ���ó��
	     					//Exe_stock();
	     					// ��ٱ��� ����
	   			    	Exe_delbasket();
            }
				    /* = -------------------------------------------------------------------------- = */
				    /* =   05-5. �޴��� ���� ��� ó��                                              = */
				    /* = -------------------------------------------------------------------------- = */
            if ( $temp_pay_method == "0000010000" )
            {

								$_Payment[status] = "OY"; //��������
								$_Payment[orderid] = $ordno; //�ֹ���ȣ
								$_Payment[paymethod] = "PH"; //��������
								$_Payment[ttno] = $trdtm; //���νð�
								$_Payment[bankkind] = ""; //�����ڵ�(��������ϰ��)
								$_Payment[accountno] = ""; //���¹�ȣ(��������ϰ��)
								$_Payment[accountname] = ""; //������(��������ϰ��)
								$_Payment[pgname] = "KSPAY";//PG�� ����
								$_Payment[tprice]		=	$amt; //�����ݾ�
								//����ó��(���º���,�ֹ� ������Ʈ)
	     					Exe_payment($_Payment);
	     					// ������ ó�� : ������ ���� ������ ����
	     					Exe_reserve();
	     					// ���ó��
	     					Exe_stock();
	     					// ��ٱ��� ����
	     			    Exe_delbasket();
            }



				    /* = -------------------------------------------------------------------------- = */
				    /* =   05-7. ���ݿ����� ��� ó��                                               = */
				    /* = -------------------------------------------------------------------------- = */


		}
	}
	/* = -------------------------------------------------------------------------- = */
  /* =   05. ���� ��� ó�� END                                                   = */
  /* ============================================================================== */





    /* ============================================================================== */
    /* =   08. �� ���� �� ��������� ȣ��                                           = */
    /* ============================================================================== */
?>
    <html>
    <head>
        <title>*** KSPAY ***</title>
        <script type="text/javascript">
            function goResult()
            {

                document.pay_info.submit();

            }

            // ���� �� ���ΰ�ħ ���� ���� ��ũ��Ʈ (�ߺ����� ����)
            function noRefresh()
            {
                /* CTRL + NŰ ����. */
                if ((event.keyCode == 78) && (event.ctrlKey == true))
                {
                    event.keyCode = 0;
                    return false;
                }
                /* F5 ��Ű ����. */
                if(event.keyCode == 116)
                {
                    event.keyCode = 0;
                    return false;
                }
            }
            document.onkeydown = noRefresh ;
        </script>
    </head>

    <body onload="goResult()">
    <form name="pay_info" method="post" action="/m/sub/order_ok.php">

    <input type="hidde" name="rescode"            value="<?=$resultcd?>">    <!-- ��� �ڵ� -->
    <input type="hidde" name="resmsg"           value="<?=$resultcd.':'.$msg1." ".$msg2?>">    <!-- ��� �޼��� -->
    <input type="hidde" name="orderid"         value="<?=$ordno?>">    <!-- �ֹ���ȣ -->
    <input type="hidde" name="tno"               value="<?=$trno            ?>">    <!-- KCP �ŷ���ȣ -->
    

    </form>
    </body>
    </html>