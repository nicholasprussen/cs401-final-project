<?php

session_start();

require_once '../KLogger.php';

$logger = new KLogger( "signup_handler.txt", KLogger::DEBUG);

//$logger->LogDebug(print_r($_POST, 1));

$errors = array();

//variable checks
$isEmailValid = False;
$isPasswordValid = False;
$isAddressValid = False;
$addressNotStarted = True;

//get required info
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];

//get optional info
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$zipcode = $_POST['zip'];
$city = $_POST['city'];
$state = $_POST['state'];



$completedAddress = "";

require_once '../Dao.php';
$dao = new Dao();


//validate names
if($firstname == "") {
    $errors['firstname'] = "First name cannot be blank";
}

if($lastname == "") {
    $errors['lastname'] = "Last name cannot be blank";
}

//validate email address
if($email != "") {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Not a valid email address";
    } else {
        if($dao->emailExists($email)){
            $errors['email'] = "This email address is already taken";
        } else {
           $isEmailValid = True; 
        }
    }
} else {
    $errors['email'] = "Email must not be blank";
}

//validate password
if($password != "") {
    if(strlen($password) > 0 && strlen($password) <= 64){
        if($password === $passwordConfirm){
            $isPasswordValid = True;
        } else {
            $errors['passwordConfirm'] = "Passwords do not match";
        }
    } else {
        $errors['password'] = "Password must be a maximum of 64 characters";
    }
} else {
    $errors['password'] = "Password must not be blank";
}

if($passwordConfirm == "") {
    $errors['passwordConfirm'] = "Confirmation cannot be blank";
}



if($address1 != "" || $address2 != "" || $zipcode != "" || $city != "" || $state != "") {
    $addressNotStarted = False;

    if($address1 == "") {
        $logger->LogDebug("Address found to be blank");
        $errors['address']['address1'] = "Address Line 1 cannot be blank";
    } 
    if($zipcode == "") {
        $errors['address']['zipcode'] = "Zipcode cannot be blank";
    }
    if($city == "") {
        $errors['address']['city'] = "City cannot be blank";
    }
    if($state == "") {
        $errors['address']['state'] = "State cannot be blank";
    }

    $user = '950STUDE6265';
    $xml_data = "<AddressValidateRequest USERID='$user'>" .
    "<IncludeOptionalElements>true</IncludeOptionalElements>" .
    "<ReturnCarrierRoute>true</ReturnCarrierRoute>" .
    "<Address ID='0'>" .
    "<FirmName />" .
    "<Address1>$address1></Address1>" .
    "<Address2>$address2</Address2>" .
    "<City>$city</City>" .
    "<State>$state</State>" .
    "<Zip5>$zipcode</Zip5>" .
    "<Zip4></Zip4>" .
    "</Address>" .
    "</AddressValidateRequest>";
    
    
    
    $url = "http://production.shippingapis.com/ShippingAPI.dll?API=Verify";
    
    
    //setting the curl parameters.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // Following line is compulsary to add as it is:
    curl_setopt($ch, CURLOPT_POSTFIELDS,
                'XML=' . $xml_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    $output = curl_exec($ch);
    echo curl_error($ch);
    curl_close($ch);
    
    
    $array_data = json_decode(json_encode(simplexml_load_string($output)), true);

    $logger->LogDebug(var_dump($array_data));
    
    //echo var_dump($array_data);
    if(!isset($array_data['Address']['Error'])){

        if($address2 == "") {
            $completedAddress = trim($address1) . ', ' . trim($city) . ', ' . trim($state) . ' ' . trim($zipcode);
            //echo $completedAddress;
        } else {
            $completedAddress = trim($address1) . ' ' . trim($address2) . ', ' . trim($city) . ', ' . trim($state) . ' ' . trim($zipcode);
            //echo $completedAddress;
        }

        $isAddressValid = True;
    } else {
        $errors['address']['general'] = "Address provided is not valid";
    }
}

$logger->LogDebug($isEmailValid);
$logger->LogDebug($isPasswordValid);
$logger->LogDebug($isAddressValid);
$logger->LogDebug($addressNotStarted);

if($isEmailValid && $isPasswordValid && ($addressNotStarted || $isAddressValid)) {
    if(!($dao->emailExists($email))) {
        $dao->createUser($firstname, $lastname, $email, $password, $completedAddress);
        $_SESSION['authenticated'] = $dao->userExists($email, $password);
    }
}



if ($_SESSION['authenticated']) {
    $_SESSION['userIdentification'] = $dao->userIdentification($email, $password);
    if(isset($_SESSION['form'])){
        unset($_SESSION['form']);
    }
    header('Location: ../home.php');
    exit;
} else {
    $_SESSION['errors'] = $errors;
    $_SESSION['form'] = $_POST;
    header('Location: ../signup.php');
    exit;
}
