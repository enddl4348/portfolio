<? include "../../inc/common.inc"; ?>
<? include "../../inc/util.inc"; ?>
<? include "../../inc/shop_info.inc"; ?>
<? include "../../inc/admin_check.inc"; ?>
<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php'; ?>


<? include "../../inc/popup.inc"; ?>


<? if($wiz_admin['level_value'] > 1) { ?>
	<div class="main__wrap">
		<section class="main__cmn-sect ord-manage">
			<h3 class="main__sec-tit">주문관리</h3>
			<table class="dash__cmn-tb">
				<thead>
					<tr>
						<th width="11%"><span><img src="/admin/img/ico/ord-ico.png" alt=""></span>승인대기</th>
						<th colspan="2"><span><img src="/admin/img/ico/ord-ico1.png" alt=""></span>발주(공급사 미접수)</th>
						<th colspan="2"><span><img src="/admin/img/ico/ord-ico2.png" alt=""></span>공급사 주문접수(미배송)</th>
						<th width="11%"><span><img src="/admin/img/ico/ord-ico3.png" alt=""></span>배송중</th>
						<th colspan="2"><span><img src="/admin/img/ico/ord-ico4.png" alt=""></span>배송완료(검수대기)</th>
						<th><span><img src="/admin/img/ico/ord-ico5.png" alt=""></span> <span class="vert-txt">입고완료 <br>(정산대기)</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td rowspan="2">
						<?
						// 승인대기
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.send_id = '".$wiz_admin['id']."' AND wo.status IN('AR', 'OA', 'TA')";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
						<td rowspan="2" width="11%">
						<?
						// 발주(공급사 미접수)
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.send_id = '".$wiz_admin['id']."' AND wo.status = 'OD'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
						<td class="sub-txt" width="11%">3일 초과</td>
						<td rowspan="2" width="11%">
						<?
						// 공급사 주문접수(미배송)
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.send_id = '".$wiz_admin['id']."' AND wo.status = 'OR'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
						<td class="sub-txt" width="11%">5일 초과</td>
						<td rowspan="2">
						<?
						// 배송중
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.send_id = '".$wiz_admin['id']."' AND wo.status = 'DR'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
						<td rowspan="2" width="11%">
						<?
						// 배송완료(검수대기)
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.send_id = '".$wiz_admin['id']."' AND wo.status = 'DC'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
						<td class="sub-txt" width="11%">3일 초과</td>
						<td rowspan="2">
						<?
						// 입고완료(정산대기)
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.send_id = '".$wiz_admin['id']."' AND wo.status = 'OW'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
					</tr>
					<tr class="over-num">
						<td>
						<?
						// 발주(공급사 미접수) 3일 초과
						$sql = "SELECT DATE_ADD(wo.order_date, INTERVAL 3 DAY) as over_date 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.send_id = '".$wiz_admin['id']."' AND wo.status = 'OD'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = 0;
						while($row = mysql_fetch_assoc($result)) {
							if(substr($row['over_date'], 0, 10) < date("Y-m-d")) $cnt++;
						}
						echo $cnt;
						?>
						</td>
						<td>
						<?
						// 공급사 주문접수(미배송) 5일 초과
						$sql = "SELECT DATE_ADD(wo.order_date, INTERVAL 3 DAY) as over_date 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.send_id = '".$wiz_admin['id']."' AND wo.status = 'OR'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = 0;
						while($row = mysql_fetch_assoc($result)) {
							if(substr($row['over_date'], 0, 10) < date("Y-m-d")) $cnt++;
						}
						echo $cnt;
						?>
						</td>
						<td>
						<?
						// 배송완료(검수대기) 3일 초과
						$sql = "SELECT DATE_ADD(wo.order_date, INTERVAL 3 DAY) as over_date 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.send_id = '".$wiz_admin['id']."' AND wo.status = 'DC'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = 0;
						while($row = mysql_fetch_assoc($result)) {
							if(substr($row['over_date'], 0, 10) < date("Y-m-d")) $cnt++;
						}
						echo $cnt;
						?>
						</td>
					</tr>
				</tbody>
			</table>
		</section> <!-- //ord-manage -->

		<section class="main__cmn-sect main__cont-md clearfix">
			<article class="dash_brd-list">
				<h3 class="main__sec-tit">구매자공지사항</h3>
				<ul class="board-wrap">
				<?
				$limit = 5;
				$sql = "select *, date_format(from_unixtime(wdate), '%Y-%m-%d') as wdate from wiz_bbs where sid='$SID' and code = 'notice_purc' order by idx desc limit $limit";
				$result = mysql_query($sql) or error(mysql_error());
				$total = mysql_num_rows($result);
				while($row = mysql_fetch_object($result)) {
				?>
					<li>
						<a href="../bbs/bbs_view.php?code=<?=$row->code?>&idx=<?=$row->idx?>" class="brd-tit"><?=cut_str($row->subject,20)?></a> 
						<a href="../bbs/bbs_view.php?code=<?=$row->code?>&idx=<?=$row->idx?>" class="date"><?=str_replace("-","/",$row->wdate)?></a>
					</li>
				<? } if($total <= 0) { ?>
					<li>등록된 게시물이 없습니다.</li>
				<? } ?>
				</ul>
			</article>

			<article class="new-reg-apply">
				<h3 class="main__sec-tit">신규 등록 요청</h3>
				<table class="dash__cmn-tb  dash__tb-b">
					<tr>
						<td rowspan="2" class="bg-b-tit">신규상품</td>
						<td class="sub-txt" width="206px">요청</td>
						<td class="sub-txt" width="206px">견적 진행</td>
						<td class="sub-txt" width="209px">등록 완료</td>
					</tr>
					<tr>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_prd' AND memid = '".$wiz_admin['id']."' AND status = '요청'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_prd' AND memid = '".$wiz_admin['id']."' AND status = '견적진행'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_prd' AND memid = '".$wiz_admin['id']."' AND status = '등록완료'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
					</tr>
					<tr>
						<td rowspan="2" class="bg-b-tit">신규공급사</td>
						<td class="sub-txt">요청</td>
						<td class="sub-txt">견적 진행</td>
						<td class="sub-txt">등록 완료</td>
					</tr>
					<tr>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_mall' AND memid = '".$wiz_admin['id']."' AND status = '요청'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_mall' AND memid = '".$wiz_admin['id']."' AND status = '견적진행'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_mall' AND memid = '".$wiz_admin['id']."' AND status = '등록완료'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
					</tr>
				</table>
			</article>
		</section> <!-- //main__cont-md -->

		<section class="main__cmn-sect clearfix">
			<article class="month-buy-status">
				<h3 class="main__sec-tit">구매 현황</h3>
				<div class="buy-status-wrap">
					<strong><em><?=date("m")?></em>월 구매 현황</strong>
					<div class="month-buy__prc">
						<p class="clearfix"><span><?=date("m")?>월 예산 금액</span> <strong><em class="red"><?=number_format(total_budget($wiz_admin['depart_code']))?></em> 원</strong></p>
						<p class="clearfix"><span>구매금액</span> <strong><em><?=number_format(total_order_budget($wiz_admin['depart_code']))?></em> 원</strong></p>
					</div>
					<div class="team-prc">
						<p class="clearfix"><span><?=$wiz_admin['sub_name']?> 구매금액</span> <strong> <em><?=number_format(total_order_budget($wiz_admin['depart_code']))?></em> 원</strong> </p>
					</div>
				</div>
			</article>

			<article class="buyer__lat-prd">
				<p class="lat_prd-tab">
					<button type="button" class="">최근 등록 상품</button>
					<button type="button" class="">최근 구매 상품</button>
				</p>
				<div class="latest-prd-wrap">
					<ul class="latest-reg-prd clearfix">
					<?
					if(!empty($wiz_admin['depart_code']))	$depart_sql	= "wpm.memdepart = '".substr($wiz_admin['depart_code'], 0, 2)."0000' AND";
					$sql = "SELECT wp.*, wpm.memprice, wpm.mallid, wm.com_name,
								(select catcode from wiz_cprelation where prdcode = wp.prdcode and catcode like '".$dep_code.$dep2_code.$dep3_code."%' limit 1) catcode
							FROM wiz_product wp
								INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
								INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
								INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
							WHERE $depart_sql wp.dell_check != 'DELL'
							ORDER BY wp.wdate DESC
							LIMIT 4";
					$result	= mysql_query($sql) or error(mysql_error());
					while($row = mysql_fetch_object($result)) {
						// 상품 이미지
						if(is_file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$row->prdimg_R))	$row->prdimg_R = "/data/prdimg/".$row->prdimg_R;
						else																$row->prdimg_R = "/images/noimage.gif";
					?>
						<li>
							<a href="/admin/purchase/purc_req.php?s_searchkey=<?=$row->prdname?>">
								<div class="prd-img">
									<img src="<?=$row->prdimg_R?>" alt="<?=$row->prdname?>"/>
								</div>
								<div class="prd-desc">
									<span class="prd-name"><?=$row->prdname?></span>
									<strong class="prd-prc"><em><?=number_format($row->memprice)?></em> 원</strong>
									<p class="option">
										<span><?=$row->com_name?></span>
										<span><?=$row->packing?> <?=$row->packing_unit?>/<?=$row->packing_unit2?></span>
										<span><?=$row->order_unit?></span>
									</p>
								</div>
							</a>
						</li>
					<? } ?>
					</ul>

					<ul class="latest-buy-prd clearfix">
					<?
					$sql = "SELECT wp.*, wpm.memprice, wb.prdprice, wm.com_name 
							FROM wiz_order wo
								INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid
								INNER JOIN wiz_product wp ON wp.prdcode = wb.prdcode
								INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
								INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
								INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
							WHERE wo.send_id = '".$wiz_admin['id']."'
							ORDER BY wo.order_date DESC, wb.idx DESC
							LIMIT 4";
					$result	= mysql_query($sql) or error(mysql_error());
					while($row = mysql_fetch_object($result)) {
						// 상품 이미지
						if(is_file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$row->prdimg_R))	$row->prdimg_R = "/data/prdimg/".$row->prdimg_R;
						else
					?>
						<li>
							<a href="/admin/purchase/purc_req.php?s_searchkey=<?=$row->prdname?>">
								<div class="prd-img">
									<img src="<?=$row->prdimg_R?>" alt="<?=$row->prdname?>"/>
								</div>
								<div class="prd-desc">
									<span class="prd-name"><?=$row->prdname?></span>
									<strong class="prd-prc"><em><?=number_format($row->memprice)?></em> 원</strong>
									<p class="option">
										<span><?=$row->com_name?></span>
										<span><?=$row->packing?> <?=$row->packing_unit?>/<?=$row->packing_unit2?></span>
										<span><?=$row->order_unit?></span>
									</p>
								</div>
							</a>
						</li>
					<? } ?>
					</ul>
				</div>
			</article>
		</section>
	</div><!--  //main__wrap -->
