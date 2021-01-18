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

// Start routing all urls

// If nothing was routed, display 404
if (!defined("ROUTED")) {

    // Include the 404 Page.
    include_once API_ABSPATH . "/API-Includes/NullRequest.php";

}
