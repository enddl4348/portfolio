<? include "../../inc/common.inc"; ?>
<? include "../../inc/util.inc"; ?>
<? include "../../inc/shop_info.inc"; ?>
<? include "../../inc/oper_info.inc"; ?>
<? include "../../inc/admin_check.inc"; ?>
<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php'; ?>
<?
if($dep_code != "") $dep_code_sql = "and catcode like '".$dep_code."%'";

$cat_sql = "select substring(catcode,1,2) as catcode, catname from wiz_category where depthno = 1 $dep_code_sql order by priorno01 asc limit 1";
$cat_result = mysql_query($cat_sql) or error(mysql_error());
$cat_row = mysql_fetch_object($cat_result);

if($dep_code == "") $cat_row->catname = "전체카테고리";

/*
$dep_code = $cat_row->catcode;
$dep_code_sql = "and catcode like '".$dep_code.$dep_code2.$dep_code3."%'";

$cat_sql2 = "select substring(catcode,3,2) as catcode, catname from wiz_category where depthno = 2 $dep_code_sql order by priorno01 asc limit 1";
$cat_result2 = mysql_query($cat_sql2) or error(mysql_error());
$cat_row2 = mysql_fetch_object($cat_result2);

$cat_sql3 = "select substring(catcode,5,2) as catcode, catname from wiz_category where depthno = 3 $dep_code_sql order by priorno01 asc limit 1";
$cat_result3 = mysql_query($cat_sql3) or error(mysql_error());
$cat_row3 = mysql_fetch_object($cat_result3);
*/

// 페이지 파라메터 (검색조건이 변하지 않도록)
//--------------------------------------------------------------------------------------------------
$param = "dep_code=$dep_code&dep2_code=$dep2_code&dep3_code=$dep3_code";
$param .= "&s_searchkey=$s_searchkey";
$param .= "&rows=$rows";
$param .= "&s_order=$s_order";
?>

<div class="prd-nav-wrap">
	<ul class="clearfix nav-category">
		<li <?if($dep_code == "") echo "class='on'";?>>
			<a href='purc_req.php' class="all-menu-btn">전체카테고리</a>
			<!-- 전체카테고리 호버시 리스트 나오는 부분 -->
			<div class="almenu-dpt-wrap clearfix">
				<div class="depth-menu-box">
					<strong class="nav__type-tit"><a href="">사무용품</a></strong>
					<ul class="nav__depth1-list">
						<li><a href="">사무용품 1차 분류</a></li>
						<li><a href="">POP/표지판/아크릴박스</a></li>
					</ul>
				</div>

				<div class="depth-menu-box">
					<strong class="nav__type-tit"><a href="">생활용품</a></strong>
					<ul class="nav__depth1-list">
						<li><a href="">생활용품 1차 분류</a></li>
						<li><a href="">귀마개/안대/베개</a></li>
					</ul>
				</div>

				<div class="depth-menu-box">
					<strong class="nav__type-tit"><a href="">의료소모품</a></strong>
					<ul class="nav__depth1-list">
						<li><a href="">의료소모품 1차 분류</a></li>
						<li><a href="">거즈/붕대/탈지면/탄력</a></li>
					</ul>
				</div>

				<div class="depth-menu-box">
					<strong class="nav__type-tit"><a href="">인쇄물</a></strong>
					<ul class="nav__depth1-list">
						<li><a href="">인쇄물 1차 분류</a></li>
						<li><a href="">리플렛/책자/복용법/양식지</a></li>
					</ul>
				</div>

				<div class="depth-menu-box">
					<strong class="nav__type-tit"><a href="">전산용품</a></strong>
					<ul class="nav__depth1-list">
						<li><a href="">전산용품 1차 분류</a></li>
						<li><a href="">보안기/정보보안기/프리젠터</a></li>
					</ul>
				</div>

				<div class="depth-menu-box">
					<strong class="nav__type-tit"><a href="">복리후생용품</a></strong>
					<ul class="nav__depth1-list">
						<li><a href="">복리후생용품 1차 분류</a></li>
						<li><a href="">경조사용품</a></li>
					</ul>
				</div>

				<div class="depth-menu-box">
					<strong class="nav__type-tit"><a href="">한방과립제</a></strong>
					<ul class="nav__depth1-list">
						<li><a href="">한방과립제 1차 분류</a></li>
						<li><a href="">혼합보험과립제</a></li>
					</ul>
				</div>

				<div class="depth-menu-box">
					<strong class="nav__type-tit"><a href="">자생</a></strong>
					<ul class="nav__depth1-list">
						<li><a href="">자생 1차 분류</a></li>
						<li><a href="">추나베개</a></li>
					</ul>
				</div>
			</div> <!-- //almenu-dpt-wrap -->
		</li>
		<?
		$sql = "select substring(catcode,1,2) as catcode, catname from wiz_category where depthno = 1 order by priorno01 asc";
		$result = mysql_query($sql) or error(mysql_error());
		while($row = mysql_fetch_object($result)){
			if($row->catcode == $dep_code)
			echo "<li class='on'><a href='purc_req.php?dep_code=$row->catcode'>$row->catname</a></li>";
			else
			echo "<li><a href='purc_req.php?dep_code=$row->catcode'>$row->catname</a></li>";
		}
		?>
	</ul>
