<?php  
//version   programmer       Date                  task
//2               khalid              10-04-2010       creation of  page
//1              khalid              14-06-2010       add code for cookie and dyanamic product image
//001		Alvin				29/07/2013			Changed table name to tbl_banner for $img_query.

	function mymail($mail_array, $template, $uid = ''){
		global $db_name;
		if($uid!='')
    	{
			$img_qry = "SELECT 
							* 
						FROM 
							tbl_banner
						WHERE 
							userid='".$uid."' 
						ORDER BY 
							count 
						DESC 
							limit 2";
			$res     = my_result($db_name, $img_qry, __LINE__); 
			$rows    = mysql_num_rows($res);	
		}
		else
   	    {
			$rows = 0; // NO USER ID SPECIFIED  
		}
		if($rows!=0)
		{	
		  while($result=mysql_fetch_array($res)){
			$cnt                           = $result['count'];
			$generic_image        = $result['image'];
			$generic_name         = $result['generic_name'];
			$g_n_c                      = str_replace(" ","-",$generic_name );
			$generic_name          = str_replace("-Generic","",$g_n_c);
			$genurl      = "http://192.168.0.226/users/emedoutlet/health-wellness/".$generic_name."/".$result["genericid"].".html".$mail_array['utm'];
		  				  
			$prod[] = "<a href='".$genurl."' title='".$generic_name." on Emedoutlet.com'><img align='middle' src='http://192.168.0.226/users/emedoutlet/upload/".$generic_image."' alt='".$generic_name." on Emedoutlet.com' border='0' /></a>";
					
            $prod_name[] = "<a href='".$genurl."' style='font-size:13px;color:#3657E4; text-decoration:none' title='".$generic_name." on Emedoutlet.com'>Generic ".$generic_name."</a>";
		   }	
		   if($rows==1)
		   {
		     // IF THERE IS ONLY ONE MATCHING RECOTD FOR USER THEN ONE DYNAMIC AND ONE STATIC PRODUCT IN EMAIL

 			 $prod[1]     ='<a href="http://192.168.0.226/users/emedoutlet/health-wellness/Plavix/153.html'.$mail_array['utm'].'" title="Plavix on Emedoutlet.com"><img align="middle" src="http://192.168.0.226/users/emedoutlet/lib/templates/images/temp_left2-2.gif" alt="Plavix on Emedoutlet.com" border="0" /></a>';

             $prod_name[1] ='<a href="http://192.168.0.226/users/emedoutlet/health-wellness/plavix/153.html'.$mail_array['utm'].'" style="font-size:13px;color:#3657E4; text-decoration:none" title="Plavix on Emedoutlet.com">Generic Plavix</a>';
		   }
		}
		else
		{
		
		    $prod[0]     = '<a href="http://192.168.0.226/users/emedoutlet/health-wellness/Lipitor/37.html'.$mail_array['utm'].'" title="Lipitor on Emedoutlet.com"><img align="middle" src="http://192.168.0.226/users/emedoutlet/lib/templates/images/temp_left2-1.gif" alt="Lipitor on Emedoutlet.com" border="0" /></a>';

			$prod[1]     ='<a href="http://192.168.0.226/users/emedoutlet/health-wellness/Plavix/153.html'.$mail_array['utm'].'" title="Plavix on Emedoutlet.com"><img align="middle" src="http://192.168.0.226/users/emedoutlet/lib/templates/images/temp_left2-2.gif" alt="Plavix on Emedoutlet.com" border="0" /></a>';
			
			$prod_name[0] ='<a href="http://192.168.0.226/users/emedoutlet/health-wellness/Lipitor/37.html'.$mail_array['utm'].'" style="font-size:13px;color:#3657E4; text-decoration:none" title="Lipitor on Emedoutlet.com">Generic Lipitor</a>';
			
			$prod_name[1] ='<a href="http://192.168.0.226/users/emedoutlet/health-wellness/plavix/153.html'.$mail_array['utm'].'" style="font-size:13px;color:#3657E4; text-decoration:none" title="Plavix on Emedoutlet.com">Generic Plavix</a>';
		
		}
			$email_template = str_replace('@@body@@',$mail_array['body'],$template);
			$email_template = str_replace('@@utm@@',$mail_array['utm'],$email_template);
			$email_template = str_replace('@@prod[0]@@',$prod[0],$email_template);
			$email_template = str_replace('@@prod[1]@@',$prod[1],$email_template);
			$email_template = str_replace('@@prod_name[0]@@',$prod_name[0],$email_template);
			$email_template = str_replace('@@prod_name[1]@@',$prod_name[1],$email_template);

		return $email_template;
	}
	
?>	