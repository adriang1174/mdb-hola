<?php ini_set('display_errors', 0);   
session_start();
 include('includes/config.php');
 include('includes/functions.php');
$errors = ''; 
if(isset($_POST['submit']))

{

  	/*$_SESSION['pensaste']=isset($_POST['q1'])?$_POST['q1']:"";

	$_SESSION['alguna']=isset($_POST['q2'])?$_POST['q2']:"";

	$_SESSION['handicap']=isset($_POST['q3'])?$_POST['q3']:"";

	$_SESSION['gustaria']=isset($_POST['q4'])?$_POST['q4']:"";

	$_SESSION['dejanos']=isset($_POST['q5'])?$_POST['q5']:"";

	$_SESSION['time']=isset($_POST['time'])?$_POST['time']:"";*/

if(empty($_SESSION['6_letters_code'] ) ||

	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)

	{

	//Note: the captcha code is compared case insensitively.

	//if you want case sensitive match, update the check above to

	// strcmp()

		$errors .= "\n The captcha code does not match!";

	}

	else

	{	
		$count=$_POST['count'];
		if($count>0)
		{
			mysql_query("insert into answers set session_id='".session_id()."'");
			for($i=1;$i<=$count;$i++)
			{
				$dbtable=$_POST['d'.$i];
				$dbfield=$_POST['f'.$i];
				$data=$_POST['data'.$i];
				mysql_query("update ".$dbtable." set ".$dbfield."='".$_POST[$data]."' where session_id='".session_id()."'");
			
			}
		}   

	   $_SESSION['msg']=message("First Form successfully created!",1);
	   header('Location: step2.php');

   exit();

}

}
?>
<?php

if(!empty($errors)){

echo "<p class='err'>".nl2br($errors)."</p>";

}

?>
<link href="css/style.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css"href="css/validform.css"/>
 <link rel="stylesheet" type="text/css"href="css/form.css"/>
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script language="JavaScript" src="scripts/gen_validatorv31.js" type="text/javascript"></script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()

{

	var img = document.images['captchaimg'];

	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;

}

</script>
<div id="innercontholder2">
<form name="contact-form" id="contact-form" method="post" action=""  onsubmit="javascript:return __doPostBackRegister();" enctype="multipart/form-data">
<?php
$xml= simplexml_load_file("sample_xml_en.xml");
//print_r($xml);

//print_r($xml->step[number]);

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
		  echo "<div class='innercontent'>".$input[label]."</div>";
		  
		  if($input[type]=="select")
		  {
	      	echo"<div class='box'>";
			echo "<select name='".$input[name]."' class='text_bx' required='required'>";
			echo "<option value=''>Choose</option>";
			foreach($input->children() as $option){
				echo "<option value='".$option[value]."'>".$option[name]."</option>";
			}			
			echo "</select>";
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo"</div>";
		  }
		  
	      /*echo "<br />";*/
		  if($input[type]=="text")
		  {
		    echo"<div class='box'>";
	      	echo "<input name='".$input[name]."' class='text_bx'>";	
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo "</div>";					
			
		  }		  		 
		  if($input[type]=="check")
		  { 
		   echo"<div class='box'>";
		   echo "<input name='".$input[name]."' type='radio' required='required>";
			foreach($input->children() as $option){			    
				echo "<input name='".$input[name]."' type='radio' value='".$option[value]."'>".$option[name]."</br>";
			}
			echo "<input type='hidden' name='data".$field."' value='".$input[name]."'>";
			echo "<input type='hidden' name='f".$field."' value='".$input[dbfield]."'>";
			echo "<input type='hidden' name='d".$dbtable."' value='".$input[dbtable]."'>";
			echo"</div>";			
		  }
	      echo "<br />";
		} ?>
        <div class="innercontent">Captcha</div>
		<div class="box"><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' > 
       <input name="6_letters_code"  id="6_letters_code" type="text"  class="text_bx2" /><br>

     <small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small>

     </div>
     <input type="hidden" name="count" value="<?php echo $field;?>" />
     <div class="continue_butt"><input name="submit" id="submit" type="submit" value="Continue" class="login_bt"  /></div> 
     <?php
	     if($f==1) {exit();}
		  
       }  
	}
?>    
</form>
</div>
<script>
$("#myform").validator();
</script>
