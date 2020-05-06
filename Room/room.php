<?php
    //POST로 user_id가 없거나 pw가 없을 경우 예외 처리
    if(!isset($_POST['room_id'])) die("ERROR: room_id가 보내지지 않았습니다.");

    //세션 시작
    session_start();
    if(!isset($_SESSION['user_id'])) die("ERROR: user_id가 세션에 존재하지 않습니다.");

    header('content-type: text/html; charset=utf-8');
    // 데이터베이스 접속 문자열, (db위치, 유저이름, 비밀번호)
    $connect=mysqli_connect( "localhost:3306", "tennis", "tennis") or
    die( "ERROR: SQL server에 연결할 수 없습니다.");

    mysqli_query($connect, "SET NAMES UTF8");
    //데이터베이스 선택
    mysqli_select_db($connect, "tennis");

    //쿼리에 필요한 변수들 정리
    $room_id = $_POST['room_id'];
    $user_id = $_SESSION['user_id'];

    //room 정보 쿼리
    $sql = "SELECT * from room WHERE room_id = '{$room_id}'";

    $result = mysqli_query($connect, $sql) or die("ERROR: 에러발생1");

    //room 결과값 존재여부 확인
    $count = mysqli_num_rows($result);
    if($count!=1)
    {
        die("ERROR: 해당하는 room정보가 없습니다");
    }
    //room 결과값 예외처리
    if(!$result)
    {
        die("ERROR: mysql error number - ".mysqli_errno($connect));
    }

    //room 결과값 처리(연관배열)
    $row = mysqli_fetch_assoc($result) or die("ERROR: 에러발생2");
    
    //video 정보 쿼리
    $sql = "SELECT video_id, file_path, result_path, team FROM video_data WHERE room_id = '{$room_id}'";

    //stmt 생성. 
    $stmt = $connect->prepare($sql);

    //video 쿼리 실행
    $stmt->execute();

    //video 변수 바인딩
    $stmt->bind_result($video_id, $file_path, $result_path, $team);
    
    $i = 1;
    while($stmt->fetch())
    {
        //각 결과값은 임의 배열에 저장
        $temp = [
            'video_id'=>$video_id,
            'file_path'=>$file_path,
            'result_path'=>$result_path,
            'team'=>$team
        ];

        //결과 배열에 데이터 저장
        $row["video_".$i] = $temp;
        $i++;
    }

    echo json_encode($row);

    mysqli_close($connect);

?>