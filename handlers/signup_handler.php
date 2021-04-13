<?php

session_start();

require_once '../KLogger.php';
$logger = new KLogger("signup_handler.txt", KLogger::ERROR);

//array for keeping track of errors
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

//variable for storing final address
$completedAddress = "";

//get Dao
require_once '../Dao.php';
$dao = new Dao();


function isEmpty($string)
{
    if ($string === "") {
        return True;
    } else {
        return False;
    }
}


//validate names
if (isEmpty($firstname))
    $errors['firstname'] = "First name cannot be blank";
if (!preg_match("/^([a-zA-Z' ]+)$/", $firstname))
    $errors['firstname'] = "Invalid first name";
if (isEmpty($lastname))
    $errors['lastname'] = "Last name cannot be blank";
if (!preg_match("/^([a-zA-Z' ]+)$/", $lastname))
    $errors['lastname'] = "Invalid last name";

//validate email address
if (!isEmpty($email)) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Not a valid email address";
    } else {
        if ($dao->emailExists($email)) {
            $errors['email'] = "This email address is already taken";
        } else {
            $isEmailValid = True;
        }
    }
} else {
    $errors['email'] = "Email cannot be blank";
}

//validate password
if (!isEmpty($password)) {
    if(strlen($password) < 8){
        $errors['password'] = "Password must be 8 characters or more";
    }
    if (strlen($password) > 8) {
        if ($password === $passwordConfirm) {
            $isPasswordValid = True;
        } else {
            $errors['passwordConfirm'] = "Passwords do not match";
        }
    }
} else {
    $errors['password'] = "Password cannot be blank";
}

//check if confirm is empty
if (isEmpty($passwordConfirm)) {
    $errors['passwordConfirm'] = "Confirmation cannot be blank";
}


//check for all address details
if (!isEmpty($address1) || !isEmpty($address2) || !isEmpty($zipcode) || !isEmpty($city) || !isEmpty($state)) {
    $addressNotStarted = False;

    if (isEmpty($address1)) {
        $errors['address']['address1'] = "Address 1 cannot be blank";
    }
    if (isEmpty($zipcode)) {
        $errors['address']['zipcode'] = "Invalid Zip";
    }
    if (isEmpty($city)) {
        $errors['address']['city'] = "Invalid City";
    }
    if (isEmpty($state)) {
        $errors['address']['state'] = "Invalid State";
    }

    //create XML request
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
    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        'XML=' . $xml_data
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    $output = curl_exec($ch);
    echo curl_error($ch);
    curl_close($ch);

    //decode response
    $array_data = json_decode(json_encode(simplexml_load_string($output)), true);

    $logger->LogDebug(var_dump($array_data));

    //check if USPS returned error
    if (!isset($array_data['Address']['Error'])) {

        if (isEmpty($address2)) {
            $completedAddress = trim($address1) . ', ' . trim($city) . ', ' . trim($state) . ' ' . trim($zipcode);
        } else {
            $completedAddress = trim($address1) . ' ' . trim($address2) . ', ' . trim($city) . ', ' . trim($state) . ' ' . trim($zipcode);
        }

        $isAddressValid = True;
    } else {
        $errors['address']['general'] = "Address provided is not valid";
    }
}

//salt and hash password
$salt = "randomjunk";
$newpass = hash('sha256', $password.$salt);

//see if all checks are passed
if ($isEmailValid && $isPasswordValid && ($addressNotStarted || $isAddressValid)) {

    //create user
    $dao->createUser($firstname, $lastname, $email, $newpass, $completedAddress);
    //double check authentication
    $_SESSION['authenticated'] = $dao->userExists($email, $newpass);

}


//redirect based on outcomes
if ($_SESSION['authenticated']) {

    //grab user id
    $_SESSION['userIdentification'] = $dao->userIdentification($email, $newpass);
    //unset form
    if (isset($_SESSION['form'])) {
        unset($_SESSION['form']);
    }

    //redirect
    header('Location: ../home.php');
    exit;
} else {
    //assign session vars
    $_SESSION['errors'] = $errors;
    $_SESSION['form'] = $_POST;

    //redirect
    header('Location: ../signup.php');
    exit;
}
