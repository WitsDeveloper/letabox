<div class="col-md-12">
     <h4>BILLING ADDRESS</h4>
                                       <?php
                                    if(@$_GET['billing']==='edit')  {
      $project_desc1 = $mysqli->query("SELECT * from lbs_customer WHERE lbs_bill_shipping_id=".$_SESSION['user_id'])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);  
       $obj_ona1= $project_desc1->fetch_object();                             
                                        
                                        ?>
    <!-- <form action="cart_process.php" method="post">-->
    <form class="billing_edit">
     
     <div class="form-group">
                                <div class="col-md-6 col-xs-12">
                                    <strong>First Name:</strong>
  <input type="text" name="Fname" class="form-control" value="<?php print $obj_ona1->Fname ? $obj_ona1->Fname : ''; ?>" required />
                                </div>
                                <div class="span1"></div>
                                <div class="col-md-6 col-xs-12">
                                    <strong>Last Name:</strong>
<input type="text" name="Lname" class="form-control" value="<?php print $obj_ona1->Lname ? $obj_ona1->Lname : ''; ?>" required />
                                </div>
                            </div>
                             <div class="form-group">
                                <div class="col-md-12"><strong>Company Name:</strong></div>
                                <div class="col-md-12">
 <input type="text" id="Company" class="form-control" name="Company" value="<?php print $obj_ona1->Company ? $obj_ona1->Company : ''; ?>" required />
                                </div>
                            </div>
                           
                         
                                <div class="col-md-12">
                                
                               <div class="form-group">
  <label for="sel1">Country:</label>
  <select class="form-control" id="sel1" name="Country">
      <option value="<?php print $obj_ona1->Country; ?>" selected="selected"><?php print $obj_ona1->Country; ?></option>
      
<?php

foreach($countries as $key => $value) {
?>
<option value="<?= $value ?>" title="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($value) ?></option>
<?php
}
?>
</select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Street Address:</strong></div>
                                <div class="col-md-12">
   <input type="text" name="Address1" class="form-control" value="<?php print $obj_ona1->Address1 ? $obj_ona1->Address1 : ''; ?>" placeholder="House number and street name" required/>
                                </div>
                                <div class="col-md-12"><br>
<input type="text" name="Address2" class="form-control" value="<?php print $obj_ona1->Address2 ? $obj_ona1->Address2 : ''; ?>" placeholder="Aprtment ,suite, etc"  required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Town / City:</strong></div>
                                <div class="col-md-12">
               <input type="text" name="City" class="form-control" value="<?php print $obj_ona1->City ? $obj_ona1->City : ''; ?>" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>State / County:</strong></div>
                                <div class="col-md-12">
                     <input type="text" name="State" class="form-control" value="<?php print $obj_ona1->State ? $obj_ona1->State : ''; ?>"  required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Postcode / Zip:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" name="Zcode" class="form-control" value="<?php print $obj_ona1->Zcode ? $obj_ona1->Zcode : ''; ?>" required/>
                                </div>
                            </div>
                            <div class="form-group"><div class="col-md-6">
                                <div class="col-md-12"><strong>Phone Number:</strong></div>
                                <div class="col-md-12"><input type="text" name="Phone" class="form-control" value="<?php print $obj_ona1->Phone ? $obj_ona1->Phone : ''; ?>" required/></div>
                            </div>   
                            <div class="col-md-6">
                                <div class="col-md-12"><strong>Email Address:</strong></div>
<div class="col-md-12"><input type="text" name="Email" class="form-control" value="<?php print $obj_ona1->Email ? $obj_ona1->Email : ''; ?>" required /></div>
                                </div>
                        </div>                       
            <div  class="col-md-12">                 
         <input type="hidden" name="billing_edit"/>
         <input type="hidden" name="lbs_bill_shipping_id" value="<?php print $obj_ona1->lbs_bill_shipping_id;?>"/>
       
                          
        <button type="submit" name="billing_edit" class="btn btn-warning btn-lg">Save</button>
         </div>
               <div id="billing_response" class="col-md-12"></div>
                    
     </form>
                    </div>
                                        
                                   <?php } else{
                                       ?><div style='width:100%; float: left;border: solid 1px gray;'>
                                               <?php
     $pdts = $mysqli->query("SELECT * from  lbs_customer WHERE lbs_bill_shipping_id=".@$_SESSION['user_id'])or die('Error : ('. $mysqli->errno .') '. $mysqli->error);   
while($obj_ptds= $pdts->fetch_object())
     {?>
   <p><?php print $obj_ptds->Fname.' '.$obj_ptds->Lname;?></p> 
     <p><?php print $obj_ptds->Company;?></p>  
       <p><?php print $obj_ptds->Country;?></p>  
       <p><a href="my-account.php?account=billing&billing=edit"><i class="fa fa-edit"></i> Edit</a></p> 
        <p><?php print $obj_ptds->Address1;?></p>  
        <p><?php print $obj_ptds->City;?></p> 
        <p><?php print $obj_ptds->State;?></p> 
          <p><?php print $obj_ptds->Zcode;?></p> 
           <p><?php print $obj_ptds->Phone;?></p> 
            <p><?php print $obj_ptds->Email;?></p> 
     <?php } ?>     
                                        </div>  
     <?php } ?>
    
</div>

