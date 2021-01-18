<?php
/***********************************************************************************/
/*                          (C) 2020 - Skyfallen                                   */
/*                          Skyfallen SkyMake API                                  */
/*                          The Skyfallen Company                                  */
/*                                                                                 */
/*                This file handles the installation process                       */
/***********************************************************************************/

// Check if called from the main install file
defined("API_ABSPATH") or die("Nope! We have thought of that before you did!");

// Set the default messages for the wizard overview
$wizard_title = "Welcome";
$wizard_description = "We'll guide you through the steps to install SkyMake API Server";
$debug_msg = "OK";
$success = false;

// Check if form was submitted
if(!empty($_POST)){

    // Turn form's MYSQL Data into more easily accessible variables
    $form_dbhost = $_POST["dbserver"];
    $form_dbname = $_POST["dbname"];
    $form_dbuser = $_POST["dbuser"];
    $form_dbpassword = $_POST["dbpassword"];

    // Test MYSQL Connection before proceeding
    @$conn_test = new mysqli($form_dbhost,$form_dbuser,$form_dbpassword,$form_dbname,3306);

    // Check if there was an error while connecting to the database
    if($conn_test->connect_error){
        // There was an error. Form will be shown again.
        $wizard_title = "Failure, Please try again.";
        $wizard_description = "We couldn't connect to the database you provided.";
    }else{
        // Now, check if the database is empty
        $stmt = $conn_test->stmt_init();
        $stmt->prepare("SHOW TABLES FROM ".mysqli_real_escape_string($conn_test,$form_dbname));
        $stmt->execute();
        $result = $stmt->get_result();

        // Verify the number of rows returned is not zero
        if($result->num_rows != 0) {
            // Database is not empty. Proceed
            $stmt->close();
            $result->free();

                    // Read the DBConfig Template
                    if(@$config_temp_file = fopen(API_ABSPATH."/Configuration/SkyMakeAPIConfiguration.php.template","r")) {
                        $config_temp_text = fread($config_temp_file, filesize(API_ABSPATH."/Configuration/SkyMakeAPIConfiguration.php.template"));

                        // Replace the empty spaces with information
                        $config_temp_text = str_replace('db_name_here',$form_dbname,$config_temp_text);
                        $config_temp_text = str_replace('db_user_here',$form_dbuser,$config_temp_text);
                        $config_temp_text = str_replace('db_server_here',$form_dbhost,$config_temp_text);
                        $config_temp_text = str_replace('db_password_here',$form_dbpassword,$config_temp_text);

                        // Save the file

                        if(@$config_file = fopen(API_ABSPATH."/Configuration/SkyMakeAPIConfiguration.php","a+")){

                            // Save the buffer to the file
                            @fwrite($config_file,$config_temp_text);

                            // Check if we have the file
                            if(file_exists(API_ABSPATH."/Configuration/SkyMakeAPIConfiguration.php")){

                                // We have the file, now include it to create the first user
                                include_once API_ABSPATH."/Configuration/SkyMakeAPIConfiguration.php";

                                    $success = true;
                                    $wizard_title = "Install Successfully Completed";
                                    $wizard_description = "Welcome to the future of form processing...";

                            } else {
                                // Fail
                                $wizard_title = "Failure, Please try again.";
                                $wizard_description = "We attempted to write to the config but the changes were not saved.";
                            }

                        } else {
                            // Fail
                            $wizard_title = "Failure, Please try again.";
                            $wizard_description = "We couldn't write to the config file. This may indicate a write permission error.";
                        }

                    } else {
                        // Fail
                        $wizard_title = "Failure, Please try again.";
                        $wizard_description = "We couldn't read the config template. This file is probably renamed or deleted.";
                    }
        } else {
            // Database wasn't empty.
            $wizard_title = "Failure, Please try again.";
            $wizard_description = "The database you provided is not empty. SecureForms doesn't support prefixed installs yet.";
        }
    }

}
?>
<html>
<head>
    <title>SkyMake API Server Installation</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@500&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js" integrity="sha512-z4OUqw38qNLpn1libAN9BsoDx6nbNFio5lA6CuTp9NlK83b89hgyCVq+N5FdBJptINztxn1Z3SaKSKUS5UP60Q==" crossorigin="anonymous"></script>
    <script>
        <?php
        if($success){
        ?>
        window.setTimeout(function(){
            location.reload();
        }, 5000);
        <?php
        }
        ?>
        var currentTab = 0;
        function showTab(n) {
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            if (n == 0) {
                document.getElementById("prev-btn").style.display = "none";
            } else {
                document.getElementById("prev-btn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("next-btn").innerHTML = "Finish";
            } else {
                document.getElementById("next-btn").innerHTML = "Next";
            }
        }

        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            if(n == 1 && !validateForm()){
                return false;
            }
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            anime({
                targets: '.step_header h3,p',
                translateY: [90, 0],
                opacity: [0,1],
                easing: 'easeOutExpo',
                delay: (el,i)=>i*150
            })
            if (currentTab >= x.length) {
                document.getElementById("options").submit();
                return false;
            }
            showTab(currentTab);
        }

        function validateForm() {
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " invalid";
                    valid = false;
                } else {
                    y[i].className = "std_input";
                }
            }
            return valid;
        }

        window.onload = () => {
            showTab(currentTab);
            anime.timeline({})
                .add({
                    targets: '.welcome_text h3,p',
                    translateY: [90, 0],
                    opacity: [0,1],
                    easing: 'easeOutExpo',
                    delay: (el,i)=>i*150
                })
            /*
        .add({
            targets: '.tab_content .tab_content_element',
            translateY: [180, 0],
            opacity: [0,1],
            easing: 'easeOutExpo',
            delay: (el,i)=>i*150
        })
             */
        }
    </script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            font-family: 'Spartan', sans-serif;
        }
        .install-wrapper{
            border: 0.2px solid #cccccc;
            border-radius: 5px;
            background-color: ;
            width: 40%;
            min-width: 500px;
            height: 40%;
            min-height: 350px;
            margin-right: auto;
            margin-left: auto;
            position: relative;
        }
        .next-btn{
        <?php
            if($success){
                ?>
            display: none;
        <?php
    }
?>
            position: absolute;
            bottom: 10px;
            right: 15px;
            color: black;
            background: #cccccc;
            border:none;
            padding: 8px 15px 8px 15px;
            border-radius: 15px;
        }
        .next-btn:hover{
            background: #a0a0a0;
            box-shadow: 1px 2px 2px 0px #cfcfcf;
        }
        .next-btn:focus{
            outline: none;
        }
        .prev-btn{
            position: absolute;
            bottom: 10px;
            right: 90px;
            color: black;
            background: #d9d9d9;
            border:none;
            padding: 8px 15px 8px 15px;
            border-radius: 15px;
        }
        .prev-btn:hover{
            background: #dddddd;
            box-shadow: 1px 2px 2px 0px #cfcfcf;
        }
        .prev-btn:focus{
            outline: none;
        }
        .app-title {
            margin-left: 20px;
            margin-top: 20px;
        }
        .welcome_text {
            margin-left: 20px;
            margin-top: 60px;
        }
        .tab {
            display: none;
        }
        .step_header {
            margin-left: 20px;
            margin-top: 20px;
        }
        .std_input{
            height: 30px;
            border: 0.1px solid #cccccc;
            border-radius: 15px;
            width: 250px;
            padding-left: 10px;
            float: right;
            margin-right: 60px;
        }
        .std_input:focus{
            outline: none;
        }
        .tab_content{
            margin-top: 50px;
        }
        .spacer-v20 {
            height: 20px;
        }
        .invalid {
            border-color: red;
        }
        .debug-info{
            background: #cccccc;
            border: 0.1px solid gray;
            font-size: small;
            font-weight: lighter;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height:5%;
            justify-content: center;
            justify-items: center;
        <?php
            if($debug_msg == "OK"){
                ?>
            display: none;
        <?php
    }
?>
        }
        .centered-debug-info{
            text-align: center;
            justify-content: center;
            justify-items: center;
        }
    </style>
