<?php

require "../../../lib/util.php";
require "../../../config.php";
require '../../../db/mysql2.php';  
require "../../../db/orm.php";
require '../../../db/users_db.php';  
//require "../../../db/payments_db.php";
require "../../../lib/libmail.php";
// require "../../../lib/logs.php";


if(PAYPAL_ENABLED!="yes") exit();

// intantiate the IPN listener
include('ipnlistener.php');
$listener = new IpnListener();

// tell the IPN listener to use the PayPal test sandbox
if(PAYPAL_USE_SANDBOX=="yes") $listener->use_sandbox = true;

//$user_id = db::exec_sql_single_value(orm::GetSelectQuery("users", array(), array("system_row"=>"-1"), ""), "UserID");

//util::SendMail(PAYPAL_SELLER_EMAIL, array(), "test", "test");

   
// try to process the IPN POST
try {
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
} catch (Exception $e) {
    //error_log($e->getMessage());
   // logs::add_log(3, $e->getMessage());
    //logs::add_log2(3, "", $user_id, util::Now(), "localhost", $e->getMessage());
    

}



   


if ($verified) {

    $errmsg = '';   // stores errors from fraud checks
    

    
    // 1. Make sure the payment status is "Completed" 
    if ($_POST['payment_status'] != 'Completed') { 
        // simply ignore any IPN that is not completed
        exit(0); 
    }

    // 2. Make sure seller email matches your primary account email.
    if ($_POST['receiver_email'] != PAYPAL_SELLER_EMAIL) {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $_POST['receiver_email']."\n";        
    }
    
    // 3. Make sure the amount(s) paid match
 //   if ($_POST['mc_gross'] != '9.99') {
 //       $errmsg .= "'mc_gross' does not match: ";
 //       $errmsg .= $_POST['mc_gross']."\n";
//    }
    
    // 4. Make sure the currency code matches
    if ($_POST['mc_currency'] != PAYPAL_CURRENCY) {
        $errmsg .= "'mc_currency' does not match: ";
        $errmsg .= $_POST['mc_currency']."\n";
    }
    
     if (floatval($_POST['mc_gross']) != floatval(PAYPAL_ACCEPT_AMOUNT)) {
        $errmsg .= "'mc_gross' - amount does not match: ";
        $errmsg .= $_POST['mc_gross']."\n";
    }
    


    $tx_id = db::exec_sql_single_value(orm::GetSelectQuery("payment_orders", array("txn_id"), array("txn_id"=>$_POST['txn_id']), ""), "txn_id");
    
    if($tx_id!="")
    {
        $errmsg .= "This transaction has already been processed \n";
    }
 
    
    if (!empty($errmsg)) {
    
        // manually investigate errors from the fraud checking        
        $body = "IPN failed fraud checks: \n$errmsg\n\n";
        $body .= $listener->getTextReport();    
       // logs::add_log(3,$body);
        //logs::add_log2(3, "", $user_id, util::Now(), "localhost", $body);
        
        if(PAYPAL_NOTIFY_FAIL_PAYMENT=="yes") util::SendMail(PAYPAL_SELLER_EMAIL, array(), "IPN Fraud Warning", $body);
    
    exit(0);        
        
    } else {
    
        $payer_email = db::clear($_POST['payer_email']);
        orm::Insert("payment_orders", array("inserted_date"=>util::Now(), "txn_id"=>$_POST['txn_id'],"payer_email"=>$_POST['payer_email'], "mc_gross"=>$_POST['mc_gross'], "currency"=>$_POST['mc_currency']));
        //logs::add_log2(4, "", $user_id, util::Now(), "localhost", $listener->getTextReport());
		
		
		if(PAYPAL_LOGIN=="yes") users_db::AddPaidUser($payer_email);
		
        if(PAYPAL_NOTIFY_SUCCESS_PAYMENT=="yes") util::SendMail(PAYPAL_SELLER_EMAIL, array(), "Paypal - payment received", $listener->getTextReport());
        
    }

} else {
    /*
    An Invalid IPN *may* be caused by a fraudulent transaction attempt. It's
    a good idea to have a developer or sys admin manually investigate any 
    invalid IPN.
    */
   // logs::add_log(3, $listener->getTextReport());
   // logs::add_log2(3, "", $user_id, util::Now(), "localhost", $listener->getTextReport());
}

?>