<?php
ini_set('auto_detect_line_endings', true);
class Schedule extends AppModel {
    public function loadCSV($filename){
	        $this->begin();
            try{
                //最初にTable:sessionを初期化
                $this->deleteAll('1=1',false);
                $handle = fopen($filename,"r");
                while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){
                mb_convert_variables("UTF-8","SJIS", $row);
                    $scheduleData = array(
                        'room' => $row[0],
                        'order' => $row[1],
                        'category' => $row[2],
                        'date' => $row[3],
                        'start_time' =>  $row[4],
                        'end_time' => $row[5],
                        'chairperson_name' => $row[6],
                        'chairperson_belongs' => $row[7],
                        'commentator_name' => $row[8],
                        'commentator_belongs' => $row[9]
                    );
                    // フォーマットヘッダー無視用
                    if($row[0] != "room") {
                            $this->create($scheduleData);
                            $this->save();
                    }
                }
                $this->commit();
            }catch(Exception $e){
                $this->rollback();
            }
    }
}
?>
