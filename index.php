<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <title>title</title>
    <link rel="stylesheet" href="css/style.css">
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="script.js"></script>
  </head>
  <body>
	

	<div class="w">
	<input id="site_url" name="site_url" type="text" placeholder="siteadi.uzanti" />
	<input id="button_1" name="s" type="button" value="Başlat"  />

	<div id="icerik_1" style="width:100%; height:auto;">
		<img style="width:100%; height:240px; margin-top:15px;" src="images/info-stats.jpg" />	
	</div>	
	
	</div>
	
  </body>
  
  
<script>
	  $('#button_1').click(function(){
		
		var sURL = $('#site_url').val();
		$('#icerik_1').html('<img class="loadingImg" src="images/loading.gif" />');
		$.ajax({ 
			type:'POST', 
			url:'jPost.php',
			data:{'site_url':sURL}, 
			success:function(dt){
				$("#icerik_1").html(dt); 
			}
		});
	  });
</script>
</html>