</head>

<body>
<div class="install-wrapper">
    <form id="options" class="options-form" method="post">
        <div class="tab">
            <div class="app-title">
                <h1>Skyfallen <br>SkyMake <br><b>API</b></h1>
            </div>
            <div class="welcome_text">
                <h3><?php echo $wizard_title; ?></h3>
                <p><?php echo $wizard_description; ?></p>
            </div>
        </div>
        <div class="tab">
            <div class="step_header">
                <h3>Database Setup</h3>
                <p>For this step, we need your MYSQL Database's details.</p>
                <div class="tab_content">
                    <label for="dbname">Database Name</label>
                    <input name="dbname" id="dbname" class="std_input"> <br>
                    <div class="spacer-v20"></div>
                    <label for="dbserver">Database Server</label>
                    <input name="dbserver" id="dbserver" class="std_input"> <br>
                    <div class="spacer-v20"></div>
                    <label for="dbuser">Database Username</label>
                    <input name="dbuser" id="dbuser" class="std_input"> <br>
                    <div class="spacer-v20"></div>
                    <label for="dbpassword">Database Password</label>
                    <input name="dbpassword" id="dbpassword" type="password" class="std_input">
                </div>
            </div>
        </div>
        <button type="button" name="prev" class="prev-btn" id="prev-btn" onclick="nextPrev(-1)">Previous</button><button type="button" name="next" id="next-btn" class="next-btn" onclick="nextPrev(1)">Next</button>
    </form>
</div>
<div class="debug-info">
    <p class="centered-debug-info">SkyMake API Server, Skyfallen Developer Center Beta Release<br> Debugging Information:".$debug_msg; ?></p>
</div>
</body>
</html>