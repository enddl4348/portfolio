<?php $on = "on"; ?>
<div class="lnb-basic">
	<div class="ttl"><?=$pageTit?></div>
	<ul>
		<?if($pageNum=="member" && strpos($_SERVER['PHP_SELF'],"/my_qna.php") === false){?>
		<?if($wiz_session !=""){?>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_info.php") !== false){ echo $on; } ?>"><a href="../member/my_info.php">ȸ����������</a></li>
		<!-- <li class="<?php if(strpos($_SERVER['PHP_SELF'],"/myinfo.php") !== false){ echo $on; } ?>"><a href="../member/cart.php">��ٱ���</a></li> -->
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/prd_basket.php") !== false){ echo $on; } ?>"><a href="../shop/prd_basket.php">��ٱ���</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_order.php") !== false){ echo $on; } ?>"><a href="../member/my_order.php">�ֹ������ȸ</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_wish.php") !== false){ echo $on; } ?>"><a href="../member/my_wish.php">���ɻ�ǰ</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_qna.php") !== false){ echo $on; } ?>"><a href="../member/my_qna.php">1:1���</a></li>
		<!-- <li class="<?php if(strpos($_SERVER['PHP_SELF'],"/myinfo.php") !== false){ echo $on; } ?>"><a href="../member/coupon.php">��������</a></li> -->
		<!-- <li class="<?php if(strpos($_SERVER['PHP_SELF'],"/myinfo.php") !== false){ echo $on; } ?>"><a href="../member/my_reserve.php">�����ݳ���</a></li> -->
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_out.php") !== false){ echo $on; } ?>"><a href="../member/my_out.php">ȸ��Ż��</a></li>

		<!-- <li class="<?php if(strpos($_SERVER['PHP_SELF'],"/myinfo.php") !== false){ echo $on; } ?>"><a href="../member/mymessage.php">��������</a></li> -->
		<!-- <li class="<?php if(strpos($_SERVER['PHP_SELF'],"/myinfo.php") !== false){ echo $on; } ?>"><a href="../member/mypoint.php">����Ʈ����</a></li> -->
		<?}else{?>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/login.php") !== false){ echo $on; } ?>"><a href="login.php">�α���</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/join.php") !== false){ echo $on; } ?>"><a href="join.php">ȸ������</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/id_search.php") !== false){ echo $on; } ?>"><a href="id_search.php">���̵�/��й�ȣã��</a></li>
		<?}

		}else if($pageNum=="service" || strpos($_SERVER['PHP_SELF'],"/my_qna.php") !== false){?>
		<li class="<? if($code == "notice") { echo $on; } ?>"><a href="../bbs/list.php?code=notice">��������</a></li>
		<li class="<? if($code == "review") { echo $on; } ?>"><a href="../bbs/list.php?code=review">���ı�</a></li>
		<li class="<? if($code == "faq") { echo $on; } ?>"><a href="../bbs/list.php?code=faq">�����ϴ�����</a></li>
		<li class="<? if($code == "qna") { echo $on; } ?>"><a href="../bbs/list.php?code=qna">1:1���</a></li>
		<!--<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/my_qna.php") !== false){ echo $on; } ?>"><a href="../member/my_qna.php">1:1���</a></li>-->

		<?}

		else if($pageNum=="chain"){?>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_business.php") !== false){ echo $on; } ?>"><a href="../member/chain_business.php">���˹��̶�</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_prospect.php") !== false){ echo $on; } ?>"><a href="../member/chain_prospect.php">���˹� �����Ư¡</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_trade_process.php") !== false){ echo $on; } ?>"><a href="../member/chain_trade_process.php">���˹��ŷ�����</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_sample.php") !== false){ echo $on; } ?>"><a href="../member/chain_sample.php">���û���Ʈ</a></li>

		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_operation.php") !== false){ echo $on; } ?>"><a href="../member/chain_operation.php">���� �� ���</a></li>

		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_eligibility.php") !== false){ echo $on; } ?>"><a href="../member/chain_eligibility.php">�������������</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_open_process.php") !== false){ echo $on; } ?>"><a href="../member/chain_open_process.php">��������������</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_function.php") !== false){ echo $on; } ?>"><a href="../member/chain_function.php">���θ��ֿ���</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_support.php") !== false){ echo $on; } ?>"><a href="../member/chain_support.php">��������</a></li>

			<?if($SID == 'admin'){?>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/chain_qna_board.php") !== false){ echo $on; } ?>"><a href="../member/chain_qna_board.php">���ǰԽ���</a></li>
			<?}?>
		<?}

		else if($pageNum=="company"){?>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/company.php") !== false){ echo $on; } ?>"><a href="../center/company.php">ȸ��Ұ�</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/guide.php") !== false){ echo $on; } ?>"><a href="../center/guide.php">�ֹ����̵�</a></li>
		<li class="<?php if(strpos($_SERVER['PHP_SELF'],"/work_notice") !== false){ echo $on; } ?>"><a href="../center/work_notice.php">�۾��� ���ǻ���</a></li>
		<?}?>
	</ul>
</div><!-- .lnb-basic -->
