<?php
// イベント識別文字列を取得
$event_str = $_POST['EventStr'];

if ($_FILES['backGroundImage']) {
	header('Content-type: text/html');
	$imageFile = $_FILES['backGroundImage']['name']; //formのinput name属性="backGroundImage" アップロードファイル名
	
	if (isset($imageFile)){
		// ファイルが既に存在すれば削除
		if (file_exists("../img/bg/".$event_str."jpg")){
			unlink("../img/bg/".$event_str."jpg");
		}
		if (file_exists("../img/bg/".$event_str."png")){
			unlink("../img/bg/".$event_str."png");
		}
		if (file_exists("../img/bg/".$event_str."gif")){
			unlink("../img/bg/".$event_str."gif");
		}
		// 画像をアップロード
		$upload_path = "../img/bg/".$event_str.".png"; //階層が変わるなら書き換え
		move_uploaded_file($_FILES['backGroundImage']['tmp_name'],$upload_path);
		echo 'upload successed';
	}else{
		echo 'can not find the file';
	}
}else{
	echo 'error!';
}
?>