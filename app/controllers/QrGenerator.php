<?php
 ?>
<?php

include('phpqrcode/qrlib.php');

 class QrGenerator extends Controller { 
    protected $templates_directory = 'main'; 
    
    function beforeroute($f3, $params) { 
        parent::beforeroute($f3, $params); 
        parent::checkSubscription(); 
    } 
     
    function renderQrCode($f3, $params) {
        $val = $f3->get('PARAMS.val');
        QRcode::png($val, false, 'QR_ECLEVEL_L', 12, 1);
    }
}