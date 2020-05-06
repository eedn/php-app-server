<?php
	header('content-type: text/html; charset=utf-8');
	//POST로 room_id가 없을 경우 예외 처리
	if(!isset($_POST['room_id'])) die("ERROR: room_id가 보내지지 않았습니다.");
	if(!isset($_POST['team'])) die("ERROR: team이 보내지지 않았습니다.");
	//세션 없을경우 예외 처리
	session_start();
	if(!isset($_SESSION['user_id'])) die("ERROR: 세션이 연결되지 않았습니다.");
	if(!isset($_FILES['myFile'])) die("ERROR: 파일이 보내지지 않았습니다.");

	//변수 정리
	$user_id = $_SESSION['user_id'];
	$room_id = $_POST['room_id'];
	$team = $_POST['team'];
	$current_dir = $_SERVER['PHP_SELF']."/../"; //현재 디렉토리

	//도메인주소(호스트명)
	$hostname = $_SERVER["HTTP_HOST"];

	$file_name = $_FILES['myFile']['name'];
	$file_size = $_FILES['myFile']['size'];
	$file_type = $_FILES['myFile']['type'];
	$temp_name = $_FILES['myFile']['tmp_name'];

	$location = "uploads/".$room_id."/"; //저장할 디렉토리

	//디렉토리 확인
	if(!is_dir("uploads/".$room_id))
	{
		mkdir("uploads/".$room_id);
	}

	//파일 이동
	if(!move_uploaded_file($temp_name, $location.$file_name)) die("ERROR: 업로드 실패!");
	$file_path = "http://".$hostname.$current_dir.$location.$file_name;

    // 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)
    $connect=mysqli_connect( "localhost:3306", "tennis", "tennis") or  
	die( "ERROR: SQL server에 연결할 수 없습니다.");
	
    mysqli_query($connect,"SET NAMES UTF8");
    // 데이터베이스 선택
	mysqli_select_db($connect,"tennis");
	
	//데이터베이스에 file_path 저장
    $sql = "INSERT INTO video_data (file_path, room_id, user_id, team) VALUES ('{$file_path}', '{$room_id}', '{$user_id}', '{$team}')";
	$result = mysqli_query($connect, $sql);
	if($result)
	{
		echo "1";
	}
	else
	{
		//데이터베이스에 room_id 존재 확인
		$sql = "SELECT room_id FROM room WHERE room_id = '{$room_id}'";
		$result = mysqli_query($connect, $sql) or die("ERROR: 에러 발생-room_id");
		$count = mysqli_num_rows($result);
		if($count!=1) die("ERROR: 존재하지 않는 room_id 입니다.");

		//데이터베이스에 file_path 중복 확인
		$sql = "SELECT file_path FROM video_data WHERE file_path = '{$file_path}'";
		$result = mysqli_query($connect, $sql) or die("ERROR: 에러 발생-file_path");
		$count = mysqli_num_rows($result);
		if($count==1) die("ERROR: 중복되는 file 입니다.");
		else die("ERROR: 알수없는 에러");
	}
	
    mysqli_close($connect);
?>