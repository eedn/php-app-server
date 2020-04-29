<?php

    header('content-type: text/html; charset=utf-8');
    // 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)
    $connect=mysqli_connect( "localhost:3306", "tennis", "tennis") or  
    die( "SQL server에 연결할 수 없습니다.");

    mysqli_query($connect,"SET NAMES UTF8");
    // 데이터베이스 선택
    mysqli_select_db($connect,"tennis");

    session_start();
    //세션에서 아이디 전달 못받을 경우, 예외처리.
    if(!isset($_SESSION['user_id'])) die("세션 아이디가 존재하지 않습니다.");
    $id = $_SESSION['user_id'];

    //DB 보낼 INSERT query 준비.
    //변수들 정리
    $teamA_1 = "'".$id."'";
    $team = Array(
        'teamA_2'=>"NULL",
        'teamB_1'=>"NULL",
        'teamB_2'=>"NULL");
    foreach($team as $key => $value)
    {
        if(isset($_POST[$key]) && ($_POST[$key] != ""))
        {
            $tmp = $_POST[$key];
            $team[$key] = "'".$tmp."'";

            //존재하는 user_id인지 확인
            $sql = "SELECT user_id FROM tennis_user WHERE user_id = '{$tmp}'";

            $result = mysqli_query($connect, $sql) or die("에러 발생 1");
            $count = mysqli_num_rows($result);
            if($count != 1) die("{$tmp} 는 존재하지 않는 아이디 입니다.");
        }
    }
    $day = "NULL";
    $place = "NULL";
    if(isset($_POST['day']) && ($_POST['day'] != "")) $day = "'".$_POST['day']."'"; // day 입력형식 : yyyy-mm-dd
    if(isset($_POST['place']) && ($_POST['place'] != "")) $place = "'".$_POST['place']."'";



    
    $sql = "INSERT INTO room (teamA_1, teamA_2, teamB_1, teamB_2, day, place) VALUES ({$teamA_1}, {$team['teamA_2']}, {$team['teamB_1']}, {$team['teamB_2']}, {$day}, {$place})";

    $result = mysqli_query($connect, $sql);

    // result of sql query
    if($result)
    {
        echo "1";
    }
    else
    {
        die("에러 발생2");
        // echo mysqli_errno($connect);
    }

    mysqli_close($connect);

?>