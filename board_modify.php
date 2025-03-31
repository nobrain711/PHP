<?php
    $con = mysqli_connect("localhost", "user1", "12345", "sample");
    $num = $_GET["num"];
    $page = $_GET["page"];

    $subject = $_POST["subject"];
    $content = $_POST["content"];
    $subject = htmlspecialchars($subject, ENT_QUOTES);
	$content = htmlspecialchars($content, ENT_QUOTES);

	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

	$upload_dir = './data/';

	$upfile_name	 = $_FILES["upfile"]["name"];
	$upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
	$upfile_type     = $_FILES["upfile"]["type"];
	$upfile_size     = $_FILES["upfile"]["size"];
	$upfile_error    = $_FILES["upfile"]["error"];

	//새로 등록된 파일이 있는지 검사
    if ($upfile_name && !$upfile_error){
		$file = explode(".", $upfile_name);
		$file_name = $file[0];
		$file_ext  = $file[1];

		$new_file_name = date("Y_m_d_H_i_s");
		$new_file_name = $new_file_name;
		$copied_file_name = $new_file_name.".".$file_ext;      
		$uploaded_file = $upload_dir.$copied_file_name;

		if( $upfile_size  > 10000000 ) {
				echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(10MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
				exit;
		}

		if (!move_uploaded_file($upfile_tmp_name, $uploaded_file) )
		{
				echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
				exit;
		}
		//전에 파일 제거
        $sql = "select file_copied from board where num = '$num'";
        $reulst = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($reulst);
        $downfile_name = $row["file_copied"];
		
		//파일 존재 여부
		if($downfile_name != ""){
        $file_path = "./data/".$downfile_name;
		@unlink($file_path);
		}

		//새로운 파일로 DB에 저장
        $sql = "update board set subject = '$subject', content = '$content',";
        $sql .="regist_day = '$regist_day', file_name = '$upfile_name',";
        $sql .="file_type = '$upfile_type', file_copied = '$copied_file_name'";
		$sql .="where num=$num";
	}
	//변경된 파일이 없으면 그래돌 진행
	else {
        $sql = "update board set subject='$subject', content='$content' ";
        $sql .= " where num=$num";        
	}

    //최종적으로 테스트
    mysqli_query($con, $sql);
    mysqli_close($con);     

    echo "
	      <script>
	          location.href = 'board_list.php?page=$page';
	      </script>
	  ";
?>

   
