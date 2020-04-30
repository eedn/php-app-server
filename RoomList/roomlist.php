<?php
    //세션 시작
    session_start();
    if(!isset($_SESSION['user_id']) || !isset($_SESSION['name'])) die("에러발생1");

    header('content-type: text/html; charset=utf-8');
    // 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)
    $connect=mysqli_connect( "localhost:3306", "tennis", "tennis") or  
    die( "SQL server에 연결할 수 없습니다.");

    mysqli_query($connect,"SET NAMES UTF8");
    // 데이터베이스 선택
    mysqli_select_db($connect,"tennis");

    $user_id = $_SESSION['user_id']; //세션 id 변수 설정

    //sql 쿼리
    $sql = "SELECT * FROM room WHERE '{$user_id}' IN (teamA_1, teamA_2, teamB_1, teamB_2)";

    $result = array(); 
    
    //creating an statment with the query
    $stmt = $connect->prepare($sql);
    
    //executing that statment
    $stmt->execute();
    
    //binding results for that statment 
    $stmt->bind_result($room_id, $teamA_1, $teamA_2, $teamB_1, $teamB_2, $day, $place);
    
    //looping through all the records
    while($stmt->fetch()){
        
        //pushing fetched data in an array 
        $temp = [
            'room_id'=>$room_id,
            'teamA_1'=>$teamA_1,
            'teamA_2'=>$teamA_2,
            'teamB_1'=>$teamB_1,
            'teamB_2'=>$teamB_2,
            'day'=>$day,
            'place'=>$place
        ];
        
        //pushing the array inside the result array 
        array_push($result, $temp);
    }
    
    //displaying the data in json format 
    echo json_encode($result);

    mysqli_close($connect);

?>