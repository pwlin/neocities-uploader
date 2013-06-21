neocities-uploader
==================

### This is a simple directory uploader for NeoCities.org

## What does it do
It will upload all the files in a directory into you NeoCities account.

## How to run
First modify

    $username = '';
and 

    $password = '';
at the beginning of the file with your NeoCities' credentials.

Then run the file with the directory path as first argument.

For example:

    ./neocities-uploader.php ./mysite/

If you run the script without any directory as argument, it assumes you want to upload everything from the current directory.	
	
## Requirements
1. php
2. php-curl