</div> <!-- //prd-nav-wrap -->


<form name="searchForm" action="<?=$PHP_SELF?>" method="get">
	<input type="hidden" name="page" value="<?=$page?>">
	<input type="hidden" name="rows" value="<?=$rows?>">
	<input type="hidden" name="s_order" value="<?=$s_order?>">
	<input type="hidden" name="s_searchkey" value="<?=$s_searchkey?>">

	<div class="prd-opt-wrap">
		<span class="home ir_pm">홈</span>
		<em class="arr-ico"></em>
		<select name="dep_code" class="cmn-slct" onChange="this.form.page.value=1;this.form.dep2_code.value='';this.form.dep3_code.value='';this.form.submit();">
			<option value=''>전체보기</option>
			<?
			$sql = "select substring(catcode,1,2) as catcode, catname from wiz_category where depthno = 1 order by priorno01 asc";
			$result = mysql_query($sql) or error(mysql_error());
			while($row = mysql_fetch_object($result)){
				if($row->catcode == $dep_code)
					echo "<option value='$row->catcode' selected>$row->catname</option>";
				else
					echo "<option value='$row->catcode'>$row->catname</option>";
			}
			?>
		</select>

		<em class="arr-ico"></em>
		<select name="dep2_code" class="cmn-slct" onChange="this.form.page.value=1;this.form.dep3_code.value='';this.form.submit();">
			<option value=''>전체보기</option>
			<?
			if($dep_code != ''){
				$sql = "select substring(catcode,3,2) as catcode, catname from wiz_category where depthno = 2 and catcode like '$dep_code%' order by priorno02 asc";
				$result = mysql_query($sql) or error(mysql_error());
				while($row = mysql_fetch_object($result)){
				if($row->catcode == $dep2_code)
					echo "<option value='$row->catcode' selected>$row->catname</option>";
				else
					echo "<option value='$row->catcode'>$row->catname</option>";
				}
			}
			?>
		</select>

		<em class="arr-ico"></em>
		<select name="dep3_code" class="cmn-slct" onChange="this.form.page.value=1;this.form.submit();">
			<option value=''>전체보기</option>
			<?
			if($dep2_code != ''){
				$sql = "select substring(catcode,5,2) as catcode, catname from wiz_category where depthno = 3 and catcode like '$dep_code$dep2_code%' order by priorno03 asc";
				$result = mysql_query($sql) or error(mysql_error());
				while($row = mysql_fetch_object($result)){
				if($row->catcode == $dep3_code)
					echo "<option value='$row->catcode' selected>$row->catname</option>";
				else
					echo "<option value='$row->catcode'>$row->catname</option>";
				}
			}
			?>
		</select>
	</div> <!-- //prd-opt-wrap -->
