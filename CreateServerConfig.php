<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                          Skyfallen SkyMake API                                  */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                         CreateServerConfig.php                                  */
/*  This file renames the ApacheHtaccess file to be affective on the first install */
/***********************************************************************************/

// Check if our ABSPATH is defined
defined("API_ABSPATH") or die("Don't mess!");

// Check if .htaccess exists
if(!file_exists(API_ABSPATH."/.htaccess")) {

    // Open .htaccess File in Writeable Mode, Stop execution otherwise to notify the user to do this manually.
    $f = fopen(".htaccess", "a+") or die("SkyMake API could not open .htaccess file. Please manually rename ApacheHtaccess to .htaccess in the document root.");

    // Open the ApacheHtaccess File in Read-Only Mode
    $f2 = fopen("ApacheHtaccess", "r");

    // Write the contents of the ApacheHtaccess to real .htaccess
    fwrite($f, fread($f2, filesize("ApacheHtaccess")));

    // Close both files
    fclose($f);
    fclose($f2);

}