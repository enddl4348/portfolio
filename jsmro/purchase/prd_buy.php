<form name="buy_frm" action="/admin/purchase/ajax.php" method="post">
	<input type="hidden" name="mode" value="order_save">
	<div class="buy-pop-wrap cmn-pop-wrap">
		<div class="pop-btn">
			<button type="button" class="view-all"></button>
			<button type="button" class="cls-pop"></button>
		</div>

		<div class="buy-pop">
			<h4 class="pop-tit">구매하기 <span class="cart-num">4</span> </h4> 

			<div class="buy-inner clearfix">
				<section class="buy__prd-list">
					<div class="list-top_opt clearfix">
						<span class="prd-info">구매 상품 정보</span>
						<span class="prd-amnt">수량</span>
						<span class="prd-prc">제품 가격</span>
					</div> <!-- //list-top_opt -->

					<div class="list-wrap">
						<div class="buy-list-item">
							<table class="cart__list">
								<thead>
									<tr class="list_top">
										<td colspan="4">
											<strong>오피스프랜드</strong>
										</td>
									</tr>
								</thead>
								<tbody>
									<tr class="cart__list-item">
										<td width="134px" class="img-wrap">
											<div class="prd-img">
												<img src="/admin/img/sub/prod_1.jpg" alt="제품이미지">
											</div>
										</td>
										<td class="prd-name" width="310px">
											<a href=""> 명함통(808L)</a>
										</td>
										<td width="152px" class="amnt"> 1 </td>
										<td class="prd-prc" width="177px">
											<em>7,200</em> 원
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
							<div class="add-detail">
								<dl class="clearfix">
									<dt>납품 요청일</dt>
									<dd> <input type="text" class="prd__datepicker"></dd>
								</dl>
								<dl class="clearfix">
									<dt>업체 요청사항</dt>
									<dd>
										<textarea name="" id="" cols="30" rows="1"
										placeholder="요청사항을 입력해주세요 (예.물건 파손되지 않게 포장 잘 부탁드립니다)"></textarea>
									</dd>
								</dl>
							</div> <!-- //add-detail -->
						</div> <!-- //buy-list-item -->
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
							<dd><input type="text" class="수령자 성명을 입력해 주세요."/></dd>
							<dt>배송지 주소</dt>
							<dd>
								<p><input type="text" class="sm-input"/> <button type="button">주소 찾기</button></p>
								<p><input type="text"/></p>
								<p><input type="text"  placeholder="상세주소를 입력해 주세요."/></p>
							</dd>
						</dl>
					</div>
					<div class="prd-sect">
						<strong>전체 합계</strong>
						<dl class="cmn__all-prc clearfix">
							<dt>총 구매 금액</dt>
							<dd><em>7,200</em> 원</dd>
						</dl>
						<button type="button" class="req-btn">구매하기</button>
					</div>
				</section> <!-- //buy-prc-sect -->
			</div>
			<!-- //buy-inner -->
		</div> <!-- //buy-pop -->
	</div> <!-- //buy-pop-wrap -->
</form>

<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
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

// 우편번호 찾기
function zipSearch(kind){
	if(kind == undefined) kind = '';
	new daum.Postcode({
		oncomplete: function(data) {
			// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
			// 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
			eval('document.buy_frm.'+kind+'post').value = data.zonecode;
			eval('document.buy_frm.'+kind+'address').value = data.address;

			//전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
			//아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
			//var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
			//document.getElementById('addr').value = addr;

			if(eval('document.buy_frm.'+kind+'address2') != null)
                eval('document.buy_frm.'+kind+'address2').value = "";
				eval('document.buy_frm.'+kind+'address2').focus();

		}
	}).open();
}

function order_save() {
	var form_data = $("form[name=buy_frm]").serialize();
	
	$.ajax({
		url     : '/admin/purchase/ajax.php',
		data    : form_data,
		dataType: 'JSON',
		type    : 'POST',
		async: false,
		success : function(data){
			if(data.status == "N") {
				alert(data.message);
				return false;
			} else if(data.status == "Y") {
				alert(data.message);
				location.href = "/admin/order/basket_list.php";
				return false;
			}
		}
	});
}

function sel_del(str) {
	var str_arr = str.split("^");
	
	$("input[name=name]").val(str_arr[0]);
	$("input[name=hphone]").val(str_arr[1]);
	$("input[name=post]").val(str_arr[2]);
	$("input[name=address]").val(str_arr[3]);
	$("input[name=address2]").val(str_arr[4]);
}
</script>