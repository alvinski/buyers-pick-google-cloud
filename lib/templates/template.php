<?php
//version   programmer    Date      task
//1         khalid        10-04-2010     creation of template page
//2         khalid        14-06-2010     add code for cookie and dyanamic product image
//3			mithila		  22-06-2010	added new variable $toll_free and chaned mailto 
 $new_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Email Template</title>
</head>
<body>
	<table align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table border="1" style="border-color:#D6DEBD; border-collapse:collapse; margin-bottom:20px;" cellpadding="0" cellspacing="0">
					<tr><td><a href="http://192.168.0.226/users/emedoutlet/@@utm@@" title="Emedoutlet.com"><img src="http://192.168.0.226/users/emedoutlet/lib/templates/images/temp_top.gif" width="679" align="center" border="0" alt="Emedoutlet-Online Pharmacy  Customer service:+1(646) 502 8606"/></a></td></tr>
					<tr><td>
							<table align="left"><tr>
								<td><a href="http://192.168.0.226/users/emedoutlet/@@utm@@" title="Emedoutlet.com" style="color:#2F6E4A;font-size:12px; font-family:Verdana;text-decoration:none">Home</a><font color="#2F6E4A">&nbsp;|</font></td>
								<td><a href="http://192.168.0.226/users/emedoutlet/sitemap.php@@utm@@" style="color:#2F6E4A;font-size:12px; font-family:Verdana;text-decoration:none" title="All Products">All products</a><font color="#2F6E4A">&nbsp;|</font></td>
								<td><a href="http://192.168.0.226/users/emedoutlet/faq.php@@utm@@" style="color:#2F6E4A;font-size:12px; font-family:Verdana;text-decoration:none" title="Frequently asked questions">Faq</a><font color="#2F6E4A">&nbsp;|</font></td>
								<td><a href="http://192.168.0.226/users/emedoutlet/details.php@@utm@@" style="color:#2F6E4A;font-size:12px; font-family:Verdana;text-decoration:none" title="Contact Us">Contact Us</a><font color="#2F6E4A">&nbsp;|</font></td>
								<td><a href="https://www.emedoutlet.com/catalog_details.php@@utm@@" style="color:#2F6E4A;font-size:12px; font-family:Verdana;text-decoration:none" title="My Account">My Account</a>&nbsp;</td>
								<td width="270"></td>
								<td><font color="#0C542D" size="2">'. date("F j, Y").'</font></td>
							</tr></table>
					</td></tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0" align="left" width="679px" border="0">
					<tr>
						<td align="left" valign="top">
							<table border="0" cellpadding="0" cellspacing="0" bgcolor="#E7EFDA" style="border-collapse:collapse;margin-bottom:12px;">
								<tr><td valign="top">
								&nbsp;
								</td></tr>
								<tr><td>
									<table align="center" border="0" cellpadding="0" cellspacing="0" style="padding-bottom:20px;">
										<tr><td align="left"><font color="#0C542D"><b>Best Sellers</b></font></td></tr>
										<tr><td>
											<table border="1" style="border-color:#D6DEBD; border-collapse:collapse">
												<tr>
													<td>
														<table border="0" align="center" width="175" cellpadding="2">
															<tr>
																<td align="center">@@prod[0]@@</td>
															</tr>
															<tr>
																<td align="center"><b>@@prod_name[0]@@</b></td>
															</tr>
															<tr><td><hr color="#D6DEBD"/></td></tr>
															<tr><td align="center">@@prod[1]@@</td></tr>
															<tr><td align="center"><font size="2"color="#3657E4"><b>@@prod_name[1]@@</b></font></td></tr>
														</table>
													</td>
												</tr>
											</table>
										</td></tr>
									</table>
								</td></tr>
								<tr><td style="padding-bottom:145px;"><a href="http://192.168.0.226/users/emedoutlet/testimonial_view.php@@utm@@" title="Give Feedback for Emedoutlet.com"><img src="http://192.168.0.226/users/emedoutlet/lib/templates/images/temp_left3.gif" border="0" alt="Write a review"/></a></td></tr>
							</table>
						</td>
						<td valign="top" align="center" >
							<table width="90%" cellpadding="0" align="center" cellspacing="0" border="1" style="border-color:#D6DEBD; border-collapse:collapse;margin-left:5px;">
								<tr>
									<td>
										<a href="http://192.168.0.226/users/emedoutlet/@@utm@@" title="Emedoutlet.com"><img src="http://192.168.0.226/users/emedoutlet/lib/templates/images/temp_right.gif" width="473" align="center" border="0" alt="Best online pharmacy Secure Payment Option"/></a>
									</td>
								</tr>
								<tr>
									<td height="555px" width="100%" align="left" valign="top" style="padding:10px 10px 10px 10px;">
										@@body@@
									</td>
								</tr>							
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr style="margin-top:0">
			<td valign="top" style="margin-top:0">
				<table style="margin-top:0;background-color:#F2F6EB; border-top:solid #D6DEBD;padding:10px 0px 0px 10px" cellpadding="0" cellspacing="0" border="0" width="679">
					<tr  >
						<td><a href="http://192.168.0.226/users/emedoutlet/@@utm@@" title="Emedoutlet.com" style="font-size:11px;color:#052ED8;font-family:Verdana;text-decoration:none">Home</a><font color="#052ED8";>&nbsp;|&nbsp;</font>
						<a href="http://192.168.0.226/users/emedoutlet/details.php@@utm@@" style="font-size:11px;color:#052ED8;font-family:Verdana;text-decoration:none" >Contact us</a><font color="#052ED8">&nbsp;|&nbsp;</font>
						<a href="http://192.168.0.226/users/emedoutlet/faq.php@@utm@@" style="font-size:11px;color:#052ED8;font-family:Verdana;text-decoration:none">Faq</a><font color="#052ED8">&nbsp;|&nbsp;</font>
						<a href="http://192.168.0.226/users/emedoutlet/shipping_policy.php@@utm@@" style="font-size:11px;color:#052ED8;font-family:Verdana;text-decoration:none">Shipping policy</a><font color="#052ED8">&nbsp;|&nbsp;</font>
						<a href="http://192.168.0.226/users/emedoutlet/privacy_policy.php@@utm@@" style="font-size:11px;color:#052ED8;font-family:Verdana;text-decoration:none">Privacy policy</a>&nbsp;</td>
						</tr>
						<tr><td width=100%><hr></hr></td></tr>
					<tr align="left" valign="top" height="120px">
		               <td valign="top" style="font-size:13px;color:#052ED8;font-family:Verdana;text-decoration:none" width="100%">Toll Free:<font color="#0c542d">'.$toll_free.'</font><br/>live support:<font color="#0c542d">'.$live_phone_var.'</font><br/>Fax:<font color="#0c542d">'.$fax_var.'</font><br/>
					   Email:<a href="http://support.medhubonline.com/index.php?_m=tickets&_a=submit" style="font-size:13px;color:#052ED8;font-family:Verdana;text-decoration:none">
					   <font color="#0c542d"> http://support.medhubonline.com</font></a></td>
		            </tr>
				</table>
				
			</td>
		</tr>
	</table>
</body>
</html>';
?>