</form>
<div class="purc__prd-list cmn-prd-list">
	<h2 class="page_ttl"><?=$cat_row->catname?></h2>

	<!-- 상단에 세부 옵션 검색했을 때 노출되는 마크업 -->
	<!--ul class="nav-depth-menu">
		<li class="on"><a href="">도장</a></li>  <!-- 각각 선택했을 때 li에 class on 붙게 --
		<li><a href="">인주</a></li>
		<li><a href="">잉크</a></li>
		<li><a href="">부채용꽂이</a></li>
		<li><a href="">명함꽂이</a></li>
	</ul-->

	<?
	$sid_sql = "wp.sid LIKE '$SID' AND ";
	if($wiz_admin['mall_id'] != "admin")	$mall_sql		= "wm.id = '".$wiz_admin['mall_id']."' AND";
	if(!empty($wiz_admin['depart_code']))	$depart_sql		= "wpm.memdepart = '".substr($wiz_admin['depart_code'], 0, 2)."0000' AND";
	if(!empty($dep_code))					$catcode_sql	= "wp.prdcode in (select distinct prdcode from wiz_cprelation where catcode like '$dep_code$dep2_code$dep3_code%') and ";
	if(!empty($s_searchkey))				$search_sql		= "wp.prdname like '%$s_searchkey%' and ";
	if($s_order == "")						$s_order		= "wp.wdate desc";

	/*
	$sql = "SELECT wp.*, wpm.mallprice, wpm2.memprice, wm.com_name, wd.name,
				(select catcode from wiz_cprelation where prdcode = wp.prdcode and catcode like '".$dep_code.$dep2_code.$dep3_code."%' limit 1) catcode
			FROM wiz_product wp
				INNER JOIN wiz_product_mallprice wpm ON wp.prdcode = wpm.prdcode
				INNER JOIN wiz_product_memprice wpm2 ON wpm.prdcode = wpm2.prdcode AND wpm.mallid = wpm2.mallid
				INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
				INNER JOIN wiz_department wd ON wpm2.memdepart = wd.areacode
			WHERE $sid_sql $mall_sql $depart_sql $catcode_sql $display_sql $search_sql $status_sql $mallid_sql wp.dell_check != 'DELL'";
	*/

	$sql = "SELECT wp.*, wpm.memprice, wpm.mallid,
				(select catcode from wiz_cprelation where prdcode = wp.prdcode and catcode like '".$dep_code.$dep2_code.$dep3_code."%' limit 1) catcode
			FROM wiz_product wp
				INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
				INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
				INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
			WHERE $depart_sql $catcode_sql $search_sql wp.dell_check != 'DELL'";
	$result	= mysql_query($sql) or error(mysql_error());
	$total	= mysql_num_rows($result);
	
	if($rows == "")$rows = 10;
	$lists	= 5;
	$page_count = ceil($total/$rows);
	if(!$page || $page > $page_count) $page = 1;
	$start	= ($page-1)*$rows;
	$no		= $total-$start;
	?>
	<p class="prd-amnt-txt">총 <em><?=$total?></em>개의 상품이 검색되어 있습니다.</p>
	<div style="text-align: right; margin-bottom: 5px;" class="prd_detail_srch">
		<input type="text" name="s_searchkey2" value="<?=$s_searchkey?>" class="cmn-ip" placeholder="리스트 내 검색"/><button type="button" class="cmn-btn" onclick="searchkey();">검색</button> <!-- 상품 검색어를 입력해주세요 -->
	</div>

	<div class="purc_list-opt">
		<span class="all-select">
			<input type="checkbox" id="all_slct" class=""/>
			<label for="all_slct">전체선택</label>
		</span>

		<span class="alg-tit">정렬방식</span>

		<div class="align-btn">
			<button type="button" class="ir_pm col">가로형리스트 버튼</button>
			<button type="button" class="ir_pm row">세로형리스트 버튼</button>
		</div>

		<select class="cmn-slct" onChange="document.searchForm.rows.value=this.value;document.searchForm.submit();">
			<option value="10" <?if($rows == 10) echo "selected";?>>10개씩 보기</option>
			<option value="20" <?if($rows == 20) echo "selected";?>>20개씩 보기</option>
			<option value="30" <?if($rows == 30) echo "selected";?>>30개씩 보기</option>
		</select>

		<select class="cmn-slct" onChange="document.searchForm.s_order.value=this.value;document.searchForm.submit();">
			<option value="wp.wdate desc" <?if($s_order == "wp.wdate desc") echo "selected";?>>최근등록상품</option>
			<option value="wpm.memprice desc" <?if($s_order == "wpm.memprice desc") echo "selected";?>>높은가격순</option>
			<option value="wpm.memprice asc" <?if($s_order == "wpm.memprice asc") echo "selected";?>>낮은가격순</option>
		</select>

		<button type="button" class="cart-btn" onclick="sel_cart();">장바구니 담기</button>
		<? if($wiz_admin['approval_buy'] == "N") { ?>
		<button type="button" class="buy-btn" onclick="sel_buy();">구매하기</button>
		<? } else { ?>
		<button type="button" class="buy-btn" onclick="sel_buy();">승인요청</button>
		<? } ?>
	</div> <!-- //purc_list-opt -->

	<div class="prd-list-type">
		<div class="prd-list-box clm-list clearfix">
		<?
		$sql = "SELECT wp.*, wpm.memprice, wpm.mallid,
					(select catcode from wiz_cprelation where prdcode = wp.prdcode and catcode like '".$dep_code.$dep2_code.$dep3_code."%' limit 1) catcode
				FROM wiz_product wp
					INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
					INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
					INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
				WHERE $depart_sql $catcode_sql $search_sql wp.dell_check != 'DELL'
				ORDER BY $s_order
				LIMIT $start, $rows";
		$result	= mysql_query($sql) or error(mysql_error());
		while($row = mysql_fetch_object($result)) {
			// 상품 이미지
			if(is_file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$row->prdimg_R))	$row->prdimg_R = "/data/prdimg/".$row->prdimg_R;
			else																$row->prdimg_R = "/images/noimage.gif";
		?>
			<div class="list-clm-item">
				<div class="prd-img">
					<img src="<?=$row->prdimg_R?>" alt="<?=$row->prdname?>">

					<div class="prd-item-hover">
						<div class="lnk-wrap ">
							<button type="button" class="detail" onclick="prd_view_ajax('<?=$row->prdcode?>', '<?=$row->mallid?>');">자세히 보기</button>
							<button type="button" class="cart" onclick="prd_cart('<?=$row->prdcode?>', '<?=$row->mallid?>');">장바구니 담기</button>
						</div>
					</div> <!-- //prd-item-hover -->
				</div>
				<div class="prd-desc">
					<p class="dec-top">
						<input type="checkbox" name="<?=$row->prdcode?>_<?=$row->mallid?>" class="chk chk_1" value="<?=$row->prdcode?>_<?=$row->mallid?>" />
						<strong class="prd-name"><?=$row->prdname?></strong>
						<span class="prd-prc"><em><?=number_format($row->memprice)?></em> 원</span>
					</p>

					<p class="prd-opt">
						<span><?=$row->maker?></span>
						<span><?=$row->spec?></span>
						<span><?=$row->order_unit?></span>
					</p>
				</div> <!-- //prd-desc -->
			</div>
		<? } ?>
		</div><!-- //가로형 리스트 마크업 여기까지 -->

		<table class="prd-list-tb prd-list-box">
		<?
		$sql = "SELECT wp.*, wpm.memprice, wpm.mallid,
					(select catcode from wiz_cprelation where prdcode = wp.prdcode and catcode like '".$dep_code.$dep2_code.$dep3_code."%' limit 1) catcode
				FROM wiz_product wp
					INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
					INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
					INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
				WHERE $depart_sql $catcode_sql $search_sql wp.dell_check != 'DELL'
				ORDER BY $s_order
				LIMIT $start, $rows";
		$result	= mysql_query($sql) or error(mysql_error());
		while($row = mysql_fetch_object($result)) {
			// 상품 이미지
			if(is_file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$row->prdimg_R))	$row->prdimg_R = "/data/prdimg/".$row->prdimg_R;
			else																$row->prdimg_R = "/images/noimage.gif";
		?>
			<tr>
				<td width="38px"><input type="checkbox" name="<?=$row->prdcode?>_<?=$row->mallid?>" class="chk chk_2" value="<?=$row->prdcode?>_<?=$row->mallid?>" /> </td>
				<td width="150px">
					<div class="prd-img"><img src="<?=$row->prdimg_R?>" alt="<?=$row->prdname?>"></div>
				</td>
				<td class="prd-desc">
					<strong class="prd-name"><?=$row->prdname?></strong>
					<p class="prd-opt"><span><?=$row->maker?></span> <span><?=$row->spec?></span> <span><?=$row->order_unit?></span></p>
				</td>
				<td class="prd-prc" width="385px"><em><?=number_format($row->memprice)?></em> 원</td>
				<td class="prd-link" width="150px">
					<button type="button" class="detail" onclick="prd_view_ajax('<?=$row->prdcode?>', '<?=$row->mallid?>');">자세히 보기</button>
					<button type="button" class="cart" onclick="prd_cart('<?=$row->prdcode?>', '<?=$row->mallid?>');">장바구니 담기</button>
				</td>
			</tr>
		<? } ?>
		</table> <!-- //세로형 리스트 마크업 여기까지 -->
	</div>  <!-- //prd-list-type -->
	
	<? print_prd_pagelist($page, $lists, $page_count, "$param"); ?>
