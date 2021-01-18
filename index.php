<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                          Skyfallen SkyMake API                                  */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/* This file is where all requests are redirected to. All file inclusions are here.*/
/***********************************************************************************/

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

// Define the application's ABSOLUTE FS Path
define("API_ABSPATH", dirname(__FILE__));

// Unless the installation was complete, the Database Config should exist, if not, run the install.
if ((@include_once API_ABSPATH . "/Configuration/SkyMakeAPIConfiguration.php") === false) {

    // Include the install file
    include_once API_ABSPATH . "/Configuration/install.php";

    // Stop further execution
    die();
}

// Start the API Headers
include_once API_ABSPATH . "/API-Includes/API_Header.php";

// Include all the classes
include_once API_ABSPATH . "/API-Includes/Router.php";

// Include the router file to route the URLs
include_once API_ABSPATH . "/router.php";

// Push the API Response

include_once API_ABSPATH . "/API-Includes/API_Push.php";