<? include "../../inc/common.inc"; ?>
<? include "../../inc/admin_check.inc"; ?>
<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php'; ?>

<div class="prd-nav-wrap">
	<ul class="clearfix">
		<li class="on"><a href="">사무용품</a></li>  <!-- 각각 선택했을 때 li 에 class on 붙게 -->
		<li><a href="">생활용품</a></li>
		<li><a href="">의료소모품</a></li>
		<li><a href="">인쇄물</a></li>
		<li><a href="">전산용품</a></li>
		<li><a href="">복리후생용품</a></li>
		<li><a href="">한방과립제</a></li>
		<li><a href="">자생</a></li>
	</ul>
</div> <!-- //prd-nav-wrap -->

<div class="prd-opt-wrap">
	<span class="home ir_pm">홈</span>
	<em class="arr-ico"></em>
	<select name="" id="" class="cmn-slct">
		<option value="">사무용품</option>
		<option value="">생활용품</option>
		<option value="">의료소모품</option>
	</select>

	<em class="arr-ico"></em>
	<select name="" id="" class="cmn-slct">
		<option value="">전체보기</option>
		<option value="">POP/표지판/아크릴박스</option>
	</select>

	<em class="arr-ico"></em>
	<select name="" id="" class="cmn-slct">
		<option value="">전체보기</option>
		<option value="">도장</option>
		<option value="">인주</option>
	</select>

	<input type="text" class="cmn-ip" placeholder="상품 검색어를 입력해주세요."/> 
	<button type="button" class="cmn-btn">검색</button>
</div> <!-- //prd-opt-wrap -->

<div class="purc__prd-list cmn-prd-list">
	<h2 class="page_ttl">사무용품</h2>

	<!-- 상단에 세부 옵션 검색했을 때 노출되는 마크업 -->
	<ul class="nav-depth-menu">
		<li class="on"><a href="">도장</a></li>  <!-- 각각 선택했을 때 li에 class on 붙게 -->
		<li><a href="">인주</a></li>
		<li><a href="">잉크</a></li>
		<li><a href="">부채용꽂이</a></li>
		<li><a href="">명함꽂이</a></li>
	</ul>

	<p class="prd-amnt-txt">총 <em>31140</em>개의 상품이 검색되어 있습니다.</p>

	<div class="purc_list-opt">
		<span class="all-select">
			<input type="checkbox" id="all_slct" class=""/>
			<label for="all_slct">전체선택</label>
		</span>

		<span class="alg-tit">정렬방식</span>

		<div class="align-btn">
			<button type="button" class="ir_pm col ">가로형리스트 버튼</button>
			<button type="button" class="ir_pm row">세로형리스트 버튼</button>
		</div>

		<select name="" id="" class="cmn-slct">
			<option value="">10개씩 보기</option>
			<option value="">20개씩 보기</option>
			<option value="">30개씩 보기</option>
		</select>

		<select name="" id="" class="cmn-slct">
			<option value="">최근등록상품</option>
			<option value="">높은가격순</option>
			<option value="">낮은가격순</option>
		</select>

		<button type="button" class="cart-btn">장바구니 담기</button>
		<button type="button" class="buy-btn">구매하기</button>
	</div> <!-- //purc_list-opt -->

	<div class="prd-list-type">
		<div class="prd-list-box clm-list clearfix">
			<div class="list-clm-item">
				<div class="prd-img">
					<img src="/admin/img/sub/prod_1.jpg" alt="제품이미지1">

					<!-- 호버했을 때 나오는 마크업 -->
					<div class="prd-item-hover">
						<div class="lnk-wrap ">
							<button type="button" class="detail">자세히 보기</button>
							<button type="button" class="cart">장바구니 담기</button>
						</div>
					</div> <!-- //prd-item-hover -->
				</div>
				<div class="prd-desc">
					<p class="dec-top">
						<input type="checkbox" />
						<strong class="prd-name">스카치폼양면테이프(#2240)-24444555</strong>
						<span class="prd-prc"><em>5,200</em> 원</span>
					</p>

					<p class="prd-opt">
						<span>오피스프랜드</span>
						<span>705*447*82</span>
						<span>EA</span>
					</p>
				</div> <!-- //prd-desc -->
			</div>
		</div><!-- //가로형 리스트 마크업 여기까지 -->

		<table class="prd-list-tb prd-list-box">
			<tr>
				<td width="38px"><input type="checkbox" /> </td>
				<td width="150px">
					<div class="prd-img"><img src="/admin/img/sub/prod_1.jpg" alt="상품 리스트"></div>
				</td>
				<td class="prd-desc">
					<strong class="prd-name">스카치폼양면테이프(#2240)-24444555</strong>
					<p class="prd-opt"><span>오피스프랜드</span> <span>705*447*82</span> <span>EA</span></p>
				</td>
				<td class="prd-prc" width="385px"><em>5,200</em> 원</td>
				<td class="prd-link" width="150px">
					<button type="button" class="detail">자세히 보기</button>
					<button type="button" class="cart">장바구니 담기</button>
				</td>
			</tr>
			<tr>
				<td width="38px"><input type="checkbox" /> </td>
				<td width="150px">
					<div class="prd-img"><img src="/admin/img/sub/prod_1.jpg" alt="상품 리스트"></div>
				</td>
				<td class="prd-desc">
					<strong class="prd-name">스카치폼양면테이프(#2240)-24444555</strong>
					<p class="prd-opt"><span>오피스프랜드</span> <span>705*447*82</span> <span>EA</span></p>
				</td>
				<td class="prd-prc" width="257px "><em>5,200</em> 원</td>
				<td class="prd-link" width="198px">
					<a href="" class="detail">자세히 보기</a>
					<a href="" class="cart">장바구니 담기</a>
				</td>
			</tr>
		</table> <!-- //세로형 리스트 마크업 여기까지 -->
	</div>  <!-- //prd-list-type -->

	<div class="paging">
		<a href="" class="ir_pm ico prev">맨 처음</a>
		<a href="" class="ir_pm ico prev2">이전으로</a>
		<b class="">1</b>
		<a href="" class="ot-pg"> 2</a>
		<a href="" class="ir_pm ico next"> 다음으로</a>
		<a href="" class="ir_pm ico next2"> 맨 마지막</a>
	</div>
</div> <!-- //purc__prd-list -->

<? include $_SERVER['DOCUMENT_ROOT'].'/admin/purchase/prd_view.php'; //상품 상세 레이어팝업 마크업 있는 경로 ?>

<? include $_SERVER['DOCUMENT_ROOT'].'/admin/purchase/prd_buy.php'; //상품구매창 레이어팝업 마크업 있는 경로 ?>

<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php'; ?>