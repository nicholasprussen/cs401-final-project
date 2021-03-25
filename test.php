<html>
    <body>
        <?php
            $address1 = "1801 W University Dr";
            $address2 = "#580";
            $city = "Boise";
            $state = "ID";
            $zipcode = "83706";

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
            
            //print_r('<pre>');
            //print_r($array_data);
            //print_r('</pre>');
            //echo PHP_EOL;
            echo var_dump($array_data);
            if(isset($array_data['Address']['Error'])){
                echo "Address not found";
            }

            if($address2 == "") {
                $completedAddress = trim($address1) . trim($address2) . ', ' . $city . ', ' . $state . ' ' . $zipcode;
                echo $completedAddress;
            } else {
                $completedAddress = trim($address1) . ' ' . trim($address2) . ', ' . $city . ', ' . $state . ' ' . $zipcode;
                echo $completedAddress;
            }
            
        ?>
    </body>
</html>