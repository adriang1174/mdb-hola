<?php
function filter($var)
{
	//$var=nl2br($var);
  //	$var=str_replace("\'","'",$var);
	//$var=str_replace("'","''",$var);
	//$var=preg_replace('/&$/','',$var);
	//$var=str_replace("\\'", "''", $var);	//SQL Special Characters
 
	if(get_magic_quotes_gpc() ) 
		$var = stripslashes($var );
	$var = preg_replace('/[^\x09\x0a\x0d\x20-\x7e]/', '?', $var );	
	return $var;
}
function filter_template($var)
{
	//$var=nl2br($var);
  	$var=str_replace("\'","'",$var);
	$var=str_replace("'","''",$var);
	$var=preg_replace('/&$/','',$var);
	$var=str_replace("\\'", "''", $var);	//SQL Special Characters
	return $var;
}

//$absolute_path=str_replace("includes\config.php","",__FILE__);

//PHP FILE NAME---------------------------------------------------------------------------------------------
//echo "File Name : ".basename(__FILE__);

//PASSWORD ENCRYPT---------------------------------------------------------------------------------------------
//echo md5("Password");

//DATE TIME FORMAT---------------------------------------------------------------------------------------------
function date_time_format($date_time,$flag=1)
{
	$unx_stamp=strtotime($date_time);
	$date_str="";
	switch($flag)
	{
		case 1: $date_str=(date("Y-m-d",$unx_stamp)); break;//2004-06-29
		case 2: $date_str=(date("m-d-Y",$unx_stamp)); break;//06-29-2004
		case 3: $date_str=(date("d-m-Y",$unx_stamp)); break;//29-06-2004
		case 4: $date_str=(date("d M Y",$unx_stamp)); break;//29 Jun 2004
		case 5: $date_str=(date("d F Y",$unx_stamp)); break;//29 June 2004
		case 6: $date_str=(date("jS M Y",$unx_stamp)); break;//29th Jun ,2004
		//case 6: $date_str=date("M j",$unx_stamp)."<sup>".date("S",$unx_stamp)."</sup>".date(", Y",$unx_stamp); break;
		case 7: $date_str=(date("D M dS,Y",$unx_stamp)); break;//Tue Jun 29th,2004
		case 8: $date_str=(date("l M jS,Y",$unx_stamp)); break;//Tuesday Jun 29th,2004
		case 9: $date_str=(date("l F jS,Y",$unx_stamp)); break;//Tuesday June 29th,2004
		case 10: $date_str=(date("d F Y l",$unx_stamp)); break;//29 June 2004 Tuesday
		case 11:  $date_str=(date("l",$unx_stamp));
	}
	
	
	/*$time_str="";
	switch(mysql_result(mysql_query("select value from configuration where id=2"),0,0))
	{
		case 1: $time_str=(date("h:i a",$unx_stamp)); break;//06:20 pm
		case 2: $time_str=(date("h:i A",$unx_stamp)); break;//06:20 PM
		case 3: $time_str=(date("H:i",$unx_stamp)); break;//18:20
	}
	*/
	
	switch($flag)
	{
		case 1: return($date_str); break;
		case 2: return($time_str); break;
		case 3: return($date_str."&nbsp; ".$time_str); break;
		default: return($date_str); break;
	}

}

//echo date_time_format("2012-09-07 10:20 AM",3);	//	1=date	2=time	3=date+time
//---------------------------------------------------------------------------------------------

//----------------------------------Random ID-------------------------------------------------

function unique_id($len = 8)
{
	$temp=mt_rand(1,500);
	$temp=md5($temp);
	$temp=substr($temp,0,$len);
	$temp=strtoupper($temp);
	return $temp;
}
//$pass=unique_id();
//////-----------------------------------------------------------------------------------------

function message($var="",$mode=3)
{
	switch($mode)
	{
		case 1:$var=" <font class='success_style'>".$var."</font> ";	//Success
				break;
		case 2:$var=" <font class='error_style'>".$var."</font> ";	//Error
				break;
		case 3:$var=" <font class='message_style'>".$var."</font> ";	//Message
				break;
		case 4:$var=" <font class='critical_style'>".$var."</font> ";	//Critical
				break;
		default:$var=" <font class='message_style'>".$var."</font> ";	//Message
				break;
	}
	return $var;
}