</div> <!-- //purc__prd-list -->

<script>
$(document).ready(function() {
	$("#all_slct").click(function() {
		if($("#all_slct").is(":checked")) {
			$(".chk_1").prop("checked", true);
			$(".chk_2").prop("checked", true);
		} else {
			$(".chk_1").prop("checked", false);
			$(".chk_2").prop("checked", false);
		}
	});

	$(".chk").click(function() {
		if($(this).is(":checked")) {
			$("input[name="+this.value+"]").prop("checked", true);
		} else {
			$("input[name="+this.value+"]").prop("checked", false);
		}
	});
});

function searchkey() {
	var s_searchkey = $("input[name=s_searchkey2]").val();
	$("input[name=s_searchkey]").val(s_searchkey);
	document.searchForm.submit();
}

function prd_view_ajax(prdcode, mallid) {
	$.ajax({
		url     : '/admin/purchase/ajax.php',
		data    : {
			'mode' : 'prd_view',
			'prdcode' : prdcode,
			'mallid' : mallid
		},
		dataType: 'text',
		type    : 'POST',
		async: false,
		success : function(data){
			$(".prd-vw-wrap").html(data);
		}
	});
}

function prd_cart(prdcode, mallid) {
	$.ajax({
		url     : '/admin/purchase/ajax.php',
		data    : {
			'mode' : 'prd_cart',
			'prdcode' : prdcode,
			'mallid' : mallid
		},
		dataType: 'text',
		type    : 'POST',
		async: false,
		success : function(data){

			alert(data);

			if(data == "장바구니에 담겼습니다.") {
				// 장바구니 레이어 팝업
				cart_list();
				var $cartPop = $('.cart-pop-wrap');
				$cartPop.show();
				$cartPop.removeClass('on');
				$('.bg').show();
			}

		}
	});
}

