<?php

	include $_SERVER['DOCUMENT_ROOT']."/inc/util.php";

	$configPath = $_SERVER['DOCUMENT_ROOT']."/".$mobile_path."/sub/dacom/lgdacom"; //LG�ڷ��޿��� ������ ȯ������("/conf/lgdacom.conf") ��ġ ����.

    /*
     * [LG�ڷ��� ȯ������ UPDATE]
     *
     * �� �������� LG�ڷ��� ȯ�������� UPDATE �մϴ�.(�������� ������.)
     */
    $CST_PLATFORM   = $_POST["CST_PLATFORM"];
    $CST_MID        = $_POST["CST_MID"];
    $LGD_MID        = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;

    if( $CST_PLATFORM == null || $CST_PLATFORM == "" ) {
        echo "[TX_PING error] �Ķ���� ����<br>";
        return;
    }
    if( $LGD_MID == null || $LGD_MID == "" ) {
        echo "[TX_PING error] �Ķ���� ����<br>";
        return;
    }

    require_once("./XPayClient.php");
    $xpay = &new XPayClient($configPath, $CST_PLATFORM);
    $xpay->Init_TX($LGD_MID);

    echo "patch result = ".$xpay->Patch("lgdacom.conf");
?>
