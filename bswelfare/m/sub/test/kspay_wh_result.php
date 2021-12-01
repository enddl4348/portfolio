<? include "./KSPayWebHost.inc"; ?>
<?
    $rcid       = $_POST["reCommConId"];
    $rctype     = $_POST["reCommType"];
    $rhash      = $_POST["reHash"];
	// rcid 없으면 결제를 끝까지 진행하지 않고 중간에 결제취소 
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

	$resultcd =  "";

	if ($ipg->kspay_send_msg("1"))
	{
		$authyn	 = $ipg->kspay_get_value("authyn");
		$trno	 = $ipg->kspay_get_value("trno"  );
		$trddt	 = $ipg->kspay_get_value("trddt" );
		$trdtm	 = $ipg->kspay_get_value("trdtm" );
		$amt	 = $ipg->kspay_get_value("amt"   );
		$authno	 = $ipg->kspay_get_value("authno");
		$msg1	 = $ipg->kspay_get_value("msg1"  );
		$msg2	 = $ipg->kspay_get_value("msg2"  );
		$ordno	 = $ipg->kspay_get_value("ordno" );
		$isscd	 = $ipg->kspay_get_value("isscd" );
		$aqucd	 = $ipg->kspay_get_value("aqucd" );
		//$temp_v	 = $ipg->getValue("temp_v");
		$result	 = $ipg->kspay_get_value("result");

		if (!empty($authyn) && 1 == strlen($authyn))
		{
			if ($authyn == "O")
			{
				$resultcd = "0000";
			}else
			{
				$resultcd = trim($authno);
			}

			//$ipg->send_msg("3");
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
<title>호스트방식(APP) 결제샘플</title>
	<style type="text/css">
	BODY{font-size:9pt; line-height:100%}
	TD{font-size:9pt; line-height:100%}
	A {color:blue;line-height:100%; background-color:#E0EFFE}
	INPUT{font-size:9pt;}
	SELECT{font-size:9pt;}
</style>
</head>
<body bgcolor=#ffffff onload="">
<CENTER><B><font size=4 color="blue">성공페이지 내역.</font></B></CENTER>
<br>
<TABLE  width=100% border="1" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td align="center" colspan=4>
			<br>
			이페이지는 <font color = "red">승인성공시</font>에 업체측으로 리턴되는 결과 값들을 나타내고 있읍니다. 
			<br>
			아래와 같은 리턴 항목들중에서 귀사에서 필요하신 부분만 받으셔서 사용하시면 됩니다.
			<br>
			<br>
		</td>
	</tr>
<TR>
	<TD><B>항목명</B></TD>
	<TD><B>변수명</B></TD>
	<TD><B>결과값</B></TD>
	<TD><B>비고</B></TD>
</TR>
<TR>
	<TD>승인구분</TD>
	<TD>authyn</TD>
	<TD><?if($authyn == "O") echo("승인"); else echo("거절");?></TD>
	<TD>승인요청에 대하여 승인이 허락되던지 <br>거절되던지 리턴값의 항목은 같읍니다.</TD>
</TR>
<TR>
	<TD>거래번호</TD>
	<TD>trno</TD>
	<TD><?echo($trno)?></TD>
	<TD>거래번호는 중요합니다. <br>결재정보중 유니크키로 사용하는값으로 사후 승인취소등의 처리시 꼭 필요합니다.</TD>
</TR>
<TR>
	<TD>거래일자</TD>
	<TD>trddt</TD>
	<TD><?echo($trddt)?></TD>
	<TD>&nbsp;</TD>
</TR>
<TR>
	<TD>거래시간</TD>
	<TD>trdtm</TD>
	<TD><?echo($trdtm)?></TD>
	<TD>&nbsp;</TD>
</TR>
<TR>
	<TD>카드사 승인번호/은행 코드번호</TD>
	<TD>authno</TD>
	<TD><?echo($authno)?></TD>
	<TD>승인번호는 카드사에서 발급하는 것으로 유니크하지 않을수도 있음에 주의하십시요.</TD>
</TR>
<TR>
	<TD>발급사코드/가상계좌번호/계좌이체번호</TD>
	<TD>isscd</TD>
	<TD><?echo($isscd)?></TD>
	<TD></TD>
</TR>
<TR>
	<TD>매입사코드</TD>
	<TD>aqucd</TD>
	<TD><?echo($aqucd)?></TD>
	<TD></TD>
</TR>
<TR>
	<TD>주문번호</TD>
	<TD>ordno</TD>
	<TD><?echo($ordno)?></TD>
	<TD>주문번호는 업체측에서 넘겨주신 값을 그대로 리턴해드립니다.</TD>
</TR>
<TR>
	<TD>금액</TD>
	<TD>amt</TD>
	<TD><?echo($amt)?></TD>
	<TD>&nbsp;</TD>
</TR>
<TR>
	<TD>메세지1</TD>
	<TD>msg1</TD>
	<TD><?echo($msg1)?></TD>
	<TD>메세지는 카드사에서 보내는 것을 그대로 리턴해 드리는것으로<br> KSNET에서 생성된 내용은 아닙니다.</TD>
</TR>
<TR>
	<TD>메세지2</TD>
	<TD>msg2</TD>
	<TD><?echo($msg2)?></TD>
	<TD>승인성공시 이부분엔 OK와 승인번호가 표시됩니다.</TD>
</TR>
<TR>
    <TD>결제수단</TD>
    <TD>result</TD>
    <TD><?echo($result)?></TD>
    <TD>결제수단이 표시됩니다.</TD>
</TR>
	<tr>
		<td align="center" colspan=4>
			<br>
			<br>
			<br>
		</td>
	</tr>
</TABLE>
</body>
</html>