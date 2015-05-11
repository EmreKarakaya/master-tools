<?php 
	error_reporting(0);
	function date_f(){ # akincio-2015  ## use=> echo date_f();
		$date_d = date('d');
		$date_m = date('m');
		$date_y = date('Y');
		$date_h = date('H:i:s');
		
		$months = array('Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık');
		$month_tr = $months[$date_m-1];
		return $date_d.' '.$month_tr.' '.$date_y.' / '.$date_h;
	}
	
	function getDomainName( $url ){ #alexa
		$pattern = '/\w+\..{2,3}(?:\..{2,3})?(?:$|(?=\/))/i';
		if ( preg_match($pattern, $url, $matches) ){
			return $matches[0];
		}
		return false;
	}

	function getGoogleCount($domain) { #Google sayfa sayısı 
		$content = file_get_contents('http://ajax.googleapis.com/ajax/services/'.'search/web?v=1.0&filter=0&q=site:' . urlencode($domain));  
		$data = json_decode($content);  
		$result = intval($data->responseData->cursor->estimatedResultCount);  
		if ($result > 1000) {$result = floor($result / 1000).'K';} return $result; 
	}
	

	function dmoz($degisken){ #Dmoz kontrolü
		$dmoz=file_get_contents("http://www.dmoz.org/search?q=$degisken"); 
		$dmoz_durum=explode("<h3>",$dmoz); 
		$dmoz_durum=explode("</h3>",$dmoz_durum[1]); 
		$dmoz_get=$dmoz_durum[0]; 
		if($dmoz_get){ 
			return "Var<img class='link' src='images/true.png' />"; 
		}else{ 
			return "Yok<img class='link' src='images/false.png' />"; 
		} 
	} 
	
	function GoogleBL($domain){ #Google Backlink Counter
	$url="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=link:%20".$domain."&filter=0";
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt ($ch, CURLOPT_NOBODY, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$json = curl_exec($ch);
	curl_close($ch);
	$data=json_decode($json,true);
	if($data['responseStatus']==200)
	return $data['responseData']['cursor']['resultCount'];
	else
	return false;
	}
	

	function fetchSocialShare($bas, $son, $yazi) 
	{ 
	@preg_match_all('/' . preg_quote($bas, '/') . 
	'(.*?)'. preg_quote($son, '/').'/i', $yazi, $m); 
	return @$m[1]; 
	} 
	



?>