<?php ini_set('display_errors', 0);
    session_start();
	include('includes/config.php');
    include('includes/functions.php');
    $errors = ''; 
	//echo $_SESSION['uniq_id'];
	if(isset($_POST['submit']))	
	{
	$count=$_POST['count'];
    if(empty($_SESSION['6_letters_code'] ) ||	strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)

	{
		if($count>0)
		{
			
			for($i=1;$i<=$count;$i++)
			{
				$ppd=$_POST['data'.$i];
				$_SESSION['fg2'.$i]=$_POST[$ppd];
				//echo $_SESSION['fg'.$i];
				//echo "<br>";
						
			}
		}   
		$errors .= "El texto no coincide!";

	}

	else

	{	
		
		if($count>0)
		{
			//mysql_query("insert into answers set session_id='".session_id()."'");
			
			for($i=1;$i<=$count;$i++)
			{
				$dbtable=$_POST['d'.$i];
				$dbfield=$_POST['f'.$i];
				$data=$_POST['data'.$i];
				mysql_query("update ".$dbtable." set ".$dbfield."='".utf8_decode($_POST[$data])."' where session_id='".$_SESSION['uniq_id']."'");
				$_SESSION['fg2'.$i]='';
			
		  }
		  
			require("class.phpmailer.php");
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
			$mail->From = $_POST['email'];
			$mail->FromName = $_POST['first_name']. ' '.$_POST['last_name'];
			$mail->ReturnPath =  $_POST['email'];
			$mail->AddAddress('promo@holatel.com');
			$mail->AddBCC('formulario@nuevahost.net');
			//$mail->AddAddress('adriang_1174@hotmail.com');
			$mail->WordWrap = 50; // set word wrap to 50 characters
			$mail->IsHTML(false); // set email format to HTML
			$mail->ContentType = "text/plain";
			$mail->CharSet = "UTF-8";
			$mail->Subject = "Formulario Promo Recomendá y Volá";
			// Retrieve the email template required 
			$message = "
			Email: ". $_POST['email'] ."\n
			Nombre: ". $_POST['first_name'] ."\n
			Apellido: ". $_POST['last_name'] ."\n
			Pais: ".$_POST['pais']."\n
			Telefono: ".$_POST['phone']."\n
			Es celular: " . $_POST['cel'];
			//Set the message 
			$mail->Body = $message; 
			//$mail->AltBody(strip_tags($message)); 
			$mail->Send();		
			//mail ( 'adriang_1174@hotmail.com', 'test', $message);


		}   

	   $_SESSION['msg']=message("Second Form successfully created!",1);
	   header('Location: step3.php');

   exit();

}

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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css"href="css/validform.css"/>
     <link rel="stylesheet" type="text/css"href="css/form.css"/>
    <script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
    <script language="JavaScript" src="scripts/gen_validatorv31.js" type="text/javascript"></script>
	<script type="text/javascript" src="jalert/jquery.alerts.js"></script>
	<link href="jalert/jquery.alerts.css" rel="stylesheet" type="text/css" />
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script language='JavaScript' type='text/javascript'>
    function refreshCaptcha()
    
    {
    
        var img = document.images['captchaimg'];
    
        img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
    
    }
	
	function Minimum(obj,min){
	 if (obj.value.length<min) alert('Debe ingresar al menos '+min+ ' caracteres para '+obj.name);
	}
    
    </script>

<?php
if(isset($_SESSION['cid']))
{
   include('includes/'.$_SESSION['cid'].'/step2_jquery.php');
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
<?php

if(!empty($errors)){


echo "<script>
jAlert('".$errors."','Error!');
 </script>";

 $errors='';
 
}

?>
<div id="contenido">
<form name="contact-form" id="contact-form" method="post" action=""  onsubmit="javascript:return __doPostBackRegister();" enctype="multipart/form-data">
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
	  if($f==2){
		  echo "<h2>".$step->h1."</h2>";
	      echo "<h3>".$step->h2."</h3>";
		  foreach($step->children() as $input){
		  $field++;
	      $dbtable++;
		  
	      /*echo "<br />";*/
		  if($input[type]=="text" & $input[required]=="yes")
		  {  
		   echo "   <div class='division'></div>";	
		  echo "<div class='innercontent'>";			
			echo $input[label];
			echo "<span style='color:#FF0000'>  *</span>";
			echo "</div>";
		    echo"<div class='box'>";
			if($input[mustcontain]=='@.')
				$type="type='email'";
			else
				$type="type='text'";
			if($input[maxlength]!=''){$maxlength="maxlength='".$input[maxlength]."'";}
			if($input[minlength]!=''){$minlength=" onBlur='Minimum(this,".$input[minlength].");'";}
	      	echo "<input id='".$input[name]."' name='".$input[name]."' value='".$_SESSION['fg2'.$field]."' class='text_bx' required='required' ".$type." ".$maxlength."  ".$minlength.">";	
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo "</div>";					
			
		  }	
		  if($input[type]=="text" & $input[required]=="no")
		  {  
		   echo "   <div class='division'></div>";			  
		    echo "<div class='innercontent'>".$input[label]."</div>";
		    echo"<div class='box'>";
			if($input[mustcontain]=='@.')
				$type="type='email'";
			else
				$type="type='text'";
			if($input[maxlength]!=''){$maxlength="maxlength='".$input[maxlength]."'";}
			if($input[minlength]!=''){$minlength=" onBlur='Minimum(this,".$input[minlength].");'";}
	      	echo "<input name='".$input[name]."' value='".$_SESSION['fg2'.$field]."' class='text_bx' ".$type." ".$maxlength."  ".$minlength.">";	
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo "</div>";					
			
		  }	
		  if($input[type]=="select" & $input[required]=="yes")
		  { 
		   echo "   <div class='division'></div>";			  
		    echo "<div class='innercontent'>";			
			echo $input[label];
			echo "<span style='color:#FF0000'>  *</span>";
			echo "</div>";
	      	echo"<div class='box'>";
			echo "<select name='".$input[name]."' class='text_bx' required='required'>";
			echo "<option value=''>Seleccionar...</option>";
			foreach($input->children() as $option){
				$checked='';
				if($option[value]==$_SESSION['fg2'.$field]){$checked="selected";}
				echo "<option value='".$option[value]."' ".$checked.">".$option[name]."</option>";
			}			
			echo "</select>";
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo"</div>";
		  }	
		   if($input[type]=="select" & $input[required]=="no")
		  { 
		   echo "   <div class='division'></div>";			  
		    echo "<div class='innercontent'>";			
			echo $input[label];
			echo "</div>";
	      	echo"<div class='box'>";
			echo "<select name='".$input[name]."' class='text_bx'>";
			echo "<option value=''>Seleccionar...</option>";
			foreach($input->children() as $option){
				$checked='';
				if($option[value]==$_SESSION['fg2'.$field]){$checked="selected";}
				echo "<option value='".$option[value]."' ".$checked.">".$option[name]."</option>";
			}			
			echo "</select>";
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo"</div>";
		  }	
		  if($input[type]=="date" & $input[required]=="yes")
		  {  
		   echo "   <div class='division'></div>";			           
		     echo "<div class='innercontent'>";			
			echo $input[label];
			echo "<span style='color:#FF0000'>  *</span>";
			echo "</div>";
		    echo"<div class='box'>";
	      	echo "<input name='".$input[name]."' value='".$_SESSION['fg2'.$field]."' class='text_bx' required='required' placeholder='".$input[format]."'>";	
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo "</div>";					
			echo"</br>";
		  }	
		  if($input[type]=="date" & $input[required]=="no")
		  {  
		   echo "   <div class='division'></div>";			           
		     echo "<div class='innercontent'>";			
			echo $input[label];
			echo "</div>";
		    echo"<div class='box'>";
	      	echo "<input name='".$input[name]."' value='".$_SESSION['fg2'.$field]."' class='text_bx' placeholder='".$input[format]."'>";	
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo "</div>";					
			echo"</br>";
		  }	
		  if($input[type]=="check" & $input[required]=="yes")
		  { 
		   echo "   <div class='division'></div>";			  
		   echo"<div class='box10'>";
		   echo "<input name='".$input[name]."' type='checkbox' required='required>";
			foreach($input->children() as $option){			
				$checked='';
				if($option[value]==$_SESSION['fg2'.$field]){$checked="checked";}	    
				echo "<input name='".$input[name]."' type='checkbox' value='".$option[value]."' ".$checked."> ".$option[name]."</br>";
			}
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo"</div>";			
		  } 
		  if($input[type]=="check" & $input[required]=="no")
		  { 
		   //echo "   <div class='division'></div>";			  
		   echo"<div class='box10'>";
		   //echo "<input name='".$input[name]."' type='checkbox'>";
			foreach($input->children() as $option){		
				$checked='';
				if($option[value]==$_SESSION['fg2'.$field]){$checked="checked";}		    
				echo "<input name='".$input[name]."' type='checkbox' value='".$option[value]."' ".$checked."> ".$option[name]."</br>";
			}
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo"</div>";			
		  }  
		  echo"</br>";		 
		}  
		}
		} 
		?>	
		<div class='division'></div>			  
        <div class="innercontent">Introduzca el texto<span style="color:#FF0000"> </span></div>
		<div class="box"><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' > 
       <input name="6_letters_code"  id="6_letters_code" type="text"  class="text_bx2" required="required" /><br>

     <small>No se ve la imagen? Click <a href='javascript: refreshCaptcha();'>aquí</a> </small>

     </div>	
     <input type="hidden" name="count" value="<?php echo $field;?>" />
     <div class="continue_butt"><input name="submit" id="submit" type="submit" value="Continuar" class="login_bt"  /></div> 
     <?php
	      if($f==1) 
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
$('#contact-form input[type=text]').on('change invalid', function() {
    var textfield = $(this).get(0);
    
    // 'setCustomValidity not only sets the message, but also marks
    // the field as invalid. In order to see whether the field really is
    // invalid, we have to remove the message first
    textfield.setCustomValidity('');
    
    if (!textfield.validity.valid) {
      textfield.setCustomValidity('Por favor completar este campo');  
    }
});
$('#contact-form select').on('change invalid', function() {
    var textfield = $(this).get(0);
    
    // 'setCustomValidity not only sets the message, but also marks
    // the field as invalid. In order to see whether the field really is
    // invalid, we have to remove the message first
    textfield.setCustomValidity('');
    
    if (!textfield.validity.valid) {
      textfield.setCustomValidity('Por favor, completar este campo');  
    }
});

</script>
</body>
</html>
