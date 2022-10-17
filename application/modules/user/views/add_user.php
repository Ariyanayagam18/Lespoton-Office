<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url() . 'user/add_edit' ?>" method="post" id="add_edit_data">
  <div class="box-body">
    <div class="row">

            <!-- <div class="col-md-6">
                  <div class="form-group">
                    <label for="status"> Status</label>
                    <select name="status" id="" class="form-control">
                  <option value="active" <?php echo (isset($userData->status) && $userData->status == 'active') ? 'selected' : ''; ?> >Active</option>

                  <option value="deleted" <?php echo (isset($userData->status) && $userData->status == 'deleted') ? 'selected' : ''; ?> >Deleted</option>

                    </select>
                  </div>
                </div>-->
           <input type="hidden" name="status" value="active">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Club Name</label>
                <input type="text" name="name" value="<?php echo isset($userData->name) ? $userData->name : ''; ?>" class="form-control" placeholder="Name" id="name" required="true">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">Email</label>
                <input type="text" name="email" id="email" value="<?php echo isset($userData->email) ? $userData->email : ''; ?>" class="form-control" placeholder="Email" required="true">
              </div>
            </div>

         <!-- <div class="col-md-6">
            <div class="form-group">
              <label for="">User Type</label>
              <?php $u_type = isset($userData->user_type) ? $userData->user_type : '';
$user_type = getAllDataByTable('permission');
?>
              <select name="user_type" class="form-control" required>
              <?php foreach ($user_type as $option) {
    $sel = '';if (strtolower($option->user_type) == strtolower($u_type)) {$sel = "selected";}
    if (strtolower($option->user_type) != 'admin') {
        ?>
                <option  value="<?php echo $option->user_type; ?>" <?php echo $sel; ?> ><?php echo ucfirst($option->user_type); ?> </option>

              <?php }}?>
              </select>
            </div>
          </div>-->

          <input type="hidden" name="user_type" value="Member">
        <div class="col-md-6">
          <div class="form-group">
          <label for="">Contact No</label>
            <input type="text" style="display: none">
             <input type="text" name="phone_no" id="phone_no" class="form-control" value="<?php echo isset($userData->phone_no) ? $userData->phone_no : ''; ?>">

          </div>
        </div>
        <?php if (isset($userData)) {?>
        <!-- <div class="col-md-6">
          <div class="form-group">
          <label for="">Contact No</label>
            <input type="text" style="display: none">
             <input type="text" name="phone_no" class="form-control" value="<?php echo isset($userData->phone_no) ? $userData->phone_no : ''; ?>">
          </div>
        </div> -->
        <!-- <div class="col-md-6">
          <div class="form-group">
          <label for="">Address</label>
            <input type="text" style="display: none">
             <input type="text" name="address" class="form-control" value="<?php echo isset($userData->address) ? $userData->address : ''; ?>">
          </div>
        </div> -->
       <!--  <div class="col-md-6">
          <div class="form-group">
          <label for="">Current Password</label>
            <input type="text" style="display: none">
             <input type="Password" name="currentpassword" class="form-control" value="" placeholder="Password">
          </div>
        </div> -->
        <?php } else {?>
        <div class="col-md-6">
          <div class="form-group">
          <label for="">Password</label>
             <input type="Password" name="password" id="password" class="form-control" value="" placeholder="Password" readonly onfocus="this.removeAttribute('readonly')">
          </div>
        </div>
        <?php }if (isset($userData)) {?>
          <div class="col-md-6">
            <div class="form-group">
            <label for="">Password</label>
               <input type="Password" name="password" id="password" class="form-control" value="" placeholder="Password">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
            <label for="">Confirm Password</label>
               <input type="Password" name="confirmPassword" class="form-control" value="" placeholder="Password">
            </div>
          </div>
          <?php }
