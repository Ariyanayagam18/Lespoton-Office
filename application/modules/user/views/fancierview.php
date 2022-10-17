<style>
.box-body {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 2px;
    border-bottom-left-radius: 2px;
    padding: 20px;
}
.profile-user-img{
  height: 100px;
}
</style>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url() . 'user/updatelatlong' ?>" method="post">
<div class="box-body box-profile">
              <?php $filename = 'uploads/' . $fancierData[0]->profile_pic;
              if ($fancierData[0]->profile_pic != '') {?>
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $filename; ?>" alt="User profile picture12">
              <?php } else {?>
                <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . 'assets/images/profile_pic.jpg'; ?>" alt="User profile picture">
               <!-- <img class="profile-user-img img-responsive img-circle" src="http://pixsector.com/cache/50fcb576/av0cc3f7b41cb8510e35c.png" alt="User profile picture"> -->
              <?php }?>

              <h3 class="profile-username text-center"><?php echo $fancierData[0]->username; ?></h3>
              <?php if ($fancierData[0]->status == "0") {?>
              <h4 class="text-center" style="color:red;">Inactive</h4>
              <?php } else {?>
              <h4 class="text-center" style="color:green;">Active</h4>
              <?php }?>
              <ul class="list-group list-group-unbordered" style="line-height:45px;">
                <li class="list-group-item">
                  <b>Club Name</b> <a class="pull-right"><?php echo $fancierData[0]->name; ?></a>
                </li>
                <?php if ($fancierData[0]->loftstatus == "0") {?>
                 <li class="list-group-item">
                  <b>Loft Status</b> <a class="pull-right" style="color:red;">Inactive</a>
                 </li>
                <?php } else {?>
                 <li class="list-group-item">
                  <b>Loft Status</b> <a class="pull-right" style="color:green;">Active</a>
                 </li>
                <?php }?>
               <!--  <li class="list-group-item">
                  <b>Read Type</b> <a class="pull-right"><?php echo $fancierData[0]->read_type; ?></a>
                </li> -->
                <li class="list-group-item">
                  <b>Contact Number</b> <a class="pull-right"><?php echo $fancierData[0]->phone_no; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Email Id</b> <a class="pull-right"><?php echo $fancierData[0]->email_id; ?></a>
                </li>
                <!-- <li class="list-group-item">
                  <b>Address</b> <a class="pull-right"><?php echo $fancierData[0]->address; ?></a>
                </li> -->
                <li class="list-group-item">
                  <b>Loft Latitude and Longitude</b> <a class="pull-right"><?php echo $fancierData[0]->latitude . " , " . $fancierData[0]->longitude; ?></a>
                </li>

                <?php if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {?>
                <!-- <li class="list-group-item">
                   <button type="submit" name="edit" value="edit" class="btn btn-success wdt-bg">Update</button>
                </li> -->
                <li class="list-group-item">
                  <b>Read Type</b>
                    <select name="read_type" id="read_type" class="form-control input-sm">
                      <!-- <option value="">Select Read Type</option> -->
                      <?php if (isset($fancierData[0]->read_type) || $fancierData[0]->read_type == "") {?>
                        <option value="0" <?php if ($fancierData[0]->read_type == '0') {echo "selected = selected";}?>>Photo</option>
                        <option value="1" <?php if ($fancierData[0]->read_type == '1') {echo "selected = selected";}?>>Chip</option>
                      <?php }?>
                    </select>
                </li>
                <?php } else{?>
                  <li class="list-group-item">
                  <b>Read Type</b>
                    <select name="read_type" id="read_type" class="form-control input-sm">
                      <!-- <option value="">Select Read Type</option> -->
                      <?php if (isset($fancierData[0]->read_type) || $fancierData[0]->read_type == "") {?>
                        <option value="0" <?php if ($fancierData[0]->read_type == '0') {echo "selected = selected";}?>>Photo</option>
                        <option value="1" <?php if ($fancierData[0]->read_type == '1') {echo "selected = selected";}?>>Chip</option>
                      <?php }?>
                    </select>
                </li>
                <button type="submit" name="edit" value="edit" class="btn btn-success wdt-bg">Update</button>
                <?php }?>

                
                <?php if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {?>
                  <li class="list-group-item">
                    <b>Latitude : <input type="text" name="lat" class="form-control" value="<?php echo $fancierData[0]->latitude; ?>">Longitude : <input type="text" name="long" class="form-control" value="<?php echo $fancierData[0]->longitude; ?>"></b> </a>
                  </li>
                <?php } else{?>
                  <li class="list-group-item">
                    <b>Latitude : <input type="text" name="lat" class="form-control" value="<?php echo $fancierData[0]->latitude; ?>" readonly>Longitude : <input type="text" name="long" class="form-control" value="<?php echo $fancierData[0]->longitude; ?>" readonly></b> </a>
                  </li>
                <?php } ?> 


                <li class="list-group-item">
                  <?php 

                  //$checkTag = $this->db->query("select * from ppa_tag_details where user_id='" . $fancierData[0]->reg_id . "' and deviceName ='" . $fancierData[0]->deviceName . "' and tag_status = 1 ");
                  //$checkTag = $checkTag->row_array();
                  //$checkTag = $checkTag['deviceName'];
                  ?>
                  <b>Device Id : <input type="text" name="device_id" class="form-control" value="<?php echo $fancierData[0]->deviceName; ?>" readonly></b>
                </li>

                <li class="list-group-item">
                  <b>Enter New Password if the user forgot their password : <input type="text" name="password" class="form-control" value=""><b>
                </li>



                <?php if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {?>
                <li class="list-group-item">
                   <button type="submit" name="edit" value="edit" class="btn btn-success wdt-bg">Update</button>
                </li>
                <?php }?>
                <li class="list-group-item">
                  <b>Joined Date</b> <a class="pull-right"><?php echo $fancierData[0]->cre_date; ?></a>
                </li>
                <input type="hidden"  name="fancier_id" value="<?php echo isset($fancierData[0]->reg_id) ? $fancierData[0]->reg_id : ''; ?>">
                <li class="list-group-item">
                  <b>Loft Image</b> <a class="pull-right">
                  </a>
                </li>

               </ul>
               <div style="float:left;text-align:center;width:100%;">
               <?php $filename = 'uploads/' . $fancierData[0]->loft_image;if (file_exists($filename) && $fancierData[0]->loft_image != '') {?>
                       <img style="text-align:center;height:200px;width:auto;" src="<?php echo base_url() . $filename; ?>" alt="User profile picture12">
                     <?php } else {?>
                       <img class="profile-user-img img-responsive img-circle" src="https://d30y9cdsu7xlg0.cloudfront.net/png/60716-200.png" alt="User profile picture">
                    <?php }?>
              </div>
</div>
</form>