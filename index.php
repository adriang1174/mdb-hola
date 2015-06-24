<?php ini_set('display_errors', 0);   
 session_start();
 include('includes/functions.php');
 include('includes/config.php'); 
$errors = ''; 
$uniq_id=unique_id();
$_SESSION['uniq_id']=$uniq_id;
if(isset($_GET['cid']))
{
	$campaign_id = $_GET['cid'];
	$_SESSION['xmlfile'] = $_GET['cid'] . '.xml';
	$_SESSION['cid'] = $_GET['cid'] ;
}
else
{
	$campaign_id = 1;
	$_SESSION['xmlfile'] = 'sample_xml_en.xml';
}	
//echo $_SESSION['xmlfile'];
//if(isset($_POST['submit']))

//{
//	$count=$_POST['count'];
	$count=1;  	
/*	if(strcasecmp('9', $_POST['6_letters_code']) != 0)

	{
		if($count>0)
		{
			
			for($i=1;$i<=$count;$i++)
			{
				$ppd=$_POST['data'.$i];
				$_SESSION['fg1'.$i]=$_POST[$ppd];
				//echo $_SESSION['fg'.$i];
				//echo "<br>";
						
			}
		}   

	
		$errors .= "El resultado de la suma no es correcto!";

	}

	else

	{	*/

		if($count>0)
		{
			mysql_query("insert into answers set session_id='".$_SESSION['uniq_id']."', ip_addr='".$_SERVER['REMOTE_ADDR']."', campaign_id='".$_REQUEST['cid']."'");
			$count = 0;
			for($i=1;$i<=$count;$i++)
			{
				$dbtable=$_POST['d'.$i];
				$dbfield=$_POST['f'.$i];
				$data=$_POST['data'.$i];
				mysql_query("update ".$dbtable." set ".$dbfield."='".utf8_decode($_POST[$data])."' where session_id='".$_SESSION['uniq_id']."'");
			
			}
		}   

	   $_SESSION['msg']=message("First Form successfully created!",1);
	   header('Location: step2.php?cid=holatel');
  	   exit();

	//}

//}
//error_log($_SESSION['xmlfile']);
$xml= simplexml_load_file($_SESSION['xmlfile']);
//$xml= simplexml_load_file("sample_xml_en.xml");
//$str = utf8_encode(file_get_contents('comunidad.xml'));
//$xml = simplexml_load_string($str);
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
    <link rel="stylesheet" type="text/css" href="css/validform.css"/>
    <link rel="stylesheet" type="text/css" href="css/form.css"/> 
    <script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
    <script language="JavaScript" src="scripts/gen_validatorv31.js" type="text/javascript"></script>
	<script type="text/javascript" src="jalert/jquery.alerts.js"></script>
	<link href="jalert/jquery.alerts.css" rel="stylesheet" type="text/css" />
	<style>
	#contenido {
	padding: 0px !important;
	}
	</style>
</head>
<body>

<div id="innercontholder2">
<!-- <img src="images/header.jpg" /> -->
<?php

if(!empty($errors)){

//echo "<p class='err'>".nl2br($errors)."</p>";


echo "<script>
jAlert('".$errors."','Error!');
 </script>";

 $errors='';
 
}

?>
<div id="contenido">
		<table width="700" border="0" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td align="center" valign="top" bgcolor="#FFFFFF"><a href="step2.php?cid=holatel " ><img src="http://www.g2desarrollo.com.ar/Holatel/mailingPromo/mailing_01.jpg" width="700" height="281" alt="" style="display:block; border:0;"/></a></td>
					</tr>
					<tr>
						<td align="center" valign="top" bgcolor="#FFFFFF"><a href="step2.php?cid=holatel " ><img src="http://www.g2desarrollo.com.ar/Holatel/mailingPromo/mailing_02.gif" width="700" height="290" alt="" style="display:block; border:0;"/></a></td>
					</tr>
					<tr>
						<td align="center" valign="top" bgcolor="#FFFFFF"><a href="step2.php?cid=holatel " ><img src="http://www.g2desarrollo.com.ar/Holatel/mailingPromo/mailing_03.jpg" width="700" height="464" alt="" style="display:block; border:0;"/></a></td>
					</tr>
					<tr>
						<td align="center" valign="top" bgcolor="#FFFFFF"><a href="http://www.holatel.com/" target="_blank"><img src="http://www.g2desarrollo.com.ar/Holatel/mailingPromo/mailing_04.gif" width="700" height="156" alt="" style="display:block; border:0;"/></a></td>
					</tr>
					</tbody>
		</table>
