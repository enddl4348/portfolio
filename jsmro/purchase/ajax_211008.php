<?
include_once $_SERVER["DOCUMENT_ROOT"]."/inc/common.inc";
include_once $_SERVER["DOCUMENT_ROOT"]."/inc/util.inc";
include_once $_SERVER["DOCUMENT_ROOT"]."/js/json.php";

// 상품상세
if($_POST['mode'] == "prd_view") {

	if(!empty($wiz_admin['depart_code'])) $depart_sql = "wpm.memdepart = '".substr($wiz_admin['depart_code'], 0, 2)."0000' AND";

	$sql = "SELECT wp.*, wpm.memprice, wpm.mallid, wm.com_name
			FROM wiz_product wp
				INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
				INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
				INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
			WHERE $depart_sql wp.dell_check != 'DELL' AND wp.prdcode = '$prdcode' AND wpm.mallid = '$mallid'";
	$result	= mysql_query($sql) or error(mysql_error());
	$row = mysql_fetch_assoc($result);

	if($row['min_amount'] > 0) $amount = $row['min_amount'];
	else $amount = 1;

	$total_price = $row['memprice'] * $amount;
?>
	<div class="prd-vw-btn pop-btn">
		<button type="button" class="view-all"></button>
		<button type="button" class="cls-pop"></button>
	</div>

	<div class="prd-vw-pop">
		<section class="prd-view-top clearfix">
			<div class="prd-opt-sect clearfix">
				<div class="prd-img-wrap">
					<div class="big-img">
					<?
					for($i=1; $i<=5; $i++) {
						if(is_file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$row['prdimg_M'.$i])) {
							echo "<img src='/data/prdimg/".$row['prdimg_M'.$i]."' alt='".$row['prdname'].$i."' style='width:100%'>";
						}
					}
					?>
					</div>
					<div class="thumb-img clearfix">
					<?
					for($i=1; $i<=5; $i++) {
						if(is_file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$row['prdimg_S'.$i])) {
							echo "<span><img src='/data/prdimg/".$row['prdimg_S'.$i]."' alt='".$row['prdname'].$i."'></span>";
						}
					}
					?>
					</div>
				</div>
				<div class="prd-option">
					<strong class="prd-name"><?=$row['prdname']?></strong>
					<ul class="opt-list">
						<li><span class="opt-tit">상품코드</span><strong><?=$row['prdcode']?></strong></li>
						<li><span class="opt-tit">구매가</span><strong><?=number_format($row['memprice'])?> 원</strong></li>
						<li><span class="opt-tit">공급사</span><strong><?=$row['com_name']?></strong></li>
						<li><span class="opt-tit">모델명</span><strong><?=$row['model_name']?></strong></li>
						<li><span class="opt-tit">사양</span><strong><?=$row['spec']?></strong></li>
						<li><span class="opt-tit">포장단위</span><strong><?=$row['packing']?> <?=$row['packing_unit']?>/<?=$row['packing_unit2']?></strong></li>
						<li><span class="opt-tit">주문단위</span><strong><?=$row['order_unit']?></strong></li>
						<li><span class="opt-tit">제조사</span><strong><?=$row['maker']?></strong></li>
						<li><span class="opt-tit">최소주문수량</span><strong><?=$row['min_amount']?></strong></li>
						<li><span class="opt-tit">최소납기일</span><strong><?=$row['min_date']?>일</strong></li>
					</ul>
				</div> <!-- //prd-option -->
			</div> <!-- //prd-opt-sect -->
			<div class="prd-buy-sect">
				<div class="amnt-box">
					<span class="prd-name"><?=$row['prdname']?></span>
					<p class="num-box">
						<button type="button" class="minus" onclick="view_amout_down();"><img src="/admin/img/ico/minus.png" alt=""></button>
						<span class="amnt-num" id="view_amount_text"><?=$amount?></span>
						<button type="button" class="" onclick="view_amout_up();"><img src="/admin/img/ico/plus.png" alt=""></button>
					</p>
					<!--<strong class="prd-prc"><em class="view_total_price_text"><?=number_format($row['memprice'])?></em> 원</strong>-->
					<strong class="prd-prc"><em class="view_total_price_text"><?=number_format($row['memprice'])?></em> 원</strong>
				</div>
				<dl class="cmn__all-prc clearfix">
					<dt>총 구매 금액</dt>
					<dd><em class="view_total_price_text"><?=number_format($total_price)?></em> 원</dd>
				</dl>

				<input type="hidden" name="view_min_amount" value="<?=$row['min_amount']?>">
				<input type="hidden" name="view_amount" value="<?=$amount?>">
				<input type="hidden" name="view_price" value="<?=$row['memprice']?>">
				<input type="hidden" name="view_total_price" value="<?=$row['memprice']?>">

				<div class="cmn__prd-btn">
					<button type="button" class="wish"> <img src="/admin/img/ico/wish.png" alt="찜하기 아이콘"> </button>
					<button type="button" class="cart" onclick="prd_view_cart('<?=$row['prdcode']?>', '<?=$row['mallid']?>');">장바구니 담기</button>
					<? if($wiz_admin['approval_buy'] == "N") { ?>
					<button class="req-btn" onclick="prd_view_buy('<?=$row['prdcode']?>', '<?=$row['mallid']?>');">구매하기</button>
					<? } else { ?>
					<button class="req-btn" onclick="prd_view_buy('<?=$row['prdcode']?>', '<?=$row['mallid']?>');">승인요청</button>
					<? } ?>
				</div>
			</div> <!-- //prd-buy-sect -->
		</section>
		<section class="prd-view-btm">
			<h4 class="tit">상품 상세 설명</h4>
			<!--div class="prd-img">
				<img src="/admin/img/sub/view_prd.png" alt="상품이미지">
			</div-->
			<p class="prd-desc"><?=$row['content']?></p>
		</section>
	</div>

	<script>
	$(function(){

		// 상품 뷰 레이어 팝업
		var $prdVBtn = $('.prd-list-type .detail');
		var $prdVPop = $('.prd-vw-wrap');
		var $prdviewClose = $prdVPop.find('.cls-pop');
		var $prdviewAll = $prdVPop.find('.view-all');

		$prdVBtn.click(function(){
			$prdVPop.show();
			$prdVPop.removeClass('on');
			$('.bg').show();
		});

		$prdviewClose.click(function(){
			$prdVPop.hide();
			$('.bg').hide();
		});

		$prdviewAll.click(function(){
			$prdVPop.toggleClass('on');
		});

		// 상품 뷰 이미지 호버
		var $prdBigimg = $('.prd-view-top .big-img > img');
		var $prdTmbimg = $('.prd-view-top .thumb-img > span');

		$prdBigimg.eq(0).show().siblings().hide();

		$prdTmbimg.mouseenter(function(){
			var idx = $(this).index();
			$prdBigimg.eq(idx).show().siblings().hide();
		});

	});
	</script>