function sel_cart() {
	if(!$(".chk_1").is(":checked")) {
		alert("상품을 선택해주세요.");
	} else {

		var sel_prdcode = "";
		var sel_mallid = "";

		$(".chk_1").each(function(){
			if($(this).is(":checked")) {
				var sel_arr = this.value.split("_");
				sel_prdcode += sel_arr[0]+",";
				sel_mallid += sel_arr[1]+",";
			}
		});

		$.ajax({
			url     : '/admin/purchase/ajax.php',
			data    : {
				'mode' : 'prd_sel_cart',
				'sel_prdcode' : sel_prdcode,
				'sel_mallid' : sel_mallid
			},
			dataType: 'text',
			type    : 'POST',
			async: false,
			success : function(data){

				alert(data);

				// 장바구니 레이어 팝업
				cart_list();
				var $cartPop = $('.cart-pop-wrap');
				$cartPop.show();
				$cartPop.removeClass('on');
				$('.bg').show();

			}
		});

	}
}

function sel_buy() {
	if(!$(".chk_1").is(":checked")) {
		alert("상품을 선택해주세요.");
	} else {

		var sel_prdcode = "";
		var sel_mallid = "";

		$(".chk_1").each(function(){
			if($(this).is(":checked")) {
				var sel_arr = this.value.split("_");
				sel_prdcode += sel_arr[0]+",";
				sel_mallid += sel_arr[1]+",";
			}
		});
		
		$.ajax({
			url     : '/admin/purchase/ajax.php',
			data    : {
				'mode' : 'prd_sel_buy',
				'sel_prdcode' : sel_prdcode,
				'sel_mallid' : sel_mallid
			},
			dataType: 'text',
			type    : 'POST',
			async: false,
			success : function(data){
				
				// 주문 상세
				buy_view(data);
				var $buyPop = $('.buy-pop-wrap');
				$buyPop.show();
				$buyPop.removeClass('on');
				$('.bg').show();

			}
		});

	}
}
</script>

<? include $_SERVER['DOCUMENT_ROOT'].'/admin/purchase/prd_view.php'; //상품 상세 레이어팝업 마크업 있는 경로 ?>

<? //include $_SERVER['DOCUMENT_ROOT'].'/admin/purchase/prd_buy.php'; //상품구매창 레이어팝업 마크업 있는 경로 ?>

<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php'; ?>