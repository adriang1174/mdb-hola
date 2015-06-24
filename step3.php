<?php ini_set('display_errors', 0);
    session_start();
	include('includes/functions.php');
    include('includes/config.php'); ?>
<?php

if(!empty($errors)){

echo "<p class='err'>".nl2br($errors)."</p>";

}
$sql = "select first_name,last_name from answers where session_id='".$_SESSION['uniq_id']."'";
$r = mysql_query($sql);
$row = mysql_fetch_assoc($r);
$nombre_cliente = utf8_encode($row['first_name']);

$xml= simplexml_load_file($_SESSION['xmlfile']);
$att = $xml->attributes();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<meta property="og:title" content="Viaja a tu país con Holatel" />
	<meta property="og:description" content="Lanzamos la D&eacute;cima Edici&oacute;n de Recomienda y Vuela de HolaTel, con la que puedes ir a visitar a tus familiares y amigos en tu pa&iacute;s de origen o hacer que ellos te visiten." />
	<meta property="og:type" content="website" />
<meta property="og:url" content="http://globalstats.com.ar/mmdb/holatel/" />
	<meta property="og:image" content="http://www.g2desarrollo.com.ar/Holatel/mailingPromo/postFacebook.png" />	
    <title><? echo $att['title'] ?></title>
    <link href="css/style.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css"href="css/validform.css"/>
 	<link rel="stylesheet" type="text/css"href="css/form.css"/>

<?php
if(isset($_SESSION['cid']))
{
   include('includes/'.$_SESSION['cid'].'/analytics.php');
}
?>

</head>
<body>

<div id="innercontholder2">
<img src="images/header.jpg" />
<div id="contenido">
<form name="contact-form" id="contact-form" method="post" action="" enctype="multipart/form-data">
<?php
//$xml= simplexml_load_file("sample_xml_en.xml");
//print_r($xml);

//print_r($xml->step[number]);

$f=0;
$field=0;
$dbtable=0;

foreach($xml->children() as $steps){
    foreach($steps->children() as $step){
	$f++;
	  if($f==3){
		  echo "<h2>".$nombre_cliente.", ".$step->h1."</h2>";
	      echo "<h3>".$step->h2."</h3>";
		  echo "   <div class='division'></div>";	
		  echo"<br>";
		  foreach($step->children() as $input){
		  $field++;
	      $dbtable++;
	      //echo "<br />";
		  if($input[type]=="fblike")
		  {  
		    $url = $input[url];
		  ?>
		  
          <div class="facebook_box">
		  <!--
			<div class="fb-like" data-href="http://facebook.com/globaldardos" data-width="450" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></div></div>
		 -->
		 <a href="http://www.facebook.com/sharer.php?u=<? echo $url ?>" target="_blank"><img src="images/boton_facebook.png"></a>
		 </div>
		 <?php }	
		  if($input[type]=="twfollow")
		  {  
		    $url = $input[url];
		    ?>
			<!--
            <div class="twitter_box">
			
            <a href="https://twitter.com/home?status=Ya soy parte de la Comunidad de @ResidentesArg ¿Y vos? http://bit.ly/1qkoa5a" target="_blank"><img src="images/logoTwitter.gif"></a>
			</div> -->
			<?php 				
			
		  }	
		  //echo"</br>";		 
		}  
		}
		} 
		  echo"<br>";
		  echo"<br>";
		?>		
     <input type="hidden" name="count" value="<?php echo $field;?>" />
     <div class="continue_butt"><a href="step4.php"><input name="Continue" id="Continue" type="button" value="Continuar" class="login_bt"  /></a></div> 
     <?php
	     if($f==3) 
			break 2;
        
	}
?>    
</form>
<div style="clear:both"></div>
</div>
    
    <img src="images/footer.gif" />
</div>
<script>
$("#myform").validator();
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>