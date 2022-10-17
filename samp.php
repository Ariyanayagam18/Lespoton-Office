<?php
ini_set('max_execution_time', 30000000); //300 seconds = 5 minutes
error_reporting(1);
          ini_set('display_errors', 1);


function resize_image_max($image,$max_width,$max_height) {
	$w = imagesx($image); //current width
	$h = imagesy($image); //current height
	if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }

	if (($w <= $max_width) && ($h <= $max_height)) { return $image; } //no resizing needed
	
	//try max width first...
	$ratio = $max_width / $w;
	$new_w = $max_width;
	$new_h = $h * $ratio;
	
	//if that didn't work
	if ($new_h > $max_height) {
		$ratio = $max_height / $h;
		$new_h = $max_height;
		$new_w = $w * $ratio;
	}
	
	$new_image = imagecreatetruecolor ($new_w, $new_h);
	imagecopyresampled($new_image,$image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
	return $new_image;
}


function resize_image($file, $w, $h, $crop=false) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    
    //Get file extension
    $exploding = explode(".",$file);
    $ext = end($exploding);
    
    switch($ext){
        case "png":
            $src = imagecreatefrompng($file);
        break;
        case "jpeg":
        case "jpg":
            $src = imagecreatefromjpeg($file);
        break;
        case "gif":
            $src = imagecreatefromgif($file);
        break;
        default:
            $src = imagecreatefromjpeg($file);
        break;
    }
    
    $dst = imagecreatetruecolor($newwidth, $newheight);
   
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

$handle = opendir(dirname(realpath(__FILE__)).'/uploads/');
$i=0;
while($file = readdir($handle)){
  if($file !== '.' && $file !== '..'){
    //echo '<img src="pictures/'.$file.'" border="0" />';
    if($i<500) {
    if(stristr($file,"fname"))  // stristr($file,"fname") || 
    {
      $filename = "uploads/".$file;
      //if(filesize($filename) > 1000000 && date("d",filemtime($filename))<="24" && date("m",filemtime($filename))=="01") {
      
      if(filesize($filename) > 1000000) {

      echo "Before ".$filename . ': ==  ' . filesize($filename) . ' bytes ---------- ';
      
      //if($file=="fname_357707085265899_1547371873211.jpg")
        //{
        $imgData = resize_image($filename, 2500,2500); // 11327814
        imagejpeg($imgData, $filename);

      echo " ---------------> After ".$filename . ':   == ' . date("d-m-Y H:i:s",filemtime($filename)) . ' bytes<br>';

         $i++; 
         //}
       }
    }

   }

  }
}

echo "<br>File count".$i;


die("END");


$filename = "uploads/1547270860loft_866945035931616.jpg";
$resizedFilename = "/var/www/images/myresizedimage.png";

// resize the image with 300x300
$imgData = resize_image($filename, 1500,1500,100);
// save the image on the given filename
imagejpeg($imgData, $filename);

echo "<img src='".$filename."'>";
die("YES");

//echo phpinfo();
//die;
// &where=properties["username"]==""JM UNITED LOFT BLR
// phone_no  9972129293
// &where=properties["apptype"]=="KRPC"

// curl https://mixpanel.com/api/2.0/segmentation/numeric?event=signed_up&from_date=2011-08-09&to_date=2011-08-09&on=number(properties["time"])&where=number(properties["time"]) >= 2000&buckets=5


 $ch = curl_init();
$headers = array("Authorization: Basic " . base64_encode('69c7a42185701fb8077d724bb85c909b'));
        curl_setopt($ch, CURLOPT_URL, 'https://data.mixpanel.com/api/2.0/export/?from_date=2018-12-30&to_date=2018-12-30&event=%5B%22new_photo%22%5D&where=properties["phone_no"]=="9972129293",properties["apptype"]=="KRPC"');

// -d 'where'='properties["$os"]=="Linux"'


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
    
        if(curl_error($ch))
        {
          $errror = 1;
        }

        curl_close($ch);
        $result = str_replace("}}","}},", $result);
        $result = "[".substr($result,0,strlen($result)-1)."]";      
        $myArray = json_decode($result, true);

print_r($myArray);

/*curl https://data.mixpanel.com/api/2.0/export/ \
    -u 'YOUR_API_SECRET': \
    -d 'from_date'='2018-02-11' \
    -d 'to_date'='2018-02-11' \
    -d 'event'='["Viewed report"]' \
    -d 'where'='properties["$os"]=="Linux"'*/

    ?>