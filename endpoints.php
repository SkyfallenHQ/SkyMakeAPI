<?php

/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                          Skyfallen SkyMake API                                  */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*         This file is handles all url requests and redirects them.               */
/***********************************************************************************/

// Check if our ABSPATH is defined
defined("SSF_ABSPATH") or die("Don't mess!");

// Start routing all urls

// If nothing was routed, display 404
if (!defined("ROUTED")) {

    // Include the 404 Page.
    include_once SSF_ABSPATH . "/API-Includes/NullRequest.php";

}