<?

// 상품 상세 장바구니 담기
} else if($_POST['mode'] == "prd_view_cart") {

	if(!empty($wiz_admin['depart_code'])) $depart_sql = "wpm.memdepart = '".substr($wiz_admin['depart_code'], 0, 2)."0000' AND";

	$sql = "SELECT wp.*, wpm.memprice, wpm.mallid, wm.com_name
			FROM wiz_product wp
				INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
				INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
				INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
			WHERE $depart_sql wp.dell_check != 'DELL' AND wp.prdcode = '$prdcode' AND wpm.mallid = '$mallid'";
	$result	= mysql_query($sql) or error(mysql_error());
	$row = mysql_fetch_assoc($result);

	// 같은상품
	$bt_sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' AND prdcode = '$prdcode' AND mallid = '".$mallid."'";
	$bt_result	= mysql_query($bt_sql) or error(mysql_error());
	if($bt_row = mysql_fetch_assoc($bt_result)) {
		$message = "이미 있는 상품입니다.";
	} else {

		$sql = "INSERT INTO wiz_basket_tmp SET
					sid = '".$SID."',
					uniq_id = '".$wiz_admin['id']."',
					prdcode = '".$prdcode."',
					prdname = '".$row['prdname']."',
					prdimg = '".$row['prdimg_R']."',
					prdprice = '".$row['memprice']."',
					amount = '".$view_amount."',
					wdate = now(),
					mallid = '".$mallid."',
					mallname = '".$row['com_name']."'";
		mysql_query($sql) or error(mysql_error());

		$message = "장바구니에 담겼습니다.";

	}

	echo $message;

// 해당 상품 장바구니 담기
} else if($_POST['mode'] == "prd_cart") {

	if(!empty($wiz_admin['depart_code'])) $depart_sql = "wpm.memdepart = '".substr($wiz_admin['depart_code'], 0, 2)."0000' AND";

	$sql = "SELECT wp.*, wpm.memprice, wpm.mallid, wm.com_name
			FROM wiz_product wp
				INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
				INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
				INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
			WHERE $depart_sql wp.dell_check != 'DELL' AND wp.prdcode = '$prdcode' AND wpm.mallid = '$mallid'";
	$result	= mysql_query($sql) or error(mysql_error());
	$row = mysql_fetch_assoc($result);

	// 같은상품
	$bt_sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' AND prdcode = '$prdcode' AND mallid = '".$mallid."'";
	$bt_result	= mysql_query($bt_sql) or error(mysql_error());
	if($bt_row = mysql_fetch_assoc($bt_result)) {
		$message = "이미 있는 상품입니다.";
	} else {

		if($row['min_amount'] > 0) $amount = $row['min_amount'];
		else $amount = 1;

		$sql = "INSERT INTO wiz_basket_tmp SET
					sid = '".$SID."',
					uniq_id = '".$wiz_admin['id']."',
					prdcode = '".$prdcode."',
					prdname = '".$row['prdname']."',
					prdimg = '".$row['prdimg_R']."',
					prdprice = '".$row['memprice']."',
					amount = '".$amount."',
					wdate = now(),
					mallid = '".$mallid."',
					mallname = '".$row['com_name']."'";
		mysql_query($sql) or error(mysql_error());

		$message = "장바구니에 담겼습니다.";

	}

	echo $message;

// 선택 상품 장바구니 담기
} else if($_POST['mode'] == "prd_sel_cart") {
	
	$sel_prdcode = substr($sel_prdcode, 0, -1);
	$sel_prdcode = explode(",", $sel_prdcode);

	$sel_mallid = substr($sel_mallid, 0, -1);
	$sel_mallid = explode(",", $sel_mallid);
	
	for($i=0; $i<count($sel_prdcode); $i++) {

		$prdcode = $sel_prdcode[$i];
		$mallid = $sel_mallid[$i];

		if(!empty($wiz_admin['depart_code'])) $depart_sql = "wpm.memdepart = '".substr($wiz_admin['depart_code'], 0, 2)."0000' AND";

		$sql = "SELECT wp.*, wpm.memprice, wpm.mallid, wm.com_name
				FROM wiz_product wp
					INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
					INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
					INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
				WHERE $depart_sql wp.dell_check != 'DELL' AND wp.prdcode = '$prdcode' AND wpm.mallid = '$mallid'";
		$result	= mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_assoc($result);

		// 같은상품
		$bt_sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' AND prdcode = '$prdcode' AND mallid = '".$mallid."'";
		$bt_result	= mysql_query($bt_sql) or error(mysql_error());
		if($bt_row = mysql_fetch_assoc($bt_result)) {
		} else {

			if($row['min_amount'] > 0) $amount = $row['min_amount'];
			else $amount = 1;

			$sql = "INSERT INTO wiz_basket_tmp SET
						sid = '".$SID."',
						uniq_id = '".$wiz_admin['id']."',
						prdcode = '".$prdcode."',
						prdname = '".$row['prdname']."',
						prdimg = '".$row['prdimg_R']."',
						prdprice = '".$row['memprice']."',
						amount = '".$amount."',
						wdate = now(),
						mallid = '".$mallid."',
						mallname = '".$row['com_name']."'";
			mysql_query($sql) or error(mysql_error());

		}
	}

	$message = "장바구니에 담겼습니다.";

	echo $message;

// 장바구니 리스트
} else if($_POST['mode'] == "cart_list") {

	$cart_sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' order by wdate desc";
	$cart_result = mysql_query($cart_sql) or error(mysql_error());
	$cart_total = mysql_num_rows($cart_result);
?>
	<h4 class="pop-tit">장바구니 <span class="cart-num"><?=$cart_total?></span> </h4> 
	<div class="cart-inner clearfix">
		<section class="cart-list-sect">
			<p class="cart_chk-opt">
				<input type="checkbox" id="all-selct" onclick="cart_sel_all();"/>
				<label for="all-selct">전체선택</label>
				<button type="button" class="selt-del" onclick="cart_sel_delete();">선택상품 삭제</button>
			</p>
			<?
			$cart_total_price = 0;
			$mall_no = 0;
			$mall_sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' group by mallid";
			$mall_result = mysql_query($mall_sql) or error(mysql_error());
			while($mall_row = mysql_fetch_assoc($mall_result)) {
			?>
				<?if($mall_no > 0) echo "<br>";?>
				<table class="cart__list">
					<thead>
						<tr class="list_top">
							<td colspan="6">
								<input type="checkbox" id="all_<?=$mall_row['mallid']?>" class="chk_all" onclick="cart_sel_mall('<?=$mall_row['mallid']?>');"/>
								<strong><?=$mall_row['mallname']?></strong>
							</td>
						</tr>
					</thead>
					<tbody>
					<?
					$mall_total_price = 0;
					$cart_sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' AND mallid = '".$mall_row['mallid']."' order by wdate desc";
					$cart_result = mysql_query($cart_sql) or error(mysql_error());
					while($cart_row = mysql_fetch_assoc($cart_result)) {
						$mall_total_price += $cart_row['prdprice'] * $cart_row['amount'];

						if(is_file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$cart_row['prdimg']))	$cart_row['prdimg'] = "/data/prdimg/".$cart_row['prdimg'];
						else																		$cart_row['prdimg'] = "/images/noimage.gif";
					?>
						<tr class="cart__list-item">
							<td width="58px" class="chk">
								<input type="checkbox" value="<?=$cart_row['idx']?>" class="cart_idx chk_all chk_<?=$mall_row['mallid']?>" />
							</td>
							<td width="93px">
								<div class="prd-img">
									<img src="<?=$cart_row['prdimg']?>" alt="<?=$cart_row['prdname']?>">
								</div>
							</td>
							<td class="prd-name" width="308px">
								<a href=""><?=$cart_row['prdname']?></a> 
							</td>
							<td class="amnt-box">
								<div class="num-box">
									<button type="button" class="minus" onclick="cart_amout_down('<?=$cart_row['idx']?>');"><img src="/admin/img/ico/minus.png" alt=""></button>
									<span class="amnt-num" id="cart_amout_text_<?=$cart_row['idx']?>"><?=$cart_row['amount']?></span>
									<button type="button" class="" onclick="cart_amout_up('<?=$cart_row['idx']?>');"><img src="/admin/img/ico/plus.png" alt=""></button>
								</div>
							</td>
							<td class="prd-prc" width="136px">
								<em id="cart_price_text_<?=$cart_row['idx']?>"><?=number_format($cart_row['prdprice'] * $cart_row['amount'])?></em> 원
							</td>
							<td width="58px" class="del-btn">
								<button type="button" onclick="cart_delete('<?=$cart_row['idx']?>');"><img src="/admin/img/ico/cart-del.png" alt="제품 삭제버튼"></button>
							</td>
						</tr>
					<? } ?>
					</tbody>

					<tfoot>
						<tr class="list_btm">
							<td colspan="6" class="prc-sect">
								<span>총 구매금액</span>
								<strong class="all-prc"><em class="cart_total_price_text"><?=number_format($mall_total_price)?></em> 원</strong>
							</td>
						</tr>
					</tfoot>
				</table>
			<?
				$cart_total_price += $mall_total_price;
				$mall_no++;
			}
			?>
		</section>

		<section class="cart-prc-sect cmn-prd-btn">
			<strong>전체 합계</strong>
			<dl class="cmn__all-prc clearfix">
				<dt>총 구매 금액</dt>
				<dd><em class="cart_total_price_text"><?=number_format($cart_total_price)?></em> 원</dd>
			</dl>
			<? if($wiz_admin['approval_buy'] == "N") { ?>
			<button class="req-btn" onclick="cart_sel_buy_view();">구매하기</button>
			<? } else { ?>
			<button class="req-btn" onclick="cart_sel_buy_view();">승인요청</button>
			<? } ?>
		</section>
	</div>
