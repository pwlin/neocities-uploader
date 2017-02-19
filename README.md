neocities-uploader
==================

### This is a simple file/directory uploader for NeoCities.org

## What does it do
It will upload a single file or all the files in a directory into you NeoCities account.

## How to run
First modify

    $username = '';
and 

    $password = '';
at the beginning of the file with your NeoCities' credentials.

If you want to upload all the files in a directory, pass the directory name as the first argument:

    ./neocities-uploader.php ./mysite/

If you want to upload a single file, pass the file name as the first argument:

    ./neocities-uploader.php page1.html

If you run the script without any argument, it assumes you want to upload everything from the current directory.	
	
## Requirements
1. php
2. php-curl

