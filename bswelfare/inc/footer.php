    <? if(strpos($_SERVER[PHP_SELF],"/member/login.php")===false && strpos($_SERVER[PHP_SELF],"/member/my_address_input.php")===false){ ?>
    <footer class="footer">
        <div class="container">
            <div class="footer__top">
                <ul class="footer__list">
                <!--<li><a href="/center/company.php">ȸ��Ұ�</a></li>-->
                <li><a href="/bbs/list.php?code=notice">��������</a></li>
                <li><a href="/center/center.php">������</a></li>
                <li><a href="/center/guide.php">�̿���</a></li>
                <li><a href="/center/privacy.php">����������޹�ħ</a></li>
                </ul>
            </div>
            <!-- //footer__top -->
            <div class="footer__bottom clearfix">
                <div class="footer__lef">
                    <h2 class="foot__logo"><a href="" class="ir_pm">biosmart</a></h2>
                    <span class="foot__txt">(��)���̿�����Ʈ ��ǥ : ��ȣ��</span>
                    <span class="foot__txt">����� ������ ������� 172(������1�� 13-5) ���Ͽ콺 4��</span>
                    <span class="foot__txt">����ڵ�Ϲ�ȣ : 201-81-49003 / ����Ǹž��Ű��ȣ : �� 2021-���Ｚ��-01114ȣ</span>
                    <small class="copyright">COPYLIGHT �� 2021 bswelfare.com All rights reserved.<?/* <a href="http://anywiz.co.kr/" target="_blank"><img src="http://anywiz.co.kr/contine/anywiz.png" onerror="this.style.display='none'" alt="�ִ�����" /></a>*/?></small>
                </div>
                <div class="footer__rig">
                    <strong>������</strong>
                    <span class="foot__txt">����������ȣå���� : ��â�� </span>
                    <span class="foot__txt">��ȭ : <em class="org-col eng-txt">02-3218-9070</em> (����  <b class="eng-txt"> 09:00 ~ 18:00</b>)</span>
                    <span class="foot__txt">�ѽ� : <b class="eng-txt">02-3218-9050 / E-mail : <em class="org-col">csmin@bs-group.kr</em></b></span>
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