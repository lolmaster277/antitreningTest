<?php
    require_once  'vendor/autoload.php';

    use \CloudPayments\Manager;
    
    if(isset($_POST['name'])&&isset($_POST['CardCryptogramPacket'])){
        $client = new Manager('pk_f90e0b450a2f4765b099043a011e0', '4029e22841587dbd2d99e703169da246');
        $transaction = $client->chargeCard(100.00,"RUB",$_SERVER['REMOTE_ADDR'],$_POST['name'],$_POST['CardCryptogramPacket']);

        if(get_class($transaction)=="CloudPayments\Model\Required3DS" ){
            
            echo json_encode(array('status'=>2,'url'=>$transaction->getUrl(),'token'=>$transaction->getToken(),'id'=>$transaction->getTransactionId()));
        }else if(get_class($transaction)=="CloudPayments\Model\TransactionPayment"){
            echo json_encode(array('status'=>1,'message'=>$transaction->getCardHolderMessage()));
        }else{
            echo json_encode(array('status'=>0,'message'=>$transaction->getCardHolderMessage()));
        }
   
    }
    
?>  