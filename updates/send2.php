   <?php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
       
    // Receive String
    
    $url = "https://stopbadbots.com/updates/receive2.php";
    
    $filename = 'error_log';
    $filedata = file_get_contents('error_log');
    $filesize = filesize($filename);


    $postData = array(
        'filename' => 'error_log.txt',
        'filedata' => file_get_contents('error_log'),
    );



        $headers = array("Content-Type:multipart/form-data"); // cURL headers for file uploading
      //  $postfields = array("filedata" => "@$filedata", "filename" => $filename);
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
           // CURLOPT_HEADER => true,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $postData,
           // CURLOPT_INFILESIZE => $filesize,
           // CURLOPT_RETURNTRANSFER => true
        ); // cURL options
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        if(!curl_errno($ch))
        {
            $info = curl_getinfo($ch);

            if ($info['http_code'] == 200)
               echo "File uploaded successfully";
            else
               echo 'Error !';
            
        }
        else
        {
            echo curl_error($ch);
        }
        curl_close($ch);
?>   