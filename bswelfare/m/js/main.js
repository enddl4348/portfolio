$(document).ready(function(){
    //gnb script
    // gnb script 
	$('.gnb_btn, .fnb_btn').click(function(){
		var height = $(document).height(); // gnb_wrap height
		$('.gnb_wrap').css('height',height).show();
	});
	$('.gnb_close').click(function(){
		$('.gnb_wrap').hide();
	});

	var gnbBtn = $('.gnb').find('span');

	gnbBtn.click(function(){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
			$(this).next().hide();
		} else {
			$('.depth_menu').hide();
			$(this).parent('li').siblings().find('span').removeClass('on');
			$(this).addClass('on');
			$(this).next().css('display','flex');
		}
	});
    
    // scrollTop script 
	$('.fnb_btn').click(function(){
		$('html,body').animate({ scrollTop:0}, 0);
	});

	$('.gotop_btn').click(function(){
		$('html,body').animate({ scrollTop:0}, 300);
	});


	// footer bar scroll script
	var didScroll;
	var lastScrollPos = 0;
	var docHeight = $(document).height();

	$(window).scroll(function(event){ didScroll = true; });

	setInterval(function() { if (didScroll) { 
		hasScrolled(); didScroll = false; 
		} }, 300); 

	function hasScrolled() { 
		var st = $(this).scrollTop();
		
		if( st > lastScrollPos){
			// Scroll Down
			$('.footer_bar').removeClass('scroll_up').addClass('scroll_down');

			if( st == docHeight + 310 ) { // Scroll End 
				$('.footer_bar').addClass('scroll_up');
			} else {
				$('.footer_bar').removeClass('scroll_up');
			}

		} else {
			// Scroll Up
			$('.footer_bar').removeClass('scroll_down').addClass('scroll_up');
		}


		lastScrollPos = st;

	}
    
    //prdview tab 
    var prdBtn = $('.prd_tabBtn').find('li'),
        prdCont = $('.prd_tabCont').find('.cont');
    
    prdBtn.click(function(){
        prdCont.hide();
        
        var idx = $(this).index();
        prdCont.eq(idx).show();
        $(this).addClass('on').siblings().removeClass('on');
    });
    prdBtn.filter(':first-child').trigger('click');

    // prdview에서 장바구니 클릭시 탑버튼 안보이게
    var $vwCartBtn = $('.foot__cart');

    $vwCartBtn.click(function(){
      $('.prd-vw').css('z-index','98');
    });
});

function get_pushid() {
	return localStorage.getItem("pushid");
}

function save_pushid() {
	var pushid = get_pushid();
	$.ajax({
		url:"/m/push_ajax.php",
		data : {
			'mode'	: 'save_pushid',
			'pushid': pushid
		},
		type : 'POST',
		async: false
	});
}

function goSetPush(){
	document.location.href = '/m/sub/setpush.php';
}