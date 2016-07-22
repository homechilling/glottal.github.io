<?php

require_once('recaptchalib.php');

// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = "6LcaZOMSAAAAAIs01gyrpmyI4vWnzXH-9IsqAU4Y";
$privatekey = "6LcaZOMSAAAAAP3Uk1l_DO5XG7kzk6WvGlsx_PM7";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Glottal</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <link href="css/layout.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/validation.js"></script>
</head>
<body style="background-image:url(images/body_bg.png); background-repeat:repeat-x; background-color:#f8f6f6">
<?php

if(isset($_POST['Submit'])){
	$firstname = trim($_POST['firstname']); 
	$lastname = trim($_POST['lastname']); 
	$company = trim($_POST['company']); 
	$desig = trim($_POST['desig']);
	$addr1 = trim($_POST['addr1']); 
	$addr2 = trim($_POST['addr2']); 
	$city = trim($_POST['city']);
	$state = trim($_POST['state']); 
	$zip = trim($_POST['zip']); 
	$country = trim($_POST['country']);
	$phone = trim($_POST['phone']); 
	$fax = trim($_POST['fax']); 
	$email = trim($_POST['email']);
	$techsupportVal = trim($_POST['techsupport']);
	$shippingdetVal = trim($_POST['shippingdet']);
	$infoVal = trim($_POST['info']);
	$quoteVal = trim($_POST['quote']);
	$otherVal = trim($_POST['other']);

	$group11 = $_POST['group1'];
	$group33 = $_POST['group3'];

	$chktechsupport = $_POST['chktechsupport'];
	$chkshippingdet = $_POST['chkshippingdet'];
	$chkinfo = $_POST['chkinfo'];
	$chkquote = $_POST['chkquote'];
	$chkother = $_POST['chkother'];

	$type = "";
	$supportStr = "";
	$ReciveNewsletter="";

	if(isset($group33))
	{
		$ReciveNewsletter = "<br /> I am interested in receiving future updates and information on Glottal's products & services";
	}

	if(isset($group11))
	{
		$type = "I am a " . $group11 . "<br />";
	}

	if(isset($chktechsupport) or isset($chkshippingdet) or isset($chkinfo) or isset($chkquote) or isset($chkother))
	{
  		$supportStr = "I require: <br />";
		$subject = "Requires "; 
    
		  if(trim($chktechsupport) == "Technical Support")
		  {
			$supportStr = $supportStr . " " .$chktechsupport . " - " . $techsupportVal . "<br />"; 
			$subject = $subject . $chktechsupport . ", ";
		  }
		  if(trim($chkshippingdet) == "Shipping Details/Updates")
			{
			$supportStr = $supportStr . " " .$chkshippingdet . " - " . $shippingdetVal . "<br />"; 		    
			$subject = $subject . $chkshippingdet . ", ";
			}
		  if(trim($chkinfo) == "Information about")
		  {
			$supportStr = $supportStr . " " .$chkinfo . " - " . $infoVal . "<br />";		
			$subject = $subject . $chkinfo . ", ";
			}
		  if(trim($chkquote) == "Quote for")
		  {
			$supportStr = $supportStr . " " .$chkquote . " - " . $quoteVal . "<br />";
			$subject = $subject . $chkquote . ", ";
			}
		  if(trim($chkother) == "Other")
		  {
			$supportStr = $supportStr . " " .$chkother . " - " . $otherVal . "<br />";				
			$subject = $subject . $chkother . ", ";
			}
	}
	else {
		$subject = "Contact from " .$firstname;  
	  }

	$isError = "N";
	if($firstname == "" ) {
		$error1= "Enter your first name.";
		$code1= "1" ;
		$isError = "Y";
	}
	if($lastname == "" ) {
		$error2= "Enter your last name.";
		$code2= "2";
		$isError = "Y";	
	}
	if($company == ""){
		$error3="Enter your company.";
		$code3= "3";
		$isError = "Y";
	}
	if($country == ""){
		$error4="Enter your country.";
		$code4= "4";
		$isError = "Y";
	}
	//if($phone == ""){
	//	$error5="Enter your phone.";
	//	$code5= "5";
	//	$isError = "Y";
	//}
	//else if(!preg_match("/^[0-9]+$/", $phone)) {
	//	$error5="Enter a valid phone Number. Phone numbers cannot have characters.";
	//	$code5= "5";
	//	$isError = "Y";
	//}
	if($email == "" ) {
		$error6= "Enter your email.";
		$code6= "6";
		$isError = "Y";
	} //check for valid email
	elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
		$error6= 'You did not enter a valid email.';
		$code6= "6";
		$isError = "Y";
	}

	# was there a reCAPTCHA response?
	if ($_POST["recaptcha_response_field"]) {
			$resp = recaptcha_check_answer ($privatekey,
											$_SERVER["REMOTE_ADDR"],
											$_POST["recaptcha_challenge_field"],
											$_POST["recaptcha_response_field"]);
	}
	if ($resp->is_valid) {
			//$isError = "N"; //echo "You got it!";
	} else {
			//# set the error code so that we can display it
			$errorMsg = "Warning : Incorrect Verification Code, Try Again!"; // .$resp->error;
			$isError = "Y";
	}

	if($isError == "N")
	{
		$message = "First Name : $firstname <br />
		Last Name : $lastname <br />
		Company : $company <br />
		Designation : $desig <br />
		Address1 : $addr1 <br />
		Address2 : $addr2 <br />
		City : $city <br />
		State : $state <br />
		Zip : $zip <br />
		Country : $country <br />
		Phone : $phone <br />
		Fax : $fax <br />
		Email : $email <br />
		$type
		$supportStr
		$ReciveNewsletter
		";

		$to = " information@glottal.com,salesdept@glottal.com ";
		$headers = 'From: '.$email.'' . "\r\n" .    'Reply-To: '.$email.'' . "\r\n" .	'Content-type: text/html; charset=utf-8' . "\r\n" .    'X-Mailer: PHP/' . phpversion();

		$send_email = mail($to,$subject,$message,$headers);

		if($send_email)
		{ 
			$msg= "Your message was sent successfully.";
			$firstname = ""; 
			$lastname = ""; 
			$company = ""; 
			$desig = "";
			$addr1 = ""; 
			$addr2 = ""; 
			$city = "";
			$state = ""; 
			$zip = ""; 
			$country = "";
			$phone = ""; 
			$fax = ""; 
			$email = "";
			$techsupportVal = "";
			$shippingdetVal = "";
			$infoVal = "";
			$quoteVal = "";
			$otherVal = "";
			$group11 = "";
			$group33 = "";
			$ReciveNewsletter = "";	
			$chktechsupport = "";
			$chkshippingdet = "";
			$chkinfo = "";
			$chkquote = "";
			$chkother = "";
		}
		else
		{
			$errorMsg = "Error in sending contact email!!!";
		}
	}
}
?>
    <div id="container">
         <div id="header">
            <div class="logoContainer">
                <div>
                    <a href="index.html"> <img src="images/glottal new logo.png" width="350px" height="140px" > </a>
                </div>
            </div>
            <div class="social" style="float:left; visibility:hidden">
                <div style="float:left; "><a href="#"><img src="images/facebook.png" alt="" width="40" height="40" style="padding: 5px; margin-left:10px" /></a></div>
                <div style="float:left"> <a href="#"><img src="images/youtube.png" alt="" width="40" height="40" style="padding: 5px" /></a></div>
                <div style="float:left"> <a href="#"><img src="images/linkedin.png" alt="" width="40" height="40" style="padding: 5px" /></a></div>
                <div style="float:left"> <a href="#"><img src="images/googleplus.png" alt="" width="40" height="40" style="padding: 5px" /></a></div>



            </div>
            <div class="topbar">
                <div class="top-info">
                    <div class="contact_heading">
                        How can we help you?
                    </div>
                    <p>
                        <br />
                        <div class="ph">Ph: +1 315 422 1213</div> <br>

                        <div id="search">
                            <script>
                                (function () {
                                    var cx = '008840200205516682870:yl-4zn3gko4';
                                    var gcse = document.createElement('script');
                                    gcse.type = 'text/javascript';
                                    gcse.async = true;
                                    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                                        '//www.google.com/cse/cse.js?cx=' + cx;
                                    var s = document.getElementsByTagName('script')[0];
                                    s.parentNode.insertBefore(gcse, s);
                                })();
                            </script>
                            <gcse:search></gcse:search>
                        </div>

                </div>
            </div>
            <div class="clearfloat">
            </div>
            <!-- Menu -->
            <div class="menu_div">
              <div id="cssmenu">
                    <ul>
                        <li><a href="index.html"><span>Home</span></a></li>
                        <li><a href="about_us.html"><span>About</span></a></li>
                        <!--<li class="has-sub">
                <a href="#"><span>Customer</span></a>
                <ul>
                    <li><a href="customer_land.html"><span>See All Customer Types</span></a></li>
                    <li><a href="slp.html"><span>SLP</span></a></li>
                    <li class="last"><a href="#"><span>Customer 2</span></a></li>
                </ul>
            </li>-->

                        <li class="has-sub">
                            <a href="product.html"><span>Research and Teaching Products</span></a>
                            <ul>
                                <!--<li><a href="product.html"><span>Full Product Listing</span></a></li>-->
                                <!-- <li><a href="Oro_Nasal_Mask.html"><span>OroNasal Mask</span></a></li>-->
                                <li>
                                    <a href="Aeroview.html"><span>Aeroview System</span></a>
                                </li>
                                <li><a href="Dualview.html"><span>Dualview System</span></a></li>
                                <li><a href="Waveview.html"><span>Waveview System</span></a></li>
                                <!--<li><a href="DividerHandle.html"><span>Seperator Handle</span></a></li>-->
                                <!--<li><a href="MS110.html"><span>MS-110 Computer Interface</span></a></li>-->
                                <li><a href="theNEMSystem.html"><span>The Nasal Emission System</span></a></li>
                                <li><a href="theNASSystem.html"><span>The Nasalance System</span></a></li>
                                 <li><a href="NVSsystem.html"><span>The NVS System</span></a></li>
								  <li><a href="PGSeries.html"><span>Subglottal Pressure Measurement System</span></a></li>
                               
                           
                                <!--<li><a href="CalibrationUnits.html"><span>Calibration Units</span></a></li>-->




                            </ul>
                        </li> <li class="has-sub">
                            <a href="Electroglottographs.html"><span>Electroglottograph</span></a>
                            <ul>
                                <!--<li><a href="product.html"><span>Full Product Listing</span></a></li>-->
                                <!-- <li><a href="Oro_Nasal_Mask.html"><span>OroNasal Mask</span></a></li>-->
                                



                            </ul>
                        </li>
                        <!--<li class="last"><a href="CustomerService.html"><span>Customer Service</span></a>

            </li>-->
                        <!-- <li class="has-sub">
                <a href="#"><span>Instructional Videos</span></a>
                <ul>

                    <li><a href="Oro_Nasal_Mask.html#res"><span>OroNasal Mask</span></a></li>
                    <li><a href="Aeroview.html#res"><span>Aeroview System</span></a></li>
                    <li><a href="Waveview.html#res"><span>Waveview System</span></a></li>
                    <li><a href="DividerHandle.html#res"><span>Seperator Handle</span></a></li>
                    <li><a href="MS110.html#res"><span>MS-110 Computer Interface</span></a></li>
                    <li><a href="Electroglottographs.html#res"><span>Electoglottographs</span></a></li>
                    <li><a href="PhaseComp.html#res"><span>PhaseComp Software</span></a></li>
                    <li><a href="CalibrationUnits.html#res"><span>Calibration Units</span></a></li>
                    <li><a href="Dualview.html#res"><span>Dualview</span></a></li>
                    <li><a href="sVisualiser.html#res"><span>S-Visualizer</span></a></li>
                    <li><a href="ConsonantVisualizer.html#res"><span>Constant Visualizer</span></a></li>


                </ul>
            </li>-->
                        <!--<li class="last"><a href="FAQs.html"><span>FAQs</span></a></li>-->
                        <li class="last"><a href="Contact_Us.php"><span>Contact Us</span></a></li>
                        <li class="last">
                            <a href="Documents/Catalog.pdf" target=_new” onclick=”_gaq.push(['_trackEvent','Download','PDF',this.href]);”>View Our Product Catalog</a>

                            </li>
                    </ul>
                </div>
            </div>
            <!-- Menu End -->
        </div>


            <div class="headerPicContainer">
                <div class="contact-mid">
                    <!-- Begin Form -->
                    <div class="contact-form">
                       <span class="tabs_heading">Contact Us</span><br>
                        
                            <span class="mnd_field"><font>* </font>Fields Are Mandatory</span>
                        <form name="contact_form" method="post" action="">
                        <div class="cont-box">
                            <table cellpadding="0" cellspacing="0" width="98%">
		<?php if (isset($errorMsg)) { ?>
        <tr>
          <td colspan="4" align="left" ><?php echo "<p class='message'>" .$errorMsg. "</p>" ; ?></td>
        </tr>
        <?php } ?>
        <?php if(isset($msg)){?>
        <tr>
          <td colspan="4" align="left" ><?php echo "<p class='success-message'>" .$msg. "</p>" ; ?></td>
        </tr>
        <?php } ?>        
                                <tr>
                                    <td width="82">
                                        <label>
                                            First Name <span style="color: #d6390f;">*</span></label>
                                    </td>
                                    <td colspan="3">
                                        <input id="tbFirstName" name= "firstname" type= "text" class="validate[required] textbox420 text-input" maxlength="200" value="<?php if(isset($firstname)){echo $firstname;} ?>" <?php if(isset($code1) && $code1 == 1){echo "class=error" ;} ?> onBlur="return fnRemoveSpecialChars(this,'')" onKeyPress="return fnAllowAlpha(this,event)" />
                                    </td>
                                </tr>
		<?php if(isset($code1) && $code1 == 1) { ?>
        <tr><td></td>
          <td colspan="3" align="left" ><?php echo "<p class='message'>" .$error1. "</p>" ; ?></td>
        </tr>
        <?php } ?>
                                <tr>
                                    <td>
                                        <label>
                                            Last Name <span style="color: #d6390f;">*</span></label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text"  id="tbLastName" name="lastname" class="validate[required] textbox420 text-input"  maxlength="200" value="<?php if(isset($lastname)){echo $lastname;} ?>" <?php if(isset($code2) && $code2 == 2){echo "class=error" ;} ?> onBlur="return fnRemoveSpecialChars(this,'')" onKeyPress="return fnAllowAlpha(this,event)" />
                                    </td>
                                </tr>
		<?php if(isset($code2) && $code2 == 2) { ?>
        <tr><td></td>
          <td colspan="3" align="left" ><?php echo "<p class='message'>" .$error2. "</p>" ; ?></td>
        </tr>
        <?php } ?>								
                                <tr>
                                    <td>
                                        <label>
                                            Company <span style="color: #d6390f;">*</span></label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text"  id="tbCompany" name="company" class="validate[required] textbox420 text-input"  maxlength="100"  value="<?php if(isset($company)){echo $company;} ?>" <?php if(isset($code3) && $code3 == 3){echo "class=error" ;} ?> onBlur="return fnRemoveSpecialChars(this,'-,._')" onKeyPress="return fnAllowAlphaNumericAndChar(this,event,'-,._')" />
                                    </td>
                                </tr>
		<?php if(isset($code3) && $code3 == 3) { ?>
        <tr><td></td>
          <td colspan="3" align="left" ><?php echo "<p class='message'>" .$error3. "</p>" ; ?></td>
        </tr>
        <?php } ?>								
                                <tr>
                                    <td>
                                        <label>
                                            Designation</label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text" id="tbDesignation" name="desig"  maxlength="30"  class="validate[required] textbox420 text-input" value="<?php if(isset($desig)){echo $desig;} ?>" onBlur="return fnRemoveSpecialChars(this,'-,._')" onKeyPress="return fnAllowAlphaNumericAndChar(this,event,'-,._')" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Address 1
                                        </label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text"  id="tbAddr1" name="addr1" maxlength="75" class="validate[required] textbox420 text-input" value="<?php if(isset($addr1)){echo $addr1;} ?>"  onBlur="return fnRemoveSpecialChars(this,'-,._')" onKeyPress="return fnAllowAlphaNumericAndChar(this,event,'-,._')" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Address 2
                                        </label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text"  id="tbAddr2" name="addr2" maxlength="75" class="validate[required] textbox420 text-input" value="<?php if(isset($addr2)){echo $addr2;} ?>" onBlur="return fnRemoveSpecialChars(this,'-,._')" onKeyPress="return fnAllowAlphaNumericAndChar(this,event,'-,._')" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Address 3
                                        </label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text" id="tbAddr2" name="addr2" maxlength="75" class="validate[required] textbox420 text-input" value="<?php if(isset($addr2)){echo $addr2;} ?>" onBlur="return fnRemoveSpecialChars(this,'-,._')" onKeyPress="return fnAllowAlphaNumericAndChar(this,event,'-,._')" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            City
                                        </label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text"  id="tbCity" name="city"  maxlength="30"  class="validate[required] textbox420 text-input" value="<?php if(isset($city)){echo $city;} ?>" onBlur="return fnRemoveSpecialChars(this,'-.')" onKeyPress="return fnAllowAlphaNumericAndChar(this,event,'-.')" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            State
                                        </label>
                                    </td>
                                    <td width="283">
                                        <input type="text" id="tbState"  name="state"  maxlength="30"   class="validate[required] textbox150 text-input" value="<?php if(isset($state)){echo $state;} ?>" onBlur="return fnRemoveSpecialChars(this,'-.')" onKeyPress="return fnAllowAlphaNumericAndChar(this,event,'-.')" />
                                    </td>
                                    <td width="37">
                                        <label>
                                            Zip
                                        </label>
                                    </td>
                                    <td width="282">
                                        <input type="text" id="tbZip" name="zip"  maxlength="30"  class="validate[required] textbox150 text-input" value="<?php if(isset($zip)){echo $zip;} ?>" onBlur="return fnRemoveSpecialChars(this,'-')" onKeyPress="return fnAllowAlphaNumericAndChar(this,event,'-')" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Country <span style="color: #d6390f;">*</span></label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text" id="tbCountry" name="country" maxlength="60" class="validate[required] textbox420 text-input" value="<?php if(isset($country)){echo $country;} ?>" <?php if(isset($code4) && $code4 == 4){echo "class=error" ;} ?> onBlur="return fnRemoveSpecialChars(this,'')" onKeyPress="return fnAllowAlphaNumericAndChar(this,event,'')" />
                                    </td>
                                </tr>
		<?php if(isset($code4) && $code4 == 4) { ?>
        <tr><td></td>
          <td colspan="3" align="left" ><?php echo "<p class='message'>" .$error4. "</p>" ; ?></td>
        </tr>
        <?php } ?>								
								
                                <tr>
                                    <td>
                                        <label>
                                            Phone</label>
                                    </td>
                                    <td width="283">
                                        <input type="text" id="tbPhone" name="phone" maxlength="30" class="validate[required] textbox150 text-input" value="<?php if(isset($phone)){echo $phone;} ?>" <?php if(isset($code5) && $code5 == 5){echo "class=error" ;} ?> onBlur="return fnRemoveSpecialChars(this,'-')" onKeyPress="return fnAllowNumericAndChar(this,event,'-')" />
                                    </td>
                                    <td width="37">
                                        <label>
                                            Fax
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" id="tbFax" name="fax" maxlength="30" class="validate[required] textbox150 text-input" value="<?php if(isset($fax)){echo $fax;} ?>" onBlur="return fnRemoveSpecialChars(this,'-')" onKeyPress="return fnAllowNumericAndChar(this,event,'-')" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Email <span style="color: #d6390f;">*</span></label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text" id="tbEmail"  name="email" class="validate[required] textbox420 text-input" value="<?php if(isset($email)){echo $email;} ?>" <?php if(isset($code6) && $code6 == 6){echo "class=error" ;} ?> onBlur="return fnRemoveSpecialChars(this,'@._-')" onKeyPress="return fnAllowAlphaNumericAndChar(this,event,'@._-')" maxlength="150" />
                                    </td>
                                </tr>
		<?php if(isset($code6) && $code6 == 6) { ?>
        <tr><td></td>
          <td colspan="3" align="left" ><?php echo "<p class='message'>" .$error6. "</p>" ; ?></td>
        </tr>
        <?php } ?>								
								
                            </table>
                        </div>
                        <div class="cont-box">
                            <table cellpadding="0" cellspacing="0" width="90%">
                                <tr valign="top">
                                    <td width="90px">
                                        <label>
                                            I am a</label>
                                    </td>
                                    <td colspan="3" align="left">
									<table cellpadding="2" cellspacing="2">
									
										<tr>
										<td>
                                        <input type="radio" name="group1" value="Researcher" <?php echo ($group11 == 'Researcher' ? 'checked' : '') ?> />
                                        Researcher</td>
										</tr>
										<tr>
										<td>
                                        <input type="radio" name="group1" value="Home User" <?php echo ($group11 == 'Home User' ? 'checked' : '') ?> />
                                        Educator</td>
										</tr>
										<tr>
										<td>
                                        <input type="radio" name="group1" value="Distributor/Vendor" <?php echo ($group11 == 'Distributor/Vendor' ? 'checked' : '') ?> />
                                        Distributor</td>
										</tr>
										<tr>
										<td>
                                        <input type="radio" name="group1" value="Other" <?php echo ($group11 == 'Other' ? 'checked' : '') ?> />
                                        Other</td>
										</tr>
										</table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="cont-box">
                            <table cellpadding="0" cellspacing="0" width="98%">
                                <tr valign="middle">
                                    <td width="90" valign="top">
                                        <label>
                                            I Require</label>
                                    </td>
                                    <td width="200" valign="top">
                                        <input type="checkbox" name="chkinfo" value="Information about" <?php echo ($chkinfo == 'Information about' ? 'checked' : '') ?> />
                                        Information about
                                    </td>
                                    <td colspan="2" valign="top"><textarea name="info" id="tbInfo"  cols="" rows="" class="validate[required] textarea_300 text-input" style="resize:vertical;"><?php if(isset($infoVal)){echo $infoVal;} ?></textarea></td>
                                </tr>
                                <tr valign="middle">
                                    <td width="90">
                                    </td>
                                    <td valign="top">
                                        <input type="checkbox" name="chkquote" value="Quote for" <?php echo ($chkquote == 'Quote for' ? 'checked' : '') ?> />
                                        Quote for
                                    </td>
                                    <td colspan="2" valign="top"><textarea name="quote" id="tbQuote" cols="" rows="" class="validate[required] textarea_300 text-input" style="resize:vertical; "><?php if(isset($quoteVal)){echo $quoteVal;} ?></textarea></td>
                                </tr>
                                <tr valign="middle">
                                    <td width="90">
                                    </td>
                                    <td valign="top">
                                        <input type="checkbox" name="chktechsupport" value="Technical Support" <?php echo ($chktechsupport == 'Technical Support' ? 'checked' : '') ?> />
                                        Technical Support
                                    </td>
                                    <td colspan="2" valign="top"><textarea id="tbTechSupport" name="techsupport" class="validate[required] textarea_300 text-input" style="resize:vertical;" cols="" rows=""><?php if(isset($techsupportVal)){echo $techsupportVal;} ?></textarea></td>
                                </tr>
                                <tr valign="middle">
                                    <td width="90">
                                    </td>
                                    <td valign="top">
                                        <input type="checkbox" name="chkshippingdet" value="Shipping Details/Updates" <?php echo ($chkshippingdet == 'Shipping Details/Updates' ? 'checked' : '') ?> />
                                        Shipping Details/Updates
                                    </td>
                                    <td colspan="2" valign="top"><textarea id="tbShippingDet" size="30" name="shippingdet" class="validate[required] textarea_300 text-input" style="resize:vertical;" cols="" rows=""><?php if(isset($shippingdetVal)){echo $shippingdetVal;} ?></textarea></td>
                                </tr>
                                <tr valign="middle">
                                    <td width="90">
                                    </td>
                                    <td valign="top">
                                        <input type="checkbox" name="chkother" value="Other" <?php echo ($chkother == 'Other' ? 'checked' : '') ?> />
                                        Other
                                    </td>
                                    <td colspan="2" valign="top"><textarea id="tbOther" size="30" name="other" class="validate[required] textarea_300 text-input" style="resize:vertical;" cols="" rows=""><?php if(isset($otherVal)){echo $otherVal;} ?></textarea></td>
                                </tr>
                                <tr valign="middle">
                                <td height="59"></td>
                                    <td colspan="3" style="padding: 0 0 10px 0;">
                                        <input type="checkbox" name="group3" value="I am interested in receiving future updates and information on Glottal's products
                                        & services" <?php echo ($ReciveNewsletter == '' ? '' :'checked') ?> />
                                        I am interested in receiving future updates and information on Glottal's products & services <br><br>  (Glottal Enterprises only sends content relevant to your needs periodically; not more than one promotional email a month at most)
                                    </td>
                                </tr>
								<tr>
								<td></td>
								<td colspan="3" align="center">
