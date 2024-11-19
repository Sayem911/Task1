<?php

class CryptoController extends Controller {

    protected $templates_directory = 'main'; 

    function beforeroute($f3, $params) {
        parent::beforeroute($f3, $params);
    }
    
    function renderPaymentsPage($f3, $params) {
        $this->setPageTitle('title.cryptopayments'); 
        $this->setTemplate('tpl.content', 'crypto/cryptopay.php'); 
        $this->renderPage(); 
    }

    function savePayment($f3, $params) {
        $user = $this->f3->get('USER');
        $amount = $f3->get('POST.amount');
        $current = $f3->get('POST.current');
        $total = $f3->get('POST.total');
        $symbol = $f3->get('POST.symbol');
        $wallet = $f3->get('POST.wallet');
        
        $cm = new CryptoModel();
        $result = $cm->add(['user_id' => $user->id, 'wallet' => $wallet, 'symbol' => $symbol, 'amount' => $amount, 'current' => $current, 'total' => $total]);
        if ($result) { 
            $success = TRUE;
            $message = $this->f3->get('crypto.payment.save.success'); 
        } else {
            $success = FALSE;
            $message = $this->f3->get('crypto.payment.save.failed'); 
            
        }
        
        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);
    } 

    function editPayment($f3, $params) {

        if(!$this->f3->get('USER')->is_admin){
            $message = $this->f3->get('crypto.payment.edit.permission.message');
            print json_encode(array('success' => $success, 'message' => $message));
            exit;
        }
        $success = FALSE;
        $id = $f3->get('POST.payment_id');
        $user = $this->f3->get('USER');
        $amount = $f3->get('POST.amount');
        $current = $f3->get('POST.current');
        $total = $f3->get('POST.total');
        
        $cm = (new CryptoModel())->getById($id);
        $data = null;
        $data = ['amount' => $amount, 'current' => $current, 'total' => $total];
        if ($cm->edit($data)) {
            $success = TRUE;
            $message = $this->f3->get('crypto.payment.save.success'); 
        }else{
            $message = $this->f3->get('crypto.payment.save.failed'); 
        }
        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);
    } 


    function deletePayment($f3, $params) {
        $success = FALSE;
        $id = $this->f3->get('POST.id');
        
        if(!$this->f3->get('USER')->is_admin){
            $message = $this->f3->get('crypto.payment.delete.permission.message');
            print json_encode(array('success' => $success, 'message' => $message));
            exit;
        }

        if ((new CryptoModel())->delete($id)) {
            $success = TRUE;
            $message = $this->f3->get('crypto.payment.delete.success'); 
        }else{
            $message = $this->f3->get('crypto.payment.delete.failed'); 
        }
        print json_encode(array('success' => $success, 'message' => $message), JSON_NUMERIC_CHECK);
        
    }

    function payments($f3, $params) {
        // check if user id is passed to filter by user (only for admin)
        $model = new CryptoModel();
        if(isset($params['user_id'])){
            if(!$this->f3->get('USER')->is_admin){
                $message = $this->f3->get('crypto.payment.edit.permission_message');
                print json_encode(array('success' => $success, 'message' => $message));
                exit;
            }else{
                $userId = $params['user_id'];
                $payments = $model->getByUserId($userId);
                print json_encode($payments, JSON_NUMERIC_CHECK);
            }
        }else{
            if(!$this->f3->get('USER')->is_admin){
                $userId = $this->f3->get('USER')->id;
                $payments = $model->getByUserId($userId);
                print json_encode($payments, JSON_NUMERIC_CHECK);
            }else{
                $payments = $model->all();
                print json_encode($payments, JSON_NUMERIC_CHECK);
            }
        }
    }
}