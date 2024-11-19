<?php
 ?>
<?php
 class UserController extends Controller { 
     protected $templates_directory = 'main'; 
     const UPLOAD_DIR = 'files'.DIRECTORY_SEPARATOR.'avatars'.DIRECTORY_SEPARATOR; 
     const MAX_IMAGE_SIZE = 307200; 
     
     function beforeroute($f3, $params) { 
         parent::beforeroute($f3, $params); 
         
     } 
     
     function renderProfilePage($f3, $params) { 
         $this->f3->set('vars.languages', $this->getLanguages());
         $this->setPageTitle('title.profile'); 
         $this->setTemplate('tpl.content', 'user/profile.php'); 
         $this->renderPage(); 
     } 
     
     function renderInviteFriendPage($f3, $params) { 
         if ($this->f3->get('REFERRALS.ENABLED')) { 
             $this->f3->set('vars.link', Helper::baseUrl().'signup?ref='.$this->f3->get('USER')->id); 
             $this->setPageTitle('title.invite'); 
             $this->setTemplate('tpl.content', 'user/invite.php'); 
             $this->renderPage(); 
         } else { 
             $this->f3->reroute($this->f3->get('SITE.DEFAULT_PAGE')); 
         } 
     } 
     
     function renderPasswordUpdatePage($f3, $params) { 
         $this->setPageTitle('title.password.update'); 
         $this->setTemplate('tpl.content', 'user/password.php'); 
         $this->renderPage(); 
         
     } 
     
     function updatePassword($f3, $params) { 
         $user = $this->f3->get('USER'); 
         $oldPassword = $this->f3->get('POST.old_password'); 
         $newPassword = $this->f3->get('POST.new_password'); 
         $newPassword2 = $this->f3->get('POST.new_password2'); 
         
         if (password_verify($oldPassword, $user->password)) { 
             if ($newPassword == $newPassword2) { 
                 $user->edit(['password' => password_hash($newPassword, PASSWORD_BCRYPT)]); 
                 $this->setMessage('positive', 'password.update.success'); 
             } else { 
                 $this->setMessage('negative', 'password.update.error02'); 
             } 
         } else { 
             $this->setMessage('negative', 'password.update.error01'); 
         } 
         
         $this->setPageTitle('title.password.update'); 
         $this->setTemplate('tpl.content', 'user/password.php'); 
         $this->renderPage(); 
     } 
     
     function updateProfile($f3, $params) { 
         $user = $this->f3->get('USER'); 
         $imageUploadError = NULL; 
         if (isset($_FILES['avatar']) && $_FILES['avatar']['name']!='') { 
             $uploadedFileName = $_FILES['avatar']['name']; 
             $uploadedFilePath = $_FILES['avatar']['tmp_name']; 
             $uploadedFileSize = $_FILES['avatar']['size']; 
             $uploadedFileExt = pathinfo($uploadedFileName, PATHINFO_EXTENSION); 
             $storedFileName = sha1($user->id.$user->first_name.$user->last_name).'.'.$uploadedFileExt; 
             
             if (!file_exists(self::UPLOAD_DIR)) { 
                 mkdir(self::UPLOAD_DIR, 0777, TRUE);
             } 
             
             if (!getimagesize($uploadedFilePath) || !in_array($uploadedFileExt, ['jpg','jpeg','png'])) { 
                 $imageUploadError = 'profile.error.incorrect_file_extenstion'; 
             } elseif ($uploadedFileSize > self::MAX_IMAGE_SIZE) { 
                 $imageUploadError = 'profile.error.image_size_too_big'; 
             } elseif (!move_uploaded_file($uploadedFilePath, self::UPLOAD_DIR.$storedFileName)) { 
                 $imageUploadError = 'profile.error.image_not_saved'; 
             } 
         }
         
         if (is_null($imageUploadError)) { 
            //  $firstName = $f3->get('POST.first_name'); 
            //  $lastName = $f3->get('POST.last_name'); 
             $phone = $f3->get('POST.phone'); 
             $landPhone = $f3->get('POST.land_phone'); 
             $fax = $f3->get('POST.fax'); 
             $streetNr = $f3->get('POST.street_nr');
             $postNr = $f3->get('POST.post_nr');
             $town = $f3->get('POST.town');
             $timeZone = $f3->get('POST.timezone'); 
             $language = $f3->get('POST.language'); 
             $user->edit([ 
                // 'first_name' => $firstName, 
                // 'last_name' => $lastName, 
                'phone' => $phone, 
                'land_phone' => $landPhone, 
                'fax' => $fax, 
                'street_nr' => $streetNr, 
                'post_nr' => $postNr, 
                'town' => $town, 
                'timezone' => $timeZone, 
                'language' => (in_array($language, $this->getLanguages()) ? $language : $this->f3->get('SITE.LANGUAGE')), 
                'avatar' => (isset($storedFileName) ? $storedFileName : $user->avatar) 
            ]); 
             
             if (
                // $user->changed('first_name') || 
                // $user->changed('last_name') || 
                $user->changed('phone') || 
                $user->changed('land_phone') || 
                $user->changed('fax') || 
                $user->changed('street_nr') || 
                $user->changed('post_nr') || 
                $user->changed('town') || 
                $user->changed('avatar') || 
                $user->changed('timezone') || 
                $user->changed('language')) { 
                //  Logger::log(sprintf('Profile updated: "%s", "%s", "%s", "%s", "%s", "%s"', $user->first_name, $user->last_name, $user->phone, $user->timezone, $user->avatar, $user->language)); 
                 $this->setMessage('positive', 'profile.save.success'); 
             } 
             
             if ($user->changed('language')) { 
                 $this->f3->set('LANGUAGE', $language); 
             } 
         } else { 
             $this->setMessage('negative', $imageUploadError); 
         } 
         
         $this->f3->set('vars.languages', $this->getLanguages()); 
         $this->setTemplate('tpl.content', 'user/profile.php'); 
         $this->renderPage(); 
     } 
 }