<div class="cart-pop-wrap cmn-pop-wrap">
	<div class="pop-btn">
		<button type="button" class="view-all"></button>
		<button type="button" class="cls-pop"></button>
	</div>

	<div class="cart-pop">
		<h4 class="pop-tit">장바구니 <span class="cart-num">2</span> </h4> 
		<div class="cart-inner clearfix">
			<section class="cart-list-sect">
				<p class="cart_chk-opt">
					<input type="checkbox" id="all-selct"/>
					<label for="all-selct">전체선택</label>
					<button type="button" class="selt-del">선택상품 삭제</button>
				</p>
				<table class="cart__list">
					<thead>
						<tr class="list_top">
							<td colspan="6">
								<input type="checkbox"/> <!-- //오피스 프랜드 전체선택 -->
								<strong>오피스프랜드</strong>
							</td>
						</tr>
					</thead>
					<tbody>
						<tr class="cart__list-item">
							<td width="58px" class="chk">
								<input type="checkbox" />
							</td>
							<td width="93px">
								<div class="prd-img">
									<img src="/admin/img/sub/prod_1.jpg" alt="제품이미지">
								</div>
							</td>
							<td class="prd-name" width="308px">
								<a href="">명함통(808L)</a> 
							</td>
							<td class="amnt-box">
								<div class="num-box">
									<button type="button" class="minus"><img src="/admin/img/ico/minus.png" alt=""></button>
									<span class="amnt-num">1</span>
									<button type="button" class=""><img src="/admin/img/ico/plus.png" alt=""></button>
								</div>
							</td>
							<td class="prd-prc" width="136px">
								<em>7,200</em> 원
							</td>
							<td width="58px" class="del-btn">
								<button type="button"><img src="/admin/img/ico/cart-del.png" alt="제품 삭제버튼"></button>
							</td>
						</tr>
						<!-- //가운데 제품 리스트 항목 하나 -->
					</tbody>
					<tfoot>
						<tr class="list_btm">
							<td colspan="6" class="prc-sect">
								<span>총 구매금액</span>
								<strong class="all-prc"><em>13,400</em> 원</strong>
							</td>
						</tr>
					</tfoot>
				</table>
			</section>
			<section class="cart-prc-sect cmn-prd-btn">
				<strong>전체 합계</strong>
				<dl class="cmn__all-prc clearfix">
					<dt>총 구매 금액</dt>
					<dd><em>7,200</em> 원</dd>
				</dl>
				<a href="" class="req-btn">승인요청</a>
				<!-- <button class="req-btn">승인요청</button>  -->
			</section>
		</div>
	</div> <!-- //cart-pop -->

	<script>
	function cart_sel_all() {
		if($("#all-selct").is(":checked")) {
			$(".chk_all").prop("checked", true);
		} else {
			$(".chk_all").prop("checked", false);
		}
	}

	function cart_sel_mall(mallid) {
		if($("#all_"+mallid).is(":checked")) {
			$(".chk_"+mallid).prop("checked", true);
		} else {
			$(".chk_"+mallid).prop("checked", false);
		}
	}

	function cart_amout_up(idx) {
		$.ajax({
			url     : '/admin/purchase/ajax.php',
			data    : {
				'mode' : 'cart_amout',
				'sub_mode' : 'up',
				'idx' : idx
			},
			dataType: 'JSON',
			type    : 'POST',
			async: false,
			success : function(data){
				cart_list();
			}
		});
	}

	function cart_amout_down(idx) {
		$.ajax({
			url     : '/admin/purchase/ajax.php',
			data    : {
				'mode' : 'cart_amout',
				'sub_mode' : 'down',
				'idx' : idx
			},
			dataType: 'JSON',
			type    : 'POST',
			async: false,
			success : function(data){
				if(data.message != "") {
					alert(data.message);
				} else {
					if(data.amount > 0) {
						cart_list();
					}
				}
			}
		});
	}

	function cart_delete(idx) {
		$.ajax({
			url     : '/admin/purchase/ajax.php',
			data    : {
				'mode' : 'cart_delete',
				'idx' : idx
			},
			dataType: 'text',
			type    : 'POST',
			async: false,
			success : function(data){
				cart_list();
			}
		});
	}

	function cart_sel_delete() {
		if(!$(".cart_idx").is(":checked")) {
			alert("상품을 선택해주세요.");
		} else {

			var sel_idx = "";
			$(".cart_idx").each(function(){
				if($(this).is(":checked")) {
					sel_idx += this.value+",";
				}
			});

			$.ajax({
				url     : '/admin/purchase/ajax.php',
				data    : {
					'mode' : 'cart_sel_delete',
					'sel_idx' : sel_idx
				},
				dataType: 'text',
				type    : 'POST',
				async: false,
				success : function(data){
					cart_list();
				}
			});

		}
	}

	function cart_sel_buy_view() {
		if(!$(".cart_idx").is(":checked")) {
			alert("상품을 선택해주세요.");
		} else {

			var sel_idx = "";
			$(".cart_idx").each(function(){
				if($(this).is(":checked")) {
					sel_idx += this.value+",";
				}
			});

			var $cartPop = $('.cart-pop-wrap');
			$cartPop.hide();
			$('.bg').hide();

			// 주문 상세
			buy_view(sel_idx);
			var $buyPop = $('.buy-pop-wrap');
			$buyPop.show();
			$buyPop.removeClass('on');
			$('.bg').show();

		}
	}
	</script>

</div> <!-- //cart-pop-wrap -->