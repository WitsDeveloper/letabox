<?php
require_once("$class_dir/class.validator.php3");
?>
<script language="javascript" type="text/javascript">
//Define page title
document.title = "<?=SYSTEM_SHORT_NAME;?> | Global Settings";

//Clear file upload field
function clearField(id){
	if ($.browser.msie) {
		$('#'+id).replaceWith($('#'+id).clone());
	}
	else {
		$('#'+id).val('');
	}
}
</script>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Global Settings</h1>
  </div>
  <!-- /.col-lg-12 --> 
</div>
<!-- /.row -->


<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="fa fa-gear fa-fw"></i> Manage Settings </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <!--Begin Forms-->

        <div class="tabs-container">
          <ul class="nav nav-tabs">
                <?php if(isSuperAdmin()){ ?>
                <li class="active"><a data-toggle="tab" href="#tabs-x" title="Premade Messages"><span>Shop Set up</span></a></li>
                <?php } ?>
            <li class=""><a data-toggle="tab" href="#tabs-1" title="Premade Messages"><span>Global Settings</span></a></li>
            <?php if(isSuperAdmin()){ ?>
            <li><a data-toggle="tab" href="#tabs-2" title="Configuration"><span>Configuration</span></a></li>
            <?php 
			}
			if(isSuperAdmin() || isSystemAdmin()){
			?>
            <li><a data-toggle="tab" href="#tabs-3" title="System Logs"><span>System Logs</span></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
                 <div id="tabs-x" class="tab-pane active">
              <h2>Global Shop Settings</h2>
                          <?php 
     
       $project_desc1 = $mysqli->query("SELECT * from lbs_settings")or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
            
      while($obj_ona1= $project_desc1->fetch_object()){
      if($obj_ona1->lbs_settings_name==='SHIPPING_RATE'){
          $SHIPPING_RATE=$obj_ona1->lbs_settings_value;
      }
      elseif($obj_ona1->lbs_settings_name==='TAX_RATE'){
        $TAX_RATE=$obj_ona1->lbs_settings_value;  
      }
        elseif($obj_ona1->lbs_settings_name==='MARGIN'){
        $MARGIN=$obj_ona1->lbs_settings_value;  
      }
        elseif($obj_ona1->lbs_settings_name==='RateUSDKES'){
        $RateUSDKES=$obj_ona1->lbs_settings_value;  
      }
       else{
           
       }
      }
   ?>
              <div class="row">
                  <form action="" method="post">
                  <div class="col-md-12">
                      <div class="form-group">
                <label class="col-sm-4 control-label"> LOCAL SHIPPING RATE</label>
                <div class="col-sm-8"><input class="form-control" name="SHIPPING_RATE" value="<?php print $SHIPPING_RATE ? $SHIPPING_RATE : ''; ?>" type="text" size="30"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">MARGIN</label>
                <div class="col-sm-8"><input class="form-control" name="MARGIN" value="<?php print $MARGIN ? $MARGIN : ''; ?>" type="text" size="20"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">TAX RATE</label>
                <div class="col-sm-8"><input class="form-control" name="TAX_RATE" value="<?php print $TAX_RATE ? $TAX_RATE : ''; ?>" type="text" size="35"></div>
                </div>
             <div class="form-group">
                <label class="col-sm-4 control-label">EXCHANGE RATE</label>
                <div class="col-sm-8"><input class="form-control" name="RateUSDKES" value="<?php print $RateUSDKES ? $RateUSDKES : ''; ?>" type="text" size="35"></div>
                </div>
                
                
                  </div>
                      <?php
                if(($TAX_RATE||$SHIPPING_RATE||$MARGIN||$REALISTIC_EXCHANGE_RATE)!='') 
                       {
                      ?>
                      <input type="submit" class="btn btn-lg" name="UPD_CONF" value="UPDATE SETTINGS"/>
                       <?php } else { ?>
                  <input type="submit" class="btn btn-lg" name="SAVE_CONF" value="SAVE SETTINGS"/>
                       <?php } ?>
                  </form>
                  
                  
              </div>
              
            </div>
            <div id="tabs-1" class="tab-pane ">
              <h2>IMPORTANT NOTICE</h2>
              <p><strong>Only the super administrator has the rights to change and view the configurations and system log files.</strong></p>
              <p>Adding wrong values to the configuration files could bring down this system making it completely unaccessible. Make sure you're aware of the values you're changing to make sure you do not compromise the stability of the system.</p>
              
              <h2>System Credits</h2>
              <p>System Developer: Sammy M. Waweru<br>
              Company Name: Wits Technologies Ltd<br>
              Email: sammy@witstechnologies.co.ke<br>
              Phone: +254 721428276</p>
              
            </div>
            <?php if(isSuperAdmin()){ ?>
            <div id="tabs-2" class="tab-pane">
              <?php
              //Array to store the error messages
              $ERRORS = array();
              $ALERTS = array();
              
              $ALERTS['MSG'] = WarnMessage("Be careful while editing this configuration file. Click on the attention icons for details.");
              
              if(isset($_POST['Submit'])){
              
                  //validation constructor
                  $check = new validator();
                  
                  //Variables
                  $SYSTEM_NAME = !is_String(strtoupper($_POST['SYSTEM_NAME']))?$ERRORS['SYSTEM_NAME']='Invalid Name':secure_string(strtoupper($_POST['SYSTEM_NAME']));
                  $SYSTEM_SHORT_NAME = !is_String(strtoupper($_POST['SYSTEM_SHORT_NAME']))?$ERRORS['SYSTEM_SHORT_NAME']='Invalid Name':secure_string(strtoupper($_POST['SYSTEM_SHORT_NAME']));
                  $PARENT_HOME_URL = !$check->is_url(strtolower($_POST['PARENT_HOME_URL']))?$ERRORS['PARENT_HOME_URL']='Invalid URL':strtolower($_POST['PARENT_HOME_URL']);
                  $SYSTEM_URL = !$check->is_url(strtolower($_POST['SYSTEM_URL']))?$ERRORS['SYSTEM_URL']='Invalid URL':strtolower($_POST['SYSTEM_URL']);	
                  $SYSTEM_LOGO_URL = !$check->is_url(strtolower($_POST['SYSTEM_LOGO_URL']))?$ERRORS['SYSTEM_LOGO_URL']='Invalid URL':strtolower($_POST['SYSTEM_LOGO_URL']);	
                  //Contacts
                  $COMPANY_PHONE = !$check->is_phone($_POST['COMPANY_PHONE'])?$ERRORS['COMPANY_PHONE']='Invalid Phone Number':$_POST['COMPANY_PHONE'];
                  $COMPANY_ADDRESS = secure_string($_POST['COMPANY_ADDRESS']);
                  //Folders                  
                  $IMAGE_FOLDER = secure_string($_POST['IMAGE_FOLDER']);
                  $FILE_FOLDER = secure_string($_POST['FILE_FOLDER']);
                  $ATTACHMENT_FOLDER = secure_string($_POST['ATTACHMENT_FOLDER']);
				  $THEME_FOLDER = secure_string($_POST['THEME_FOLDER']);
				  //Theme
				  $THEME_NAME_BE = secure_string($_POST['THEME_NAME_BE']);
				  $THEME_DIR_BE = secure_string($_POST['THEME_DIR_BE']);
				  $THEME_URL_BE = secure_string($_POST['THEME_URL_BE']);
                  //Emails used for alarts/notifications
                  $INFO_NAME = !is_String(strtoupper($_POST['INFO_NAME']))?$ERRORS['INFO_NAME']='Invalid Name':secure_string(strtoupper($_POST['INFO_NAME']));
                  $INFO_EMAIL = !$check->is_email(strtolower($_POST['INFO_EMAIL']))?$ERRORS['INFO_EMAIL']='Invalid email address':strtolower($_POST['INFO_EMAIL']);
                  $SUPPORT_NAME = !is_String(strtoupper($_POST['SUPPORT_NAME']))?$ERRORS['SUPPORT_NAME']='Invalid Name':secure_string(strtoupper($_POST['SUPPORT_NAME']));
                  $SUPPORT_EMAIL = !$check->is_email(strtolower($_POST['SUPPORT_EMAIL']))?$ERRORS['SUPPORT_EMAIL']='Invalid email address':strtolower($_POST['SUPPORT_EMAIL']);
                  $DEVELOPER_NAME = !is_String(strtoupper($_POST['DEVELOPER_NAME']))?$ERRORS['DEVELOPER_NAME']='Invalid Name':secure_string(strtoupper($_POST['DEVELOPER_NAME']));
                  $DEVELOPER_EMAIL = !$check->is_email(strtolower($_POST['DEVELOPER_EMAIL']))?$ERRORS['DEVELOPER_EMAIL']='Invalid email address':strtolower($_POST['DEVELOPER_EMAIL']);
                  //Database Settings
                  $DB_HOST = secure_string($_POST['DB_HOST']);
                  $DB_USER = secure_string($_POST['DB_USER']);
                  $DB_PASS = secure_string($_POST['DB_PASS']);
                  $DB_NAME = secure_string($_POST['DB_NAME']);
                  $DB_PREFIX = secure_string($_POST['DB_PREFIX']);
                  //Email Settings
                  $MAILER_FROM_NAME = !is_String(strtoupper($_POST['MAILER_FROM_NAME']))?$ERRORS['MAILER_FROM_NAME']='Invalid Name':secure_string(strtoupper($_POST['MAILER_FROM_NAME']));
                  $MAILER_FROM_EMAIL = !$check->is_email(strtolower($_POST['MAILER_FROM_EMAIL']))?$ERRORS['MAILER_FROM_EMAIL']='Invalid email address':strtolower($_POST['MAILER_FROM_EMAIL']);
                  $MAILER = secure_string($_POST['MAILER']);
                  $SENDMAIL = secure_string($_POST['SENDMAIL']);
                  $SMTP_AUTH = !empty($_POST['SMTP_AUTH'])?$_POST['SMTP_AUTH']:false;
                  $SMTP_SECU = !empty($_POST['SMTP_SECU'])?$_POST['SMTP_SECU']:'';
                  $SMTP_USER = secure_string($_POST['SMTP_USER']);
                  $SMTP_PASS = secure_string($_POST['SMTP_PASS']);
                  $SMTP_HOST = !$check->is_host($_POST['SMTP_HOST'])?$ERRORS['SMTP_HOST']='Invalid Host IP':$_POST['SMTP_HOST'];
                  $SMTP_PORT = !$check->is_port($_POST['SMTP_PORT'])?$ERRORS['SMTP_PORT']='Invalid Port IP':$_POST['SMTP_PORT'];
                  //Permission Settings
                  $LIMIT_USERS = !empty($_POST['LIMIT_USERS'])?$_POST['LIMIT_USERS']:false;
                  $LIMIT_ALLOWED = !$check->is_Numeric($_POST['LIMIT_ALLOWED'])?$ERRORS['LIMIT_ALLOWED']='Invalid digit':$_POST['LIMIT_ALLOWED'];
                  //Timezone Settings
                  $TIMEZONE = secure_string($_POST['TIMEZONE']);
                  //reCaptcha Keys
                  $RECAPTCHA_PUBLIC_KEY = secure_string($_POST['RECAPTCHA_PUBLIC_KEY']);
                  $RECAPTCHA_PRIVATE_KEY = secure_string($_POST['RECAPTCHA_PRIVATE_KEY']);
                  //Google Analytics
                  $GOOGLE_ANALYTICS_ID = secure_string($_POST['GOOGLE_ANALYTICS_ID']);
                  //SEO Settings
                  $META_KEYS = secure_string($_POST['META_KEYS']);
                  $META_DESC = secure_string($_POST['META_DESC']);
              
                  //file path
                  $fname = "$incl_dir/config.php";
              
                  // verify if there were any errors by checking
                  // the number of elements in the $ERRORS array
              
                  if(sizeof($ERRORS)>0){
                      //alert
                      $ALERTS['MSG'] = ErrorMessage("ERRORS ENCOUNTERED!");
                  }
                  else{
                      //write
                      if(is_writable($fname)){
                          $fhandle = fopen($fname,"wb");
                          fwrite($fhandle, "<?php \n");
                          fwrite($fhandle, "/********************************************* \n");
                          fwrite($fhandle, "Company:	Wits Technologies Ltd \n");
                          fwrite($fhandle, "Developer:	Sammy Mwaura Waweru \n");
                          fwrite($fhandle, "Mobile:		+254721428276 \n");
                          fwrite($fhandle, "Email:		sammy@witstechnologies.co.ke \n");
                          fwrite($fhandle, "Website:	http://www.witstechnologies.co.ke/ \n");
                          fwrite($fhandle, "Date Last Modified: ".date('d/m/Y')." \n");
                          fwrite($fhandle, "Last Modified By: ".$_SESSION['sysFullName']." \n");
                          fwrite($fhandle, "*********************************************/ \n\n");
                          fwrite($fhandle, "#Handle Errors \n");
                          fwrite($fhandle, "error_reporting(E_ALL ^ E_NOTICE); \n");
                          fwrite($fhandle, "header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1 \n");
                          fwrite($fhandle, "header('Expires: Thu, 19 Nov 1981 08:52:00 GMT'); // Date in the past \n");
                          fwrite($fhandle, "#Enable Sessions \n");
                          fwrite($fhandle, "session_start(); \n\n");
                          fwrite($fhandle, "#Site Settings \n");
                          fwrite($fhandle, "$"."SYSTEM_NAME = '".$SYSTEM_NAME."';\n");
                          fwrite($fhandle, "$"."SYSTEM_SHORT_NAME = '".$SYSTEM_SHORT_NAME."';\n");
                          fwrite($fhandle, "$"."PARENT_HOME_URL = '".$PARENT_HOME_URL."';\n");
                          fwrite($fhandle, "$"."SYSTEM_URL = '".$SYSTEM_URL."';\n");	
                          fwrite($fhandle, "$"."SYSTEM_LOGO_URL = '".$SYSTEM_LOGO_URL."';\n");
                          fwrite($fhandle, "#Site Contacts \n");
                          fwrite($fhandle, "$"."COMPANY_PHONE = '".$COMPANY_PHONE."';\n");
                          fwrite($fhandle, "$"."COMPANY_ADDRESS = '".$COMPANY_ADDRESS."';\n");
                          fwrite($fhandle, "#Theme \n");
                          fwrite($fhandle, "$"."SYS_PATH = dirname(dirname(__FILE__)));\n");
						  fwrite($fhandle, "$"."THEME_NAME_BE = '".$THEME_NAME_BE."';\n");
						  fwrite($fhandle, "$"."THEME_DIR_BE = '".$THEME_DIR_BE."';\n");
                          fwrite($fhandle, "$"."THEME_URL_BE = '".$THEME_DIR_BE."';\n");
						  fwrite($fhandle, "#Folders \n");
                          fwrite($fhandle, "$"."IMAGE_FOLDER = '".$IMAGE_FOLDER."';\n");
                          fwrite($fhandle, "$"."FILE_FOLDER = '".$FILE_FOLDER."';\n");
                          fwrite($fhandle, "$"."ATTACHMENT_FOLDER = '".$ATTACHMENT_FOLDER."';\n");
                          fwrite($fhandle, "#Emails used for alarts/notifications \n");
                          fwrite($fhandle, "$"."INFO_NAME = '".$INFO_NAME."';\n");
                          fwrite($fhandle, "$"."INFO_EMAIL = '".$INFO_EMAIL."';\n");
                          fwrite($fhandle, "$"."SUPPORT_NAME = '".$SUPPORT_NAME."';\n");
                          fwrite($fhandle, "$"."SUPPORT_EMAIL = '".$SUPPORT_EMAIL."';\n");
                          fwrite($fhandle, "$"."DEVELOPER_NAME = '".$DEVELOPER_NAME."';\n");
                          fwrite($fhandle, "$"."DEVELOPER_EMAIL = '".$DEVELOPER_EMAIL."';\n");
                          fwrite($fhandle, "#Database Settings \n");
                          fwrite($fhandle, "$"."DB_HOST = '".$DB_HOST."';\n");
                          fwrite($fhandle, "$"."DB_USER = '".$DB_USER."';\n");
                          fwrite($fhandle, "$"."DB_PASS = '".$DB_PASS."';\n");
                          fwrite($fhandle, "$"."DB_NAME = '".$DB_NAME."';\n");
                          fwrite($fhandle, "$"."DB_PREFIX = '".$DB_PREFIX."';\n");
                          fwrite($fhandle, "#Mailer Settings \n");
                          fwrite($fhandle, "$"."MAILER_FROM_NAME = '".$MAILER_FROM_NAME."';\n");
                          fwrite($fhandle, "$"."MAILER_FROM_EMAIL = '".$MAILER_FROM_EMAIL."';\n");
                          fwrite($fhandle, "$"."MAILER = '".$MAILER."';\n");
                          fwrite($fhandle, "$"."SENDMAIL = '".$SENDMAIL."';\n");
                          fwrite($fhandle, "$"."SMTP_AUTH = ".$SMTP_AUTH.";\n");
                          fwrite($fhandle, "$"."SMTP_SECU = '".$SMTP_SECU."';\n");
                          fwrite($fhandle, "$"."SMTP_USER = '".$SMTP_USER."';\n");
                          fwrite($fhandle, "$"."SMTP_PASS = '".$SMTP_PASS."';\n");
                          fwrite($fhandle, "$"."SMTP_HOST = '".$SMTP_HOST."';\n");
                          fwrite($fhandle, "$"."SMTP_PORT = ".$SMTP_PORT.";\n");
                          fwrite($fhandle, "#Permission Settings \n");
                          fwrite($fhandle, "$"."LIMIT_USERS = ".$LIMIT_USERS.";\n");
                          fwrite($fhandle, "$"."LIMIT_ALLOWED = ".$LIMIT_ALLOWED.";\n");
                          fwrite($fhandle, "#Timezone Settings \n");
                          fwrite($fhandle, "date_default_timezone_set('".$TIMEZONE."');\n");
                          fwrite($fhandle, "#reCAPTCHA keys \n");
                          fwrite($fhandle, "$"."RECAPTCHA_PUBLIC_KEY = '".$RECAPTCHA_PUBLIC_KEY."';\n");
                          fwrite($fhandle, "$"."RECAPTCHA_PRIVATE_KEY = '".$RECAPTCHA_PRIVATE_KEY."';\n");
                          fwrite($fhandle, "#Google Analytics \n");
                          fwrite($fhandle, "$"."GOOGLE_ANALYTICS_ID = '".$GOOGLE_ANALYTICS_ID."';\n");
                          fwrite($fhandle, "#SEO Settings \n");
                          fwrite($fhandle, "$"."META_KEYS = '".$META_KEYS."';\n");
                          fwrite($fhandle, "$"."META_DESC = '".$META_DESC."';\n");
                          fwrite($fhandle, "?>");
                          fclose($fhandle);
                      }
                  
                      $enable_write = isset($_POST['enable_write'])?$_POST['enable_write']:NULL;
                      $oldperms = fileperms($fname);
                      if ( $enable_write ) {
                  
                          @chmod( $fname, $oldperms | 0222);
                      }
                      if ($enable_write) {
                          @chmod($fname, $oldperms);
                      } 
                      else {
                          if (isset($_POST['disable_write'])?$_POST['disable_write']:NULL)
                              @chmod($fname, $oldperms & 0777555);
                      }
                      //alert
                      $ALERTS['MSG'] = ConfirmMessage("NEW SETTINGS WERE WRITTEN SUCCESSFULLY");
                  }
              }
              ?>
              <ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li><a href="admin.php?tab=9&task=edit" title="Global Settings">Global Settings</a></li><li class="active">Configuration</li></ol>
              <form class="form-horizontal" id="configeditor" name="ConfigEditor" method="post" action="">
                  
                <div id="hideMsg"><?php if(sizeof($ALERTS['MSG'])>0) { echo $ALERTS['MSG']; } ?></div>
                
                <div class="form-group">
                  <label class="col-sm-4 control-label">Configuration file is :<?php echo is_writable("$incl_dir/config.php") ? '<strong><span class="text-success"> Writeable</span></strong>' : '<strong><span class="text-danger"> Unwriteable</span></strong>' ?></label>
                  <div class="col-sm-8">
                    <div class="checkbox">
                    <?php
                    if (is_writable("$incl_dir/config.php")) {
                    ?>
                      <label for="disable_write"><input type="checkbox" id="disable_write" name="disable_write" value="1"/>Make unwriteable after saving</label>	
                    <?php
                    } else {
                    ?>
                      <label for="enable_write"><input type="checkbox" id="enable_write" name="enable_write" value="1"/>Override write protection while saving</label>
                    <?php
                    }
                    ?>
                    </div>
                  </div>
                </div>
                
                <p class="text-center"><strong>SITE INFORMATION SETTINGS</strong><hr></p>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">System Name <a name="SYSTEM_NAME" href="Javascript:;" onclick="alert('System Name is the full name of the client using this site.');"><img border="0" src="../images/icons/attention.png" alt="Attention!" width="16" height="16"></a></label>
                <div class="col-sm-8"><input class="form-control" name="SYSTEM_NAME" value="<?php echo $SYSTEM_NAME;?>" type="text" size="40"><?php echo "<span class='text-danger'>".$ERRORS['SYSTEM_NAME']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">System Short Name <a name="SYSTEM_SHORT_NAME" href="Javascript:;" onclick="alert('System sort name is the abbreviation  of the client using this site.');"><img border="0" src="../images/icons/attention.png" alt="Attention!" width="16" height="16"></a></label>
                <div class="col-sm-8"><input class="form-control" name="SYSTEM_SHORT_NAME" value="<?php echo $SYSTEM_SHORT_NAME;?>" type="text" size="40"><?php echo "<span class='text-danger'>".$ERRORS['SYSTEM_SHORT_NAME']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Parent Site URL <a name="PARENT_HOME_URL" href="Javascript:;" onclick="alert('The internet URL of the parent site homepage.');"><img border="0" src="../images/icons/attention.png" alt="Attention!" width="16" height="16"></a></label>
                <div class="col-sm-8"><input class="form-control" name="PARENT_HOME_URL" value="<?php echo $PARENT_HOME_URL;?>" type="text" size="40"><?php echo "<span class='text-danger'>".$ERRORS['PARENT_HOME_URL']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">System URL <a name="SYSTEM_URL" href="Javascript:;" onclick="alert('The intranet URL of this system.');"><img border="0" src="../images/icons/attention.png" alt="Attention!" width="16" height="16"></a></label>
                <div class="col-sm-8"><input class="form-control" name="SYSTEM_URL" value="<?php echo $SYSTEM_URL;?>" type="text" size="40"><?php echo "<span class='text-danger'>".$ERRORS['SYSTEM_URL']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">System Logo URL <a name="SYSTEM_LOGO_URL" href="Javascript:;" onclick="alert('The URL of the logo to use on this system.');"><img border="0" src="../images/icons/attention.png" alt="Attention!" width="16" height="16"></a></label>
                <div class="col-sm-8"><input class="form-control" name="SYSTEM_LOGO_URL" value="<?php echo $SYSTEM_LOGO_URL;?>" type="text" size="40"><?php echo "<span class='text-danger'>".$ERRORS['SYSTEM_LOGO_URL']."</span>";?></div>
                </div>
                
                <p class="text-center"><strong>CONTACT SETTINGS</strong><hr></p>
                                
                <div class="form-group">
                <label class="col-sm-4 control-label">Phone Number</label>
                <div class="col-sm-8"><input class="form-control" name="COMPANY_PHONE" value="<?php echo $COMPANY_PHONE;?>" type="text" size="20"><?php echo "<span class='text-danger'>".$ERRORS['COMPANY_PHONE']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Postal Address</label>
                <div class="col-sm-8"><textarea class="form-control" name="COMPANY_ADDRESS" cols="20" rows="2"><?php echo $COMPANY_ADDRESS;?></textarea></div>
                </div>
                
                <p class="text-center"><strong>FOLDERS</strong><hr></p>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Theme Name</label>
                <div class="col-sm-8"><input class="form-control" name="THEME_NAME_BE" value="<?php echo $THEME_NAME_BE;?>" type="text" size="40"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Image Folder URL</label>                 
                <div class="col-sm-8"><input class="form-control" name="IMAGE_FOLDER" value="<?php echo $IMAGE_FOLDER;?>" type="text" size="40"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">File Folder URL</label>
                <div class="col-sm-8"><input class="form-control" name="FILE_FOLDER" value="<?php echo $FILE_FOLDER;?>" type="text" size="40"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Attachment Folder URL</label>
                <div class="col-sm-8"><input class="form-control" name="ATTACHMENT_FOLDER" value="<?php echo $ATTACHMENT_FOLDER;?>" type="text" size="40"></div>
                </div>
                
                <p class="text-center"><strong>EMAIL SETTINGS</strong><hr></p>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Information Name</label>
                <div class="col-sm-8"><input class="form-control" name="INFO_NAME" value="<?php echo $INFO_NAME;?>" type="text" size="30"><?php echo "<span class='text-danger'>".$ERRORS['INFO_NAME']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Information Email</label>
                <div class="col-sm-8"><input class="form-control" name="INFO_EMAIL" value="<?php echo $INFO_EMAIL;?>" type="text" size="35"><?php echo "<span class='text-danger'>".$ERRORS['INFO_EMAIL']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Support Name</label>
                <div class="col-sm-8"><input class="form-control" name="SUPPORT_NAME" value="<?php echo $SUPPORT_NAME;?>" type="text" size="30"><?php echo "<span class='text-danger'>".$ERRORS['SUPPORT_NAME']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Support Email</label>
                <div class="col-sm-8"><input class="form-control" name="SUPPORT_EMAIL" value="<?php echo $SUPPORT_EMAIL;?>" type="text" size="35"><?php echo "<span class='text-danger'>".$ERRORS['SUPPORT_EMAIL']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Developer Name</label>
                <div class="col-sm-8"><input class="form-control" name="DEVELOPER_NAME" value="<?php echo $DEVELOPER_NAME;?>" type="text" size="30"><?php echo "<span class='text-danger'>".$ERRORS['DEVELOPER_NAME']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Developer Email</label>
                <div class="col-sm-8"><input class="form-control" name="DEVELOPER_EMAIL" value="<?php echo $DEVELOPER_EMAIL;?>" type="text" size="35"><?php echo "<span class='text-danger'>".$ERRORS['DEVELOPER_EMAIL']."</span>";?></div>
                </div>
                
                <p class="text-center"><strong>DATABASE SETTINGS</strong>&nbsp;<a name="dbsettings" href="Javascript:;" onclick="alert('Do not change the database settings unless you know what you are doing');"><img border="0" src="../images/icons/warn.png" alt="Warning!" width="16" height="16"></a><hr></p>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Host</label>
                <div class="col-sm-8"><input class="form-control" name="DB_HOST" value="<?php echo $DB_HOST;?>" type="text" size="35"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">User</label>
                <div class="col-sm-8"><input class="form-control" name="DB_USER" value="<?php echo $DB_USER;?>" type="text" size="20"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Password</label>
                <div class="col-sm-8"><input class="form-control" name="DB_PASS" value="<?php echo $DB_PASS;?>" type="password" size="20"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Database</label>
                <div class="col-sm-8"><input class="form-control" name="DB_NAME" value="<?php echo $DB_NAME;?>" type="text" size="20"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Table Prefix</label>
                <div class="col-sm-8"><input class="form-control" name="DB_PREFIX" value="<?php echo $DB_PREFIX;?>" type="text" size="10"></div>
                </div>
                
                <p class="text-center"><strong>MAIL SETTINGS</strong>&nbsp;<a name="mailsettings" href="Javascript:;" onclick="alert('Do not change the mail settings unless you know what you are doing');"><img border="0" src="../images/icons/warn.png" alt="Warning!" width="16" height="16"></a><hr></p>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">From Name</label>
                <div class="col-sm-8"><input class="form-control" name="MAILER_FROM_NAME" value="<?php echo $MAILER_FROM_NAME;?>" type="text" size="30"><?php echo "<span class='text-danger'>".$ERRORS['MAILER_FROM_NAME']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">From Email <a name="MAILER_FROM_EMAIL" href="Javascript:;" onclick="alert('From email is used by the system to send email notifications and alerts.');"><img border="0" src="../images/icons/attention.png" alt="Attention!" width="16" height="16"></a></label>
                <div class="col-sm-8"><input class="form-control" name="MAILER_FROM_EMAIL" value="<?php echo $MAILER_FROM_EMAIL;?>" type="text" size="35"><?php echo "<span class='text-danger'>".$ERRORS['MAILER_FROM_EMAIL']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Mailer</label>
                <div class="col-sm-8"><select class="form-control" name="MAILER">
                <?php 
                if($MAILER == 'mail') $MAILER1 = 'selected="selected"'; 
                elseif($MAILER == 'smtp') $MAILER2 = 'selected="selected"'; 
                elseif($MAILER == 'sendmail') $MAILER3 = 'selected="selected"';
                else {$MAILER1 = $MAILER2 = $MAILER3 = '';}
                ?>
                <option <?=$MAILER1?> value="mail">Mail</option>
                <option <?=$MAILER2?> value="smtp">SMTP</option>
                <option <?=$MAILER3?> value="senmail">Sendmail</option>
                </select></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Sendmail Path</label>
                <div class="col-sm-8"><input class="form-control" name="SENDMAIL" value="<?php echo $SENDMAIL;?>" type="text" size="30"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">SMTP Authentication</label>
                <div class="col-sm-8"><select class="form-control" name="SMTP_AUTH">
                <?php 
                if($SMTP_AUTH) 
                $SMTP_AUTH1 = 'selected="selected"'; 
                else 
                $SMTP_AUTH2 = 'selected="selected"'; 
                ?>
                <option <?=$SMTP_AUTH1?> value="true">True</option>
                <option <?=$SMTP_AUTH2?> value="false">False</option>
                </select></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">SMTP Servier</label>
                <div class="col-sm-8"><select class="form-control" name="SMTP_SECU">
                <?php
                if($servier == 'ssl') $servier1 = 'selected="selected"'; 
                elseif($servier == 'tls') $servier2 = 'selected="selected"'; 
                else {$servier1 = $servier2 = '';}
                ?>
                <option value="">None</option>
                <option <?=$servier1?> value="ssl">SSL</option>
                <option <?=$servier2?> value="tls">TLS</option>
                </select></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">SMTP User</label>
                <div class="col-sm-8"><input class="form-control" name="SMTP_USER" value="<?php echo $SMTP_USER;?>" type="text" size="30"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">SMTP Password</label>
                <div class="col-sm-8"><input class="form-control" name="SMTP_PASS" value="<?php echo $SMTP_PASS;?>" type="password" size="20"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">SMTP Host</label>
                <div class="col-sm-8"><input class="form-control" name="SMTP_HOST" value="<?php echo $SMTP_HOST;?>" type="text" size="35"><?php echo "<span class='text-danger'>".$ERRORS['SMTP_HOST']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">SMTP Port</label>
                <div class="col-sm-8"><input class="form-control" name="SMTP_PORT" value="<?php echo $SMTP_PORT;?>" type="text" size="10"><?php echo "<span class='text-danger'>".$ERRORS['SMTP_PORT']."</span>";?></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Timezone</label>
                <div class="col-sm-8"><select class="form-control" name="TIMEZONE">
                <option value="Africa/Nairobi">Africa/Nairobi</option>
                </select></div>
                </div>
                
                <p class="text-center"><strong>PERMISSION SETTINGS</strong>&nbsp;<a name="permsettings" href="Javascript:;" onclick="alert('Do not change permission settings unless you know what you are doing');"><img border="0" src="../images/icons/warn.png" alt="Warning!" width="16" height="16"></a><hr></p>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Limit Back-end Users</label>
                <div class="col-sm-8"><select class="form-control" name="LIMIT_USERS">
                <?php 
                if($LIMIT_USERS) 
                $userlimit1 = 'selected="selected"'; 
                else 
                $userlimit2 = 'selected="selected"'; 
                ?>
                <option <?=$userlimit1?> value="true">Yes</option>
                <option <?=$userlimit2?> value="false">No</option>
                </select></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Allowed Limit</label>
                <div class="col-sm-8"><input class="form-control" name="LIMIT_ALLOWED" value="<?php echo $LIMIT_ALLOWED;?>" type="text" size="10"><?php echo "<span class='text-danger'>".$ERRORS['LIMIT_ALLOWED']."</span>";?></div>
                </div>
                
                <p class="text-center"><strong>reCAPTCHA SETTINGS</strong>&nbsp;<a name="metasettings" href="Javascript:;" onclick="alert('Do not change the reCAPTCHA settings unless you know what you are doing');"><img border="0" src="../images/icons/warn.png" alt="Warning!" width="16" height="16"></a><hr></p>
                
                <p class="text-center">Please obtain public and private keys from Google reCAPTCHA website <a href="https://www.google.com/recaptcha" target="_blank">https://www.google.com/recaptcha</a></p>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Public Key</label>
                <div class="col-sm-8"><input class="form-control" name="RECAPTCHA_PUBLIC_KEY" value="<?php echo $RECAPTCHA_PUBLIC_KEY;?>" type="text" size="50"></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Private Key</label>
                <div class="col-sm-8"><input class="form-control" name="RECAPTCHA_PRIVATE_KEY" value="<?php echo $RECAPTCHA_PRIVATE_KEY;?>" type="text" size="50"></div>
                </div>
                
                <p class="text-center"><strong>GOOGLE ANALYTICS</strong><hr></p>
                
                <p class="text-center">Please register your website on Google Analytics website <a href="http://www.google.com/analytics/" target="_blank">http://www.google.com/analytics/</a></p>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Tracking ID <small>(something like this: UA-XXXXXXXX-X)</small></label>
                <div class="col-sm-8"><input class="form-control" name="GOOGLE_ANALYTICS_ID" value="<?php echo $GOOGLE_ANALYTICS_ID;?>" type="text" size="50"></div>
                </div>
                
                <p class="text-center"><strong>SEO SETTINGS</strong><hr></p>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Meta Keys<small>(separate words with commas)</small></label>
                <div class="col-sm-8"><textarea class="form-control" name="META_KEYS" cols="30" rows="5"><?php echo $META_KEYS;?></textarea></div>
                </div>
                
                <div class="form-group">
                <label class="col-sm-4 control-label">Meta Description</label>
                <div class="col-sm-8"><textarea class="form-control" name="META_DESC" cols="40" rows="5"><?php echo $META_DESC;?></textarea></div>
                </div>
                
                <div class="form-group">
                  <div class="col-sm-12">
                    
                    <input class="btn btn-primary" type="submit" name="Submit" value="Save">
                  </div>
                </div>
                                  
              </form>
            </div>
          <?php
		  }
		  if(isSuperAdmin() || isSystemAdmin()){
		  ?>
            <div id="tabs-3" class="tab-pane">
              <ol class="breadcrumb"><li><a href="admin.php" title="Dashboard">Dashboard</a></li><li><a href="admin.php?tab=9&task=edit" title="Global Settings">Global Settings</a></li><li class="active">System Logs</li></ol>
              <p><strong>PHP Version:</strong> <?=phpversion();?><br>
              <strong>MySQL Version:</strong> <?=db_version();?></p><hr>
              <?php
                  $filename = "$logs_dir/system_logs.txt";
                  
                  if(isset($_POST['ClearErrors'])){	
                      // Let's make sure the file exists and is writable first.
                      if (is_writable($filename)) {	
                          // Write the contents to the file, 
                          // using the FILE_APPEND flag to append the content to the end of the file
                          // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
                          if(file_put_contents($filename, "", LOCK_EX) === FALSE){
                              echo "Cannot clear the file. Try again later";
                          }
                      }
                  }
                  
                  if (file_exists($filename)) {
                      $file = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
                      
                      if($file){
                          echo "<form name=\"ClearForm\" method=\"post\" action=\"\"><input type=\"submit\" name=\"ClearErrors\" value=\"Clear Errors\"></form>";
                          echo $file;
                          echo "<form name=\"ClearForm\" method=\"post\" action=\"\"><input type=\"submit\" name=\"ClearErrors\" value=\"Clear Errors\"></form>";
                      }
                      else
                          echo "Error file is empty";
                  }else{
                      echo "The server claims that this file does not exist.";
                  }		
              ?>    
            </div>
            <?php
            }
            ?>
          </div>
          <!-- / .tab-content -->
        </div>
  		<!-- / .tabs-container -->

		<!--End Forms-->      
      </div>
      <!-- /.panel-body --> 
    </div>
    <!-- /.panel-default --> 
  </div>
  <!-- /.col-lg-12 --> 
</div>
<!-- /.row -->
<?php
if(isset($_POST["SAVE_CONF"])||isset($_POST["UPD_CONF"])){
            global $mysqli;
            
		// Customer info
$SETTINGS_NAME='SHOP_SETUP';
$SHIPPING_RATE=$_POST['SHIPPING_RATE'];
$TAX_RATE=$_POST["TAX_RATE"];    
$MARGIN=$_POST["MARGIN"]; 
$RateUSDKES=$_POST["RateUSDKES"]; 
$userId=$_SESSION['sysUserID'];
$regDate=date("Y-m-d h:i:s");


$lbs_settings_name1 = 'SHIPPING_RATE';
$lbs_settings_value1 = $SHIPPING_RATE;

//2

$lbs_settings_name2 = 'TAX_RATE';
$lbs_settings_value2 = $TAX_RATE;
//3
$lbs_settings_name3 = 'MARGIN';
$lbs_settings_value3 = $MARGIN;
//4
$lbs_settings_name4 = 'RateUSDKES';
$lbs_settings_value4 = $RateUSDKES;

if(isset($_POST["SAVE_CONF"])){

$insert = $mysqli->query("INSERT INTO lbs_settings(lbs_settings_name,lbs_settings_value,userID,lbs_settings_date) VALUES
('$lbs_settings_name1', '$lbs_settings_value1', '$userId','$regDate'),"
        . "('$lbs_settings_name2', '$lbs_settings_value2', '$userId','$regDate'),"
        . "('$lbs_settings_name3', '$lbs_settings_value3', '$userId','$regDate'),"
        . "('$lbs_settings_name4', '$lbs_settings_value4', '$userId','$regDate')")
        or die('Error : (' . $mysqli->errno . ') ' . $mysqli->error);

if($insert){

 print '<script type="text/javascript">'.'alert("Settings saved.");'.'</script>';     
                 
        print "<script language=\"javascript\"> 
      var myurl='admin.php?tab=7'
       window.location.assign(myurl)
       </script>";       
                


}
}
else{   
$statement = $mysqli->query("UPDATE lbs_settings SET lbs_settings_value='$lbs_settings_value1' WHERE lbs_settings_name='$lbs_settings_name1'");
$statement = $mysqli->query("UPDATE lbs_settings SET lbs_settings_value='$lbs_settings_value2' WHERE lbs_settings_name='$lbs_settings_name2'");
$statement = $mysqli->query("UPDATE lbs_settings SET lbs_settings_value='$lbs_settings_value3' WHERE lbs_settings_name='$lbs_settings_name3'");
$statement = $mysqli->query("UPDATE lbs_settings SET lbs_settings_value='$lbs_settings_value4' WHERE lbs_settings_name='$lbs_settings_name4'");
                      
if(!$statement) {die('Error : ('. $mysqli->errno .') '. $mysqli->error);  }
print '<script type="text/javascript">'.'alert("Settings Upadated.");'.'</script>';     
                 
        print "<script language=\"javascript\"> 
      var myurl='admin.php?tab=7'
       window.location.assign(myurl)
       </script>"; 
}
}
        
        ?>