<?php
echo recaptcha_get_html($publickey, $error);
?>
</td>
</tr>
                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td width="378" align="left">
<input type="submit" class="button_green" size="30" name="Submit" value="Submit" />
<input type="submit" name="reset" value="Clear Form"  class="button_green" onclick="document.theForm.reset();return false;" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </form>

                    </div>
                    <!-- Begin Information -->
                    <div class="contact-right">
                        <div class="contact-info">
                            <span class="contact-info-box">
                            <span class="retro_style">Glottal Enterprises Incorporated</span>
                            <span class="retro_content">1201 E. Fayette St, Suite #15<br />
                                Syracuse NY 13210 - 1953<br />
                                USA <br></span>  
                            </span>
                            <span class="contact-info-box">Ph: + 1 315 422 1213<br />
                                Fax: +1 315 422 1216 </span>
                                
                        </div>
                    </div>
                    <!-- End Information -->
                </div>
            </div>
        </div>
        <!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats -->
        <br class="clearfloat" />
        <!-- begin #footer -->
        <div id="footer">
            <p>
	                   <a title="Home" href="index.html" class="footerLink">Home</a> | 
                       <a title="About Us" href="about_us.html" class="footerLink">About Us</a> | 
                       <a title="Contact Us" href="Contact_Us.php" class="footerLink">Contact Us</a>
            <div class="vlinks">
                &copy; Glottal Enterprises Incorporated 2014</div>
        </div>
    </div>
</body>


<link href="favicon.ico" />
</html>