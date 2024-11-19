<?php
 ?>
<?php
 class MailChimp { private $apiKey; private $apiUrl; public function __construct($apiKey) { $this->apiKey = $apiKey; $dataCenterCode = substr($this->apiKey, strpos($this->apiKey,'-')+1); $this->apiUrl = 'https://' . $dataCenterCode . '.api.mailchimp.com/3.0/'; } public function addToMailchimpList($listId, $email, $firstName, $lastName, $ip = NULL) { $newListMember = [ 'email_address' => $email, 'status' => 'subscribed', 'member_rating' => 3, 'ip_signup' => $ip, 'merge_fields' => [ 'FNAME' => $firstName, 'LNAME' => $lastName ] ]; $requestOptions = [ 'method' => 'POST', 'header' => array('Authorization: apikey '.$this->apiKey), 'content' => json_encode($newListMember) ]; Logger::log(sprintf('Adding %s to mailchimp list %s', $email, $listId)); $web = \Web::instance(); $requestResult = $web->request($this->apiUrl . 'lists/' . $listId . '/members', $requestOptions); if (isset($requestResult['body'])) { $response = json_decode($requestResult['body']); if (isset($response->status) && $response->status=='subscribed') { Logger::log('Successfully subscribed'); return TRUE; } else { Logger::log($response); return FALSE; } } return FALSE; } }