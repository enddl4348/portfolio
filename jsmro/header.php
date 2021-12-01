<?
$config_img = "_2";
$shop_img = "_2";
$page_img = "_2";
$product_img = "_2";
$order_img = "_2";
$member_img = "_2";
$marketing_img = "_2";
$bbs_img = "_2";
$sch_img = "_2";
$poll_img = "_2";
if(strpos($PHP_SELF,"/config/") !== false) $config_img = "";
else if(strpos($PHP_SELF,"/shop/") !== false) $shop_img = "";
else if(strpos($PHP_SELF,"/page/") !== false) $page_img = "";
else if(strpos($PHP_SELF,"/product/") !== false) $product_img = "";
else if(strpos($PHP_SELF,"/order/") !== false) $order_img = "";
else if(strpos($PHP_SELF,"/member/") !== false) $member_img = "";
else if(strpos($PHP_SELF,"/marketing/") !== false) $marketing_img = "";
else if(strpos($PHP_SELF,"/bbs/") !== false) $bbs_img = "";
else if(strpos($PHP_SELF,"/schedule/") !== false) $sch_img = "";
else if(strpos($PHP_SELF,"/poll/") !== false) $poll_img = "";

if($ssl && $_SERVER['HTTPS'] != 'on'){
	//header("Location: ".$ssl.$_SERVER['REQUEST_URI']);

    //$REQUEST_URI=$ssl.$_SERVER['REQUEST_URI'];
    //echo "<script>document.location.replace('$REQUEST_URI')</script>";
    //exit;
}

if(strpos($_SERVER['PHP_SELF'], "/main/")!==false){ $pageTxt='관리자 메인'; }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?if($SID=="admin") echo "MRO쇼핑몰 관리자"; else echo "분양몰관리자";?></title>
	<link rel="stylesheet" href="/admin/css/font.css">
	<link rel="stylesheet" href="/admin/css/reset.css">
	<link href="/admin/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="/admin/css/common.css">
	<link rel="stylesheet" href="/admin/css/style.css">
	<link rel="stylesheet" href="/admin/css/jquery-ui.css">
	<script language="JavaScript" src="/js/jquery-1.7.2.min.js"></script>
	<!--[if lt IE 9]>
	<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="/js/selectivizr-min.js"></script>
	<![endif]-->
	<!--[if gte IE 9]>
	<script type="text/javascript" src="/js/jquery-2.2.4.min.js"></script>
	<![endif]-->
	<!--[if !IE]> -->
	<script src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/jquery-2.2.4.min.js"></script>
	<!-- <![endif]-->
	<script src="/admin/js/jquery-ui.js"></script>
	<script language="JavaScript" src="/js/lib.js"></script>
	<script language="JavaScript" src="/js/calendar.js"></script>
	<script language="JavaScript" src="/js/imgix.min.js"></script>
	<script language="JavaScript" type="text/JavaScript">
	$(function(){
		initDatepicker();
	});

	function initDatepicker(){
		$(".datepicker").datepicker({
			dateFormat: 'yy-mm-dd',
			//yearSuffix: '년',
			showOn: "both", // 버튼과 텍스트 필드 모두 캘린더를 보여준다.
			buttonImage: "/admin/css/images/cal.gif", // 버튼 이미지
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
			changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
			showMonthAfterYear: true, // 년월 셀렉트 박스 위치 변경
			currentText: '오늘 날짜' , // 오늘 날짜로 이동하는 버튼 패널
			nextText: '다음 달', // next 아이콘의 툴팁.
			prevText: '이전 달' // prev 아이콘의 툴팁.
			//yearRange : "c-80:c+10"
			//altField: "#date", // 타겟 필드
			//minDate: '-0d', // 오늘 이전 날짜는 선택 못함
		});
	}

			$(document).ready(function(){
		if($.cookie("left_quick") == "close"){
			$('.AW-manage-wrap').addClass('left_close');
		} else {
			$('.AW-manage-wrap').removeClass('left_close');
		}
	});
	function leftBtn() {
	$('.AW-manage-wrap').toggleClass('left_close');
		if ($('.AW-manage-wrap').hasClass('left_close')) {
			$.cookie('left_quick', 'close', { expires: 1, path: '/', domain: 'wizmall.anywiz.co.kr', secure: false });
		} else {
			$.cookie('left_quick', 'open', { expires: 1, path: '/', domain: 'wizmall.anywiz.co.kr', secure: false });
		}
	}
	</script>