<form name="contact-form" id="contact-form" method="post" action=""  onsubmit="javascript:return __doPostBackRegister();" enctype="multipart/form-data">
<?php
//$xml= simplexml_load_file("sample_xml_en.xml");
//print_r($xml);

//print_r($xml->step[number]);
echo "<input type='hidden' name='cid' value='".$campaign_id."'>";
$f=0;
$field=0;
$dbtable=0;
foreach($xml->children() as $steps){
    foreach($steps->children() as $step){
	$f++;
	
		  echo "<h2>".$step->h1."</h2>";
	      echo "<h3>".$step->h2."</h3>";
		  
		 foreach($step->children() as $input){

		 $field++;
	      $dbtable++;
		 // echo "<div class='innercontent'>".$input[label]."</div>";
		  
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
				if($option[value]==$_SESSION['fg1'.$field]){$checked="selected";}
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
				if($option[value]==$_SESSION['fg1'.$field]){$checked="selected";}
				echo "<option value='".$option[value]."' ".$checked.">".$option[name]."</option>";
			}			
			echo "</select>";
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo"</div>";
		  }		  
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
	      	echo "<input name='".$input[name]."' value='".$_SESSION['fg1'.$field]."' class='text_bx' required='required' ".$type." ".$maxlength."  ".$minlength.">";	
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
	      	echo "<input name='".$input[name]."' value='".$_SESSION['fg1'.$field]."' class='text_bx' ".$type. ">";	
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo "</div>";					
			
		  }		  		 
		  if($input[type]=="check" & $input[required]=="yes")
		  { 
		    echo "   <div class='division'></div>";			    
			echo "<div class='innercontent'> &nbsp;";			
			echo $input[label];
			echo "<span style='color:#FF0000'>  *</span>";
			echo "</div>";
		   echo"<div class='box'>";
			echo "<input name='".$input[name]."' type='radio' required='required>";
			foreach($input->children() as $option){	
				$checked='';
				if($option[value]==$_SESSION['fg1'.$field]){$checked="checked";}		    
				echo "<input name='".$input[name]."' type='radio' value='".$option[value]."' ".$checked.">&nbsp;".$option[name]."</br>";
			}
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo"</div>";			
		  }
		   if($input[type]=="check" & $input[required]=="no")
		  { 
		    echo "   <div class='division'></div>";	
		    echo "<div class='innercontent'>";			
			echo $input[label];
			echo "</div>";
		   echo"<div class='box'>";
			echo "<input name='".$input[name]."' type='radio'>";
			foreach($input->children() as $option){			
				$checked='';
				if($option[value]==$_SESSION['fg1'.$field]){$checked="checked";}	    
				echo "<input name='".$input[name]."' type='radio' value='".$option[value]."' ".$checked.">".$option[name]."</br>";
			}
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo"</div>";			
		  } 
	      echo "<br />";
		} ?>
        

		<!--<div class="innercontent">Cuánto es 5 + 4<span style="color:#FF0000">  &nbsp;*</span></div>
		<div class="box">
       <input type="hidden" name="6_letters_code"  id="6_letters_code" type="text"  value="9" class="text_bx2" required="required" /><br>
     </div> -->
     <input type="hidden" name="count" value="<?php echo "1"//echo $field;?>" />
             <!--
			 <div class="division"></div>
    <div class="innercontent"><span style="color:#FF0000">* - Obligatorio</span></div>
	 <div class="continue_butt"><input name="submit" id="submit" type="submit" value="Continuar" class="login_bt"/></div>  -->
     <?php
	     if($f==1) 
			break 2;
	  
       }

	}
?>     
</form>
<div style="clear:both"></div>
</div>
    
   <!-- <img src="images/footer.gif" /> -->
</div>


<script>
<!-- USE PLUGIN HERE -->
</script>
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