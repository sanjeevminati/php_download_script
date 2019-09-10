<!DOCTYPE html>
<html>
<body>

  <?php
  class  Download {
    const URL_MAX_LENGTH = 2050;
    //clean url
    protected function cleanUrl($url)
    {
      if (isset($url))
      {
        if (!empty($url))
        {
          if (strlen($url) < self::URL_MAX_LENGTH){
            return strip_tags($url);
          }
        }

      }
    }


  
//is url
  protected function is_url($url)
  {
    $url = $this->cleanUrl($url);
    if(isset($url)){
      if (filter_var($url , FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)){
        return $url;

      }
    }
  }
  //extension
protected function extension($url)
{
  if ($this->is_url($url)) {
  //$end = end(preg_split("/[.]+/", $url));
    $end1 = explode('.', $url);
    $end = end($end1);
  if (isset($end)) 
  {
    return $end;
  }
  }
    
}


//downlaod file
public function download_file($url)
{
  if($this->is_url($url))
  {
    $extension =$this->extension($url);
    if ($extension)
    {
      //echo $url;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
      $result = curl_exec($ch);
      curl_close($ch);

      $destination = "download/file.$extension";
      $file = fopen($destination, "w+");
      fputs($file, $result);
      if (fclose($file)) {
        echo "File Download";
      }
    }
  }
}
}
//creating object
$obj = new Download();
if (isset($_POST['url'])) {
  $url=$_POST['url'];
}



?>
<form method="post">
  <input type="text" name="url" maxlength="2000"/>
  <input type="submit" name="submit" value="download" />

</form>
<?php if (isset($url)) { $obj->download_file($url);} ?>

</body>
</html>