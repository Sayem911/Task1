<?php
 ?>
<?php
 class ErrorController { protected $templates_directory = 'error'; function renderErrorPage($f3, $params) { Logger::log(sprintf('Error %d (%s), page %s, trace %s', $f3->get('ERROR.code'), $f3->get('ERROR.status'), $f3->get('BASE').$f3->get('PATH'), htmlspecialchars_decode(strip_tags($f3->get('ERROR.trace'))))); echo Template::instance()->render($this->templates_directory . '/error.php'); } }