<!DOCTYPE html>
<meta charset="utf-8" />
<a href="../Logout"><button>로그아웃</button></a><br/>
<?php

    // 세션 시작
    session_start();

    $id = $_SESSION['user_id'];
    $name = $_SESSION['name'];

    echo "이름은 {$name}.<br/>";

?>
<form enctype="multipart/form-data" method='post' action='videoupload.php'>
<table>
<tr>
	<td>room_id : </td>
	<td><input type='text' name='room_id' tabindex='1'/></td>
	<td rowspan='2'><input type='submit' tabindex='3' value='전송' style='height:50px'/></td>
</tr>
<tr>
	<td>파일</td>
	<td><input type='file'' name='myFile' tabindex='2'/></td>
</tr>
</table>
</form>