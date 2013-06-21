#!/usr/bin/php
<?php
/* === START CONFIGURATION === */
/* define your NeoCities' username and password */

$username = '';
$password = '';

/* === END CONFIGURATION === */

ini_set('error_reporting', E_ALL | E_STRICT );
ini_set('display_errors', 'on');
$upload_dir = @$argv[1];

$uploader = new NeoCities_Uploader($username, $password, $upload_dir);
$uploader->init();

class NeoCities_Uploader {
    
    private $root_url = 'http://neocities.org';
    private $username = '';
    private $password = '';
    private $upload_dir = '';
    private $files_list = array();
    
    private $curl_default_options = array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_AUTOREFERER => 1,
            CURLOPT_MAXREDIRS => 50,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_TIMEOUT => 35,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => array(
                    'Connection: close',
                    'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0'
            ),
    );
    
    public function __construct($username, $password, $upload_dir='') {
        $this->username = $username;
        $this->password = $password;
        $this->upload_dir = (isset($upload_dir) && !empty($upload_dir)) ? realpath($upload_dir) : realpath('.'); 
        echo("\nUpload directory set to: {$this->upload_dir}\n");
        $cookie = tempnam(sys_get_temp_dir(), 'neo');
        $this->curl_default_options[CURLOPT_COOKIEJAR] = $cookie;
        $this->curl_default_options[CURLOPT_COOKIEFILE] = $cookie;
    }

    public function init() {
        $this->recursive_dir();
        $this->login();
        foreach($this->files_list as $file) {
            echo("\nUploading $file\n");
            $this->upload($file);    
        }
        echo("\nFinished Uploading\n");
    }
    
    private function recursive_dir() {
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->upload_dir, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $path) {
            if ($path->isFile()) {
                $this->files_list[] =  $path->getPathname();
            }
        }    
    }
    
    private function login() {
        $curl = curl_init();
        $options = $this->curl_default_options;
        $options[CURLOPT_URL] = $this->root_url . '/signin';
        $options[CURLOPT_POSTFIELDS] = http_build_query(array(
                'username' => $this->username,
                'password' => $this->password
        ));
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        curl_close($curl);
    }
    
    private function upload($file) {
        $curl = curl_init();
        $options = $this->curl_default_options;
        $options[CURLOPT_URL] = $this->root_url . '/site_files/upload';
        $options[CURLOPT_POSTFIELDS] = array(
                'newfile' => '@' . $file
        );
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        curl_close($curl);
    }
    
    
}



