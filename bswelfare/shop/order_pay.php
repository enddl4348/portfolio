<?
include $_SERVER["DOCUMENT_ROOT"]."/inc/common.inc"; 			// DB컨넥션, 접속자 파악
include $_SERVER["DOCUMENT_ROOT"]."/inc/oper_info.inc"; 	// 운영 정보
include $_SERVER["DOCUMENT_ROOT"]."/inc/mem_info.inc"; 		// 회원 정보
include $_SERVER["DOCUMENT_ROOT"]."/inc/util.inc"; 		   	// 유틸 라이브러리

ob_start();

$now_position = "<a href=/>Home</a> &gt; 주문하기 &gt; 결제하기";
$page_type = "orderform";
include $_SERVER["DOCUMENT_ROOT"]."/inc/page_info.inc"; 	// 페이지 정보
include $SKIN_DIR."/inc/header.php"; 			// 상단디자인

?>
<body onUnload="cuponClose();">
<div class=" container clearfix">

	<div class="content-body">

		<div class="bbs_wrap">

		<? $step3="on"; include "./basket_step.php"; ?>

		<div class="join_ttl">고객님께서 주문하신 상품입니다.</div>

		<? include "basket_order.inc"; ?>

		<? include Inc_payment($pay_method,$oper_info->pay_agent); ?>

		</div><!-- .bbs_wrap -->

	</div><!-- .content-body -->
</div><!-- .Sub-Container -->
<? include $SKIN_DIR."/inc/footer.php"; 		// 하단디자인 ?>
<?
// 이노페이에서 한글 인코딩 문제가 있어 전체 HTML을 utf-8 변환하여 출력함
$html = ob_get_contents();
ob_end_clean();

if($pay_method != 'PB'){
	$html = str_replace('<meta charset="euc-kr">', '<meta charset="utf-8">', $html);
	$html = iconv('euc-kr', 'utf-8', $html);
}
echo $html;
?>