<?

// 장바구니 수량
} else if($_POST['mode'] == "cart_amout") {

	if($sub_mode == "up") {

		$sql = "SELECT * FROM wiz_basket_tmp WHERE idx = '$idx'";
		$result	= mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_assoc($result);

		$amount = $row['amount'] + 1;

		$sql = "UPDATE wiz_basket_tmp SET amount = '$amount' WHERE idx = '$idx'";
		mysql_query($sql) or error(mysql_error());

		$data->amount = $amount;
		echo json_encode($data);
		exit;

	} else if($sub_mode == "down") {

		$sql = "SELECT * FROM wiz_basket_tmp WHERE idx = '$idx'";
		$result	= mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_assoc($result);

		$amount = $row['amount'] - 1;

		$prd_sql = "SELECT * FROM wiz_product WHERE prdcode = '".$row['prdcode']."'";
		$prd_result	= mysql_query($prd_sql) or error(mysql_error());
		$prd_row = mysql_fetch_assoc($prd_result);

		if($prd_row['min_amount'] > 0 && $prd_row['min_amount'] > $amount) {
			$data->message = "최소 주문수량보다 적습니다.";
		} else {

			$data->message = "";

			if($amount > 0) {
				$sql = "UPDATE wiz_basket_tmp SET amount = '$amount' WHERE idx = '$idx'";
				mysql_query($sql) or error(mysql_error());
			}

		}
		
		$data->amount = $amount;
		echo json_encode($data);
		exit;

	}

// 장바구니 삭제
} else if($_POST['mode'] == "cart_delete") {

	$sql = "DELETE FROM wiz_basket_tmp WHERE idx = '$idx'";
	mysql_query($sql) or error(mysql_error());

// 장바구니 선택 삭제
} else if($_POST['mode'] == "cart_sel_delete") {

	$sel_idx = substr($sel_idx, 0, -1);
	$sel_idx = explode(",", $sel_idx);
	
	foreach($sel_idx as $idx) {
		$sql = "DELETE FROM wiz_basket_tmp WHERE idx = '$idx'";
		mysql_query($sql) or error(mysql_error());
	}

// 상품상세 주문
} else if($_POST['mode'] == "prd_view_buy") {

	if(!empty($wiz_admin['depart_code'])) $depart_sql = "wpm.memdepart = '".substr($wiz_admin['depart_code'], 0, 2)."0000' AND";

	$sql = "SELECT wp.*, wpm.memprice, wpm.mallid, wm.com_name
			FROM wiz_product wp
				INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
				INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
				INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
			WHERE $depart_sql wp.dell_check != 'DELL' AND wp.prdcode = '$prdcode' AND wpm.mallid = '$mallid'";
	$result	= mysql_query($sql) or error(mysql_error());
	$row = mysql_fetch_assoc($result);

	// 같은상품
	$bt_sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' AND prdcode = '$prdcode' AND mallid = '".$mallid."'";
	$bt_result	= mysql_query($bt_sql) or error(mysql_error());
	if($bt_row = mysql_fetch_assoc($bt_result)) {
		$sql = "UPDATE wiz_basket_tmp SET amount = '".$view_amount."' WHERE idx = '".$row['idx']."'";
		mysql_query($sql) or error(mysql_error());
	} else {

		$sql = "INSERT INTO wiz_basket_tmp SET
					sid = '".$SID."',
					uniq_id = '".$wiz_admin['id']."',
					prdcode = '".$prdcode."',
					prdname = '".$row['prdname']."',
					prdimg = '".$row['prdimg_R']."',
					prdprice = '".$row['memprice']."',
					amount = '".$view_amount."',
					wdate = now(),
					mallid = '".$mallid."',
					mallname = '".$row['com_name']."'";
		mysql_query($sql) or error(mysql_error());

	}

	$sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '$SID' AND prdcode = '$prdcode' AND mallid = '$mallid'";
	$result	= mysql_query($sql) or error(mysql_error());
	$row = mysql_fetch_assoc($result);

	echo $row['idx'].",";

// 선택 상품 주문
} else if($_POST['mode'] == "prd_sel_buy") {

	$sel_prdcode = substr($sel_prdcode, 0, -1);
	$sel_prdcode = explode(",", $sel_prdcode);

	$sel_mallid = substr($sel_mallid, 0, -1);
	$sel_mallid = explode(",", $sel_mallid);

	$sel_idx = "";
	
	for($i=0; $i<count($sel_prdcode); $i++) {

		$prdcode = $sel_prdcode[$i];
		$mallid = $sel_mallid[$i];

		if(!empty($wiz_admin['depart_code'])) $depart_sql = "wpm.memdepart = '".substr($wiz_admin['depart_code'], 0, 2)."0000' AND";

		$sql = "SELECT wp.*, wpm.memprice, wpm.mallid, wm.com_name
				FROM wiz_product wp
					INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
					INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
					INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
				WHERE $depart_sql wp.dell_check != 'DELL' AND wp.prdcode = '$prdcode' AND wpm.mallid = '$mallid'";
		$result	= mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_assoc($result);

		// 같은상품
		$bt_sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' AND prdcode = '$prdcode' AND mallid = '".$mallid."'";
		$bt_result	= mysql_query($bt_sql) or error(mysql_error());
		if($bt_row = mysql_fetch_assoc($bt_result)) {
			$sql = "UPDATE wiz_basket_tmp SET amount = '1' WHERE idx = '".$row['idx']."'";
			mysql_query($sql) or error(mysql_error());
		} else {

			$sql = "INSERT INTO wiz_basket_tmp SET
						sid = '".$SID."',
						uniq_id = '".$wiz_admin['id']."',
						prdcode = '".$prdcode."',
						prdname = '".$row['prdname']."',
						prdimg = '".$row['prdimg_R']."',
						prdprice = '".$row['memprice']."',
						amount = '1',
						wdate = now(),
						mallid = '".$mallid."',
						mallname = '".$row['com_name']."'";
			mysql_query($sql) or error(mysql_error());

		}

		$sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '$SID' AND prdcode = '$prdcode' AND mallid = '$mallid'";
		$result	= mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_assoc($result);
		$sel_idx .= $row['idx'].",";
	}

	echo $sel_idx;

// 주문 상세
} else if($_POST['mode'] == "buy_view") {

	$bk_idx = "";

	if($sel_idx != "") {
		$sel_idx = substr($sel_idx, 0, -1);
		$bk_idx = $sel_idx;
		$prd_sql = " AND idx in(".$sel_idx.")";
	}
	
	$sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' $prd_sql order by wdate desc";
	$result = mysql_query($sql) or error(mysql_error());
	$total = mysql_num_rows($result);

	if($wiz_admin['approval_buy'] == "N") {
		$buy_text = "구매하기";
	} else {
		$buy_text = "승인요청";
	}
?>
	<input type="hidden" name="sel_idx" value="<?=$bk_idx?>">
	<h4 class="pop-tit"><?=$buy_text?> <span class="cart-num"><?=$total?></span> </h4> 
	<div class="buy-inner clearfix">
		<section class="buy__prd-list">
			<div class="list-top_opt clearfix">
				<span class="prd-info">구매 상품 정보</span>
				<span class="prd-amnt">수량</span>
				<span class="prd-prc">제품 가격</span>
			</div> <!-- //list-top_opt -->

			<div class="list-wrap">
			<?
			$cart_total_price = 0;
			$mall_sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' $prd_sql group by mallid";
			$mall_result = mysql_query($mall_sql) or error(mysql_error());
			while($mall_row = mysql_fetch_assoc($mall_result)) {
			?>
				<div class="buy-list-item">
					<table class="cart__list">
						<thead>
							<tr class="list_top">
								<td colspan="4">
									<strong><?=$mall_row['mallname']?></strong>
								</td>
							</tr>
						</thead>
						<tbody>
						<?
						$mall_total_price = 0;
						$cart_sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$wiz_admin['id']."' AND sid = '".$SID."' AND mallid = '".$mall_row['mallid']."' $prd_sql order by wdate desc";
						$cart_result = mysql_query($cart_sql) or error(mysql_error());
						while($cart_row = mysql_fetch_assoc($cart_result)) {
							$mall_total_price += $cart_row['prdprice'] * $cart_row['amount'];

							if(is_file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$cart_row['prdimg']))	$cart_row['prdimg'] = "/data/prdimg/".$cart_row['prdimg'];
							else																		$cart_row['prdimg'] = "/images/noimage.gif";
						?>
							<tr class="cart__list-item">
								<td width="134px" class="img-wrap">
									<div class="prd-img">
										<img src="<?=$cart_row['prdimg']?>" alt="<?=$cart_row['prdname']?>">
									</div>
								</td>
								<td class="prd-name" width="310px">
									<a href=""><?=$cart_row['prdname']?></a>
								</td>
								<td width="152px" class="amnt"><?=$cart_row['amount']?></td>
								<td class="prd-prc" width="177px">
									<em><?=number_format($cart_row['prdprice'] * $cart_row['amount'])?></em> 원
								</td>
							</tr>
						<? } ?>
						</tbody>
						<tfoot>
							<tr class="list_btm">
								<td colspan="6" class="prc-sect">
									<span>총 구매금액</span>
									<strong class="all-prc"><em><?=number_format($mall_total_price)?></em> 원</strong>
								</td>
							</tr>
						</tfoot>
					</table>
					<div class="add-detail">
						<dl class="clearfix">
							<dt>납품 요청일</dt>
							<dd> <input type="text" name="del_date[<?=$mall_row['mallid']?>]" class="prd__datepicker" autocomplete="off"></dd>
						</dl>
						<dl class="clearfix">
							<dt>업체 요청사항</dt>
							<dd>
								<textarea name="com_request[<?=$mall_row['mallid']?>]" cols="30" rows="1"
								placeholder="요청사항을 입력해주세요 (예.물건 파손되지 않게 포장 잘 부탁드립니다)"></textarea>
							</dd>
						</dl>
					</div> <!-- //add-detail -->
				</div> <!-- //buy-list-item -->
			<?
				$cart_total_price += $mall_total_price;
			}
			?>
			</div> <!-- //list-wrap -->
		</section> <!-- //buy__prd-list -->
		<section class="buy-prc-sect cmn-prd-btn">
			<div class="dvey-info">
				<strong>배송 정보</strong>
				<dl class="delv-sect">
					<dt>배송지 선택</dt>
					<dd>
						<select name="" id="">
							<option value="">주문자와 동일</option>
						</select>
					</dd>
					<dt>수령자</dt>
					<dd><input type="text" name="name" placeholder="수령자 성명을 입력해 주세요."/></dd>
					<dt>연락처</dt>
					<dd><input type="text" name="hphone" placeholder="연락처를 입력해 주세요."/></dd>
					<dt>배송지 주소</dt>
					<dd>
						<p><input type="text" name="post" class="sm-input" onclick="zipSearch('');" readonly/> <button type="button" onclick="zipSearch('');">주소 찾기</button></p>
						<p><input type="text" name="address" onclick="zipSearch('');" readonly/></p>
						<p><input type="text" name="address2"  placeholder="상세주소를 입력해 주세요."/></p>
					</dd>
				</dl>
			</div>
			<div class="prd-sect">
				<strong>전체 합계</strong>
				<dl class="cmn__all-prc clearfix">
					<dt>총 구매 금액</dt>
					<dd><em><?=number_format($cart_total_price)?></em> 원</dd>
					<input type="hidden" name="total_price" value="<?=$cart_total_price?>">
				</dl>
				<button type="submit" class="req-btn"><?=$buy_text?></button>
			</div>
		</section> <!-- //buy-prc-sect -->
	</div>
	<!-- //buy-inner -->

	<script>
	$(".prd__datepicker").datepicker({
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
	</script>
<?

// 구매하기
} else if($_POST['mode'] == "order_save") {

	$de_sql = "select * from wiz_department where areacode = '".$wiz_admin['depart_code']."'";
	$de_result = mysql_query($de_sql) or error(mysql_error());
	$de_row = mysql_fetch_assoc($de_result);

	// 주문번호
	$orderid = date("ymdHis").rand(100,999);
	
	$idx_arr = explode(",", $sel_idx);

	foreach($idx_arr as $idx) {
		$sql = "SELECT * FROM wiz_basket_tmp WHERE idx = '$idx' AND uniq_id = '".$wiz_admin['id']."'";
		$result = mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_assoc($result);

		$sql = "INSERT INTO wiz_basket_tmp SET
					sid = '".$SID."',
					tmp_idx = '".$row['idx']."',
					orderid = '".$orderid."',
					prdcode = '".$row['prdcode']."',
					prdname = '".$row['prdname']."',
					prdimg = '".$row['prdimg']."',
					prdprice = '".$row['prdprice']."',
					amount = '".$row['amount']."',
					wdate = now(),
					mallid = '".$row['mallid']."',
					mall_name = '".$row['mallname']."',
					del_date = '".$del_date[$row['mallid']]."',
					com_request = '".$com_request[$row['mallid']]."'";
		//mysql_query($sql) or error(mysql_error());
	}

}
?>