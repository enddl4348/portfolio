<?
include $_SERVER["DOCUMENT_ROOT"]."/inc/common.inc"; 			// DB���ؼ�, ������ �ľ�
include $_SERVER["DOCUMENT_ROOT"]."/inc/oper_info.inc"; 	// � ����
include $_SERVER["DOCUMENT_ROOT"]."/inc/mem_info.inc"; 		// ȸ�� ����
include $_SERVER["DOCUMENT_ROOT"]."/inc/util.inc"; 		   	// ��ƿ ���̺귯��

ob_start();

$now_position = "<a href=/>Home</a> &gt; �ֹ��ϱ� &gt; �����ϱ�";
$page_type = "orderform";
include $_SERVER["DOCUMENT_ROOT"]."/inc/page_info.inc"; 	// ������ ����
include $SKIN_DIR."/inc/header.php"; 			// ��ܵ�����

?>
<body onUnload="cuponClose();">
<div class=" container clearfix">

	<div class="content-body">

		<div class="bbs_wrap">

		<? $step3="on"; include "./basket_step.php"; ?>

		<div class="join_ttl">���Բ��� �ֹ��Ͻ� ��ǰ�Դϴ�.</div>

		<? include "basket_order.inc"; ?>

		<? include Inc_payment($pay_method,$oper_info->pay_agent); ?>

		</div><!-- .bbs_wrap -->

	</div><!-- .content-body -->
</div><!-- .Sub-Container -->
<? include $SKIN_DIR."/inc/footer.php"; 		// �ϴܵ����� ?>
<?
// �̳����̿��� �ѱ� ���ڵ� ������ �־� ��ü HTML�� utf-8 ��ȯ�Ͽ� �����
$html = ob_get_contents();
ob_end_clean();

if($pay_method != 'PB'){
	$html = str_replace('<meta charset="euc-kr">', '<meta charset="utf-8">', $html);
	$html = iconv('euc-kr', 'utf-8', $html);
}
echo $html;
?>