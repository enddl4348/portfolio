$(function(){

	// 구매자 대시보드 하단 탭
	var $latPrdBtn = $('.lat_prd-tab button');
	var $latPrdList = $('.latest-prd-wrap ul');

	$latPrdBtn.click(function(){
		$(this).addClass('on').siblings().removeClass('on');
		var idx = $(this).index();

		$latPrdList.eq(idx).show().siblings().hide();
	});

	$latPrdBtn.eq(0).trigger('click');


	//로그인 탭
	var $logTab = $('.log_type > button');
	var $logInputBx = $('.log_type-cont .log-cont-box');

	$logTab.click(function(){
		$(this).addClass('on').siblings().removeClass('on');

		var idx = $(this).index();

		$logInputBx.eq(idx).show().siblings().hide();
	});

	$logTab.eq(0).trigger('click');


  // 구매 전체메뉴 클릭 이벤트
  $('.prd-nav-wrap .all-menu-btn').click(function(){
    $(this).toggleClass('on');
    $(this).next('.almenu-dpt-wrap').toggleClass('on');
  });

	// 상품 뷰 레이어 팝업
	var $prdVBtn = $('.prd-list-type .detail');
	var $prdVPop = $('.prd-vw-wrap');
	var $prdviewClose = $prdVPop.find('.cls-pop');
	var $prdviewAll = $prdVPop.find('.view-all');

	$prdVBtn.click(function(){
    scrollOff(); //바디 스크롤 방지 함수
		$prdVPop.show();
		$prdVPop.removeClass('on');
		$('.bg').show();
	});

	$prdviewClose.click(function(){
    $prdVPop.hide();
		$('.bg').hide();
    scrollOn(); //바디 스크롤 해지 함수
	});

	$prdviewAll.click(function(){
		$prdVPop.toggleClass('on');
	});


	// 구매하기 레이어 팝업
	var $buyBtn = $('.purc_list-opt .buy-btn');
	var $buyPop = $('.buy-pop-wrap');
	var $buyClose = $buyPop.find('.cls-pop');
	var $buyAll = $buyPop.find('.view-all');

	
	$buyBtn.click(function(){
		$buyPop.show();
		$buyPop.removeClass('on');
		$('.bg').show();
	});
	

	$buyClose.click(function(){
    scrollOn(); //바디 스크롤 해지 함수
		$buyPop.hide();
		$('.bg').hide();
	});

	$buyAll.click(function(){
		$buyPop.toggleClass('on');
	});

	// 장바구니 레이어 팝업
	var $cartBtn = $('.cart-btn');
	var $headCartBtn = $('.header .cart_btn');
	var $cartPop = $('.cart-pop-wrap');
	var $cartClose = $cartPop.find('.cls-pop');
	var $cartAll = $cartPop.find('.view-all');

	$cartBtn.click(function(){
	scrollOff(); //바디 스크롤 방지 함수

		$cartPop.show();
		$cartPop.removeClass('on');
		$('.bg').show();
	});

	$cartClose.click(function(){
		$cartPop.hide(); 
		$('.bg').hide();
    scrollOn(); //바디 스크롤 해지 함수
	});

	$cartAll.click(function(){ //화면 전체보기 이벤트
		$cartPop.toggleClass('on');
	});

	$headCartBtn.click(function(){
    scrollOff(); //바디 스크롤 방지 함수

		$cartPop.show();
		$cartPop.removeClass('on');
		$('.bg').show();
	});


	//구매요청 페리지 상품 리스트 가로,세로 배열
	var $listTypeBtn = $('.align-btn > button');
	var $listType = $('.prd-list-type .prd-list-box');

	$listTypeBtn.click(function(){
		var idx = $(this).index();
		$(this).addClass('on').siblings().removeClass('on');

		$listType.eq(idx).show().siblings().hide();
	});

	$listTypeBtn.eq(0).trigger('click');


	// 상품 뷰 이미지 호버
	var $prdBigimg = $('.prd-view-top .big-img > img');
	var $prdTmbimg = $('.prd-view-top .thumb-img > span');

	$prdTmbimg.mouseenter(function(){
		var idx = $(this).index();
		$prdBigimg.eq(idx).show().siblings().hide();
	});


	// 왼쪽 메뉴 토글 & 스크립트
	var $lnbTit = $('.lnb__tit');
	var $lnbDepth = $('.lnb__menu');
	var $lnbDepthMenu = $('.lnb__menu > li');
	$lnbDepth.hide();

	$lnbTit.click(function(){
		$(this).next($lnbDepth).slideToggle();
    $(this).toggleClass('on');
	});

	// $lnbDepth.eq(0).show();

	if( $lnbDepthMenu.hasClass('active') ){  //클릭한 애가 active 클래스명을 갖고 있으면 
		var $actParnt = $('.lnb__menu > li.active').parent('ul');
		$actParnt.show();
	}

	
  // 레이어 팝업 클릭,off시 뒤에 바디 스크롤 관련 함수
  function scrollOff() { // body scroll fixed
    $('body').addClass('scrollOff').on('scroll touchmove mousewheel', function (e) {
      e.preventDefault();
    });
  }

  function scrollOn() {
    $('body').removeClass('scrollOff').off('scroll touchmove mousewheel');
  }

});