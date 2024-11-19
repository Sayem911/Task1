<?php
 ?>
<?php
 class AdminController extends Controller { 
     
     protected $templates_directory = 'main'; 
     protected $settings_file = 'config/framework.ini'; 
     
     function beforeroute($f3, $params) { 
         parent::beforeroute($f3, $params); 
         if (!$this->f3->get('USER')->is_admin) { 
             $f3->error(403); 
         } 
     }
         
    function renderSettingsPage($f3, $params) { 
        $this->f3->set('vars.languages', $this->getLanguages()); 
        $this->setPageTitle('title.settings'); 
        $this->setTemplate('tpl.content', 'admin/settings.php'); 
        $this->renderPage(); 
        
    } 
    
    function renderUsersPage($f3, $params) { 
        $userModel = new UserModel(); 
        $this->setPageTitle('title.users'); 
        $f3->set('vars.users', $userModel->getAll()); 
        $this->setTemplate('tpl.content', 'admin/users.php'); 
        $this->renderPage(); 
    } 
    
    function updateSettings($f3, $params) { 
        $settingsChanged = FALSE; 
        if ($settings = file_get_contents($this->settings_file)) { 
            foreach ($this->f3->get('POST') as $settingId => $settingValue) { 
                if (strpos($settingId, '#') !== FALSE) { 
                    list ($settingGroup, $settingName) = explode('#', $settingId); 
                    $escapedSettingValue = str_replace(['\\','$'],['\\\\','\\$'], $settingValue); 
                    $settings = preg_replace('#(\['.$settingGroup.'\].*'.$settingName.'=)(.*)(\r?\n|$)#sU', '${1}'.$escapedSettingValue.'${3}', $settings); 
                    $settingArray = explode(',',$settingValue); 
                    
                    if (count($settingArray)>1 && !in_array($settingGroup,['DB','SMTP'])) { 
                        $settingValue = $settingArray;
                    } 
                    
                    $this->f3->set(str_replace('#','.',$settingId), $settingValue); 
                    $settingsChanged = TRUE; 
                } 
            } 
        } 
        
        if ($settingsChanged) { 
            if (file_put_contents($this->settings_file, $settings)) { 
                $this->setMessage('positive', 'settings.save.success'); 
            } else { 
                $this->setMessage('negative', 'settings.save.failure'); 
            } 
        } 
        
        $this->f3->set('vars.languages', $this->getLanguages()); 
        $this->setTemplate('tpl.content', 'admin/settings.php'); 
        $this->renderPage(); 
    } 
 }
