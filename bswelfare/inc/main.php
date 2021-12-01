<div class="main__visual">

    <div class="main__visual__swiper">
        <div class="swiper-wrapper main__slides">
			<?
			$code	= 'main_vis';
			$sql	= "SELECT * FROM wiz_banner
					   WHERE sid='$SID' AND name='$code' AND isuse='Y' AND de_type='IMG'
					   ORDER BY prior, idx";
			$result	= mysql_query($sql) or error(mysql_error());
			while($ban_row = mysql_fetch_object($result)) {
				$onClick = "";
				if(!empty($ban_row->link_url)) {
					if(!strcmp($ban_row->link_target, "_SELF") || empty($ban_row->link_target)) $onClick = "self.location.href='".$ban_row->link_url."'\" ";
					if(!strcmp($ban_row->link_target, "_BLANK")) $onClick = "window.open('".$ban_row->link_url."')\"";
				}
				$img_src = "/data/banner/".$ban_row->de_img;
			?>
			<img onclick="<?=$onClick?>" src="<?=$img_src?>" class="swiper-slide"/>
			<? } // END while($ban_row) ?>
        </div>
        <div class="container">
            <div class="swiper-pagination"></div>
            <div class="swiper-button-play main-vis-btn ir_pm">play</div>
        </div>
    </div>
</div>
<!-- //main__visual -->
<script>
// 메인비쥬얼 슬라이드
var mainSwiper = new Swiper ('.main__visual__swiper', {
        direction:'horizontal',
        loop:true,
        autoplay: {
        delay:3000,
        autoplayDisableOnInteraction: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            type: 'fraction',
            clickable:true
        },

    });

    var $mainVisBtn = $('.main-vis-btn');

    $mainVisBtn.on('click', function(){
    var playIs = $mainVisBtn.hasClass('swiper-button-play');

    if(playIs == true){
    mainSwiper.autoplay.stop();
    $mainVisBtn.removeClass('swiper-button-play').addClass('swiper-button-pause');

    } else {
    mainSwiper.autoplay.start();
    $mainVisBtn.removeClass('swiper-button-pause').addClass('swiper-button-play');
    }

    });
</script>

