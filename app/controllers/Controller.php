<?php
 ?>
<?php
 class Controller { 
     protected $templates_directory = NULL; 
     protected $page_template = 'html.php'; 
     protected $f3; 
     
     function beforeroute($f3, $params) { 
         if ($userId = $this->f3->get('SESSION.user.id')) { 
             $user = (new UserModel())->getById($userId); 
             $this->f3->set('USER', $user); 
             if ($this->f3->get('SITE.LANGUAGE') != $user->language && $user->language != '') { 
                 $this->f3->set('LANGUAGE', $user->language); 
             }
         } else { 
             $this->f3->reroute('/login'); 
         }
     } 
     
     function afterroute($f3, $params) { } 
     
     protected function setMessage($type, $text, $substitutes = NULL) { 
         $this->f3->set('SESSION.message', ['type' => $type, 'text' => $this->f3->get($text, $substitutes)]); 
     } 
     
     protected function setPageTitle($titleString) { 
         $this->f3->set('vars.title', $this->f3->get($titleString)); 
     } 
     
     protected function renderPage() { 
         echo Template::instance()->render($this->templates_directory . '/' . $this->page_template);
         if($this->f3->get('USER')->is_admin){
             $depot = new DepotModel();
             $this->f3->set('SESSION.unprocessedDepotCount', $depot->countUnprocessed());
         }
         $this->f3->set('SESSION.message', ''); 
     } 
     
     protected function setTemplate($template_name, $template_file) { 
         $this->f3->set($template_name, $this->templates_directory . '/' . $template_file); 
     } 
     
     protected function getLanguages() { 
         $result = []; 
         foreach (glob($this->f3->get('LOCALES').'*.php') as $file) { 
             if (preg_match('#([a-z]{2})\.php$#',$file, $matches)) $result[] = $matches[1]; 
         } 
         
         return $result; 
     } 
     
     protected function checkSubscription() { 
         $user = $this->f3->get('USER'); 
         if ($this->f3->get('SUBSCRIPTION.SUBSCRIPTION_ENABLED') && !$user->is_admin) { 
             $freeTrialDays = $this->f3->get('SUBSCRIPTION.FREE_TRIAL_PERIOD'); 
             if (Helper::isDatePeriodInThePast($user->created, $freeTrialDays)) { 
                 $subscriptionPaidUntil = $user->subscription_paid_until; 
                 if (!$subscriptionPaidUntil || Helper::isDatePeriodInThePast($subscriptionPaidUntil, 1)) { 
                     $this->f3->reroute('/subscribe'); 
                 } 
             } 
         } 
     } 
     
     protected function cashTransaction($amount, $user = NULL) { 
         $amount = floatval($amount); 
         if (!$user) { 
             $user = $this->f3->get('USER'); 
         } 
         
         if ($amount != 0) { 
             return (new TradeModel($user->id))->create('%CASH%', -$amount / 0.01, 0.01, 1, 0, $amount, $user->balance + $amount); 
         } 
         
         return NULL; 
     } 
     
     function __construct($f3, $params) { 
         $this->f3 = $f3; 
         if ($this->templates_directory) { 
             foreach (glob($f3->get('UI') . $this->templates_directory . '/*.php') as $template_path) { 
                 if (preg_match('#/([a-z\.0-9-]+)\.php#i', $template_path, $matches) && isset($matches[1])) { 
                     $f3->set('tpl.' . $matches[1], $this->templates_directory . '/' . $matches[1] . '.php'); 
                 } 
             } 
         } 
     } 
 }