<?php
/*
 * PHP library for Mixpanel data API -- http://www.mixpanel.com/
 * Requires PHP 5.2 with JSON
 */
error_reporting(1);
          ini_set('display_errors', 1);
          global $dbconnection;
$dbconnection = mysqli_connect('localhost','karlakat_spot','Windows123',"karlakat_spotlight");
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$handle = opendir(dirname(realpath(__FILE__)).'/uploads/');
$i=0;
$j=0;
while($file = readdir($handle)){
  if($file !== '.' && $file !== '..'){
    //echo '<img src="pictures/'.$file.'" border="0" />';  filesize($filename) > 1000000 && 
     if($j<100000) {
    if(stristr($file,"fname"))
    {
      $available = "NO";
      $filename = "uploads/".$file;
      //if(date("d",filemtime($filename))<="15" && date("m",filemtime($filename))=="01") {
      if(date("m-d-Y",filemtime($filename))<="01-25-2019" && date("m-d-Y",filemtime($filename))>="01-18-2019") {
      $checkfilename = mysqli_query($dbconnection,"select img_name from ppa_report where img_name='".$file."'");
      if(mysqli_num_rows($checkfilename)>0)
       $available = "YES";
      else
       $available = "NO";
     
      $j++;
      echo " ---------------> After ".$filename . ':   == ' . filesize($filename) . ' bytes - DATE : '.date("d-F-Y",filemtime($filename))." ------ ".$available." <br>";
      //if($available=="NO")
      //@unlink($filename);
         if($available=="YES")  // count1003End
         $i++;
       }
     }
   }
     //  echo $file."  -  ".filesize($filename)."<br>";
    //}

  

  }
}

echo "<br>File count".$j." YES count".$i;
die("End");
// date("F d Y H:i:s.",filemtime($filename))



class Mixpanel
{
    private $api_url = 'https://mixpanel.com/api';
    private $version = '2.0';
    private $api_secret;
    
    public function __construct($api_secret) {
        $this->api_secret = $api_secret;
    }
    
    public function request($methods, $params, $format='json') {
        // $end_point is an API end point such as events, properties, funnels, etc.
        // $method is an API method such as general, unique, average, etc.
        // $params is an associative array of parameters.
        // See http://mixpanel.com/api/docs/guides/api/

        $params['format'] = $format;
        
        $param_query = '';
        foreach ($params as $param => &$value) {
            if (is_array($value))
                $value = json_encode($value);
            $param_query .= '&' . urlencode($param) . '=' . urlencode($value);
        }
        
        $uri = '/' . $this->version . '/' . join('/', $methods) . '/';
        $request_url = $uri . '?' . $param_query;
        
        $headers = array("Authorization: Basic " . base64_encode($this->api_secret));
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $this->api_url . $request_url);
        curl_setopt($curl_handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl_handle);
        curl_close($curl_handle);
        
        return json_decode($data);
    }
}
    
// Example usage
 //$api_secret = '69c7a42185701fb8077d724bb85c909b';
// 
// $mp = new Mixpanel($api_secret);
// $data = $mp->request(array('export'), array(
  //   'event' => 'new_photo',
   //  'from_date'=> '2015-09-01',
   //  'to_date' => '2015-09-2'
   // ));
 
 //var_dump($data);
$selecteddate = "2019-01-08";
$selecteddate2 = "2019-01-09";

$ch = curl_init();

//https://mixpanel.com/api/2.0/events/
// https://data.mixpanel.com/api/2.0/export/
$headers = array("Authorization: Basic " . base64_encode('69c7a42185701fb8077d724bb85c909b'));
        curl_setopt($ch, CURLOPT_URL, 'https://mixpanel.com/api/2.0/events/?from_date='.$selecteddate.'&to_date='.$selecteddate2.'&event=%5B%22new_photo%22%5D&unit=day&type=average');

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

echo "<pre>";
print_r($result);
echo "</pre>";
?>
