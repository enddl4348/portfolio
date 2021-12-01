<? include "../../inc/common.inc"; ?>
<? include "../../inc/util.inc"; ?>
<? include "../../inc/shop_info.inc"; ?>
<? include "../../inc/admin_check.inc"; ?>
<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php'; ?>

<? include "../../inc/popup.inc"; ?>

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
					<td rowspan="2">5</td>
					<td rowspan="2" width="11%">10</td>
					<td class="sub-txt" width="11%">3일 초과</td>
					<td rowspan="2" width="11%">20</td>
					<td class="sub-txt" width="11%">5일 초과</td>
					<td rowspan="2">10</td>
					<td rowspan="2" width="11%">10</td>
					<td class="sub-txt" width="11%">3일 초과</td>
					<td rowspan="2">50</td>
				</tr>
				<tr class="over-num">
					<td>3</td>
					<td>6</td>
					<td>5</td>
				</tr>
			</tbody>
		</table>
	</section> <!-- //ord-manage -->

	<section class="main__cmn-sect main__cont-md clearfix">
		<article class="dash_brd-list">
			<h3 class="main__sec-tit">최근 게시물</h3>
			<ul class="board-wrap">
			<?
			$limit = 5;
			$sql = "select *, date_format(from_unixtime(wdate), '%Y-%m-%d') as wdate from wiz_bbs where sid='$SID' and code != 'memout' order by idx desc limit $limit";
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
					<td>5</td>
					<td>10</td>
					<td>10</td>
				</tr>
				<tr>
					<td rowspan="2" class="bg-b-tit">신규공급사</td>
					<td class="sub-txt">요청</td>
					<td class="sub-txt">견적 진행</td>
					<td class="sub-txt">등록 완료</td>
				</tr>
				<tr>
					<td>3</td>
					<td>5</td>
					<td>5</td>
				</tr>
			</table>
		</article>
	</section> <!-- //main__cont-md -->

	<section class="main__cmn-sect clearfix">
		<article class="month-buy-status">
			<h3 class="main__sec-tit">구매 현황</h3>
			<div class="buy-status-wrap">
				<strong><em>7</em>월 구매 현황</strong>
				<div class="month-buy__prc">
					<p class="clearfix"><span>7월 예산 금액</span> <strong><em class="red">2,222,000</em> 원</strong></p>
					<p class="clearfix"><span>구매금액</span> <strong><em>2,222,000</em> 원</strong></p>
				</div>
				<div class="team-prc">
					<p class="clearfix"><span>1팀 구매금액</span> <strong> <em>1,450,000</em> 원</strong> </p>
					<p class="clearfix"><span>2팀 구매금액</span> <strong> <em>1,450,000</em> 원</strong> </p>
					<p class="clearfix"><span>3팀 구매금액</span> <strong> <em>1,450,000</em> 원</strong> </p>
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
					<li>
						<a href="">
							<div class="prd-img">
								<img src="/admin/img/sub/prod_1.jpg" alt="제품이미지1"/>
							</div>
							<div class="prd-desc">
								<span class="prd-name"> 스카치폼양면테이프</span>
								<strong class="prd-prc"><em>5,200</em> 원</strong>
								<p class="option"> <span>오피스프랜드</span> <span>705*447*82</span> <span>EA</span></p>
							</div>
						</a>
					</li>
					<li>
						<a href="">
							<div class="prd-img">
								<img src="/admin/img/sub/prod_2.jpg" alt="제품이미지1"/>
							</div>
							<div class="prd-desc">
								<span class="prd-name"> 스카치폼양면테이프</span>
								<strong class="prd-prc"><em>5,200</em> 원</strong>
								<p class="option"> <span>오피스프랜드</span> <span>705*447*82</span> <span>EA</span></p>
							</div>
						</a>
					</li>
					<li>
						<a href="">
							<div class="prd-img">
								<img src="/admin/img/sub/prod_3.jpg" alt="제품이미지1"/>
							</div>
							<div class="prd-desc">
								<span class="prd-name"> 스카치폼양면테이프</span>
								<strong class="prd-prc"><em>5,200</em> 원</strong>
								<p class="option"> <span>오피스프랜드</span> <span>705*447*82</span> <span>EA</span></p>
							</div>
						</a>
					</li>
					<li>
						<a href="">
							<div class="prd-img">
								<img src="/admin/img/sub/prod_4.jpg" alt="제품이미지1"/>
							</div>
							<div class="prd-desc">
								<span class="prd-name"> 스카치폼양면테이프</span>
								<strong class="prd-prc"><em>5,200</em> 원</strong>
								<p class="option"> <span>오피스프랜드</span> <span>705*447*82</span> <span>EA</span></p>
							</div>
						</a>
					</li>
				</ul>

				<ul class="latest-buy-prd clearfix">
					<li>
						<a href="">
							<div class="prd-img">
								<img src="/admin/img/sub/prod_1.jpg" alt="제품이미지1"/>
							</div>
							<div class="prd-desc">
								<span class="prd-name"> 스카치폼양면테이프</span>
								<strong class="prd-prc"><em>5,200</em> 원</strong>
								<p class="option"> <span>오피스프랜드</span> <span>705*447*82</span> <span>EA</span></p>
							</div>
						</a>
					</li>
					<li>
						<a href="">
							<div class="prd-img">
								<img src="/admin/img/sub/prod_3.jpg" alt="제품이미지1"/>
							</div>
							<div class="prd-desc">
								<span class="prd-name"> 스카치폼양면테이프</span>
								<strong class="prd-prc"><em>5,200</em> 원</strong>
								<p class="option"> <span>오피스프랜드</span> <span>705*447*82</span> <span>EA</span></p>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</article>
	</section>
</div><!--  //main__wrap -->


<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php'; ?>