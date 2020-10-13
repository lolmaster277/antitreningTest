<?php
    require_once  'vendor/autoload.php';

    use \CloudPayments\Manager;

    if(isset($_POST['MD'])&&isset($_POST['PaRes'])){
        $client = new Manager('pk_f90e0b450a2f4765b099043a011e0', '4029e22841587dbd2d99e703169da246');
        $transaction = $client->confirm3DS($_POST['MD'],$_POST['PaRes']);
    
        echo $transaction->getCardHolderMessage();
    
   
    }
    
?>  