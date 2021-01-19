<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                          Skyfallen SkyMake API                                  */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*         This file is handles all url requests and redirects them.               */
/***********************************************************************************/

// Check if our ABSPATH is defined
defined("API_ABSPATH") or die("Don't mess!");

// Define the request
if(isset($_GET["path"])){
    define("REQUEST",$_GET["path"]);
} else {
    define("REQUEST","/");
}

// Start routing all urls
include_once API_ABSPATH . "/API-Functions/getUserRole.php";
Router::routePage("getUserRole","getUserRole");

include_once API_ABSPATH . "/API-Functions/getAssignedCourses.php";
Router::routePage("getAssignedCourses","getAssignedCourses");

// If nothing was routed, display 404
if (!defined("ROUTED")) {

    // Include the 404 Page.
    include_once API_ABSPATH . "/API-Includes/NullRequest.php";

}
