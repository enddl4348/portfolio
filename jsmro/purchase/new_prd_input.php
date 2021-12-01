<? include "../../inc/common.inc"; ?>
<? include "../../inc/util.inc"; ?>
<? include "../../inc/shop_info.inc"; ?>
<? include "../../inc/bbs_info.inc"; ?>
<? include "../../inc/admin_check.inc"; ?>
<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php'; ?>

<?
$param = "code=$code&searchopt=$searchopt&searchkey=$searchkey";
$param .= "&page=$page";


$upfile_max = $bbs_info[upfile];
$movie_max = $bbs_info[movie];

if($mode == "insert" || $mode == ""){

	$mode = "insert";
	$bbs_row[name] = $wiz_admin[name];
	$bbs_row[email] = $wiz_admin[email];
	$bbs_row[wdate] = date('Y-m-d H:i:s');
	$bbs_row[passwd] = date('is');
	$bbs_row[count] = 0;

}else if($mode == "update"){

	$sql = "select *,from_unixtime(wdate, '%Y-%m-%d %H:%i:%s') as wdate from wiz_bbs where code = '$code' and idx='$idx' and sid='$SID'";
	$result = mysql_query($sql) or error(mysql_error());
	$bbs_row = mysql_fetch_array($result);

}
?>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function inputCheck(frm){

	if(frm.prdinfo1.value == ""){
		alert("상품명을 입력하세요.");
		frm.prdinfo1.focus();
		return false;
	}

	if(frm.prdinfo5.value == ""){
		alert("예상구매수량을 입력하세요.");
		frm.prdinfo5.focus();
		return false;
	}

	if(frm.prdinfo6.value == ""){
		alert("1회성여부를 선택하세요.");
		return false;
	}

}

// 우편번호 찾기
function zipSearch(kind){
	if(kind == undefined) kind = '';
	new daum.Postcode({
		oncomplete: function(data) {
			// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
			// 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
			eval('document.frm.'+kind+'post').value = data.zonecode;
			eval('document.frm.'+kind+'address1').value = data.address;

			//전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
			//아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
			//var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
			//document.getElementById('addr').value = addr;

			if(eval('document.frm.'+kind+'address2') != null)
				eval('document.frm.'+kind+'address2').focus();
		}
	}).open();
}
//-->
</script>


<h2 class="page_ttl"><?=$bbs_info[title]?></h2>

<form name="frm" action="new_prd_save.php" method="post" enctype="multipart/form-data" onSubmit="return inputCheck(this)">
	<input type="hidden" name="code" value="<?=$code?>">
	<input type="hidden" name="mode" value="<?=$mode?>">
	<input type="hidden" name="idx" value="<?=$idx?>">
	<input type="hidden" name="page" value="<?=$page?>">
	<input type="hidden" name="searchopt" value="<?=$searchopt?>">
	<input type="hidden" name="searchkey" value="<?=$searchkey?>">

	<? if($wiz_admin['type'] == "admin") { ?>
	<div>
		<input type="radio" name="status" id="status1" value="요청" <?if($bbs_row['status'] == "요청") echo "checked";?>> <label for="status1">요청</label>
		<input type="radio" name="status" id="status2" value="견적진행" <?if($bbs_row['status'] == "견적진행") echo "checked";?>> <label for="status2">견적진행</label>
		<input type="radio" name="status" id="status3" value="등록완료" <?if($bbs_row['status'] == "등록완료") echo "checked";?>> <label for="status3">등록완료</label>
	</div>
	<? } else { ?>
	<input type="hidden" name="status" value="<?=$bbs_row['status']?>">
	<? } ?>
	<table class="sec_cmn-tb">
		<tr>
			<th>상품명</th>
			<td colspan="3"><input type="text" name="prdinfo1" value="<?=$bbs_row['prdinfo1']?>" placeholder="상품명을 입력해 주세요."/></td>
		</tr>
		<tr>
			<th>모델명</th>
			<td colspan="3"><input type="text" name="prdinfo2" value="<?=$bbs_row['prdinfo2']?>" placeholder="모델명을 입력해 주세요."/></td>
		</tr>
		<tr>
			<th>사양</th>
			<td colspan="3"><input type="text" name="prdinfo3" value="<?=$bbs_row['prdinfo3']?>" placeholder="사양을 입력해 주세요."/></td>
		</tr>
		<tr>
			<th>제조사</th>
			<td colspan="3"><input type="text" name="prdinfo4" value="<?=$bbs_row['prdinfo4']?>" placeholder="제조사를 입력해 주세요."/></td>
		</tr>
		<tr>
			<th>예상 구매수량</th>
			<td width="30%"><input type="text" name="prdinfo5" value="<?=$bbs_row['prdinfo5']?>" placeholder="예상 구매수량을 입력해 주세요."/></td>
			<th>1회성 여부</th>
			<td class="input-radio">
				<input type="radio" id="yes" name="prdinfo6" value="Yes" <?=$bbs_row['prdinfo6']=="Yes"? "checked" : ""?>>	<label for="yes"> Yes</label>
				<input type="radio" id="no" name="prdinfo6" value="No" <?=$bbs_row['prdinfo6']=="No"? "checked" : ""?>> <label for="no">NO</label>
			</td>
		</tr>
		<tr>
			<th>신규등록요청사유</th>
			<td colspan="3"><input type="text" name="prdinfo7" value="<?=$bbs_row['prdinfo7']?>" placeholder="신규등록요청사유를 입력해 주세요." style="width:760px;"/></td>
		</tr>
	</table>

	<div class="AW-manage-btnwrap clearfix">
		<button type="submit" class="on">확인</button>
		<a href="new_prd.php?<?=$param?>">목록</a>
	</div>
</form>

<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php'; ?>