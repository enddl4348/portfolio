<? include "./KSPayWebHost.inc"; ?>
<?
    $rcid       = $_POST["reCommConId"];
    $rctype     = $_POST["reCommType"];
    $rhash      = $_POST["reHash"];
	// rcid ������ ������ ������ �������� �ʰ� �߰��� ������� 
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
<title>ȣ��Ʈ���(APP) ��������</title>
	<style type="text/css">
	BODY{font-size:9pt; line-height:100%}
	TD{font-size:9pt; line-height:100%}
	A {color:blue;line-height:100%; background-color:#E0EFFE}
	INPUT{font-size:9pt;}
	SELECT{font-size:9pt;}
</style>
</head>
<body bgcolor=#ffffff onload="">
<CENTER><B><font size=4 color="blue">���������� ����.</font></B></CENTER>
<br>
<TABLE  width=100% border="1" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td align="center" colspan=4>
			<br>
			���������� <font color = "red">���μ�����</font>�� ��ü������ ���ϵǴ� ��� ������ ��Ÿ���� �����ϴ�. 
			<br>
			�Ʒ��� ���� ���� �׸���߿��� �ͻ翡�� �ʿ��Ͻ� �κи� �����ż� ����Ͻø� �˴ϴ�.
			<br>
			<br>
		</td>
	</tr>
<TR>
	<TD><B>�׸��</B></TD>
	<TD><B>������</B></TD>
	<TD><B>�����</B></TD>
	<TD><B>���</B></TD>
</TR>
<TR>
	<TD>���α���</TD>
	<TD>authyn</TD>
	<TD><?if($authyn == "O") echo("����"); else echo("����");?></TD>
	<TD>���ο�û�� ���Ͽ� ������ ����Ǵ��� <br>�����Ǵ��� ���ϰ��� �׸��� �����ϴ�.</TD>
</TR>
<TR>
	<TD>�ŷ���ȣ</TD>
	<TD>trno</TD>
	<TD><?echo($trno)?></TD>
	<TD>�ŷ���ȣ�� �߿��մϴ�. <br>���������� ����ũŰ�� ����ϴ°����� ���� ������ҵ��� ó���� �� �ʿ��մϴ�.</TD>
</TR>
<TR>
	<TD>�ŷ�����</TD>
	<TD>trddt</TD>
	<TD><?echo($trddt)?></TD>
	<TD>&nbsp;</TD>
</TR>
<TR>
	<TD>�ŷ��ð�</TD>
	<TD>trdtm</TD>
	<TD><?echo($trdtm)?></TD>
	<TD>&nbsp;</TD>
</TR>
<TR>
	<TD>ī��� ���ι�ȣ/���� �ڵ��ȣ</TD>
	<TD>authno</TD>
	<TD><?echo($authno)?></TD>
	<TD>���ι�ȣ�� ī��翡�� �߱��ϴ� ������ ����ũ���� �������� ������ �����Ͻʽÿ�.</TD>
</TR>
<TR>
	<TD>�߱޻��ڵ�/������¹�ȣ/������ü��ȣ</TD>
	<TD>isscd</TD>
	<TD><?echo($isscd)?></TD>
	<TD></TD>
</TR>
<TR>
	<TD>���Ի��ڵ�</TD>
	<TD>aqucd</TD>
	<TD><?echo($aqucd)?></TD>
	<TD></TD>
</TR>
<TR>
	<TD>�ֹ���ȣ</TD>
	<TD>ordno</TD>
	<TD><?echo($ordno)?></TD>
	<TD>�ֹ���ȣ�� ��ü������ �Ѱ��ֽ� ���� �״�� �����ص帳�ϴ�.</TD>
</TR>
<TR>
	<TD>�ݾ�</TD>
	<TD>amt</TD>
	<TD><?echo($amt)?></TD>
	<TD>&nbsp;</TD>
</TR>
<TR>
	<TD>�޼���1</TD>
	<TD>msg1</TD>
	<TD><?echo($msg1)?></TD>
	<TD>�޼����� ī��翡�� ������ ���� �״�� ������ �帮�°�����<br> KSNET���� ������ ������ �ƴմϴ�.</TD>
</TR>
<TR>
	<TD>�޼���2</TD>
	<TD>msg2</TD>
	<TD><?echo($msg2)?></TD>
	<TD>���μ����� �̺κп� OK�� ���ι�ȣ�� ǥ�õ˴ϴ�.</TD>
</TR>
<TR>
    <TD>��������</TD>
    <TD>result</TD>
    <TD><?echo($result)?></TD>
    <TD>���������� ǥ�õ˴ϴ�.</TD>
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