if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {?>
          <div class="col-md-6">
            <div class="form-group">
            <label for="">Expiry Date</label>
               <input type="text" name="expiryclubdate" id="expiryclubdate" class="form-control datepicker" value="<?php echo isset($userData->Expire_date) ? $userData->Expire_date : ''; ?>" required="true">
            </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Fancier Limit</label>
                <input type="text" name="usercount" id="usercount" value="<?php echo isset($userData->usercount) ? $userData->usercount : ''; ?>" class="form-control" required="true">
              </div>
            </div>
          <?php if ($this->session->userdata('user_details')[0]->user_type == 'Admin') {?>
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Org code</label>
                <input type="text" name="orgcode" id="orgcode" <?php if ($userData->Org_code != '') {?>readonly="true"<?php }?> value="<?php echo isset($userData->Org_code) ? $userData->Org_code : ''; ?>" class="form-control" id="orgcode" required="true">
              </div>
            </div>
          <?php }}?>
          
          <div class="col-md-6">
            <div class="form-group">
              <!-- <label for="">Read Type</label> -->
                  <select name="read_type" id="read_type" class="form-control input-sm">
                    <option value="">Select Read Type</option>
                    <?php if (isset($userData->read_type) || $userData->read_type == "") {?>
                      <option value="0" <?php if ($userData->read_type == '0') {echo "selected = selected";}?>>0-Photo</option>
                      <option value="1" <?php if ($userData->read_type == '1') {echo "selected = selected";}?>>1-Chip</option>
                    <?php }?>
                  </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="">Country</label>
                  <select name="user_country" id="user_country" class="form-control input-sm">
                    <option value="Asia/Kolkata" selected>Asia/Kolkata</option>
                  </select>
            </div>
          </div>

          <div class="col-md-6" style="clear: both;">
            <div class="form-group imsize">
              <label for="exampleInputFile">Image Upload</label>
              <div class="pic_size" id="image-holder">
                <?php if (isset($userData->profile_pic) && file_exists('assets/images/' . $userData->profile_pic)) {
    $profile_pic = $userData->profile_pic;
} else {
    $profile_pic = 'user.png';
}?>
                <left> <img class="thumb-image setpropileam" src="<?php echo base_url(); ?>/assets/images/<?php echo isset($profile_pic) ? $profile_pic : 'user.png'; ?>" alt="User profile picture"></left>
              </div> <input type="file" name="profile_pic" id="exampleInputFile">
            </div>
          </div>

         

        </div>
        <?php if (!empty($userData->users_id)) {?>
        <input type="hidden"  name="users_id" value="<?php echo isset($userData->users_id) ? $userData->users_id : ''; ?>">
        <input type="hidden" name="fileOld" value="<?php echo isset($userData->profile_pic) ? $userData->profile_pic : ''; ?>">
        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="edit" value="edit" class="btn btn-success wdt-bg" id="update_submit">Update</button>
        </div>
              <!-- /.box-body -->
        <?php } else {?>
        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="submit" value="add" class="btn btn-success wdt-bg" id="add_submit">Add</button>
        </div>
        <?php }?>
      </form>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
      <script type="text/javascript">
        function alertmsg(msg)
        {
          toastr.error(msg, 'Lespoton');
        }
        $(function () {

   $(".datepicker").datepicker({
    dateFormat: 'yy-mm-dd'
});
   });

        $("#name").on("keyup",function(e){
            var name = $(this).val();
            if(e.keyCode == "222")
            {
              $(this).val("");
            }
        });


        $("#orgcode").on("keyup",function(){
          var org_name = $("#orgcode").val();
           if(org_name != "")
            {
                $.ajax({
                 type: "POST",
                 url:locurl+"user/get_org_name",
                 cache: false,
                 //data: org_name,
                 data: { org_name: org_name },
                 dataType: 'json',
                 success: function(data){
                  if(data == "1")
                  {
                      alertmsg("Org Code already exists");
                      $("#orgcode").val("");
                  }
                 }

               });
            }
        });
      </script>
      <script>
        $(document).ready(function(){
          $('#add_submit').click(function(e) {
            // e.preventDefault();
            var name = $("#name").val();
            var email = $("#email").val();
            var phone_no = $("#phone_no").val();
            var expiryclubdate = $("#expiryclubdate").val();
            var usercount = $("#usercount").val();
            var orgcode = $("#orgcode").val();

            if(name == '' || name == 'NULL' )
            {
              alertmsg("Name field is empty");
            }
            if(email == '' || email == 'NULL' )
            {
              alertmsg("Email field is empty");
            }
            if(expiryclubdate == '' || expiryclubdate == 'NULL' )
            {
              alertmsg("Club date field is empty");
            }
            if(usercount == '' || usercount == 'NULL' )
            {
              alertmsg("Fancier count is empty");
            }
            if(orgcode == '' || orgcode == 'NULL' )
            {
              alertmsg("Orgcode field is empty");
            }
            $("#add_edit_data").submit();
          });
        });
      </script>
      
<style>
select#read_type {
display: none;
}
</style>