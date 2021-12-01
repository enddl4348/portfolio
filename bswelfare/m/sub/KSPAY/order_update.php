<?
include "$_SERVER[DOCUMENT_ROOT]/inc/common.inc"; 				// DB컨넥션, 접속자 파악
include "$_SERVER[DOCUMENT_ROOT]/inc/util.inc"; 					// 유틸 라이브러리
include "$_SERVER[DOCUMENT_ROOT]/inc/oper_info.inc"; 		// 운영 정보
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

	//업체에서 추가하신 인자값을 받는 부분입니다
	$temp_pay_method =  $_POST["temp_pay_method"]; 
	$b =  $_POST["b"]; 
	$c =  $_POST["c"]; 
	$d =  $_POST["d"];


	if ($ipg->kspay_send_msg("1"))
	{
		$authyn	 = $ipg->kspay_get_value("authyn"); //성공여부
		$trno	 = $ipg->kspay_get_value("trno"  ); //거래번호
		$trddt	 = $ipg->kspay_get_value("trddt" ); //거래일자
		$trdtm	 = $ipg->kspay_get_value("trdtm" ); //거래시간
		$amt	 = $ipg->kspay_get_value("amt"   ); //금액
		$authno	 = $ipg->kspay_get_value("authno"); //카드사 승인번호
		$msg1	 = $ipg->kspay_get_value("msg1"  ); //메시지1
		$msg2	 = $ipg->kspay_get_value("msg2"  ); //메시지2
		$ordno	 = $ipg->kspay_get_value("ordno" ); //주문번호
		$isscd	 = $ipg->kspay_get_value("isscd" ); //발급사코드/가상계좌번호/계좌이체번호
		$aqucd	 = $ipg->kspay_get_value("aqucd" ); //매입사코드
		$temp_v	 = ""; //성공여부
		$result	 = $ipg->kspay_get_value("result"); //결과
		$halbu	 = $ipg->kspay_get_value("halbu"); //할부
		$cbtrno	 = $ipg->kspay_get_value("cbtrno"); //정상승인의 경우만 영수증출력: 계좌이체의 경우만 제공
		$cbauthno	 = $ipg->kspay_get_value("cbauthno"); //성공여부

		if (!empty($authyn) && 1 == strlen($authyn))
		{
			if ($authyn == "O")
			{
				$resultcd = "0000";
			}else
			{
				$resultcd = trim($authno);
			}

			//$ipg->kspay_send_msg("3"); // 정상처리가 완료되었을 경우 호출합니다.(이 과정이 없으면 일시적으로 kspay_send_msg("1")을 호출하여 거래내역 조회가 가능합니다.)
		}
	}

    if ( $authyn == "O" )
    {
        if( $resultcd == "0000" )
        {
						// 주문정보
						$sql = "SELECT * FROM wiz_order WHERE orderid = '$ordno'";
						$result = mysql_query($sql) or error(mysql_error());
						$order_info = mysql_fetch_object($result);

				    /* = -------------------------------------------------------------------------- = */
				    /* =   05-1. 신용카드 승인 결과 처리                                            = */
				    /* = -------------------------------------------------------------------------- = */
            if ( $temp_pay_method == "1000000000" )
            {

	     					////////////////////////////////////////////////////////////////////////////
	     				 	// 주문정보 업데이트
	     				 	////////////////////////////////////////////////////////////////////////////
	     				 	$_Payment[status] = "OY"; //결제상태
	     					$_Payment[orderid] = $ordno; //주문번호
	     					$_Payment[paymethod] = "PC"; //결제종류
	     					$_Payment[ttno] = $trno; //거래번호
	     					$_Payment[bankkind] = ""; //은행코드(가상계좌일경우)
	     					$_Payment[accountno] = ""; //계좌번호(가상계좌일경우)
	     					$_Payment[pgname] = "KSPAY";//PG사 종류
	     					$_Payment[tprice]		=	$amt; //결제금액

	     					//결제처리(상태변경,주문 업데이트)
	     					Exe_payment($_Payment);
	     					// 적립금 처리 : 적립금 사용시 적립금 감소
	     					Exe_reserve();
	     					// 재고처리
	     					Exe_stock();
	     					// 장바구니 삭제
	     			    Exe_delbasket();
            }

				    /* = -------------------------------------------------------------------------- = */
				    /* =   05-2. 계좌이체 승인 결과 처리                                            = */
				    /* = -------------------------------------------------------------------------- = */
            if ( $temp_pay_method == "0010000000" )
            {

		            $Payment[status] = "OY"; //결제상태
								$Payment[orderid] = $ordno; //주문번호
								$Payment[paymethod] = "PN"; //결제종류
								$Payment[ttno] = $trno; //승인번호
								$Payment[bankkind] = $authno; //은행코드(입금한 은행명)
								$Payment[accountno] = ""; //계좌번호(가상계좌일경우)
								$Payment[accountname] = ""; //예금주(가상계좌일경우)
								$Payment[pgname] = "KSPAY";//PG사 종류
								$Payment[es_check]	= $oper_info->pay_escrow;//에스크로 사용여부
								$Payment[es_stats]	= "IN";//에스크로 상태(데이콤으로 기본정보 발송)
								$Payment[tprice]		=	$amt; //결제금액

								//결제처리(상태변경,주문 업데이트)
								Exe_payment($Payment);
								// 적립금 처리 : 적립금 사용시 적립금 감소
								Exe_reserve();
								// 재고처리
								Exe_stock();
								// 장바구니 삭제
				    		Exe_delbasket();
            }

				    /* = -------------------------------------------------------------------------- = */
				    /* =   05-3. 가상계좌 승인 결과 처리                                            = */
				    /* = -------------------------------------------------------------------------- = */
            if ( $temp_pay_method == "0100000000" )
            {

                $Payment[status] = "OR"; //결제상태
								$Payment[orderid] = $ordno; //주문번호
								$Payment[paymethod] = "PV"; //결제종류
								$Payment[ttno] = $trno; //승인번호
								$Payment[bankkind] = $authno; //은행코드(가상계좌일경우)
								$Payment[accountno] = $isscd; //계좌번호(가상계좌일경우)
								$Payment[accountname] = $account; //예금주(가상계좌일경우)
								$Payment[pgname] = "KSPAY";//PG사 종류
								$Payment[es_check]	= $oper_info->pay_escrow;//에스크로 사용여부
								$Payment[es_stats]	= "IN";//에스크로 상태(데이콤으로 기본정보 발송)
								$Payment[tprice]		=	$amt; //결제금액
								//결제처리(상태변경,주문 업데이트)
	     					Exe_payment($Payment);
	     					// 적립금 처리 : 적립금 사용시 적립금 감소
	     					Exe_reserve();
	     					// 재고처리
	     					//Exe_stock();
	     					// 장바구니 삭제
	   			    	Exe_delbasket();
            }
				    /* = -------------------------------------------------------------------------- = */
				    /* =   05-5. 휴대폰 승인 결과 처리                                              = */
				    /* = -------------------------------------------------------------------------- = */
            if ( $temp_pay_method == "0000010000" )
            {

								$_Payment[status] = "OY"; //결제상태
								$_Payment[orderid] = $ordno; //주문번호
								$_Payment[paymethod] = "PH"; //결제종류
								$_Payment[ttno] = $trdtm; //승인시간
								$_Payment[bankkind] = ""; //은행코드(가상계좌일경우)
								$_Payment[accountno] = ""; //계좌번호(가상계좌일경우)
								$_Payment[accountname] = ""; //예금주(가상계좌일경우)
								$_Payment[pgname] = "KSPAY";//PG사 종류
								$_Payment[tprice]		=	$amt; //결제금액
								//결제처리(상태변경,주문 업데이트)
	     					Exe_payment($_Payment);
	     					// 적립금 처리 : 적립금 사용시 적립금 감소
	     					Exe_reserve();
	     					// 재고처리
	     					Exe_stock();
	     					// 장바구니 삭제
	     			    Exe_delbasket();
            }



				    /* = -------------------------------------------------------------------------- = */
				    /* =   05-7. 현금영수증 결과 처리                                               = */
				    /* = -------------------------------------------------------------------------- = */


		}
	}
	/* = -------------------------------------------------------------------------- = */
  /* =   05. 승인 결과 처리 END                                                   = */
  /* ============================================================================== */





    /* ============================================================================== */
    /* =   08. 폼 구성 및 결과페이지 호출                                           = */
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

            // 결제 중 새로고침 방지 샘플 스크립트 (중복결제 방지)
            function noRefresh()
            {
                /* CTRL + N키 막음. */
                if ((event.keyCode == 78) && (event.ctrlKey == true))
                {
                    event.keyCode = 0;
                    return false;
                }
                /* F5 번키 막음. */
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

    <input type="hidde" name="rescode"            value="<?=$resultcd?>">    <!-- 결과 코드 -->
    <input type="hidde" name="resmsg"           value="<?=$resultcd.':'.$msg1." ".$msg2?>">    <!-- 결과 메세지 -->
    <input type="hidde" name="orderid"         value="<?=$ordno?>">    <!-- 주문번호 -->
    <input type="hidde" name="tno"               value="<?=$trno            ?>">    <!-- KCP 거래번호 -->
    

    </form>
    </body>
    </html>