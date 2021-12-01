<? include "../../inc/common.inc"; ?>
<? include "../../inc/util.inc"; ?>
<? include "../../inc/shop_info.inc"; ?>
<? include "../../inc/bbs_info.inc"; ?>
<? include "../../inc/admin_check.inc"; ?>
<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php'; ?>
<?
$param = "code=$code&searchopt=$searchopt&searchkey=$searchkey";
?>
<script language="JavaScript" type="text/javascript">
<!--

// 체크박스 전체선택
function selectAll(){
	var i;
	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].idx != null){
			if(document.forms[i].select_checkbox){
				document.forms[i].select_checkbox.checked = true;
			}
		}
	}
	return;
}

// 체크박스 선택해제
function selectCancel(){
	var i;
	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].select_checkbox){
			if(document.forms[i].idx != null){
				document.forms[i].select_checkbox.checked = false;
			}
		}
	}
	return;
}

// 체크박스선택 반전
function selectReverse(form){
	if(form.select_tmp.checked){
		selectAll();
	}else{
		selectCancel();
	}
}

// 체크박스 선택리스트
function selectValue(){
	var i;
	var selbbs = "";
	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].idx != null){
			if(document.forms[i].select_checkbox){
				if(document.forms[i].select_checkbox.checked)
					selbbs = selbbs + document.forms[i].idx.value + "|";
				}
			}
	}
	return selbbs;
}

//선택게시물 삭제
function delBbs(){

	selbbs = selectValue();

	if(selbbs == ""){
		alert("삭제할 게시물을 선택하세요.");
		return false;
	}else{
		if(confirm("선택한 게시물을 정말 삭제하시겠습니까?")){
			document.location = "new_mall_save.php?<?=$param?>&page=<?=$page?>&mode=delbbs&selbbs=" + selbbs;
		}
	}
}
//-->
</script>


<h2 class="page_ttl"><?=$bbs_info[title]?></small></h2>

    <form name="searchForm" action="bbs_list.php" method="get">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>

        <td align="right" valign="bottom" style="padding:0 0 3px;">
          <select name="searchopt">
          <option value="subject">제목
          <option value="content">내용
          <option value="name">작성자
          </select>
		  <input type="text" size="13" name="searchkey" class="input">
			<button type="submit" class="btn-search">검색</button>
        </td>
      </tr>
      <tr><td height="3"></td></tr>
    </table>
	</form>
    <script language="javascript">
    <!--
    code = document.searchForm.code;
    for(ii=0; ii<code.length; ii++){
      if(code.options[ii].value == "<?=$code?>")
      code.options[ii].selected = true;
    }
    if(document.searchForm.category != null){
    category = document.searchForm.category;
    for(ii=0; ii<category.length; ii++){
      if(category.options[ii].value == "<?=$category?>")
      category.options[ii].selected = true;
    }
  	}
    searchopt = document.searchForm.searchopt;
    for(ii=0; ii<searchopt.length; ii++){
      if(searchopt.options[ii].value == "<?=$searchopt?>")
      searchopt.options[ii].selected = true;
    }
    -->
    </script>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="layout:fixed;">
      <form>
      <tr><td class="t_rd" colspan="20"></td></tr>
      <tr class="t_th">
        <th width="5%"><input type="checkbox" name="select_tmp" onClick="selectReverse(this.form)"></th>
        <th width="8%">번호</th>
        <th>상품명</th>
        <th>모델명</th>
        <th>사양</th>
        <th>제조사</th>
		<th>예상구매수량</th>
		<th>1회성 여부</th>
		<th>상태</th>
		<th>기능</th>
      </tr>
      <tr><td class="t_rd" colspan="20"></td></tr>
      </form>
		<?
		if($category) $category_sql = " and category = '$category' ";
		if($searchopt) $search_sql = " and $searchopt like '%$searchkey%' ";

		if($wiz_admin['type'] == "member") $member_sql = "AND memid = '".$wiz_admin['id']."'";

		$sql = "select wb.*, wb.wdate as wtime, from_unixtime(wb.wdate, '%Y-%m-%d') as wdate, wc.catname
						from wiz_bbs as wb left join wiz_bbscat as wc on wb.category = wc.idx
						where wb.sid='$SID' and wb.code = '$code' $category_sql $search_sql $member_sql order by wb.prino desc";

		$result = mysql_query($sql) or error(mysql_error());
		$total = mysql_num_rows($result);

		$rows = 20;
		$lists = 5;
        $ttime = mktime(0,0,0,date('m'),date('d'),date('Y'));
		$today = date('Ymd');
		$page_count = ceil($total/$rows);
		if(!$page || $page > $page_count) $page = 1;
		$start = ($page-1)*$rows;
		$no = $total-$start;

		$sql = "select wb.*, wb.wdate as wtime, from_unixtime(wb.wdate, '%Y-%m-%d') as wdate, wc.catname as category
						from wiz_bbs as wb left join wiz_bbscat as wc on wb.category = wc.idx
						where wb.sid='$SID' and wb.code = '$code' $category_sql $search_sql $member_sql
						order by wb.prino desc limit $start, $rows";
		$result = mysql_query($sql) or error(mysql_error());

		while(($row = mysql_fetch_array($result)) && $rows){
		?>
		<form>
			<input type="hidden" name="idx" value="<?=$row[idx]?>">
			<tr>
			    <td align="center">
				<? if($row['status'] == "요청" || $wiz_admin['type'] == "admin") { ?>
					<input type="checkbox" name="select_checkbox">
				<? } ?>
				</td>
				<td height="40" align="center"><?=$no?></td>
				<td align="center"><?=$row['prdinfo1']?></td>
				<td align="center"><?=$row['prdinfo2']?></td>
				<td align="center"><?=$row['prdinfo3']?></td>
				<td align="center"><?=$row['prdinfo4']?></td>
				<td align="center"><?=$row['prdinfo5']?></td>
				<td align="center"><?=$row['prdinfo6']?></td>
				<td align="center"><?=$row['status']?></td>
				<td align="center"><a href="./new_mall_input.php?mode=update&idx=<?=$row['idx']?>&<?=$param?>&page=<?=$page?>" class="AW-btn-s">상세보기</a></td>
			  </tr>
			<tr><td colspan="20" class="t_line"></td></tr>
		</form>
   	<?
   		$no--;
			$rows--;
    }
    if($total <= 0){
    ?>
    <tr><td height=25 colspan=10 align=center>작성된 글이 없습니다.</td></tr>
    <tr><td colspan="20" class="t_line"></td></tr>
    <?
    }
    ?>
    </table>

    <table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
    	<tr><td height="5"></td></tr>
    	<tr>
        <td width="33%">
            <button type="button" class="AW-btn" onclick="delBbs();">선택삭제</button>
            <a href="new_mall_input.php?<?=$param?>" class="AW-btn">글쓰기</a>
        </td>
        <td width="33%"><? print_pagelist($page, $lists, $page_count, $param); ?></td>
        <td width="33%" align="right">
        </td>
      </tr>

    </table>


    <? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php'; ?>
