<title>Share content URL in social media using PHP</title>

<?php 
 $ShareUrl = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
 $Title = 'Share content URL in social media using PHP';
 $Media = 'http://2.bp.blogspot.com/-nr1K0W-Zqi0/U_4lUoyvvVI/AAAAAAAABJE/F_C7i48sI58/s1600/new2.png';
?>


<h2> Main tutorial <a href="http://www.2my4edge.com/2016/05/share-webpage-url-content-in-social.html"> Share content URL in social media using PHP </a> & More Tutorial <a href="http://2my4edg.com"> www.2my4edge.com</a>  </h2>


<div align="center">


<!-- Share in facebook -->
<a onclick="shareinsocialmedia('https://www.facebook.com/sharer/sharer.php?u=<?php echo $ShareUrl;?>&title=<?php echo $Title;?>')" href="">
<img src="images/facebook.gif" title="share in facebook">
</a>


<!-- Share in twitter -->
<a onclick="shareinsocialmedia('http://twitter.com/home?status=<?php echo $Title; ?>+<?php echo $ShareUrl; ?>')" href="">
<img src="images/twitter.gif" title="share in twitter">
</a>


<!-- Share in google plus -->
<a onclick="shareinsocialmedia('https://plus.google.com/share?url=<?php echo $ShareUrl; ?>')" href="">
<img src="images/gplus.gif" title="share in google plus">
</a>


<!-- Share in Linkedin -->
<a onclick="shareinsocialmedia('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $ShareUrl; ?>&title=<?php echo $Title; ?>')" href="">
<img src="images/linkedin.gif" title="share in linkexdin">
</a>


<!-- Share in Pinterest -->
<a onclick="shareinsocialmedia('http://pinterest.com/pin/create/button/?url=<?php echo $ShareUrl; ?>&media=<?php echo $Media; ?>&description=<?php echo $Title; ?>')" href="">
<img src="images/pin.gif" title="share in pinterest">
</a>


<!-- Share in Digg -->
<a onclick="shareinsocialmedia('http://www.digg.com/submit?phase=2&url=<?php echo $ShareUrl; ?>&title=<?php echo $Title; ?>')" href="">
<img src="images/digg.gif" title="share in digg">
</a>


<!-- Share in Stumbleupon -->
<a onclick="shareinsocialmedia('http://www.stumbleupon.com/submit?url=<?php echo $ShareUrl; ?>&title=<?php echo $Title; ?>')" href="">
<img src="images/stumble.gif" title="share in stumbleupon">
</a>


</div>


<script type="text/javascript" async >
	function shareinsocialmedia(url){
	window.open(url,'sharein','toolbar=0,status=0,width=648,height=395');
	return true;
	}
</script>


