$(function(){

  //  intro welcome text
  var welcomeSection = $('.welcome-section'),
  enterButton = welcomeSection.find('.enter-button');

  setTimeout(function(){
    welcomeSection.removeClass('content-hidden');
  },700);
  enterButton.on('click',function(e){
    e.preventDefault();
    welcomeSection.fadeOut();
    
  });
  

  // header hover
  $('.header').mouseover(function(){
    $('.header').addClass('hover');
  });

  $('.header').mouseleave(function(){
    $('.header').removeClass('hover');
  });


  // main txt slide
  var introText = new Swiper(".slide-txt", {
    direction: "vertical",
    speed: 1500,
    autoplay:{
    delay:2500
    },
    on:{
      slideChange: function () {
        $('.m__rgtsld-txt li').removeClass('on');
        $('.m__rgtsld-txt li').eq(this.realIndex).addClass('on').siblings().removeClass('on');
        $('.sld-txt-wrap').addClass('active');
      }
    }
    
  }); // introText

  
  // work-slide slide

  var bullet = ['제주영상스튜디오', 'Bs welfare', '대치명인', '자생한방병원','매경증권아카데미', '네이처스팜 진단서비스', '분자영상학회', '피터앤김'];
  var workSlide = new Swiper(".work-slide", {
    direction: "horizontal",
    speed: 2500,
    autoplay:{
    delay:5000,
    disableOnInteraction: true,
    },
    effect: "fade",
    pagination: {
      el: ".work-slide .swiper-pagination",
      // type: "fraction",
      clickable: true,
      renderBullet: function (index, className) {
        return '<span class="' + className + '">' + (bullet[index]) + '</span>';
      }
    },
    navigation: {
      nextEl: ".work .swiper-button-next",
      prevEl: ".work .swiper-button-prev",
    },
    on:{
      slideChange: function () {
        $('.cmn-work-bg').removeClass('on');
        $('.cmn-work-bg').eq(this.realIndex).addClass('on').siblings().removeClass('on');
        
      }
    }
  }); // introText


   //풀페이지
  new fullpage('#full-page',{
    licenseKey:'',
    anchors: ['firstPage', 'secondPage', '3rdPage', '4thpage','5thPage'],
    menu: '#gnb__menu',
    navigation:true, //nav indicator
    navigationTooltips:['Home', 'About', 'Skill', 'Work','Contact'],
    navigationPosition: 'left',
    slidesNavigation: true,  //�����̵� navigation�� ǥ��
    slidesToSections: true,  //�����̵��Ű���� ��ҿ� Ŭ������ �����̵�
    scrollingSpeed:1400,//��ũ�ѵǴ� �ӵ�
    onLeave:function(origin,destination,direction) { 
       
     }, //��ũ���� ���۵ɶ�
    afterLoad:function(origin,destination,direction) {  //��ũ���� ���۵ǰ� ������ ��
        //ù ���������� �Ͼ�� ��
        if(destination.index == 0){
            $('#fp-nav ul li:first-child').addClass('on').siblings().removeClass('on');            
        }
        if(destination.index == 1){
          $('#fp-nav ul li:nth-child(2)').addClass('on').siblings().removeClass('on');            
        }
        if(destination.index == 2){
          $('#fp-nav ul li:nth-child(3)').addClass('on').siblings().removeClass('on');            
        }
        if(destination.index == 3){
          $('#fp-nav ul li:nth-child(4)').addClass('on').siblings().removeClass('on');            
        }
        if(destination.index == 4){
          $('#fp-nav ul li:nth-child(5)').addClass('on').siblings().removeClass('on');            
        }
      }
  });

 

}); 
