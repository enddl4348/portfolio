    <? if(strpos($_SERVER[PHP_SELF],"/member/login.php")===false && strpos($_SERVER[PHP_SELF],"/member/my_address_input.php")===false){ ?>
    <footer class="footer">
        <div class="container">
            <div class="footer__top">
                <ul class="footer__list">
                <!--<li><a href="/center/company.php">회사소개</a></li>-->
                <li><a href="/bbs/list.php?code=notice">공지사항</a></li>
                <li><a href="/center/center.php">고객센터</a></li>
                <li><a href="/center/guide.php">이용약관</a></li>
                <li><a href="/center/privacy.php">개인정보취급방침</a></li>
                </ul>
            </div>
            <!-- //footer__top -->
            <div class="footer__bottom clearfix">
                <div class="footer__lef">
                    <h2 class="foot__logo"><a href="" class="ir_pm">biosmart</a></h2>
                    <span class="foot__txt">(주)바이오스마트 대표 : 윤호권</span>
                    <span class="foot__txt">서울시 성동구 광나루로 172(성수동1가 13-5) 린하우스 4층</span>
                    <span class="foot__txt">사업자등록번호 : 201-81-49003 / 통신판매업신고번호 : 제 2021-서울성동-01114호</span>
                    <small class="copyright">COPYLIGHT ⓒ 2021 bswelfare.com All rights reserved.<?/* <a href="http://anywiz.co.kr/" target="_blank"><img src="http://anywiz.co.kr/contine/anywiz.png" onerror="this.style.display='none'" alt="애니위즈" /></a>*/?></small>
                </div>
                <div class="footer__rig">
                    <strong>고객센터</strong>
                    <span class="foot__txt">개인정보보호책임자 : 민창석 </span>
                    <span class="foot__txt">전화 : <em class="org-col eng-txt">02-3218-9070</em> (평일  <b class="eng-txt"> 09:00 ~ 18:00</b>)</span>
                    <span class="foot__txt">팩스 : <b class="eng-txt">02-3218-9050 / E-mail : <em class="org-col">csmin@bs-group.kr</em></b></span>
                </div>
            </div>
            <!-- //footer__bottom -->
        </div>
        <div class="go-top__btn">
            <button type="button" class="ir_pm">TOP</button>
        </div>
        <!-- //go-top__btn -->
    </footer>
    <? } ?>
    <?// include $_SERVER["DOCUMENT_ROOT"]."/inc/quick.php" ?>
    </div>
    <!-- //wrap -->
	<form name="frmParter" action="/go_partner.php" method="get" target="_blank">
	<input type="hidden" name="catcode">
	</form>
	<script>
	function goPartner(v){
		var f=document.frmParter;
		f.catcode.value=v;
		f.submit();
	}
	</script>
</body>
</html>