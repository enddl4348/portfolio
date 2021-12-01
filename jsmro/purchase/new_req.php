<? include "../../inc/common.inc"; ?>
<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php'; ?>

<div class="new_req">
  <h2 class="page_ttl">신규상품등록요청</h2>
  
  <table class="sec_cmn-tb">
    <tr>
      <th>상품명</th>
      <td> <input type="text" placeholder="상품명을 입력해 주세요."/></td>
    </tr>
    <tr>
      <th>필요 수량</th>
      <td> <input type="text" placeholder="필요 수량을 입력해 주세요."/></td>
    </tr>
    <tr>
      <th>상세 설명</th>
      <td> 
        	<?
			$edit_height = "500";
		
			include "../webedit/WIZEditor.html";
			?></td>
    </tr>
    
  </table>
  <div class="AW-manage-btnwrap clearfix">
    <button type="submit" class="on">확인</button>
    <button type="button">취소</button>
  </div>
</div>

<? include $_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php'; ?>


