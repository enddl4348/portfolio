
<div id="quick">
	<div class="quick-bn">
		<ul>
			<?
			$sql = "select link_url, link_target, de_type, de_img, de_html, su_img
					from wiz_banner 
					where sid='".$SID."' and name='left-quick' and isuse = 'Y' order by align desc, prior asc, idx asc";
			$result = mysql_query($sql) or error(mysql_error());
			$total = mysql_num_rows($result);
			while($row = mysql_fetch_object($result)){
				
				$onClick = "";

				if(!empty($row->link_url)) {
					if(!strcmp($row->link_target, "_SELF") || empty($row->link_target)) $onClick = "javascript:self.location.href='".$row->link_url."'\"";
					if(!strcmp($row->link_target, "_BLANK")) $onClick = "javascript:window.open('".$row->link_url."')\"";
				}

				if($row->de_type == 'HTML'){?>
				<li><?=$row->de_html?></li>
				<?}
				else{
					$img_src = $FILE_URL."/banner/".$row->de_img;
				?>
				<li><a href="<?=$onClick?>"><img src="<?=$img_src?>" /></a></li>
				<?
				}
			}
			?>
		</ul>
	</div><!-- .quick-bn -->
</div><!--.left-quick-->
<?
$total = 0;
for($ii=0;$ii<100;$ii++){
	if($_SESSION["view_list"][$ii][prdcode]) $total++;
}
$v_idx = $total-1;
$scroll_amount = 285;				// 한번에 스크롤되는 값
if($total > 0) $div_height = 285;		// 오늘본상품 역역 높이

// 오늘본 상품 총 페이지 수
$total_page = floor($total/3);
// 상품이 3개씩 딱 안떨어질 경우 페이지 하나 추가
if($total%3 != 0){ $total_page = $total_page+1; $remainder = $total%3;}
?>
<div id="quick2">
	<div class="quick-bn">
		<ul>
			<?
			$sql = "select link_url, link_target, de_type, de_img, de_html, su_img from wiz_banner where sid='".$SID."' and name='right-quick' and isuse = 'Y' order by align desc, prior asc, idx asc";
			$result = mysql_query($sql) or error(mysql_error());
			$total = mysql_num_rows($result);
			while($row = mysql_fetch_object($result)){
				
				$onClick = "";

				if(!empty($row->link_url)) {
					if(!strcmp($row->link_target, "_SELF") || empty($row->link_target)) $onClick = "javascript:self.location.href='".$row->link_url."'\"";
					if(!strcmp($row->link_target, "_BLANK")) $onClick = "javascript:window.open('".$row->link_url."')\"";
				}

				$img_src = $FILE_URL."/banner/".$row->de_img;

			?>
			<li><a href="<?=$onClick?>"><img src="<?=$img_src?>" /></a></li>
			<?
			}
			?>
		</ul>
	</div><!-- .quick-bn -->

	<div class="quick-today">
		<div class="ttl">TODAY</div>
		<div class="cont">
			<ul id="gdscroll" style="height:<?=$div_height?>px;overflow:hidden;">
				<?
				while(0 <= $v_idx){
					// 상품 이미지
					if(!@file($_SERVER[DOCUMENT_ROOT]."/data/".$sid."/prdimg/".$_SESSION["view_list"][$v_idx][prdimg])) $view_prdimg = "/images/noimg_R.gif";
					else $view_prdimg = "/data/".$sid."/prdimg/".$_SESSION["view_list"][$v_idx][prdimg];
				?>
				<li><a href="/shop/prd_view.php?prdcode=<?=$_SESSION["view_list"][$v_idx][prdcode]?>" onFocus="this.blur();"><img src="<?=$view_prdimg?>" /></a></li>
				<?
					$v_idx--;
				}
				?>
				<?
				while(0 < $remainder){

				?>
				<li><img src="http://placehold.it/80px80" width="80" height="80" style="opacity: 0;"/></li>
				<?
					$remainder--;
				}
				?>
			</ul>
			<div class="page-btn">
				<button onclick="gdscroll('-<?=$scroll_amount?>');"><a href="javascript:gdscroll('-<?=$scroll_amount?>')" onFocus="this.blur();"><img src="/img/comm/btn-prev.jpg" /></a></button>
				<span><b id="current_page"><?if($total < 0){ echo "0"; }else{ echo "1"; }?></b>/<?=$total_page?></span>
				<button onclick="gdscroll('<?=$scroll_amount?>');"><a href="javascript:gdscroll('<?=$scroll_amount?>')" onFocus="this.blur();"><img src="/img/comm/btn-next.jpg" /></a></button>
			</div>			
		</div><!-- .cont -->
	</div><!-- .quick-today -->

	
	<div class="quick-top">
		<a href="#">TOP</a>
	</div><!-- .quick-top -->
		
    </div><!--.right-quick-->	
    
	<script>
	/*
	function gdscroll(gap){
		var gdscroll = document.getElementById('gdscroll');
		gdscroll.scrollTop += gap;
	}
	*/
	function gdscroll(gap){

		// 현재 페이지 넘버
		var page_num = document.getElementById('current_page');
		
		// 다음 페이지로 넘길 경우
		if(gap > 0){ page_num.innerText = parseInt(page_num.innerText) + 1; if(page_num.innerText > <?=$total_page?>){ page_num.innerText = <?=$total_page?>; return false; } }
		// 이전 페이지로 돌아갈 경우
		else if(gap < 0){ page_num.innerText = parseInt(page_num.innerText) - 1; if(page_num.innerText <= 0){ page_num.innerText = 1; } }
		
		// 현재 투데이 스크롤
		var gdscroll = document.getElementById('gdscroll');
		
		// 현재 높이 값과 스크롤 값 더하기(스크롤 움직이기)
		gdscroll.scrollTop = parseInt(gdscroll.scrollTop) + parseInt(gap);

	}
	</script>





<script type="text/javascript">
$("document").ready(function() {
    var topBanner = $('.Top-banner').length;

    if(topBanner){ // 최상단 배너가 있을 때 
        var banHeight = $('.Top-banner').height(); // 상단배너 높이값
        var qoffset1 = $('#quick').offset().top;
        var qoffset2 = $('#quick2').offset().top;

        $('#quick').css('top',banHeight+qoffset1); // 상단배너 높이값만큼 offset 변경
        $('#quick2').css('top',banHeight+qoffset2);

        $(window).scroll(function() {
            var position = $(this).scrollTop(); 
            if(position>qoffset1+banHeight){ // 스크롤이 quick의 새로운 offset top 보다 커지면
                $("#quick").css({
                    position:'fixed',
                    top:20+'px',
                    right:50+'%',
                    marginReft:620+'px'
                });
            } else {
                $("#quick").css({
                    position:'absolute',
                    top:banHeight+qoffset1+'px',
                    right:50+'%',
                    marginReft:620+'px'
                });
            }
        });
    } else { // 최상단배너가 없을 때 적용되는 스크립트
        var qoffset1 = $('#quick').offset().top;

        $(window).scroll(function() {
            var position = $(this).scrollTop(); 
            if(position>qoffset1-20){
                $("#quick").css({
                    position:'fixed',
                    top:20+'px',
                    right:50+'%',
                    marginReft:620+'px'
                });
            } else {
                $("#quick").css({
                    position:'absolute',
                    top:258+'px',
                    right:50+'%',
                    marginReft:620+'px'
                });
            }
        });

    }
});
</script>


