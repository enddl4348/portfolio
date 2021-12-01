$(function(){
//약 리스트 popup
  var $drugpopBg = $('.dpop-bg');
  var $drugPop = $('.drug_pop');
  var $drugBtn = $('.btn--modify');
  var $drugcancel = $('.drug_pop .cancel');

  $drugBtn.click(function(){
    $drugpopBg.show();
    $drugPop.show();
  });

  $drugcancel.click(function(){
    $drugpopBg.hide();
    $drugPop.hide();
  });

  //정보수정 popup
  var $popBg = $('.pop-bg');
  var $infoPop = $('.info-pop');
  var $infoBtn = $('.info-edit');
  var $cancel = $('.btn-wrap .cancel');


  $infoBtn.click(function(){
    $popBg.show();
    $infoPop.show();
  });
  
  $cancel.click(function(){
    $popBg.hide();
    $infoPop.hide();
  });

  //개인정보 popup
  var $q_popBg = $('.q-pop-bg');
  var $q_Pop = $('.q-pop-cont');
  var $q_Btn = $('.info-chk-wrap .detail');
  var $q_cancel = $('.q-pop-cont .pop-del');


  $q_Btn.click(function(){
    $q_popBg.show();
    $q_Pop.show();
  });
  
  $q_cancel.click(function(){
    $q_popBg.hide();
    $q_Pop.hide();
  });

  //결과 내보내기 popup
  var $ex_popBg = $('.ex-pop-bg');
  var $ex_Pop = $('.export-pop');
  var $exBtn = $('.header__log .export');
  var $exCancel = $('.export-pop .cancel');

  $exBtn.click(function(){
    $ex_popBg.show();
    $ex_Pop.show();
  });
  
  
  // 문자보내기 팝업 닫기 누를때
  $exCancel.click(function(){
    $ex_popBg.hide();
    $ex_Pop.hide();
    $rslt_Pop.hide();
  });

 //결과 내보내기 공유 새로 추가 210930
 var $rslt_popBg = $('.ex-pop-bg');
 var $rslt_Pop = $('.chk-export-box');
 var $qrimg_Pop = $('.qr-code-box');
 var $rsltCancel = $('.chk-export-box .cancel');

 var $qrCancel = $('.qr-code-box .cancel');

  $rsltCancel.click(function(){
    $rslt_popBg.hide();
    $rslt_Pop.hide();
  });

  // qr 팝업 닫기 누를때 클릭이벤트
  $qrCancel.click(function(){
    $rslt_popBg.hide();
    $rslt_Pop.hide();
    $qrimg_Pop.hide();
    
  });

  
  





  //검색창 단어 on class
  var $wordBtn = $('.search__ord-option > button');
  $wordBtn.click(function(){
    $(this).addClass('on').siblings().removeClass('on');
    console.log(this);
  });
  //검색창 호버
  var $srchHover = $('.member-list');
  var ww = $(window).width();

  $srchHover.mouseover(function(){
    $(this).css('border-color','transparent');
    $(this).prev().css('border-color','transparent');
  }).mouseleave(function(){
    $(this).css('border-color','#dcdcdc');
    $(this).prev().css('border-color',' #dcdcdc');
  });

  if(ww < 1025 ) {
    $srchHover.mouseover(function(){
      $(this).css('border-color',' #dcdcdc');
      $(this).prev().css('border-color',' #dcdcdc');
    }).mouseleave(function(){
      $(this).css('border-color','#dcdcdc');
      $(this).prev().css('border-color',' #dcdcdc');
    }); 
  }
  
  // 종합-리스트 버튼 클릭했을 때 이벤트 
  var $allGraphbtn = $('.synthesis .graph-btn');
  var $allListbtn = $('.synthesis .list-btn');

  $allListbtn.click(function(){
    $(this).addClass('on').siblings().removeClass('on');
    $('.result__list').show().siblings('.result__graph').hide();
       
    $('html, body').animate({ scrollTop : 0}, 400);
    return false;
  });
  
  // 종합-그래프 버튼 클릭했을 때 이벤트 
  $allGraphbtn.click(function(){
    $(this).addClass('on').siblings().removeClass('on');
    $('.result__graph').show().siblings('.result__list').hide();
  });



  // 관심분야 3가지 -리스트 버튼 클릭했을 때 이벤트 
  var $sGraphbtn = $('.disease-sort .graph-btn');
  var $sListbtn = $('.disease-sort .list-btn');
  var $sGraphcont = $('.disease-sort .result__graph');
  var $sListcont = $('.disease-sort .result__list');
  
  $sListbtn.click(function(){
    $(this).addClass('on').siblings('.graph-btn').removeClass('on');
    $sListcont.show().siblings('.disease-sort .result__graph').hide();

    $('html, body').animate({ scrollTop : 0 }, 400);
    return false;

  });
  // 관심분야 3가지 -그래프 버튼 클릭했을 때 이벤트 
  $sGraphbtn.click(function(){
    $(this).addClass('on').siblings('.list-btn').removeClass('on');
    $sGraphcont.show().siblings('.disease-sort .result__list').hide();
  });



  // 기본(소화,대소변) -리스트 버튼 클릭했을 때 이벤트 
  var $basicGraphbtn = $('.basic-disease .graph-btn');
  var $basicListbtn = $('.basic-disease .list-btn');
  var $braphcont = $('.basic-disease .result__graph');
  var $bListcont = $('.basic-disease .result__list');
  
  $basicListbtn.click(function(){
    $(this).addClass('on').siblings('.graph-btn').removeClass('on');
    $bListcont.show().siblings('.basic-disease .result__graph').hide();

    $('html, body').animate({scrollTop : 0}, 400);
    return false;

  });

  // 기본(소화,대소변) -그래프 버튼 클릭했을 때 이벤트 
  $basicGraphbtn.click(function(){
    $(this).addClass('on').siblings('.list-btn').removeClass('on');
    $braphcont.show().siblings('.basic-disease .result__list').hide();
  });

  // 결과란 상단 공통 탭 슬라이드
  var tabList = $('.tab__list > .over');
  var ww = $(window).width();
  var tabSwiper = undefined;




// 넘치는 애들 클릭했을 때 앞으로 보이게
 function srollMenu(){
  var tab_idx = 0;
  $('.tab__list li > a').each(function(index){ 
    if( $(this).parent('li').hasClass("over")) 
    tab_idx = index; 
   }); 

   var tab_left = $('.tab__list li').eq(tab_idx).offset().left; 
   $('.tab__list').scrollLeft(tab_left);

   console.log(tab_left);
 }



  


});