<section class="main">
    <div class="container">
        <h2 class="main_tit">기획상품</h2>
        <div class="plan-prd__sec clearfix">
            <div class="plan-prd__lef">
                <span class="width__ban">
					<?
					$code	= 'main_promoL';
					$sql	= "SELECT * FROM wiz_banner
							   WHERE sid='$SID' AND name='$code' AND isuse='Y' AND de_type='IMG'
							   ORDER BY prior, idx LIMIT 0, 1";
					$result	= mysql_query($sql) or error(mysql_error());
					while($ban_row = mysql_fetch_object($result)) {
						$url	= ($ban_row->link_url ? $ban_row->link_url : 'javascript:void(0);');
						$target	= ($ban_row->link_target=='_BLANK' ? ' target="_blank"' : '');
						$img_src= "/data/banner/".$ban_row->de_img;
					?>
					<a href="<?=$url?>"<?=$target?>>
                        <img src="<?=$img_src?>" />
                        <span class="cate__go-ico ir_pm">바로가기</span>
                    </a>
					<? } // END while($ban_row) ?>
                </span>
                <ul class="plan__ban-box clearfix">
					<?
					$code	= 'main_promoS';
					$sql	= "SELECT * FROM wiz_banner
							   WHERE sid='$SID' AND name='$code' AND isuse='Y' AND de_type='IMG'
							   ORDER BY prior, idx LIMIT 0, 4";
					$result	= mysql_query($sql) or error(mysql_error());
					while($ban_row = mysql_fetch_object($result)) {
						$url	= ($ban_row->link_url ? $ban_row->link_url : 'javascript:void(0);');
						$target	= ($ban_row->link_target=='_BLANK' ? ' target="_blank"' : '');
						$img_src= "/data/banner/".$ban_row->de_img;
					?>
					<li class="ban-one">
                        <a href="<?=$url?>"<?=$target?>>
                            <img src="<?=$img_src?>" />
                            <span class="cate__go-ico ir_pm">바로가기</span>
                        </a>
                    </li>
					<? } // END while($ban_row) ?>
                </ul>
            </div>
            <div class="plan-prd__right">
                <ul class="plan__ban-box rig clearfix">
					<?
					$code	= 'main_promoS';
					$sql	= "SELECT * FROM wiz_banner
							   WHERE sid='$SID' AND name='$code' AND isuse='Y' AND de_type='IMG'
							   ORDER BY prior, idx LIMIT 4, 4";
					$result	= mysql_query($sql) or error(mysql_error());
					while($ban_row = mysql_fetch_object($result)) {
						$url	= ($ban_row->link_url ? $ban_row->link_url : 'javascript:void(0);');
						$target	= ($ban_row->link_target=='_BLANK' ? ' target="_blank"' : '');
						$img_src= "/data/banner/".$ban_row->de_img;
					?>
					<li class="ban-one">
                        <a href="<?=$url?>"<?=$target?>>
                            <img src="<?=$img_src?>" />
                            <span class="cate__go-ico ir_pm">바로가기</span>
                        </a>
                    </li>
					<? } // END while($ban_row) ?>
                </ul>
                <span class="width__ban">
					<?
					$code	= 'main_promoL';
					$sql	= "SELECT * FROM wiz_banner
							   WHERE sid='$SID' AND name='$code' AND isuse='Y' AND de_type='IMG'
							   ORDER BY prior, idx LIMIT 1, 1";
					$result	= mysql_query($sql) or error(mysql_error());
					while($ban_row = mysql_fetch_object($result)) {
						$url	= ($ban_row->link_url ? $ban_row->link_url : 'javascript:void(0);');
						$target	= ($ban_row->link_target=='_BLANK' ? ' target="_blank"' : '');
						$img_src= "/data/banner/".$ban_row->de_img;
					?>
					<a href="<?=$url?>"<?=$target?>>
                        <img src="<?=$img_src?>" />
                        <span class="cate__go-ico ir_pm">바로가기</span>
                    </a>
					<? } // END while($ban_row) ?>
                </span>
            </div>
        </div>
        <!-- // plan-prd__sec -->
        <h2 class="main_tit">카테고리별<em class="org-col"> 추천상품</em></h2>

		<?
		// 배너 사용 확인(카테고리 사용 + 배너 사용 + 등록된 배너가 있는지 > $useCat 에 코드값 저장)
		unset($banUse);
		if($SID == 'admin'){
			/*$cat_sql	= "SELECT sid, catname, catcode FROM wiz_category WHERE catuse != 'N' AND depthno = '1'
							ORDER BY priorno01 ASC";*/
			$cat_sql	= "SELECT sid, catname, catcode FROM wiz_category AS wc
								INNER JOIN wiz_category_shop_relation wcsr ON wc.catcode = wcsr.catcode_fk AND wcsr.sid_fk = '".$SID."'
							WHERE catuse != 'N' AND depthno = '1'
							ORDER BY wc.priorno01 ASC";
		}
		else{
			$cat_sql	= "SELECT sid, catname, catcode FROM wiz_category AS wc
								INNER JOIN wiz_category_shop_relation wcsr ON wc.catcode = wcsr.catcode_fk AND wcsr.sid_fk = '".$SID."'
							WHERE catuse != 'N' AND depthno = '1'
							ORDER BY wc.priorno01 ASC";
		}

		$cat_res	= mysql_query($cat_sql) or error(mysql_error());
		while($cat_row = mysql_fetch_assoc($cat_res)){
			$bn_sql	= "SELECT bi.idx, bi.name, bi.tags, (SELECT COUNT(*) FROM wiz_banner WHERE sid=bi.sid AND name=bi.name AND isuse='Y' AND gubun='p') AS bn_cnt
						FROM wiz_bannerinfo AS bi
						WHERE sid='$SID' AND bi.name='main_prd".$cat_row['catcode']."' AND isuse='Y' HAVING bn_cnt > 0";
			$bn_res	= mysql_query($bn_sql) or error(mysql_error());
			while($bn_row = mysql_fetch_assoc($bn_res)){
				$useCat[$cat_row['catcode']]['banner_idx']	= $bn_row['idx'];
				$useCat[$cat_row['catcode']]['catname']		= $cat_row['catname'];
				$useCat[$cat_row['catcode']]['tags']		= $bn_row['tags'];
			}
		}

		// 카테고리 노출
		foreach($useCat as $catcode => $banInfo){
			if($catcode == '100000')		{ $cls = 'fashion';	$col = 'red';		}
			else if($catcode == '110000')	{ $cls = 'beauty';	$col = 'pink';		}
			else if($catcode == '120000')	{ $cls = 'baby';	$col = 'orange';	}
			else if($catcode == '130000')	{ $cls = 'food';	$col = 'green';		}
			else if($catcode == '140000')	{ $cls = 'kitc';	$col = 'melon';		}
			else if($catcode == '150000')	{ $cls = 'dairy';	$col = 'sky';		}
			else if($catcode == '160000')	{ $cls = 'interi';	$col = 'blue';		}
			else if($catcode == '170000')	{ $cls = 'digital';	$col = 'deep';		}
			else if($catcode == '180000')	{ $cls = 'sport';	$col = 'purple';	}
			else if($catcode == '190000')	{ $cls = 'car';		$col = 'palepink';	}
			else if($catcode == '200000')	{ $cls = 'book';	$col = 'red';		}
			else if($catcode == '210000')	{ $cls = 'toy';		$col = 'pink';		}
			else if($catcode == '220000')	{ $cls = 'office';	$col = 'orange';	}
			else if($catcode == '230000')	{ $cls = 'pet';		$col = 'green';		}
			else if($catcode == '240000')	{ $cls = 'health';	$col = 'melon';		}
			else if($catcode == '250000')	{ $cls = 'travel';	$col = 'sky';		}
		?>
		<div class="recom-prd__sec recm-prd__<?=$cls?> clearfix">
            <span class="categ-tit__wrap">
                <h3 class="categ__tit <?=$col?>"><?=$banInfo['catname']?></h3>
                <a href="/shop/prd_list.php?catcode=<?=$catcode?>" class="<?=$col?>">바로가기</a>
            </span>
            <!-- //상단타이틀 -->
			<?
			unset($tags);
			if(trim($banInfo['tags'])){
				$tags	= explode(',', $banInfo['tags']);
			}
			if(is_array($tags)){
			?>
			<div class="keyw__wrap">
                <strong><em class="eng">HOT</em> 키워드</strong>
                <ul class="hot_key <?=$col?>">
					<? for($i=0; $i<sizeof($tags); $i++){ ?>
					<li><a href="/shop/prd_list.php?search_keyword=<?=urlencode($tags[$i])?>"> #<?=$tags[$i]?></a></li>
					<? } ?>
                </ul>
            </div>
            <!-- //HOT 키워드 -->
			<? } ?>
            <div class="cat-com__left">
                <div class="swiper-container m__cat-slide" id="mainPrdSlide<?=$catcode?>">
                    <ul class="swiper-wrapper">
						<?
						// 상품배너
						$bn_sql	= "SELECT * FROM wiz_banner WHERE sid='$SID' AND name='main_prd".$catcode."' AND isuse='Y' AND de_type='IMG' AND gubun='p' ORDER BY prior";
						$bn_res	= mysql_query($bn_sql) or error(mysql_error());
						$bn_cnt	= mysql_num_rows($bn_res);
						while($bn_row = mysql_fetch_assoc($bn_res)){
							$href = 'javascript:void(0);'; $target = '';
							if($bn_row['link_url'])					$href	= $bn_row['link_url'];
							if($bn_row['link_target']=='_BLANK')	$target	= ' target="'.$bn_row['link_target'].'"';
							$img_src = "/data/banner/".$bn_row['de_img'];
						?>
						<li class="swiper-slide">
                            <a href="<?=$href?>"<?=$target?>>
                                <img src="<?=$img_src?>" alt="<?=$catname?>">
                            </a>
                        </li>
						<?
						}
						?>
                    </ul>
                    <div class="cate-prd__pager">
						<? for($pg=1; $pg<=$nb_cnt; $pg++) echo '<span>'.$pg.'</span>'; ?>
                    </div>
                </div>
                <!-- //swiper-container -->
                <!-- 내가 만든 버튼에 동작시키기 -->
                <div class="cate-prd__controls" id="mainPrdNav<?=$catcode?>">
                    <span class="cate_prev ir_pm">Prev Slide</span>
                    <span class="cate_next ir_pm">Next Slide</span>
                </div>
            </div>
            <!-- //cat-com__left -->

			<!-- 여기 리스트 통으로 돌아가는 슬라이드 -->
			<div class="swiper-container main__catelist__slide catelist__slide-<?=$cls?>">
				<div class="swiper-wrapper">
					<ul class="swiper-slide cat-com__right clearfix">
						<?
						$catcode_sql = " and wc.catcode like '".substr($catcode, 0, 2)."%'";
						if($SID=="admin"){
							/*$prd_sql	= "select distinct wp.prdcode, wp.prdname, wp.sellprice, wp.strprice, wp.prdimg_M1, wp.shortage, wp.prdicon, wp.stock, wp.conprice, wp.c_price, wp.prd_type
											from wiz_cprelation wc
												inner join wiz_product wp on wc.prdcode = wp.prdcode
												inner join wiz_category wy on wc.catcode = wy.catcode and wy.catuse != 'N'
												inner join wiz_banner_product wbp on wp.prdcode = wbp.prdcode
											where wp.sid='$SID' and wp.status='Y' AND wp.dell_check NOT LIKE 'DELL' AND wbp.banner_idx='".$banInfo['banner_idx']."' $catcode_sql
											order by wbp.ordno limit 18";*/
							$prd_sql	= "select distinct wp.prdcode, wp.prdname, wp.sellprice, wp.strprice, wp.prdimg_M1, wp.shortage, wp.prdicon, wp.stock, wp.conprice, wp.c_price, wp.prd_type
											from wiz_product wp
												inner join wiz_product_shop_relation AS wps ON wp.prdcode = wps.prd_fk AND wps.sid_fk = '$SID'
												inner join wiz_cprelation wc on wc.prdcode = wp.prdcode
												inner join wiz_category wy on wc.catcode = wy.catcode and wy.catuse != 'N'
												inner join wiz_banner_product wbp on wp.prdcode = wbp.prdcode
											where (wp.sid='admin' or wp.sid='$SID') and wp.status='Y' AND wp.dell_check NOT LIKE 'DELL' AND wbp.banner_idx='".$banInfo['banner_idx']."' $catcode_sql
											order by wbp.ordno limit 18";
						}else{
							$prd_sql	= "select distinct wp.prdcode, wp.prdname, wp.sellprice, wp.strprice, wp.prdimg_M1, wp.shortage, wp.prdicon, wp.stock, wp.conprice, wp.c_price, wp.prd_type
											from wiz_product wp
												inner join wiz_product_shop_relation AS wps ON wp.prdcode = wps.prd_fk AND wps.sid_fk = '$SID'
												inner join wiz_cprelation wc on wc.prdcode = wp.prdcode
												inner join wiz_category wy on wc.catcode = wy.catcode and wy.catuse != 'N'
												inner join wiz_banner_product wbp on wp.prdcode = wbp.prdcode
											where (wp.sid='admin' or wp.sid='$SID') and wp.status='Y' AND wp.dell_check NOT LIKE 'DELL' AND wbp.banner_idx='".$banInfo['banner_idx']."' $catcode_sql
											order by wbp.ordno limit 18";
						}
						$prd_res	= mysql_query($prd_sql) or error(mysql_error());
						for($no=0; $prd_row = mysql_fetch_object($prd_res); $no++){

							if($no>0 && $no%6==0) echo '</ul><ul class="swiper-slide cat-com__right clearfix">';

							if($prd_row->sellprice_sid != "") $prd_row->sellprice = $prd_row->sellprice_sid;

							$sellprice = '<strong>'.number_format($prd_row->sellprice)."</strong>원";

							if(!empty($prd_row->strprice)) {
								$conprice = "";
								$sellprice = $prd_row->strprice;
							}

							// 상품 이미지
							if(!@file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$prd_row->prdimg_M1)) $prd_row->prdimg_M1 = "$SKIN_URL/images/noimg_R.gif";
							else $prd_row->prdimg_M1 = "/data/prdimg/".$prd_row->prdimg_M1;

							// 개별가격 등록여부 확인
							$QUERY = "SELECT COUNT(sid) CNT FROM wiz_sid_price WHERE sid LIKE '".$SID."' AND prdcode LIKE '".$prd_row->prdcode."' AND dell_state NOT LIKE 'DELL'";
							$c_result = mysql_query($QUERY) or error(mysql_error());
							$c_info = mysql_fetch_array($c_result);
							$CNT = $c_info['CNT'];

							$QUERY = "SELECT c_num, c_price FROM wiz_sid_price WHERE sid LIKE '".$SID."' AND prdcode LIKE '".$prd_row->prdcode."'";
							$c_result = mysql_query($QUERY) or error(mysql_error());
							$c_info = mysql_fetch_array($c_result);

							$c_price_check = "";
							// 개별가격이 등록되어있을 경우
							if($CNT > 0){ $c_price_check = $c_info['c_price']; }
							// 개별가격이 등록되어있지 않은 경우
							else{ $c_price_check = $prd_row->c_price; }

							$c_price = "";
							list($c_price1, $c_price2, $c_price3, $c_price4, $c_price5, $c_price6, $c_price7) = explode("|", $c_price_check);
							if($prd_row->prd_type=='2'){		// 공동구매가
								for($i = 1; $i <= 7; $i++){
									if(${"c_price".$i}){
										$c_price = ${"c_price".$i};
									}
								}
							}
							else $c_price = $c_price1;		// 일반가

							$sellprice = '<strong>'.number_format($c_price)."</strong>원";

							// 정상가(판매가보다 높을경우 할인표시)
							$conprice = ""; $tmp_sellprice = intval(str_replace(array(',','원'), '', $sellprice));
							if($prd_row->conprice > $tmp_sellprice){
								$conprice = '<small class="sale-txt">'.(100-round($tmp_sellprice/$prd_row->conprice*100)).'%<del>'.number_format($prd_row->conprice).'원</del></small>';
							}

							if(!empty($prd_row->strprice)) {
								$conprice = "";
								$sellprice = "".$prd_row->strprice."";
							}
						?>
						<li>
							<a href="/shop/prd_view.php?prdcode=<?=$prd_row->prdcode?>">
								<span class="prd_img"><img src="<?=$prd_row->prdimg_M1?>" alt="<?=$prd_row->prdname?>"></span>
								<span class="cat__prd-name"><?=$prd_row->prdname?></span>
								<span class="cat__prd-price"><?=$sellprice?></span>
							</a>
						</li>
						<?
						}
						?>
					</ul>
					<!-- //cat-com__right -->
					<!-- 리스트 6개감싸고 있는 부모 통 슬라이드 여기까지 -->
				</div>
				<!-- swiper-wrapper -->
				<div class="catelist__pager">

				</div>
				<!-- 내가 만든 버튼에 동작시키기 -->
				<div class="cate-prdlist__control" >
					<span class="catelist_prev ir_pm">Prev Slide</span>
					<span class="catelist_next ir_pm">Next Slide</span>
				</div>
			</div>
			<!-- //catelist__slide-fashion -->
		</div>
		<!-- //recm-prd__fashion -->

		<div class="main__line-ban winter-plan">
			<?
			// 띠배너
			$bn_sql	= "SELECT * FROM wiz_banner WHERE sid='$SID' AND name='main_prd".$catcode."' AND isuse='Y' AND de_type='IMG' AND gubun='b' ORDER BY prior LIMIT 1";
			$bn_res	= mysql_query($bn_sql) or error(mysql_error());
			$bn_cnt	= mysql_num_rows($bn_res);
			while($bn_row = mysql_fetch_assoc($bn_res)){
				$href = 'javascript:void(0);'; $target = '';
				if($bn_row['link_url'])					$href	= $bn_row['link_url'];
				if($bn_row['link_target']=='_BLANK')	$target	= ' target="'.$bn_row['link_target'].'"';
				$img_src = "/data/banner/".$bn_row['de_img'];
			?>
			<a href="<?=$href?>"<?=$target?>><img src="<?=$img_src?>"></a>
			<?
			}
			?>
		</div>
        <!-- //띠배너 -->
		<script>
		const slide<?=$catcode?> = new Swiper ('#mainPrdSlide<?=$catcode?>', {
			direction:'horizontal',
			loop:true,
			autoplay: {
				delay:3000,
			},
			navigation: {
				nextEl: '#mainPrdNav<?=$catcode?> .cate_next',
				prevEl: '#mainPrdNav<?=$catcode?> .cate_prev',
			},
			pagination: {
				el: '.cate-prd__pager',
				clickable:true,
			}
		});

		const <?=$cls?>List = new Swiper ('.catelist__slide-<?=$cls?>', {
			direction:'horizontal',
			loop:true,
			// autoplay: {
			//     delay:3000,
			// },
			navigation: {
				nextEl: '.catelist__slide-<?=$cls?> .catelist_next',
				prevEl: '.catelist__slide-<?=$cls?> .catelist_prev',
			},
			pagination: {
				el: '.catelist__slide-<?=$cls?> .catelist__pager',
				clickable:true,
			}
		});
		</script>
		<?
		}
		?>

        <!-- 오른쪽 aside 메뉴 -->
        <div class="aside__right-menu">
            <span class="aside_cart"><a href="/shop/prd_basket.php" data-amount="<?=$baskCnt?>">장바구니</a></span>
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
                slidesPerView:3,
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
    </div>
    <!-- //container -->
</section>
<!-- //main -->