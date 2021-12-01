<?php $on = "on"; ?>
<div class="lnb-basic">
	<div class="ttl"><?=$pageTit?></div>
	<ul>
		<?if($pageNum=="member" && strpos($_SERVER['PHP_SELF'],"/my_qna.php") === false){?>
		<?if($wiz_session !=""){?>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_info.php") !== false){ echo $on; } ?>"><a href="../member/my_info.php">회원정보수정</a></li>
		<!-- <li class="<?php if(strpos($_SERVER['PHP_SELF'],"/myinfo.php") !== false){ echo $on; } ?>"><a href="../member/cart.php">장바구니</a></li> -->
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/prd_basket.php") !== false){ echo $on; } ?>"><a href="../shop/prd_basket.php">장바구니</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_order.php") !== false){ echo $on; } ?>"><a href="../member/my_order.php">주문배송조회</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_wish.php") !== false){ echo $on; } ?>"><a href="../member/my_wish.php">관심상품</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_qna.php") !== false){ echo $on; } ?>"><a href="../member/my_qna.php">1:1상담</a></li>
		<!-- <li class="<?php if(strpos($_SERVER['PHP_SELF'],"/myinfo.php") !== false){ echo $on; } ?>"><a href="../member/coupon.php">쿠폰관리</a></li> -->
		<!-- <li class="<?php if(strpos($_SERVER['PHP_SELF'],"/myinfo.php") !== false){ echo $on; } ?>"><a href="../member/my_reserve.php">적립금내역</a></li> -->
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_out.php") !== false){ echo $on; } ?>"><a href="../member/my_out.php">회원탈퇴</a></li>

		<!-- <li class="<?php if(strpos($_SERVER['PHP_SELF'],"/myinfo.php") !== false){ echo $on; } ?>"><a href="../member/mymessage.php">쪽지관리</a></li> -->
		<!-- <li class="<?php if(strpos($_SERVER['PHP_SELF'],"/myinfo.php") !== false){ echo $on; } ?>"><a href="../member/mypoint.php">포인트관리</a></li> -->
		<?}else{?>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/login.php") !== false){ echo $on; } ?>"><a href="login.php">로그인</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/join.php") !== false){ echo $on; } ?>"><a href="join.php">회원가입</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/id_search.php") !== false){ echo $on; } ?>"><a href="id_search.php">아이디/비밀번호찾기</a></li>
		<?}

		}else if($pageNum=="service" || strpos($_SERVER['PHP_SELF'],"/my_qna.php") !== false){?>
		<li class="<? if($code == "notice") { echo $on; } ?>"><a href="../bbs/list.php?code=notice">공지사항</a></li>
		<li class="<? if($code == "review") { echo $on; } ?>"><a href="../bbs/list.php?code=review">고객후기</a></li>
		<li class="<? if($code == "faq") { echo $on; } ?>"><a href="../bbs/list.php?code=faq">자주하는질문</a></li>
		<li class="<? if($code == "qna") { echo $on; } ?>"><a href="../bbs/list.php?code=qna">1:1상담</a></li>
		<!--<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_qna.php") !== false){ echo $on; } ?>"><a href="../member/my_qna.php">1:1상담</a></li>-->

		<?}

		else if($pageNum=="chain"){?>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_business.php") !== false){ echo $on; } ?>"><a href="../member/chain_business.php">판촉물이란</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_prospect.php") !== false){ echo $on; } ?>"><a href="../member/chain_prospect.php">판촉물 사업의특징</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_trade_process.php") !== false){ echo $on; } ?>"><a href="../member/chain_trade_process.php">판촉물거래과정</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_sample.php") !== false){ echo $on; } ?>"><a href="../member/chain_sample.php">샘플사이트</a></li>

		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_operation.php") !== false){ echo $on; } ?>"><a href="../member/chain_operation.php">운영방법 및 비용</a></li>

		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_eligibility.php") !== false){ echo $on; } ?>"><a href="../member/chain_eligibility.php">가맹점개설요건</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_open_process.php") !== false){ echo $on; } ?>"><a href="../member/chain_open_process.php">가맹점개설절차</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_function.php") !== false){ echo $on; } ?>"><a href="../member/chain_function.php">쇼핑몰주요기능</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_support.php") !== false){ echo $on; } ?>"><a href="../member/chain_support.php">영업지원</a></li>

			<?if($SID == 'admin'){?>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_qna_board.php") !== false){ echo $on; } ?>"><a href="../member/chain_qna_board.php">문의게시판</a></li>
			<?}?>
		<?}

		else if($pageNum=="company"){?>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/company.php") !== false){ echo $on; } ?>"><a href="../center/company.php">회사소개</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/guide.php") !== false){ echo $on; } ?>"><a href="../center/guide.php">주문가이드</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/work_notice") !== false){ echo $on; } ?>"><a href="../center/work_notice.php">작업시 유의사항</a></li>
		<?}?>
	</ul>
</div><!-- .lnb-basic -->
