<?php
 ?>
<?php
 class LoginController extends Controller { 
     
    protected $templates_directory = 'login';

    function beforeroute($f3, $params) { 
        if ($f3->get('SESSION.user.id') && isset($params[0]) && $params[0]!='/logout') { 
            $f3->reroute($this->f3->get('SITE.DEFAULT_PAGE')); 
        } 
    } 
    
    function renderLoginPage($f3, $params) {
        
        // if($f3->get('SESSION.gtfa.secret')){
        //     $this->f3->reroute('/verify-gtfa');
        // }
        $this->setPageTitle('title.login');
        $this->setTemplate('tpl.content', 'login.php'); 
        $this->renderPage(); 
    } 
        
    function renderSignupPage($f3, $params) { 
        $this->setPageTitle('title.signup'); 
        $this->setTemplate('tpl.content', 'signup.php'); 
        $this->renderPage(); 
    } 
    
    function renderPasswordRecoveryPage($f3, $params) { 
        $this->setPageTitle('title.password.recovery'); 
        $this->setTemplate('tpl.content', 'password-recovery.php'); 
        $this->renderPage(); 
    } 
    
    function renderPasswordResetPage($f3, $params) { 
        $this->setPageTitle('title.password.reset'); 
        $user_id = $this->f3->get('PARAMS.user_id'); 
        $token = $this->f3->get('PARAMS.token'); 
        
        if (!$user_id || !$token) { 
            $this->f3->reroute('/login'); 
        } 
        
        $password_reset = new PasswordResetModel(); 
        
        if ($password_reset->verify($user_id, $token)) { 
            $this->setTemplate('tpl.content', 'password-reset.php'); 
            $this->renderPage(); 
        } else { 
            $this->setMessage('negative', 'password.reset.token.invalid'); 
            $f3->reroute('/password'); 
        } 
    } 
    
    function renderTwoFactorAuthenticationPage($f3, $params) { 
        if (!$this->f3->get('SESSION.tfa.code')) 
            $this->f3->reroute('/login'); 

        $this->setPageTitle('title.tfa'); 
        $this->setTemplate('tpl.content', 'tfa.php'); 
        $this->renderPage(); 
    } 
    
    function renderGoogleTwoFactorAuthenticationPage($f3, $params) { 
        if (!$this->f3->get('SESSION.gtfa.secret')) 
            $this->f3->reroute('/login'); 

        $this->setPageTitle('title.gtfa'); 
        $this->setTemplate('tpl.content', 'gtfa-verify.php'); 
        $this->renderPage(); 
    } 
    
    function renderRegisterGoogleTwoFactorAuthenticationPage($f3, $params) {
        $user = $f3->get('SESSION.gtfa.user');
        
        if($user == null)
            $f3->reroute('/login');
        
        if($user->google_secret_code != null)
            $f3->reroute('/verify-gtfa');
            
        $this->setPageTitle('title.gtfa');
        $ga = new GoogleAuthenticator();
        $secret = null;
        if(!$f3->get('SESSION.gtfa.secret')){
            $secret = $ga->createSecret();
        }else{
            $secret = $f3->get('SESSION.gtfa.secret');
        }
        $qrCodeUrl 	= $ga->getQRCodeGoogleUrl($user->email, $secret, $_SERVER['SERVER_NAME']);
        $this->f3->set('qrCodeUrl', $qrCodeUrl);
        $this->f3->set('SESSION.gtfa.secret', $secret);
        $this->setTemplate('tpl.content', 'gtfa-register.php'); 
        $this->renderPage(); 
    } 
    
    function signup($f3, $params) { 
        $first_name = $this->f3->get('POST.first_name'); 
        $last_name = $this->f3->get('POST.last_name'); 
        $email = $this->f3->get('POST.email'); 
        $phone = $this->f3->get('POST.phone'); 
        $streetNr = $f3->get('POST.street_nr');
        $postNr = $f3->get('POST.post_nr');
        $town = $f3->get('POST.town');
        $referrerId = intval($this->f3->get('POST.referrer')); 
        
        if (!$first_name || !$last_name || !$email) { 
            $this->setMessage('negative', 'signup.form.validation.all_fields'); 
            $this->f3->reroute($params[0]); 
        }
        
        if ($this->f3->get('SECURITY.RECAPTCHA_ENABLED')) { 
            $web = \Web::instance(); 
            $requestOptions = [ 
                'method' => 'POST', 
                'content' => [ 
                    'secret' => $this->f3->get('SECURITY.RECAPTCHA_PRIVATE_KEY'), 
                    'response' => $this->f3->get('POST.g-recaptcha-response'), 
                    'remoteip' => $this->f3->get('IP') 
                ] 
            ];
            
            $requestResult = $web->request('https://www.google.com/recaptcha/api/siteverify', $requestOptions); 
            
            $recaptchaTestPassed = FALSE; 
            
            if (isset($requestResult['body'])) { 
                $response = json_decode($requestResult['body']); 
                if (isset($response->success) && $response->success) { 
                    $recaptchaTestPassed = TRUE; 
                } else { 
                    Logger::log($response); 
                } 
            } 
            
            if (!$recaptchaTestPassed) { 
                $this->setMessage('negative', 'signup.form.validation.captcha'); 
                $this->f3->reroute($params[0]); 
            } 
        } 
        
        $user = new UserModel();
        $totalUsers = $user->countAll(); 
        $user->getByEmail($email); 
        
        if (!$user->dry()) { 
            $this->setMessage('negative', 'signup.form.validation.user.exists'); 
            $this->f3->reroute($params[0]); 
        } 
        
        $newUser = new stdClass();
        $newUser->first_name = $first_name; 
        $newUser->last_name = $last_name; 
        $newUser->email = $email; 
        $newUser->phone = $phone; 
        $newUser->street_nr = $streetNr; 
        $newUser->post_nr = $postNr; 
        $newUser->town = $town; 
        $newUser->balance = $this->f3->get('TRADE.INITIAL_BALANCE'); 
        $newUser->currency = $this->f3->get('TRADE.ACCOUNT_CURRENCY'); 
        $newUser->timezone = $this->f3->get('SITE.TIMEZONE'); 
        $newUser->language = $this->f3->get('SITE.LANGUAGE'); 
        $newUser->is_admin = ($totalUsers > 0 ? 0 : 1); 
        $newUser->created = Helper::timeStamp(); 
        $newUser->ip = $this->f3->get('IP'); 
        $newUser->referrer_id = $referrerId > 0 ? $referrerId : NULL; 
        
        if (!$this->f3->get('SITE.EMAIL_VERIFICATION')) { 
            $password = $this->f3->get('POST.password'); 
            $password2 = $f3->get('POST.password2'); 
            
            if (!$password || $password!=$password2) { 
                $this->setMessage('negative', 'password.reset.form.passwords.not.equal'); 
                $f3->reroute($params[0]); 
            } 
            
            $newUser->password = password_hash($password, PASSWORD_BCRYPT); 
        } 
        
        if ($this->f3->get('ADMIN.GENERATE_ACCOUNT_NUMBER')) { 
            $newUser->account_number = Helper::randomNumber(7); 
        } 
        
        if ($this->f3->get('SECURITY.TFA_ENABLED')) { 
            if (!preg_match('#^[0-9]{7,}$#', $phone)) { 
                $this->setMessage('negative', 'signup.form.validation.phone'); 
                $f3->reroute($params[0]); 
            } else { 
                $code = Helper::randomNumber(4); 
                $sms = new TextMessage(); 
                $sms->send($phone, $code); 
                $this->f3->set('SESSION.tfa.code', $code); 
                $this->f3->set('SESSION.tfa.user', $newUser); 
                $this->f3->set('SESSION.tfa.attempts', 0); 
                $this->f3->set('SESSION.tfa.referer', $params[0]); $this->f3->reroute('/verify'); 
            } 
        } 
        
        $this->addUser($newUser); 
    } 
    
    function resetPassword($f3, $params) { 
        $user_id = $f3->get('PARAMS.user_id'); 
        $token = $f3->get('PARAMS.token'); 
        $password = $f3->get('POST.password'); 
        $password2 = $f3->get('POST.password2'); 
        
        Logger::log(sprintf('User %d, token %s tries to reset password', $user_id, $token)); 
        
        if (!$user_id || !$token) { 
            $f3->reroute('/login');
        } 
        
        if (!$password || $password!=$password2) { 
            $this->setMessage('negative', 'password.reset.form.passwords.not.equal'); 
            $f3->reroute($params[0]);
        } 
        
        $password_reset = new PasswordResetModel(); 
        
        if ($password_reset->verify($user_id, $token)) { 
            $user = new UserModel(); 
            $user->getById($user_id)->edit(array('password' => password_hash($password, PASSWORD_BCRYPT))); 
            $result = $password_reset->delete($user_id, $token); 
            
            Logger::log(sprintf('Password for user %d updated. Result %s', $user_id, $result)); 
            
            if ($this->f3->get('ADMIN.NOTIFY_WHEN_USERS_CHANGE_PASSWORD')) { 
                $f3->set('vars.name', $user->first_name.' '.$user->last_name); 
                $f3->set('vars.email', $user->email); 
                $email = new Email($this->f3->get('SITE.EMAIL'), $this->f3->get('email.password_change.subject'), 'email/password-change-notification.php'); 
            } 
            
            $this->setMessage('positive', 'password.reset.success'); 
            $f3->reroute('/login');
        } else { 
            $this->setMessage('negative', 'password.reset.token.invalid'); 
            $f3->reroute('/password'); 
        }
    } 
    
    function recoverPassword($f3, $params) { 
        $user_email = $f3->get('POST.email'); 
        
        Logger::log(sprintf('User %s wants to recover password', $user_email)); 
        
        $user = new UserModel(); 
        $user->getByEmail($user_email); 
        
        if (!$user->dry()) { 
            $token = self::generateToken(); 
            $password_reset = new PasswordResetModel(); 
            $password_reset->add($user->id, $token); 
            $f3->set('vars.first_name', $user->last_name); 
            $f3->set('vars.password_reset_url', Helper::baseUrl().'password-reset/'.$user->id.'/'.$token); 
            $email = new Email($user_email, $this->f3->get('email.password.subject'), 'email/password-recovery.php'); 
            $this->setMessage('positive', 'password.form.success.message'); 
            $f3->reroute('/password');
        } else { 
            $this->setMessage('negative', 'password.form.error.incorrect_email'); 
            $f3->reroute('/password'); 
        } 
    }
    
    function login($f3, $params) { 
        $user_email = $f3->get('POST.email'); 
        $user_password = $f3->get('POST.password'); 
        
        Logger::log(sprintf('User %s logs in', $user_email)); 
        
        $user = new UserModel(); 
        $user->getByEmail($user_email); 
        
        if ($user->dry() || !password_verify($user_password, $user->password)) { 
            Logger::log(sprintf('Incorrect login or password for %s', $user->email)); 
            $this->setMessage('negative', 'login.form.error.incorrect', [$this->f3->get('BASE').'/password']); 
            $f3->reroute('/login');
        } 
        
        if ($user->blocked) { 
            Logger::log(sprintf('User is blocked %s', $user->email)); 
            $this->setMessage('negative', 'login.form.error.blocked'); 
            $f3->reroute('/login');
        }
        
        if ($this->f3->get('SECURITY.TFA_ENABLED') && $user->phone != '') { 
            $code = Helper::randomNumber(4); 
            $sms = new TextMessage(); 
            $sms->send($user->phone, $code); 
            $this->f3->set('SESSION.tfa.code', $code); 
            $this->f3->set('SESSION.tfa.user', (object)$user->cast()); 
            $this->f3->set('SESSION.tfa.attempts', 0); 
            $this->f3->set('SESSION.tfa.referer', $params[0]); 
            $this->f3->reroute('/verify');
        } 
        
        if($this->f3->get('SECURITY.GTFA_ENABLED')){
            if($user->g2fa_enabled == 1){
                if($user->google_secret_code == null){
                    $this->f3->set('SESSION.gtfa.user', (object)$user->cast());
                    $this->f3->set('SESSION.gtfa.referer', $params[0]);
                    $this->f3->reroute('/register-gtfa');
                }else{
                    $this->f3->set('SESSION.gtfa.secret', $user->google_secret_code);
                    $this->f3->set('SESSION.gtfa.user', (object)$user->cast());
                    $this->f3->set('SESSION.gtfa.referer', $params[0]);
                    $this->f3->set('SESSION.gtfa.attempts', 0); 
                    $this->f3->reroute('/verify-gtfa');
                }
            }
        }

        $this->createSession($user); 
    } 
    
    function verify($f3, $params) { 
        $user = $this->f3->get('SESSION.tfa.user'); 
        $generatedCode = $this->f3->get('SESSION.tfa.code'); 
        $attempts = $this->f3->get('SESSION.tfa.attempts'); 
        $referer = $this->f3->get('SESSION.tfa.referer'); 
        $userCode = $this->f3->get('POST.code'); 
        if ($generatedCode!=$userCode) { 
            $attempts++; 
            if ($attempts >= $this->f3->get('SECURITY.TFA_MAX_ATTEMPTS')) { 
                $this->f3->clear('SESSION'); 
                $this->setMessage('negative', 'tfa.form.error.max_attempts'); 
                $this->f3->reroute('/login');
            } else { 
                $this->setMessage('negative', 'tfa.form.error.incorrect'); 
                $this->f3->set('SESSION.tfa.attempts', $attempts); 
                $this->f3->reroute($params[0]);
            } 
        } 
        
        if ($referer=='/signup') { 
            $this->addUser($user); 
        } elseif ($referer=='/login') { 
            $this->createSession($user);
        } else { 
            $this->f3->reroute('/'); 
        } 
    } 
    
    function g2faVerify($f3, $params) {
        
        $user = $this->f3->get('SESSION.gtfa.user');
        $referer = $this->f3->get('SESSION.gtfa.referer');
                
        if($user == null || $referer == null)
            $f3->reroute('/login');
        
        $userid = $user->id;
        $user = new UserModel();
        $user->getById($userid);
        
        $ga = new GoogleAuthenticator();
        $attempts = $this->f3->get('SESSION.gtfa.attempts'); 
        $userSecret = $this->f3->get('SESSION.gtfa.secret');
        $userCode = $this->f3->get('POST.code');
        $checkResult = $ga->verifyCode($userSecret, $userCode, 1); // 1 = 1*30 sec clock tolerance
        if (!$checkResult) { 
            $attempts++;
            if ($attempts >= $this->f3->get('SECURITY.GTFA_MAX_ATTEMPTS')) { 
                $this->f3->clear('SESSION');
                $this->setMessage('negative', 'gtfa.verify.form.error.max_attempts');
                $this->f3->reroute('/login');
            } else { 
                $this->setMessage('negative', 'gtfa.verify.form.error.incorrect'); 
                $this->f3->set('SESSION.gtfa.attempts', $attempts); 
                $this->f3->reroute($params[0]);
            } 
        }

        $this->createSession($user);
    } 
    
    function g2faRegister($f3, $params) {
        
        $user = $this->f3->get('SESSION.gtfa.user');
        $referer = $this->f3->get('SESSION.gtfa.referer');
        
        if($user == null || $referer != '/login')
            $f3->reroute('/login');
        
        $ga = new GoogleAuthenticator();
        $userSecret = $this->f3->get('SESSION.gtfa.secret');
        $userCode = $this->f3->get('POST.code');
        $checkResult = $ga->verifyCode($userSecret, $userCode, 1); // 1 = 1*30 sec clock tolerance
        if (!$checkResult) { 
            $this->setMessage('negative', 'gtfa.verify.form.error.incorrect'); 
            $this->f3->reroute('/register-gtfa');
        } 
        
        $userModel = new UserModel();
        $userModel->getById($user->id);
        $userModel->edit(['google_secret_code' => $userSecret]);

        $this->createSession($user);
    } 

    function logout($f3, $params) { 
        $f3->clear('SESSION'); 
        $f3->reroute('/login'); 
    } 
    
    public static function generateToken($length = 32) { 
        if (function_exists('openssl_random_pseudo_bytes')) { 
            if ($bytes = openssl_random_pseudo_bytes($length * 2)) { 
                return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
            } 
        } 
        
        return self::quickRandom($length);
    } 
    
    public static function quickRandom($length = 32) { 
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length); 
    } 
    
    private function createSession($user) { 
        new Session(); 
        $this->f3->set('SESSION.user.id', $user->id); 
        $userModel = new UserModel(); 
        $userModel->getById($user->id); 
        $userModel->edit([ 
            'last_login' => Helper::timeStamp(), 
            'ip' => $this->f3->get('IP') 
        ]); 
        if($this->f3->get('USER')->is_admin){
        }
        $depot = new DepotModel();
        $this->f3->set('SESSION.unprocessedDepotCount', $depot->countUnprocessed());
        Logger::log(sprintf('User %s logged in', $user->email)); 
        $this->f3->reroute($this->f3->get('SITE.DEFAULT_PAGE')); 
    } 
    
    private function addUser($user) { 
        $userModel = new UserModel(); 
        if (!isset($user->password)) { 
            $token = self::generateToken(); 
            $user->password = password_hash($token, PASSWORD_BCRYPT);
        } 
        
        if ($userModel->add((array)$user)) { 
            Logger::log(sprintf('User %d (%s) created', $userModel->id, $userModel->email)); 
            
            $watchlist = new WatchlistModel($userModel->id); 
            $watchlist->addSymbols($this->f3->get('MARKETS.DEFAULT_WATCHLIST')); 
            
            if ($this->f3->get('REFERRALS.ENABLED') && $userModel->referrer_id) { 
                $this->cashTransaction($this->f3->get('REFERRALS.REFERRAL_BONUS'), $userModel); 
                
                Logger::log(sprintf('Bonus %f assigned to referral user %d', $this->f3->get('REFERRALS.REFERRAL_BONUS'), $userModel->id)); 
                
                $referrer = new UserModel(); 
                $referrer->getById($userModel->referrer_id); 
                $this->cashTransaction($this->f3->get('REFERRALS.REFERRER_BONUS'), $referrer); 
                
                Logger::log(sprintf('Bonus %f assigned to referrer user %d', $this->f3->get('REFERRALS.REFERRER_BONUS'), $referrer->id));
            } 
            
            if ($this->f3->get('MAILCHIMP.API_KEY') && $this->f3->get('MAILCHIMP.SIGNUP_LIST_ID')) { 
                $mailchimp = new MailChimp($this->f3->get('MAILCHIMP.API_KEY')); 
                $mailchimp->addToMailchimpList( $this->f3->get('MAILCHIMP.SIGNUP_LIST_ID'), $userModel->email, $userModel->first_name, $userModel->last_name, $this->f3->get('IP') ); 
            } 
            
            if ($this->f3->get('SITE.EMAIL_VERIFICATION')) { 
                $password_reset = new PasswordResetModel(); 
                $password_reset->add($userModel->id, $token); 
                $this->f3->set('vars.first_name', $userModel->last_name); 
                $this->f3->set('vars.password_reset_url', Helper::baseUrl() . 'password-reset/' . $userModel->id . '/' . $token); 
                $email = new Email($userModel->email, $this->f3->get('email.signup.subject', $this->f3->get('website.title')), 'email/signup.php'); 
                $this->setMessage('positive', 'signup.form.success.message'); 
                $this->f3->reroute('/login'); 
            } else { 
                $this->createSession($userModel); 
            } 
        } else { 
            $this->setMessage('negative', 'signup.form.failure.message'); 
            $this->f3->reroute('/signup'); 
        } 
    } 
 }