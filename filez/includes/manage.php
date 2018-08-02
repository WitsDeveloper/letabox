 <?php    
       $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id=".$_SESSION['user_id'])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
       while($obj_ona1= $project_desc1->fetch_object())
     {?><div class="col-md-8 col-md-offset-2" <h3>Manage your account</h3>
 <!-- <form action="cart_process.php" method="post">-->
      <form class="checkout_update"> 
  <div class="form-group row">       <div class="col-md-6 col-xs-12">
                                    <strong>First Name:</strong>
  <input type="text" name="Fname" class="form-control" value="<?php print $obj_ona1->Fname ? $obj_ona1->Fname : ''; ?>" required />
                                </div>
                           
                                <div class="col-md-6 col-xs-12">
                                    <strong>Last Name:</strong>
<input type="text" name="Lname" class="form-control" value="<?php print $obj_ona1->Lname ? $obj_ona1->Lname : ''; ?>" required />
                                </div>
                            </div>
         <div class="form-group row">   
                            
                                <div class="col-md-12"><strong>Email Address:</strong></div>
<div class="col-md-12"><input type="text" name="Email" class="form-control" value="<?php print $obj_ona1->Email ? $obj_ona1->Email : ''; ?>" required /></div>
                                
                        </div>
           <div class="form-group row">                                  
<div class="col-md-12"><strong>Current password (leave blank to leave unchanged)</strong></div>
     <div class="col-md-12"><input type="password" name="Password" class="form-control" value="" required /></div>
</div>
                 <div class="form-group row">                                
<div class="col-md-12"><strong>New password (leave blank to leave unchanged)</strong></div>
     <div class="col-md-12"><input type="password" name="PasswordNew" class="form-control" value=""/></div>
</div>
                <div class="form-group row">                                  
<div class="col-md-12"><strong>Confirm new password:</strong></div>
     <div class="col-md-12"><input type="password" name="PasswordCon" class="form-control" value=""/></div>
</div>
             <input type="hidden" name="user_id_edit_acc" value="<?php print $_SESSION['user_id']?>"/>
              <div id="manage_response" class="form-group row">                                  

                  <button type="submit" name="modify_account" class="btn btn-warning">Save</button>
</div>
        
    </form>
</div>
     <?php } ?>
