	<?php
    //$JsonFile='{"toppage_img":"'.$this->Html->webroot.'img/thumb/toppage_pbla.png","posmapp_bg":["'.$this->Html->webroot.'img/bg/backGround.png"],"STATIC_WIDTH":"720","STATIC_HEIGHT":"960",';
       $url="";
      if (file_exists("floormap/".$_SESSION["event_id"]."." ."jpg"))
      {
       $url='"venuemap":"'.str_replace('/','\/', $this->Html->webroot).'floormap\/'.$_SESSION["event_id"] .'.jpg",';
        }
       else  if (file_exists("floormap/".$_SESSION["event_id"]."."  ."png"))
       {
      $url='"venuemap":"'.str_replace('/','\/', $this->Html->webroot).'floormap\/'.$_SESSION["event_id"] .'.png",';
       }
       else  if (file_exists("floormap/".$_SESSION["event_id"]."."  ."gif"))
       {
        $url='"venuemap":"'.str_replace('/','\/', $this->Html->webroot).'floormap\/'.$_SESSION["event_id"] .'.gif",';
       }



    $JsonFile='{"toppage_img":"'.str_replace('/','\/',$this->Html->webroot).'img\/thumb\/toppage_pbla.png","posmapp_bg":["'.str_replace('/','\/',$this->Html->webroot).'img\/bg\/backGround.png"],'.$url.'"STATIC_WIDTH":"720","STATIC_HEIGHT":"960",';
    //echo str_replace('/','\/',$this->Html->webroot);
    $pointer=1;
    $JsonPosition='"position":[';
    $JsonAuthor='"author":[';
    $JsonPresent='"presen":[';
    $JsonPoster='"poster":[';
    $JsonKeyword = '"keyword":[';

    foreach($posters as $poster):

    	// presentation_idからプレゼンテーションの情報を取得する
    	if($poster['Poster']['presentation_id'] != 0){
    		$relatedPre = $this->requestAction('/presentations/getByID/'.$poster['Poster']['presentation_id']);
    		// 取得したきたレコードは1件（主キーで検索をかけているから）
    		$preNumber = $relatedPre[0]['Presentation']['number'];
    		$preTitle = $relatedPre[0]['Presentation']['title'];
    		$preAbstract = $relatedPre[0]['Presentation']['abstract'];
    		$preKeywords = $relatedPre[0]['Presentation']['keyword'];
    		$preAuthorsName = $relatedPre[0]['Presentation']['authors_name'];
    		$preAuthorsBelongs = $relatedPre[0]['Presentation']['authors_belongs'];
    	}

    	$JsonPosition.='{';
    	$JsonPosition.='"id":'.'"'.$pointer.'",';
    	$JsonPosition.='"x":'.'"'.$poster['Poster']['x'].'",';
    	$JsonPosition.='"y":'.'"'.$poster['Poster']['y'].'",';
    	$JsonPosition.='"width":'.'"'.$poster['Poster']['width'].'",';
    	$JsonPosition.='"height":'.'"'.$poster['Poster']['height'].'",';
    	$JsonPosition.='"direction":'.'"sideways"';
    	$JsonPosition.='}';

    	// TODO: Authorをさらにコンマで分割してJSONに記述する必要がある
    	$JsonAuthor.='{';
    	$JsonAuthor.='"presenid":"'.$preNumber.'",';
    	$JsonAuthor.='"name":"' .$preAuthorsName. '",';
    	$JsonAuthor.='"belongs":"' .$preAuthorsBelongs. '",';
    	$JsonAuthor.='"first":"1"';
    	$JsonAuthor.='}';

    	$JsonPresent.='{';
    	$JsonPresent.='"presenid":"'.$preNumber.'",';
    	$JsonPresent.='"title":"'.$preTitle.'",';
    	$JsonPresent.='"abstract":"'.$preAbstract.'",';
    	$JsonPresent.='"bookmark":"0"';
    	$JsonPresent.='}';

    	$JsonPoster.='{';
    	$JsonPoster.='"presenid":"'  .$preNumber.  '",';
    	$JsonPoster.='"posterid":"'  .$pointer.  '",';
    	$JsonPoster.='"star":"1",';
    	$JsonPoster.='"date":"1"';
    	$JsonPoster.='}';

    	// TODO: Keywordをさらにコンマで分割してJSONに記述する必要がある
    	$JsonKeyword .= '{';
    	$JsonKeyword .= '"presenid":"' .$preNumber. '",';
    	$JsonKeyword .= '"keyword":"' .$preKeywords. '"';
    	$JsonKeyword .= '}';

    	if($pointer<count($posters)){
    		$pointer=$pointer+1;
    		$JsonPosition.=',';
    		$JsonAuthor.=',';
    		$JsonPresent.=',';
    		$JsonPoster.=',';
    		$JsonKeyword .= ',';
    	}

    	// table出力
    	$htmlAdd = '<tr>';
    	$htmlAdd .= '<td>'.$poster['Poster']['id'].'</td>';
    	$htmlAdd .= '<td>'.$poster['Poster']['width'].'</td>';
    	$htmlAdd .= '<td>'.$poster['Poster']['height'].'</td>';
    	$htmlAdd .= '<td>'.$poster['Poster']['x'].'</td>';
    	$htmlAdd .= '<td>'.$poster['Poster']['y'].'</td>';
    	$htmlAdd .= '<td>'.$poster['Poster']['area_id'].'</td>';
    	$htmlAdd .= '<td>'.$poster['Poster']['date'].'</td>';
    	$htmlAdd .= '</tr>';

    endforeach;

    $JsonPosition.='],';
    $JsonAuthor.='],';
    $JsonPresent.='],';
    $JsonPoster.='],';
    $JsonKeyword .= ']';
    $JsonFile.=$JsonPosition.$JsonAuthor.$JsonPresent.$JsonPoster.$JsonKeyword.'}';
    //echo $JsonFile;

    // JSONへ変換して書き込み
    $filename ='../webroot/json/data.json';

    $handle = fopen($filename, 'w');
    fwrite($handle,$JsonFile);
    fclose($handle);
    //echo 'save successed!';

    ?>
	<script type="text/javascript">
				 window.onload=function()
                 {
			localStorage.clear();
			window.location.href="<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'index')) ?>";
			}
	</script>
