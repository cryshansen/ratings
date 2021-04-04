<?php
session_start();
global $pdo;
include('utilities/bdd.php');

global $rating;


if(count($_POST)){
    $total =0;
    $subtotal=0;
    
    $prod = 23452;
    $myIP = getIP();
    $username ="chansen";
    //Check if the session variable exists.
    if(!isset($_SESSION['ratings'])){
        //If it doesn't, create an empty array.
        $_SESSION['ratings'] = array();
    }
    if($rating==null){
        //console_log($ratings);
        $rating = $_POST['rating'];
    }
    $_SESSION['ratings'][] = $rating;
    $i = count($_SESSION['ratings']);
    //calculate the value to return plus count for number of votes
    foreach($_SESSION['ratings'] as $productId){
        //echo $productId, '  <br>';
        if(!is_array($productId))
            $subtotal = $subtotal + $productId;
    }
    
    $total = round($subtotal/$i,2);
    //echo $total;
    //hit database utf8_decode($val);
    $req = $pdo->prepare("INSERT INTO `Ratings`(`rating`, `adrIP`, `username`, `productId`) VALUES (:rating,:addrIP,:username,:prod)");
    
    //$req = $pdo->prepare("INSERT INTO `Ratings`(`rating`, `adrIP`, `username`) VALUES (:rating, :addrIP, :username)");
    $req->bindParam(':rating', $rating, PDO::PARAM_STR);
    $req->bindParam(':addrIP', $myIP, PDO::PARAM_STR);
    $req->bindParam(':username', $username, PDO::PARAM_STR);
    $req->bindParam(':prod', $prod, PDO::PARAM_INT);
    $status = ($req->execute()) ? "<hr>Rating Gecko: <span style='font-weight:bold;color:#090'>OK</span><br>":"<hr>Rating Gecko: <span style='font-weight:bold;color:#900'>Error</span><br>";
	$req->closeCursor();
    //echo $status;
    header("Location: http://crystalhansenartographic.com/test/starrating.html?rating=".$total . "&votes=".$i); 
 
 

 
}


function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}


function getIP($ip = null, $deep_detect = TRUE){
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }
    return $ip;
}



 //session_end();

?>