<? } else { ?>
	<div class="main__wrap">
		<section class="main__cmn-sect ord-manage">
			<h3 class="main__sec-tit">주문관리</h3>
			<table class="dash__cmn-tb">
				<thead>
					<tr>
						<th width="11%"><span><img src="/admin/img/ico/ord-ico.png" alt=""></span>승인대기</th>
						<th colspan="2"><span><img src="/admin/img/ico/ord-ico1.png" alt=""></span>발주(공급사 미접수)</th>
						<th colspan="2"><span><img src="/admin/img/ico/ord-ico2.png" alt=""></span>공급사 주문접수(미배송)</th>
						<th width="11%"><span><img src="/admin/img/ico/ord-ico3.png" alt=""></span>배송중</th>
						<th colspan="2"><span><img src="/admin/img/ico/ord-ico4.png" alt=""></span>배송완료(검수대기)</th>
						<th><span><img src="/admin/img/ico/ord-ico5.png" alt=""></span> <span class="vert-txt">입고완료 <br>(정산대기)</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td rowspan="2">
						<?
						// 승인대기
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND wo.status IN('AR', 'OA', 'TA')";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
						<td rowspan="2" width="11%">
						<?
						// 발주(공급사 미접수)
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND wo.status = 'OD'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
						<td class="sub-txt" width="11%">3일 초과</td>
						<td rowspan="2" width="11%">
						<?
						// 공급사 주문접수(미배송)
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND wo.status = 'OR'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
						<td class="sub-txt" width="11%">5일 초과</td>
						<td rowspan="2">
						<?
						// 배송중
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND wo.status = 'DR'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
						<td rowspan="2" width="11%">
						<?
						// 배송완료(검수대기)
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND wo.status = 'DC'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
						<td class="sub-txt" width="11%">3일 초과</td>
						<td rowspan="2">
						<?
						// 입고완료(정산대기)
						$sql = "SELECT wo.* 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND wo.status = 'OW'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = mysql_num_rows($result);
						echo $cnt;
						?>
						</td>
					</tr>
					<tr class="over-num">
						<td>
						<?
						// 발주(공급사 미접수) 3일 초과
						$sql = "SELECT DATE_ADD(wo.order_date, INTERVAL 3 DAY) as over_date 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND wo.status = 'OD'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = 0;
						while($row = mysql_fetch_assoc($result)) {
							if(substr($row['over_date'], 0, 10) < date("Y-m-d")) $cnt++;
						}
						echo $cnt;
						?>
						</td>
						<td>
						<?
						// 공급사 주문접수(미배송) 5일 초과
						$sql = "SELECT DATE_ADD(wo.order_date, INTERVAL 3 DAY) as over_date 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND wo.status = 'OR'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = 0;
						while($row = mysql_fetch_assoc($result)) {
							if(substr($row['over_date'], 0, 10) < date("Y-m-d")) $cnt++;
						}
						echo $cnt;
						?>
						</td>
						<td>
						<?
						// 배송완료(검수대기) 3일 초과
						$sql = "SELECT DATE_ADD(wo.order_date, INTERVAL 3 DAY) as over_date 
								FROM wiz_order wo 
									INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid 
								WHERE wo.depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND wo.status = 'DC'";
						$result = mysql_query($sql) or error(mysql_error());
						$cnt = 0;
						while($row = mysql_fetch_assoc($result)) {
							if(substr($row['over_date'], 0, 10) < date("Y-m-d")) $cnt++;
						}
						echo $cnt;
						?>
						</td>
					</tr>
				</tbody>
			</table>
		</section> <!-- //ord-manage -->

		<section class="main__cmn-sect main__cont-md clearfix">
			<article class="dash_brd-list">
				<h3 class="main__sec-tit">구매자공지사항</h3>
				<ul class="board-wrap">
				<?
				$limit = 5;
				$sql = "select *, date_format(from_unixtime(wdate), '%Y-%m-%d') as wdate from wiz_bbs where sid='$SID' and code = 'notice_purc' order by idx desc limit $limit";
				$result = mysql_query($sql) or error(mysql_error());
				$total = mysql_num_rows($result);
				while($row = mysql_fetch_object($result)) {
				?>
					<li>
						<a href="../bbs/bbs_view.php?code=<?=$row->code?>&idx=<?=$row->idx?>" class="brd-tit"><?=cut_str($row->subject,20)?></a> 
						<a href="../bbs/bbs_view.php?code=<?=$row->code?>&idx=<?=$row->idx?>" class="date"><?=str_replace("-","/",$row->wdate)?></a>
					</li>
				<? } if($total <= 0) { ?>
					<li>등록된 게시물이 없습니다.</li>
				<? } ?>
				</ul>
			</article>

			<article class="new-reg-apply">
				<h3 class="main__sec-tit">신규 등록 요청</h3>
				<table class="dash__cmn-tb  dash__tb-b">
					<tr>
						<td rowspan="2" class="bg-b-tit">신규상품</td>
						<td class="sub-txt" width="206px">요청</td>
						<td class="sub-txt" width="206px">견적 진행</td>
						<td class="sub-txt" width="209px">등록 완료</td>
					</tr>
					<tr>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_prd' AND depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND status = '요청'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_prd' AND depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND status = '견적진행'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_prd' AND depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND status = '등록완료'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
					</tr>
					<tr>
						<td rowspan="2" class="bg-b-tit">신규공급사</td>
						<td class="sub-txt">요청</td>
						<td class="sub-txt">견적 진행</td>
						<td class="sub-txt">등록 완료</td>
					</tr>
					<tr>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_mall' AND depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND status = '요청'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_mall' AND depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND status = '견적진행'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
						<td>
						<?
						$sql = "SELECT * FROM wiz_bbs WHERE code = 'new_mall' AND depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND status = '등록완료'";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						echo $total;
						?>
						</td>
					</tr>
				</table>
			</article>
		</section> <!-- //main__cont-md -->

		<?
		$sql = "SELECT * FROM wiz_department WHERE areacode LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND depthno = 1";
		$result = mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_assoc($result);
		$total_budget = $row['budget'];

		$sdate = date("Y-m-d", mktime(0,0,0,date(m),1,date(Y)))." 00:00:00";
		$edate = date("Y-m-t",strtotime(date("Y-m-d")))." 23:59:59";

		$dep_name = array();
		$dep_order_budget = array();

		$order_total = 0;

		$sql = "SELECT * FROM wiz_department WHERE areacode LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%' AND depthno = 3 ORDER BY areacode ASC";
		$result = mysql_query($sql) or error(mysql_error());
		while($row = mysql_fetch_assoc($result)) {
			$sql2 = "SELECT SUM(total_price) as order_total FROM wiz_order WHERE depart_code = '".$row['areacode']."' AND order_date >= '$sdate' AND order_date <= '$edate'";
			$result2 = mysql_query($sql2) or error(mysql_error());
			$row2 = mysql_fetch_assoc($result2);
			$order_total += $row2['order_total'];

			array_push($dep_name, $row['sub_name']);
			array_push($dep_order_budget, $row2['order_total']);
		}
		?>

		<section class="main__cmn-sect clearfix">
			<article class="month-buy-status">
				<h3 class="main__sec-tit">구매 현황</h3>
				<div class="buy-status-wrap">
					<strong><em><?=date("m")?></em>월 구매 현황</strong>
					<div class="month-buy__prc">
						<p class="clearfix"><span><?=date("m")?>월 예산 금액</span> <strong><em class="red"><?=number_format($total_budget)?></em> 원</strong></p>
						<p class="clearfix"><span>구매금액</span> <strong><em><?=number_format(total_order_budget($wiz_admin['depart_code']))?></em> 원</strong></p>
					</div>
					<div class="team-prc">
					<? for($i=0; $i<count($dep_name); $i++) { ?>
						<p class="clearfix"><span><?=$dep_name[$i]?> 구매금액</span> <strong> <em><?=number_format($dep_order_budget[$i])?></em> 원</strong> </p>
					<? } ?>
					</div>
				</div>
			</article>

			<article class="buyer__lat-prd">
				<p class="lat_prd-tab">
					<button type="button" class="">최근 등록 상품</button>
					<button type="button" class="">최근 구매 상품</button>
				</p>
				<div class="latest-prd-wrap">
					<ul class="latest-reg-prd clearfix">
					<?
					if(!empty($wiz_admin['depart_code']))	$depart_sql	= "wpm.memdepart = '".substr($wiz_admin['depart_code'], 0, 2)."0000' AND";
					$sql = "SELECT wp.*, wpm.memprice, wpm.mallid, wm.com_name,
								(select catcode from wiz_cprelation where prdcode = wp.prdcode and catcode like '".$dep_code.$dep2_code.$dep3_code."%' limit 1) catcode
							FROM wiz_product wp
								INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
								INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
								INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
							WHERE $depart_sql wp.dell_check != 'DELL'
							ORDER BY wp.wdate DESC
							LIMIT 4";
					$result	= mysql_query($sql) or error(mysql_error());
					while($row = mysql_fetch_object($result)) {
						// 상품 이미지
						if(is_file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$row->prdimg_R))	$row->prdimg_R = "/data/prdimg/".$row->prdimg_R;
						else																$row->prdimg_R = "/images/noimage.gif";
					?>
						<li>
							<a href="/admin/purchase/purc_req.php?s_searchkey=<?=$row->prdname?>">
								<div class="prd-img">
									<img src="<?=$row->prdimg_R?>" alt="<?=$row->prdname?>"/>
								</div>
								<div class="prd-desc">
									<span class="prd-name"><?=$row->prdname?></span>
									<strong class="prd-prc"><em><?=number_format($row->memprice)?></em> 원</strong>
									<p class="option">
										<span><?=$row->com_name?></span>
										<span><?=$row->packing?> <?=$row->packing_unit?>/<?=$row->packing_unit2?></span>
										<span><?=$row->order_unit?></span>
									</p>
								</div>
							</a>
						</li>
					<? } ?>
					</ul>

					<ul class="latest-buy-prd clearfix">
					<?
					$sql = "SELECT wp.*, wpm.memprice, wb.prdprice, wm.com_name 
							FROM wiz_order wo
								INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid
								INNER JOIN wiz_product wp ON wp.prdcode = wb.prdcode
								INNER JOIN wiz_product_memprice wpm ON wp.prdcode = wpm.prdcode
								INNER JOIN wiz_mall wm ON wpm.mallid = wm.id
								INNER JOIN wiz_department wd ON wpm.memdepart = wd.areacode
							WHERE wo.depart_code LIKE '".substr($wiz_admin['depart_code'], 0, 2)."%'
							ORDER BY wo.order_date DESC, wb.idx DESC
							LIMIT 4";
					$result	= mysql_query($sql) or error(mysql_error());
					while($row = mysql_fetch_object($result)) {
						// 상품 이미지
						if(is_file($_SERVER[DOCUMENT_ROOT]."/data/prdimg/".$row->prdimg_R))	$row->prdimg_R = "/data/prdimg/".$row->prdimg_R;
						else
					?>
						<li>
							<a href="/admin/purchase/purc_req.php?s_searchkey=<?=$row->prdname?>">
								<div class="prd-img">
									<img src="<?=$row->prdimg_R?>" alt="<?=$row->prdname?>"/>
								</div>
								<div class="prd-desc">
									<span class="prd-name"><?=$row->prdname?></span>
									<strong class="prd-prc"><em><?=number_format($row->memprice)?></em> 원</strong>
									<p class="option">
										<span><?=$row->com_name?></span>
										<span><?=$row->packing?> <?=$row->packing_unit?>/<?=$row->packing_unit2?></span>
										<span><?=$row->order_unit?></span>
									</p>
								</div>
							</a>
						</li>
					<? } ?>
					</ul>
				</div>
			</article>
		</section>
	</div><!--  //main__wrap -->
<? } ?>


<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php'; ?>