<?php
/***********************************************************************************/
/*                          (C) 2021 - Skyfallen                                   */
/*                          Skyfallen SkyMake API                                  */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*               This file pushes the API response to the client                   */
/***********************************************************************************/

// Check if our ABSPATH is defined
defined("API_ABSPATH") or die("Don't mess!");

// Get the global response array
global $response;

// Convert response to json
$json_response = json_encode($response);

// Echo out the json response
echo $json_response;