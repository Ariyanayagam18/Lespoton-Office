<style>
.box-body {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 2px;
    border-bottom-left-radius: 2px;
    padding: 20px;
}
</style>   
<?php
?>     
<div class="box-body box-profile">
              <?php $filename = 'assets/images/'.$clubData[0]->profile_pic; if(file_exists($filename) && $clubData[0]->profile_pic) { ?>
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url().$filename;?>" alt="User profile picture">
              <?php } else { ?>
               <img class="profile-user-img img-responsive img-circle" src="http://icons.iconarchive.com/icons/custom-icon-design/mono-business/256/company-building-icon.png" alt="User profile picture">
              <?php } ?>

              <h3 class="profile-username text-center"><?php echo $clubData[0]->name;?></h3>
               
              <?php if($clubData[0]->Org_status=="0") { ?>
              <h4 class="text-center" style="color:red;">Inactive</h4>
              <?php } else { ?>
              <h4 class="text-center" style="color:green;">Active</h4>
              <?php } ?>
              <ul class="list-group list-group-unbordered" style="line-height:45px;">
                <li class="list-group-item">
                  <b>Contact Number</b> <a class="pull-right"><?php echo $clubData[0]->phone_no;?></a>
                </li>
                <li class="list-group-item">
                  <b>Address</b> <a class="pull-right"><?php echo $clubData[0]->address;?></a>
                </li>
                <li class="list-group-item">
                  <b>Expire Date</b> <a class="pull-right"><?php echo $clubData[0]->Expire_date;?></a>
                </li>
                <li class="list-group-item">
                  <b>Total Fanciers</b> <a class="pull-right"><?php echo $clubData[0]->usercnt;?></a>
                </li>
                <li class="list-group-item">
                  <b>Total Races</b> <a class="pull-right"><?php echo $clubData[0]->racecnt;?></a>
                </li>
               </ul>            
</div>