function text_alert($var="",$mode=3)
{
	switch($mode)
	{
		case 1:$var=" <font class='alert_success'>".$var."</font> ";	//Success
				break;
		case 2:$var=" <font class='alert_error'>".$var."</font> ";	//Error
				break;
		case 3:$var=" <font class='alert_message'>".$var."</font> ";	//Message
				break;
		case 4:$var=" <font class='alert_critical'>".$var."</font> ";	//Critical
				break;
		default:$var=" <font class='alert_message'>".$var."</font> ";	//Message
				break;
	}
	return $var;
}


function send_mail($to, $subject, $message ,$from) 
{
	$header = "MIME-Version: 1.0\n";
	$header=$header."From: ".$from."\n";
	$header=$header."Content-Type: text/html; charset=\"iso-8859-1\"\n";
	
	$flag=@mail($to, $subject, $message, $header);

	if($flag==false)	//delete
		$_SESSION['mail_display']="<b>To:</b> $to<br><b>From:</b> $from<br><b>Subject:</b> $subject<br><b>Message:</b><br>$message";	//delete
	return  $flag;
}

function prepare_send_mail($format_id,$member_id)//$format_id=mail format id	
{
	if($format_id!='' || $member_id!='')
	{
		$result=mysql_query("select * from mail_invitation where id='$member_id'");
		if($row=mysql_fetch_object($result))
		{
			$row1=mysql_fetch_object(mysql_query("select * from automated_mail where sl_no='$format_id'"));
			
			$to=$row->email_id;
			//if($row->rank==1)
				//$to=mysql_result(mysql_query("select value from configuration where id=7"),0,0);
			$from=mysql_result(mysql_query("select value from configuration where id=6"),0,0);
			$subject=$row1->subject;
			$message=$row1->message;
		
			$subject=str_replace("  ","&nbsp;&nbsp;",$subject);
			$subject=nl2br($subject);
			//$subject=str_replace("#full_name#",$row->name,$subject);
			$subject=str_replace("#site_url#",SITE_URL,$subject);
			
			$message=str_replace("  ","&nbsp;&nbsp;",$message);
			$message=nl2br($message);
			//$message=str_replace("#name#",$row->name,$message);
			
		
			if($format_id==1)
			{
				//$subject=str_replace("#email_id#",$row->email_id,$subject);
				$site_url=SITE_URL."inform.php?invi_code=".$row->code;
				$message=str_replace("#site_url#",$site_url,$message);
				$message=str_replace("#email_id#",$row->email_id,$message);
			}
			/*if($format_id==1 || $format_id==3)
			{
				$password=mysql_result(mysql_query("select password from admin_user where member_id='$member_id'"),0,0);
				$subject=str_replace("#password#",$password,$subject);
				$message=str_replace("#password#",$password,$message);
			}*/
			return send_mail($to,$subject,$message,$from);
		}
		
	}
	else return false;
}

function output_file($file,$name)					//Download file as attachment
{
	//do something on download abort/finish
	//register_shutdown_function( 'function_name'  );
	if(!file_exists($file))
		die('file not exist!');
	$size = filesize($file);
	$name = rawurldecode($name);
	
	if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
		$UserBrowser = "Opera";
	elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
		$UserBrowser = "IE";
	else
	$UserBrowser = '';
	
	/// important for download im most browser
	$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ?
	 'application/octetstream' : 'application/octet-stream';
	@ob_end_clean(); /// decrease cpu usage extreme
	header('Content-Type: ' . $mime_type);
	header('Content-Disposition: attachment; filename="'.$name.'"');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header('Accept-Ranges: bytes');
	header("Cache-control: private");
	header('Pragma: private');
	
	/////  multipart-download and resume-download
	if(isset($_SERVER['HTTP_RANGE']))
	{
		list($a, $range) = explode("=",$_SERVER['HTTP_RANGE']);
		str_replace($range, "-", $range);
		$size2 = $size-1;
		$new_length = $size-$range;
		header("HTTP/1.1 206 Partial Content");
		header("Content-Length: $new_length");
		header("Content-Range: bytes $range$size2/$size");
	}
	else
	{
		$size2=$size-1;
		header("Content-Length: ".$size);
	}
	$chunksize = 1*(1024*1024);
	$this->bytes_send = 0;
	if ($file = fopen($file, 'r'))
	{
		if(isset($_SERVER['HTTP_RANGE']))
		fseek($file, $range);
		while(!feof($file) and (connection_status()==0))
		{
			$buffer = fread($file, $chunksize);
			print($buffer);//echo($buffer); // is also possible
			flush();
			$this->bytes_send += strlen($buffer);
			//sleep(1);//// decrease download speed
		}
		fclose($file);
	}
	else
		die('error can not open file');
	if(isset($new_length))
		$size = $new_length;
	die();
} 

