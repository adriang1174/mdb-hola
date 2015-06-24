<?php ini_set('display_errors', 0);
    session_start();
	include('includes/config.php');
    include('includes/functions.php');
    $errors = ''; 

    $sql = "select first_name,last_name from answers where session_id='".$_SESSION['uniq_id']."'";
    $r = mysql_query($sql);
    $row = mysql_fetch_assoc($r);
    $nombre_cliente = utf8_encode($row['first_name']." ".$row['last_name']);
	$nombre_solo = utf8_encode($row['first_name']);

	if(isset($_POST['submit']))	
	{
		$count=$_POST['count'];
		if($count>0)
		{
			//mysql_query("insert into answers set session_id='".session_id()."'");
			for($i=1;$i<=$count;$i++)
			{
				$dbtable=$_POST['d'.$i];
				$dbfield=$_POST['f'.$i];
				$data=$_POST['data'.$i];
				mysql_query("update ".$dbtable." set ".$dbfield."='".$_POST[$data]."' where session_id='".$_SESSION['uniq_id']."'");
			
			}
		}   
        
	   $_SESSION['msg']=message("Second Form successfully created!",1);
	   //Acá hay que mandar los correos
	   $recommend_count = 0;
	   $emails_to = array();
	   for($i=1;$i<=4;$i++)
	   {
			$reco = "recommend".$i;
		   if (!empty($_POST[$reco]))
		   {
				$recommend_count++;
				$emails_to[$recommend_count] = $_POST[$reco];
			}
		}
		//$emails_to ---> all emails to send
		require("class.phpmailer.php");
		foreach($emails_to as $email_to)
		{
				$mail = new PHPMailer();
				//This is SMTP settings
				//$mail->IsSMTP();
				//$mail->SMTPAuth = true;
				//$mail->SMTPSecure = "tls";
				//$mail->Host = "smtp.gmail.com";
				//$mail->Port = 587;
				//$mail->Username = "mdb@globalstats.com.ar";
				//$mail->Password = "Mdb*123!";
				//End SMTP settings
				//This is SMTP settings
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = "ssl";
				$mail->Host = "smtp.mandrillapp.com";
				$mail->Port = 465;
				$mail->Username = "sac@globaldardos.com";
				$mail->Password = "fEdGGoPnpCHYmbPFi_b3Zg";
				//End SMTP settings
				$mail->From = "ventas@holatel.com";
				$mail->FromName = "Holatel";
				$mail->AddAddress($email_to);
				$mail->AddBCC('formulario@nuevahost.net');
				$mail->WordWrap = 50; // set word wrap to 50 characters
				$mail->IsHTML(true); // set email format to HTML
				$mail->ContentType = "text/html";
				$mail->CharSet = "UTF-8";
				$mail->Subject = $nombre_cliente." te recomienda que viajes con Holatel";
				// Retrieve the email template required 
				$message = file_get_contents('http://globalstats.com.ar/mailing/holatel/v1/index.html'); 
				// Replace the % with the actual information 
				$message = str_replace('%nombre%', $nombre_cliente, $message); 
				//Set the message 
				$mail->Body = $message; 
				//$mail->AltBody(strip_tags($message)); 
				$mail->Send();		
		}
		header('Location: step5.php');
   exit();
  }
?>
<?php

