<!-- 오른쪽 aside 메뉴 -->
<div class="aside__right-menu sub__right">
    <span class="aside_cart"><a href="/shop/prd_basket.php" data-amount="<?=number_format($baskCnt)?>">장바구니</a></span>
    <div class="aside_btm">
        <span class="latest-see">최근 본 상품</span>
        <div class="swiper-container latest__slide">
            <ul class="swiper-wrapper">
				<?
				$total = 0;
				for($ii=0;$ii<100;$ii++){
					if($_SESSION["view_list"][$ii][prdcode]) $total++;
				}
				$v_idx = $total-1;
				while(0 <= $v_idx){
					// 상품 이미지
					if(!@file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$_SESSION["view_list"][$v_idx][prdimg])) $view_prdimg = "/images/noimg_R.gif";
					else $view_prdimg = "/data/prdimg/".$_SESSION["view_list"][$v_idx][prdimg];
				?>
				<li class="swiper-slide"><a href="/shop/prd_view.php?prdcode=<?=$_SESSION["view_list"][$v_idx][prdcode]?>"><img src="<?=$view_prdimg?>"></a></li>
				<?
					$v_idx--;
				}
				?>
            </ul>

        </div>
        <!-- //swiper-container -->
        <div class="paging_btn">
            <button type="button" class="prev"></button>
            <div class="latest__pagination"></div>
            <button type="button" class="next"></button>
        </div>
    </div>

</div>
<!-- //오른쪽 aside메뉴 -->

<script>
    var latest__swiper = new Swiper('.latest__slide', {
        slidesPerView: 3,
        pagination: {
        el: '.latest__pagination',
        type: 'fraction',
        },
        navigation: {
            nextEl: '.paging_btn .next',
            prevEl: '.paging_btn .prev',
        },
        direction: 'vertical',
    });

</script>