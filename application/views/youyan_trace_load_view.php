<?php
date_default_timezone_set('PRC');

for($i=0;$i<=5;$i++){
	$pinTime = time()-60*60*24*$i;
	$pinDate = date('Y-m-d',$pinTime);
	$nextTime = $pinTime+60*60*24;
	$nextDate = date('Y-m-d',$nextTime);
	$dailyreport = mysql_query("SELECT view as flow, DATE_FORMAT(date, '%Y-%m-%d' ) as s_time, domain as domain_name
							FROM domain_date_view WHERE to_days(date) >= to_days('$pinDate') AND to_days(date) < to_days('$nextDate')  ORDER BY view DESC");
	$arrItem[$i]['allTrace'] = 0;
	$arrItem[$i]['countAll'] = 0;
	$arrItem[$i]['countGreat'] = 0;
	while($rowData = mysql_fetch_array($dailyreport)){
		$arrItem[$i][$rowData['domain_name']] = $rowData['flow'];
		$arrItem[$i]['allTrace'] += $rowData['flow'];
		$arrItem[$i]['countAll'] +=1;
		if($rowData['flow']>=100){$arrItem[$i]['countGreat'] +=1;};
	}
}
//$i = 0 means current day $i = 1 means previous day
for($i=0;$i<=4;$i++){
	$pinTime = time()-60*60*24*$i;
	$pinDate = date('Y-m-d',$pinTime);
	$nextTime = $pinTime+60*60*24;
	$nextDate = date('Y-m-d',$nextTime);
	echo '<br/><br/><strong>日期:'.$pinDate.'  日累计UV:'.$arrItem[$i]['allTrace'];
	$amountChange = $arrItem[$i]['countAll'] -$arrItem[($i+1)]['countAll'];
	if($amountChange>0){
	echo ' 日加载网站:'.$arrItem[$i]['countAll'].'<span style="font-weight:bold;color:#C60A00;">(增长'.$amountChange.'个)</span>';
	}else{
	$amountChange = -$amountChange;
	echo ' 日加载网站:'.$arrItem[$i]['countAll'].'<span style="font-weight:bold;color:#008000;">(减少'.$amountChange.'个)</span>';	
	}

	$amountGreatChange = $arrItem[$i]['countGreat'] -$arrItem[($i+1)]['countGreat'];
	if($amountGreatChange>0){
	echo ' 日高质网站:'.$arrItem[$i]['countGreat'].'<span style="font-weight:bold;color:#C60A00;">(增长'.$amountGreatChange.'个)</span></strong><br/><br/>';
	}else{
	$amountGreatChange = -$amountGreatChange;
	echo ' 日高质网站:'.$arrItem[$i]['countGreat'].'<span style="font-weight:bold;color:#008000;">(减少'.$amountGreatChange.'个)</span></strong><br/><br/>';	
	}
	$listTerrible = array();	
	foreach($arrItem[$i] as $domainName => $rowData){
		echo '<div style="padding:5px 0 5px 0;border-top:1px solid #aaa;"><strong style="width:300px;display:block;float:left;">'.$domainName.'</strong> ';
		if($domainName=='countAll'||$domainName=='countGreat'){
			echo '<div style="float:left;width:100px;">网站数:'.$rowData.'</div>';
		}else{
			echo '<div style="float:left;width:100px;">UV:'.$rowData.'</div>';
		}
		if(isset($arrItem[($i+1)][$domainName])&&$arrItem[($i+1)][$domainName]!=''){
			$changeState = $rowData - $arrItem[($i+1)][$domainName];
			if($changeState>0){
				echo '<div style="float:left;padding-left:10px;font-weight:bold;color:#C60A00;">日比增长:'.$changeState.'</div>';
				echo '<div style="float:left;padding-left:4px;font-weight:bold;color:#C60A00;">比率:'.round(100*($changeState/$rowData),0).'%</div>';
			}else{
				echo '<div style="float:left;padding-left:10px;font-weight:bold;color:#008000;">日比下降:'.(0-$changeState).'</div>';
				echo '<div style="float:left;padding-left:4px;font-weight:bold;color:#008000;">比率:'.round(100*((0-$changeState)/$rowData),0).'%</div>';
			}
			if($rowData<=100&&$arrItem[($i+1)][$domainName]>100){
				$listTerrible = $listTerrible.$domainName.' 上日UV: '.$arrItem[($i+1)][$domainName].' 今日UV: '.$rowData.', ';
			}
		
		}else{
			echo '<div style="float:left;padding-left:10px;font-weight:bold;color:#e07706;">新网站</div>';
		}
		
		echo '<div style="clear:both;font-size:1px;height:0;}"></div></div>';
		
	}
	echo '<div style="font-size:16px;color:#008000;font-weight:bold; padding:10px;background-color:#ddd;">'.$listTerrible.'</div>';
}


?>