</head>
<body>
	<header class="header clearfix">
		<? if($SID == "admin"){ ?>
		<h1 class="logo"><a href="/admin/main/main.php">자생 <em>MRO</em> 시스템</a></h1>
		<? } ?>
		<ul class="hd__menu">
			<li><a href="">주문배송조회</a></li>
			<li><a href="">마이페이지</a></li>
			<li><a href="../admin_logout.php">로그아웃</a></li>
		</ul>
	</header>
	<div class="AW-manage-navi">
		<h1><a href="/admin/main/main.php">ADMIN<span>ISTRATOR</span></a></h1>
		<ul>
			<? if($wiz_admin[designer] == "Y"){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/config/")!==false){ echo "active"; $pageTxt='환경설정'; } ?>"><a href="../config/basic_config.php">환경설정</a></li>
			<? } ?>

			<? if(strpos($wiz_admin[permi], "01-00") !== false || !strcmp($wiz_admin[designer], "Y")){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/shop/")!==false){ echo "active"; $pageTxt='상점관리'; } ?>"><a href="../shop/shop_info.php">상점관리</a></li>
			<? } ?>

			<? if(strpos($wiz_admin[permi], "03-00") !== false || !strcmp($wiz_admin[designer], "Y")){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/page/")!==false){ echo "active"; $pageTxt='페이지 설정'; } ?>"><a href="../page/popup_list.php">페이지 설정</a></li>
			<? } ?>

			<? if(strpos($wiz_admin[permi], "04-00") !== false || !strcmp($wiz_admin[designer], "Y")){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/product/")!==false){ echo "active"; $pageTxt='상품관리'; } ?>"><a href="../product/prd_list.php">상품관리</a></li>
			<? } ?>

			<? if(strpos($wiz_admin[permi], "05-00") !== false || !strcmp($wiz_admin[designer], "Y")){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/order/")!==false){ echo "active"; $pageTxt='주문관리'; } ?>"><a href="../order/basket_list.php">주문관리</a></li>
			<? } ?>

			<? if(strpos($wiz_admin[permi], "06-00") !== false || !strcmp($wiz_admin[designer], "Y")){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/member/")!==false){ echo "active"; $pageTxt='회원관리'; } ?>"><a href="../member/member_list.php">회원관리</a></li>
			<? } ?>

			<? if(strpos($wiz_admin[permi], "07-00") !== false || !strcmp($wiz_admin[designer], "Y")){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/marketing/")!==false){ echo "active"; $pageTxt='마케팅분석'; } ?>"><a href="../marketing/connect_list.php">마케팅분석</a></li>
			<? } ?>

			<? if(strpos($wiz_admin[permi], "08-00") !== false || !strcmp($wiz_admin[designer], "Y")){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/bbs/")!==false){ echo "active"; $pageTxt='게시판관리'; } ?>"><a href="../bbs/bbs_pro_list.php">게시판관리</a></li>
			<? } ?>

			<!--
			<? if((strpos($wiz_admin[permi], "11-00") !== false || !strcmp($wiz_admin[designer], "Y")) && $SID == "admin"){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/mall/")!==false){ echo "active"; $pageTxt='가맹점 관리'; } ?>"><a href="../mall/mall_list.php">가맹점 관리</a></li>
			<? } ?>
			-->

			<? if((strpos($wiz_admin[permi], "12-00") !== false || !strcmp($wiz_admin[designer], "Y")) && $SID == "admin"){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/pmall/")!==false){ echo "active"; $pageTxt='공급처관리'; } ?>"><a href="../pmall/mall_list.php">공급처관리</a></li>
			<? } ?>

			<? if($SID != "admin"){ ?>
			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/account/")!==false){ echo "active"; $pageTxt='정산관리'; } ?>"><a href="../account/account_list.php">정산관리</a></li>
			<? } ?>

			<li class="<? if(strpos($_SERVER['PHP_SELF'], "/budget/")!==false){ echo "active"; $pageTxt='예산정책'; } ?>"><a href="../budget/fc_list.php">예산정책</a></li>
		</ul>
	</div><!-- .AW-manage-navi -->

	<div class="ad-manage-wrap">
		<div class="lnb-wrap">
			<!-- <//? include "./left_menu.php"; ?>		 -->
			<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/lnb.php'; ?>
		</div>
		<!-- .lnb-wrap -->

		<div class="content-wrap">