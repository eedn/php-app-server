<!DOCTYPE html>
<meta charset="utf-8" />
<?php
    session_start();
    if(!isset($_SESSION['user_id'])) echo "세션 없음";
	else echo $_SESSION['user_id'];
?>
<a href="../Logout"><button>로그아웃</button></a>
<form method='post' action='createroom.php'>
<table>
<tr>
	<td>팀원1</td>
	<td><input type='text' name='teamA_2' tabindex='1'/></td>
	<td rowspan='5'><input type='submit' tabindex='6' value='룸 생성' style='height:125px'/></td>
</tr>
<tr>
	<td>상대팀1</td>
	<td><input type='text' name='teamB_1' tabindex='2'/></td>
</tr>
<tr>
	<td>상대팀2</td>
	<td><input type='text' name='teamB_2' tabindex='3'/></td>
</tr>
<tr>
	<td>날짜</td>
	<td><input type='text' name='day' tabindex='4' placehold="yyyy-mm-dd"/></td>
</tr>
<tr>
	<td>장소</td>
	<td><input type='text' name='place' tabindex='5'/></td>
</tr>
</table>
</form>
<a href="../RoomList"><button>룸 목록으로</button></a>