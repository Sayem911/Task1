<script type="text/javascript">$(document).ready(function(){var o=parseInt("<?php echo $SECURITY['TFA_ENABLED']; ?>"),r=parseInt("<?php echo $SITE['EMAIL_VERIFICATION']; ?>"),p={rules:[{type:"empty",prompt:"<?php echo $login['form']['validation']['empty_password']; ?>"},{type:"minLength[6]",prompt:"<?php echo $login['form']['validation']['valid_password']; ?>"}]},e={rules:[{type:"match[password]",prompt:"<?php echo $password['reset']['form']['passwords']['not']['equal']; ?>"}]},t={rules:[{type:"empty",prompt:"<?php echo $login['form']['validation']['empty_email']; ?>"},{type:"email",prompt:"<?php echo $login['form']['validation']['valid_email']; ?>"}]},m={rules:[{type:"empty",prompt:"<?php echo $signup['form']['validation']['first_name']; ?>"}]},a={rules:[{type:"empty",prompt:"<?php echo $signup['form']['validation']['last_name']; ?>"}]},s={rules:[{type:"empty",prompt:"<?php echo $signup['form']['validation']['phone']; ?>"},{type:"number",prompt:"<?php echo $signup['form']['validation']['phone']; ?>"}]},i={rules:[{type:"empty",prompt:"<?php echo $tfa['form']['validation']['code']; ?>"},{type:"number",prompt:"<?php echo $tfa['form']['validation']['code']; ?>"}]},l={first_name:m,last_name:a,email:t};$("#form-login").form({fields:{email:t}}),o&&(l.phone=s),r||(l.password=p,l.password2=e),$("#form-signup").form({fields:l}),$("#form-password-recovery").form({fields:{email:t}}),$("#form-password-reset").form({on:"blur",fields:{password:p,password2:e}}),$("#form-tfa").form({on:"blur",fields:{code:i}})});</script>