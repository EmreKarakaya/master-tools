<?php
include('config/functions.php');
include("config/DomainAge.class.php");
include("config/get-social-metrics.php");


require_once("config/google_pagerank.class.php");

echo "<br/>Sorgu zamanı : ".date_f()."</br>";

if ( !isset($_POST['p']) ){
	$url = $_POST['site_url'];
	if($url == "")$url="google.com";
	if ( $url && $domain = getDomainName( $url ) ){
		$alexaApiURL = 'http://data.alexa.com/data?cli=10&url=' . $domain;
		$alexaApi = simplexml_load_file( $alexaApiURL );
		
		$tmpArray = array(
			'GLOBAL' => (int) $alexaApi->SD->POPULARITY->attributes()->TEXT 
		);
		
		if ( isset($alexaApi->SD->COUNTRY) ){
			$tmpArray['COUNTRY'] = (int) $alexaApi->SD->COUNTRY->attributes()->RANK;
			$tmpArray['COUNTRY_FLAG'] = (string) $alexaApi->SD->COUNTRY->attributes()->CODE;
			$tmpArray['COUNTRY_NAME'] = (string) $alexaApi->SD->COUNTRY->attributes()->NAME;
		}	
	}
}

?>


<?php if ( isset($tmpArray) ){ ?>
		<hr />
		<table cellspacing="0" cellpadding="5" class="stable">
		<tr>
			<td>Site Adresi</td>
			<td><?php echo $domain; ?> </td>
		</tr>
		<tr>
			<td>Alexa Global Değer</td>			
			<td><?php echo number_format($tmpArray['GLOBAL'],0,'','.'); ?> </td>
		</tr>
		<tr>
			<td>Alexa Yerel Değer</td>
			<td>
				<?php if ( isset($tmpArray['COUNTRY']) ){ ?>
				<?php echo number_format($tmpArray['COUNTRY'],0,'','.'); ?>
				<?php }else{echo "-";} ?>
			</td>
		</tr>
		<tr>
			<td>Google Index</td>
			<td><?php echo getGoogleCount($domain); ?>  <a target="_blank" href="https://www.google.com.tr/search?q=site:<?php echo $domain; ?>&gws_rd=ssl"><img class="link" src="images/true.png" /></a></td>
		</tr>
		<tr>
			<td>Google Backlink</td>
			<td>
			<?php 
			echo GoogleBL($domain);
			?>
			</td>
		</tr>
		<tr>
			<td>Google PageRank</td>
			<td>
			<?php
				$page_rank = new PageRank($domain);
				echo $page_rank->pr;
			?>
			</td>
			
		</tr>
		<tr>
			<td>Dmoz kaydı</td>
			<td><?php echo dmoz($domain); ?></td>
		</tr>
		
		<tr>
			<td>Domain Yaşı</td>
			<td>
			<?php 
			$w=new DomainAge();
			if($w->age($domain) != ""){
			echo $w->age($domain);
			}else{echo "Bilinmiyor..";}
			?>
			</td>
		</tr>
		
		<tr>
			<td>Facebook Paylaşım</td>
			<td>
			<?php 
			$kaynak = file_get_contents("https://graph.facebook.com/?id=http://www.".$domain.""); 
			$veri = json_decode($kaynak, true);
			echo $veri['shares']; 
			?>
			</td>
		</tr>
		<tr>
			<td>Twitter Paylaşım</td>
			<td>
			<?php 
			$kaynak = file_get_contents("https://cdn.api.twitter.com/1/urls/count.json?url=http://www.".$domain.""); 
			$veri = json_decode($kaynak, true);
			echo $veri['count']; 
			?>
			</td>
		</tr>

		</table>
<?php } ?>