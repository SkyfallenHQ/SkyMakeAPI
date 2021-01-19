<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                          Skyfallen SkyMake API                                  */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/* This file is called when the request made does not resolve to a valid function  */
/***********************************************************************************/

// Check if our ABSPATH is defined
defined("API_ABSPATH") or die("Don't mess!");

// Get the global response file
global $response;

// Add the error message
$response["status"]["code"] = "404";
$response["status"]["message"] = "Not Found.";
$response["error"]["description"] = "The requested API Endpoint does not exist.";