function delete_directory($dir)
{
   if (substr($dir, strlen($dir)-1, 1) != '/')
       $dir .= '/';
   if ($handle = opendir($dir))
   {
       while ($obj = readdir($handle))
       {
           if ($obj != '.' && $obj != '..')
           {
               if (is_dir($dir.$obj))
               {
                   if (!deleteDir($dir.$obj))
                       return false;
               }
               elseif (is_file($dir.$obj))
               {
                   if (!unlink($dir.$obj))
                       return false;
               }
           }
       }

       closedir($handle);

       if (!@rmdir($dir))
           return false;
       return true;
   }
   return false;
}

function convert_to_mysql_date($date)		//converts a date form '31/12/2006' => '2006-12-31'
{
	$first_slash_pos=strpos($date,'/');
	$second_slash_pos=strpos($date,'/',strpos($date,'/')+1);
	
	$day=substr($date,0,$first_slash_pos);
	$mon=substr($date,$first_slash_pos+1,($second_slash_pos-$first_slash_pos)-1);
	$year=substr($date,-4);

	$day=strlen($day)==1?"0".$day:$day;	
	$mon=strlen($mon)==1?"0".$mon:$mon;
		
	$date=$year."-".$mon."-".$day;
	return $date;
}
function convert_to_normal_date($date)		//converts a date form '2006-12-31' => '31/12/2006' 
{
	$date_arr=explode("-",$date);
	$date=(integer)$date_arr[2]."/".(integer)$date_arr[1]."/".(integer)$date_arr[0];
	return $date;
}

function month_in_datediff($dformat, $endDate, $beginDate)
{
	$date_parts1=explode($dformat, $beginDate);
	$date_parts2=explode($dformat, $endDate);
	$start_date=gregoriantojd($date_parts1[1], $date_parts1[0], $date_parts1[2]);
	$end_date=gregoriantojd($date_parts2[1], $date_parts2[0], $date_parts2[2]);
	
	$total_day_diff=$end_date - $start_date;
	$month=($total_day_diff/365)*12;
	return round($month,0);
}
//month_in_datediff("/", date("d/m/Y"),"25/7/1981");

function day_in_datediff($dformat, $endDate, $beginDate)
{
	$date_parts1=explode($dformat, $beginDate);
	$date_parts2=explode($dformat, $endDate);
	$start_date=gregoriantojd($date_parts1[1], $date_parts1[0], $date_parts1[2]);
	$end_date=gregoriantojd($date_parts2[1], $date_parts2[0], $date_parts2[2]);
	
	$total_day_diff=$end_date - $start_date;
	
	return $total_day_diff;
}
//day_in_datediff("/", date("d/m/Y"),"25/7/1981");

function error($message)
{
	$_SESSION['msg']=$message;     
	header('Location: error.php');
	exit();
}
function image_exists($path)	//	$path=	"../uploads/a.gif"
{
	if($path=='' || $path==NULL || substr($path,(strlen($path)-1))=='/' || !file_exists($path))
		return false;
	else
		return true;
}
function check_type_support($userfile_type)
{
	$flag=0;
	if ($userfile_type == 'image/x-png')
	{
		$userfile_type = 'image/png';
	}
	if ($userfile_type == 'image/pjpeg')
	{
		$userfile_type = 'image/jpeg';
	}
	
	switch($userfile_type)
	{
		case 'image/gif':
						break;
		case 'image/png':
						break;
		case 'image/jpeg':
						break;
		default:
			  $flag=1;
			  break;
	}
    return $flag;	
}

?>