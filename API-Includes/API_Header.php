<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                          Skyfallen SkyMake API                                  */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                   This file starts the response header                          */
/***********************************************************************************/

// Check if our ABSPATH is defined
defined("API_ABSPATH") or die("Don't mess!");

// Define a global assoc array
$response = array();

// Add API Data

$response["api"]["vendor"] = "Skyfallen";
$response["api"]["version"] = "SFR-221001";
$response["api"]["name"] = "Skyfallen SkyMake API";
