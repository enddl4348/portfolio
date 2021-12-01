<? include "../../inc/common.inc"; ?>
<? include "../../inc/util.inc"; ?>
<? include "../../inc/admin_check.inc"; ?>
<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php'; ?>

<?
$sql = "SELECT wo.order_date, wo.orderid, wb.prdcode, wb.prdname, wp.spec, wp.packing, wp.packing_unit, wp.packing_unit2, wp.order_unit, wb.mall_name, wb.prdprice, wb.ord_status, wb.del_date, wb.ex_del_date, wb.b_pay_date
		from wiz_order wo
		INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid
		INNER JOIN wiz_product wp ON wp.prdcode = wb.prdcode
		LEFT JOIN wiz_mall wpm ON wpm.id = wb.mallid
		WHERE 1 AND wo.send_id = '".$wiz_admin['id']."'
		ORDER BY wo.order_date desc, wb.idx desc";
$result = mysql_query($sql) or error(mysql_error());
$total = mysql_num_rows($result);

$rows = 20;
$lists = 5;
$page_count = ceil($total/$rows);
if($page < 1 || $page > $page_count) $page = 1;
$start = ($page-1)*$rows;
$no = $total-$start;
?>
<div class="purc_list">
	<h2 class="page_ttl">구매현황</h2>
	<table class="purc_list-tb">
		<tr>
			<th>구매일자</th>
			<th>PO 번호</th>
			<th>PO 번호_NO</th>
			<th>상품코드</th>
			<th>구매사</th>
			<th>부서</th>
			<th>상품평</th>
			<th>사양</th>
			<th>포장단위</th>
			<th>주문단위</th>
			<th>공급사</th>
			<th>단가금액</th>
			<th>주문상태</th>
			<th>납품요청일</th>
			<th>납품예정일</th>
			<th>납품완료일</th>
		</tr>
		<?
		$sql = "SELECT wo.order_date, wo.orderid, wb.prdcode, wb.prdname, wp.spec, wp.packing, wp.packing_unit, wp.packing_unit2, wp.order_unit, wb.mall_name, wb.prdprice, wb.ord_status, wb.del_date, wb.ex_del_date, wb.b_pay_date
				from wiz_order wo
				INNER JOIN wiz_basket wb ON wb.orderid = wo.orderid
				INNER JOIN wiz_product wp ON wp.prdcode = wb.prdcode
				LEFT JOIN wiz_mall wpm ON wpm.id = wb.mallid
				WHERE 1 AND wo.send_id = '".$wiz_admin['id']."'
				ORDER BY wo.order_date desc, wb.idx desc
				LIMIT $start, $rows";
		$result = mysql_query($sql) or error(mysql_error());

		$order_no = 1;
		$orderid_new = "";

		while($row = mysql_fetch_assoc($result)) {
			$row['order_date'] = str_replace("-", ".", substr($row['order_date'], 0, 10));
			$row['del_date'] = str_replace("-", ".", $row['del_date']);
			$row['ex_del_date'] = str_replace("-", ".", $row['ex_del_date']);

			if($row['orderid'] == $orderid_new) $order_no++;
			else $order_no = 1;
		?>
		<tr>
			<td><?=$row['order_date']?></td>
			<td><?=$row['orderid']?></td>
			<td><?=$order_no?></td>
			<td><?=$row['prdcode']?></td>
			<td><?=$wiz_admin['com_name']?></td>
			<td><?=$wiz_admin['sub_name']?></td>
			<td class="prd-name"><span><?=$row['prdname']?></span></td>
			<td><?=$row['spec']?></td>
			<td><?=$row['packing']?> <?=$row['packing_unit']?>/<?=$row['packing_unit2']?></td>
			<td><?=$row['order_unit']?></td>
			<td><?=$row['mall_name']?></td>
			<td><?=number_format($row['prdprice'])?></td>
			<td><?=order_status($row['ord_status'])?></td>
			<td><?=$row['del_date']?></td>
			<td><?=$row['ex_del_date']?></td>
			<td><?=$row['b_pay_date']?></td>
		</tr>
		<?
			$orderid_new = $row['orderid'];
		}
		?>
	</table>
	<br>
	<? print_prd_pagelist($page, $lists, $page_count, "$param"); ?>
</div>

<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php'; ?>