if(!empty($errors)){

echo "<p class='err'>".nl2br($errors)."</p>";

}
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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
  $(function() {
    var availableTags = [
	"Afganistán", 
	"Albania",
	"Alemania",
	"Andorra",
	"Angola",
	"Antigua y Barbuda",
	"Arabia Saudita",
	"Argelia",
	"Argentina",
	"Armenia",
	"Australia",
	"Austria",
	"Azerbaiyán",
	"Bahamas",
	"Bangladés",
	"Barbados",
	"Baréin",
	"Bélgica",
	"Belice",
	"Benín",
	"Bielorrusia",
	"Birmania",
	"Bolivia",
	"Bosnia y Herzegovina",
	"Botsuana",
	"Brasil",
	"Brunéi",
	"Bulgaria",
	"Burkina Faso",
	"Burundi",
	"Bután",
	"Cabo Verde",
	"Camboya",
	"Camerún",
	"Canadá",
	"Catar",
	"Chad",
	"Chile",
	"China",
	"Chipre",
	"Ciudad del Vaticano",
	"Colombia",
	"Comoras",
	"Corea del Norte",
	"Corea del Sur",
	"Costa de Marfil",
	"Costa Rica",
	"Croacia",
	"Cuba",
	"Dinamarca",
	"Dominica",
	"Ecuador",
	"Egipto",
	"El Salvador",
	"Emiratos Árabes Unidos",
	"Eritrea",
	"Eslovaquia",
	"Eslovenia",
	"España",
	"Estados Unidos",
	"Estonia",
	"Etiopía",
	"Filipinas",
	"Finlandia",
	"Fiyi",
	"Francia",
	"Gabón",
	"Gambia",
	"Georgia",
	"Ghana",
	"Granada",
	"Grecia",
	"Guatemala",
	"Guyana",
	"Guinea",
	"Guinea-Bisáu",
	"Guinea Ecuatorial",
	"Haití",
	"Honduras",
	"Hungría",
	"India",
	"Indonesia",
	"Irak",
	"Irán",
	"Irlanda",
	"Islandia",
	"Islas Marshall",
	"Islas Salomón",
	"Israel",
	"Italia",
	"Jamaica",
	"Japón",
	"Jordania",
	"Kazajistán",
	"Kenia",
	"Kirguistán",
	"Kiribati",
	"Kuwait",
	"Laos",
	"Lesoto",
	"Letonia",
	"Líbano",
	"Liberia",
	"Libia",
	"Liechtenstein",
	"Lituania",
	"Luxemburgo",
	"Madagascar",
	"Malasia",
	"Malaui",
	"Maldivas",
	"Malí",
	"Malta",
	"Marruecos",
	"Mauricio",
	"Mauritania",
	"México",
	"Micronesia",
	"Moldavia",
	"Mónaco",
	"Mongolia",
	"Montenegro",
	"Mozambique",
	"Namibia",
	"Nauru",
	"Nepal",
	"Nicaragua",
	"Níger",
	"Nigeria",
	"Noruega",
	"Nueva Zelanda",
	"Omán",
	"Países Bajos",
	"Pakistán",
	"Palaos",
	"Panamá",
	"Papúa Nueva Guinea",
	"Paraguay",
	"Perú",
	"Polonia",
	"Portugal",
	"Reino Unido",
	"República Centroafricana",
	"República Checa",
	"República de Macedonia",
	"República del Congo",
	"República Democrática del Congo",
	"República Dominicana",
	"República Sudafricana",
	"Ruanda",
	"Rumanía",
	"Rusia",
	"Samoa",
	"San Cristóbal y Nieves",
	"San Marino",
	"San Vicente y las Granadinas",
	"Santa Lucía",
	"Santo Tomé y Príncipe",
	"Senegal",
	"Serbia",
	"Seychelles",
	"Sierra Leona",
	"Singapur",
	"Siria",
	"Somalia",
	"Sri Lanka",
	"Suazilandia",
	"Sudán",
	"Sudán del Sur",
	"Suecia",
	"Suiza",
	"Surinam",
	"Tailandia",
	"Tanzania",
	"Tayikistán",
	"Timor Oriental",
	"Togo",
	"Tonga",
	"Trinidad y Tobago",
	"Túnez",
	"Turkmenistán",
	"Turquía",
	"Tuvalu",
	"Ucrania",
	"Uganda",
	"Uruguay",
	"Uzbekistán",
	"Vanuatu",
	"Venezuela",
	"Vietnam",
	"Yemen",
	"Yibuti",
	"Zambia",
	"Zimbabue"
    ];
    $( "#recommend1_country" ).autocomplete({
       source: function( request, response ) {
          var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
          response( $.grep( availableTags, function( item ){
              return matcher.test( item );
          }) );
      }
    });
	    $( "#recommend2_country" ).autocomplete({
       source: function( request, response ) {
          var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
          response( $.grep( availableTags, function( item ){
              return matcher.test( item );
          }) );
      }
    });
	    $( "#recommend3_country" ).autocomplete({
       source: function( request, response ) {
          var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
          response( $.grep( availableTags, function( item ){
              return matcher.test( item );
          }) );
      }
    });
	    $( "#recommend4_country" ).autocomplete({
       source: function( request, response ) {
          var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
          response( $.grep( availableTags, function( item ){
              return matcher.test( item );
          }) );
      }
    });
});
  
 </script>  
   <script>
  $(function() {
      var max_fields      = 4; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $("#add_button"); //Add button ID
    
	$("#innercontent_recommend2").hide();
	$("#box_recommend2").hide();
	$("#division_recommend2").hide();
	$("#innercontent_recommend2_country").hide();
	$("#box_recommend2_country").hide();
	$("#division_recommend2_country").hide();
	$("#innercontent_recommend2_name").hide();
	$("#box_recommend2_name").hide();
	$("#division_recommend2_name").hide();

	$("#innercontent_recommend3").hide();
	$("#box_recommend3").hide();
	$("#division_recommend3").hide();
	$("#innercontent_recommend3_country").hide();
	$("#box_recommend3_country").hide();
	$("#division_recommend3_country").hide();
	$("#innercontent_recommend3_name").hide();
	$("#box_recommend3_name").hide();
	$("#division_recommend3_name").hide();
	
	$("#innercontent_recommend4").hide();
	$("#box_recommend4").hide();
	$("#division_recommend4").hide();
	$("#innercontent_recommend4_country").hide();
	$("#box_recommend4_country").hide();
	$("#division_recommend4_country").hide();
	$("#innercontent_recommend4_name").hide();
	$("#box_recommend4_name").hide();
	$("#division_recommend4_name").hide();


    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
		//alert("click en agregar");
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            //$(wrapper).append('<div><input type="text" name="mytext[]"/></div>'); //add input box
			$("#innercontent_recommend"+x).show();
			$("#box_recommend"+x).show();
			$("#division_recommend"+x).show();
			$("#innercontent_recommend"+x+"_country").show();
			$("#box_recommend"+x+"_country").show();
			$("#division_recommend"+x+"_country").show();
			$("#innercontent_recommend"+x+"_name").show();
			$("#box_recommend"+x+"_name").show();
			$("#division_recommend"+x+"_name").show();
        }
    });
});
  </script>
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
$f=0;
$field=0;
$dbtable=0;
foreach($xml->children() as $steps){
    foreach($steps->children() as $step){
	$f++;
	  if($f==4){
		  echo "<h2>".$step->h1."</h2>";
	      echo "<h3>". $nombre_solo.$step->h2."</h3>";

		  foreach($step->children() as $input){
		  $field++;
	      $dbtable++;
		  
	      /*echo "<br />";*/
		  if($input[type]=="text" & $input[required]=="yes")
		  {  
			echo "   <div class='division' id='division_".$input[name]."'></div>";			  
		    echo "<div class='innercontent' id='innercontent_".$input[name]."'>";			
			echo $input[label];
			echo "<span style='color:#FF0000'>(Required*)</span>";
			echo "</div>";
		    echo"<div class='box' id='box_".$input[name]."'>";
			if($input[mustcontain]=='@.'){$type="type='email'";}
			if($input[maxlength]!=''){$maxlength="maxlength='".$input[maxlength]."'";}
			if($input[minlength]!=''){$minlength=" onBlur='Minimum(this,".$input[minlength].");'";}
	      	echo "<input id='".$input[name]."' name='".$input[name]."' class='text_bx' required='required' ".$type." ".$maxlength."  ".$minlength."/>";	
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo "</div>";					
			
		  }	
		  if($input[type]=="text" & $input[required]=="no")
		  { 
			echo "   <div class='division' id='division_".$input[name]."'></div>";			  
		    echo "<div class='innercontent' id='innercontent_".$input[name]."'>".$input[label]."</div>";
		    echo"<div class='box' id='box_".$input[name]."'>";
			if($input[mustcontain]=='@.')
				$type="type='email'";
			else
				$type="type='text'";
			if($input[maxlength]!=''){$maxlength="maxlength='".$input[maxlength]."'";}
			if($input[minlength]!=''){$minlength=" onBlur='Minimum(this,".$input[minlength].");'";}
	      	echo "<input  id='".$input[name]."' name='".$input[name]."' class='text_bx' ".$type." ".$maxlength."  ".$minlength. ">";	
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo "</div>";					
			
		  }	 
		  //echo"</br>";		 
		}  
		}
		} 
		?>			
     <input type="hidden" name="count" value="<?php echo $field;?>" />
     <div class="continue_butt"><input name="add_button" id="add_button" type="button" value="Recomendar otro" class="login_bt"  />&nbsp;&nbsp;<input name="submit" id="submit" type="submit" value="Continuar" class="login_bt"  /></div> 
	     <?php
	     if($f==4) 
				break 2;
        
	}
?>    
</form>
<div style="clear:both"></div>
</div>
    
    <img src="images/footer.gif" />
</div>
<script>
//$("#myform").validator();
$('#contact-form input[type=email]').on('change invalid', function() {
    var textfield = $(this).get(0);
    
    // 'setCustomValidity not only sets the message, but also marks
    // the field as invalid. In order to see whether the field really is
    // invalid, we have to remove the message first
    textfield.setCustomValidity('');
    
    if (!textfield.validity.valid) {
      textfield.setCustomValidity('Por favor indique una direccion de correo válida');  
    }
});
</script>
</body>
</html>
