<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                          Skyfallen SkyMake API                                  */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                This file is handles the user authorisation                      */
/***********************************************************************************/

if(isset($_GET["username"]) && isset($_GET["password"])){
    global $connection;

    $stmt = $connection->stmt_init();

    $stmt->prepare("SELECT password FROM skymake_users WHERE username=?");

    $stmt->bind_param("s",$_GET["username"]);

    $stmt->execute();

    if($stmt->error){
        $this->error = $stmt->error;
        killapp("Invalid Authorisation.","403");
    }

    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $psr = $result->fetch_assoc();
        $hashed_password = $psr["password"];

        if(password_verify($_GET["password"],$hashed_password)){
            define("ISLOGGEDIN",true);
            define("USERNAME",$_GET["username"]);
        } else {
            killapp("Invalid Authorisation.","403");
        }
    } else {
        killapp("Invalid Authorisation.","403");
    }
} else {
    killapp("Invalid Authorisation.","403");
}

/**
 * Kill the API and returns an error
 * @param $errorMsg String Error Message
 * @param $errorCode String Error Code
 */
function killapp($errorMsg,$errorCode){

    global $response;

    $response["status"]["code"] = $errorCode;
    $response["error"]["description"] = $errorMsg;

    die(json_encode($response));

}