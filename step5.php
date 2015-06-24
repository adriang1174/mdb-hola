<?php ini_set('display_errors', 0); 
session_start();
include('includes/config.php');
include('includes/functions.php');

$sql = "select first_name,last_name from answers where session_id='".$_SESSION['uniq_id']."'";
$r = mysql_query($sql);
$row = mysql_fetch_assoc($r);
$nombre_cliente = utf8_encode($row['first_name']." ".$row['last_name']);
$nombre_solo = utf8_encode($row['first_name']);

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
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=1487489201484133&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="innercontholder2">
<img src="images/header.jpg" />
<div class="fb-like-box" data-href="https://www.facebook.com/Holatel.Llamadas" data-width="700" data-height="200" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
<div id="contenido">

<?php
//$xml= simplexml_load_file("comunidad.xml");
$f=0;
$field=0;
$dbtable=0;
foreach($xml->children() as $steps){
    foreach($steps->children() as $step){
	$f++;
	  if($f==5){
		  echo "<h2>".$nombre_solo.$step->h1."</h2>";
	      echo "<h3>".$step->h2."</h3>";
		 
		  }
		}
		} 
		
		?>			
</div>
    
    <img src="images/footer.gif" />
</div>
</body>
</html>