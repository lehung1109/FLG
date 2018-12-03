<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]><html class="no-js ie6 oldie" lang="<?php print $language->language; ?>"><![endif]-->
<!--[if IE 7]><html class="no-js ie7 oldie" lang="<?php print $language->language; ?>"><![endif]-->
<!--[if IE 8]><html class="no-js ie8 oldie" lang="<?php print $language->language; ?>"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php print $language->language; ?>"><!--<![endif]-->
<head>
	<?php print $head; ?>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
	<title><?php print $head_title; ?></title>
	<?php print $styles; ?>

	<script type="text/javascript">
		var pathToTheme = "<?php echo path_to_theme() ?>";
	</script>
	<?php print $scripts; ?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5aea85a5a9f6a00011d0350f&product=inline-share-buttons"></script>
	<?php if($_SERVER['HTTP_HOST'] === 'www.flg.com.au'){
     echo "
          <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-55712619-1', 'auto');
		  ga('send', 'pageview'); 

		</script>
     ";
	} ?>

<script src="https://use.typekit.net/wca4amy.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

</head>
<body class="<?php print $classes; ?>" <?php if(arg(1) == '4415'){?>onunload="" <?php }?> <?php print $attributes;?>>
<?php if(arg(1) == '4415'){?>
	<script type="text/javascript">
		window.onpageshow = function (event) {
	        if (event.persisted) {
	            window.location.reload();
	        }
	    };
	    if(performance.navigation.type == 2){
		   location.reload(true);
		}

	</script>

<?php }?>
	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=790729007623615&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php print $page_top; ?>
<?php print $page ?>
<?php print $page_bottom; ?>

</body>
</html>