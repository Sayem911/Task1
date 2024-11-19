<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta property="og:title" content="<?php echo $website['title']; ?>" />
<meta property="og:description" content="<?php echo $website['slogan']; ?>. <?php echo $website['slogan2']; ?>." />
<meta property="og:url" content="<?php echo Helper::baseUrl(); ?>" />
<meta property="og:type" content="website" />
<meta property="og:image" content="<?php echo Helper::baseUrl(); ?>assets/images/background-header.png" />

<title><?php echo $website['title'] . ' | ' . $vars['title']; ?></title>

<link rel="manifest" href="<?php echo $BASE; ?>/assets/images/icons/manifest.json">
<link rel="mask-icon" href="<?php echo $BASE; ?>/assets/images/icons/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="<?php echo $BASE; ?>/assets/images/icons/favicon.ico">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="<?php echo $BASE; ?>/assets/images/icons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">

<!--<link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/semantic/2.4.1/semantic.min.css">-->
<link rel="stylesheet" type="text/css" class="ui" href="//semantic-ui.com/dist/semantic.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/css/app.css?v=<?php echo md5(microtime(true)); ?>">

<script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
<!--<script src="<?php echo $BASE; ?>/assets/vendor/semantic/2.4.1/semantic.min.js"></script>-->
<script src="//semantic-ui.com/dist/semantic.min.js"></script>
<script src="<?php echo $BASE; ?>/assets/vendor/moment/moment.min.js"></script>
<script src="<?php echo $BASE; ?>/assets/vendor/moment/moment-timezone-with-data-2012-2022.min.js"></script>
<script src="<?php echo $BASE; ?>/assets/js/app<?php echo $MINIFIED_JS?'.min':''; ?>.js?v=<?php echo md5(microtime(true)); ?>"></script>
<?php if ($ADSENSE['CLIENT_ID'] && $ADSENSE['SLOT_ID']): ?>
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<?php endif; ?>

<?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['const'] : $tpl['js']['const'],$this->mime,get_defined_vars(),0); ?>

<?php if ($PATH=='/password-update'): ?>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['password'] : $tpl['js']['password'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/markets'): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.dataTables.css">
  <script src="<?php echo $BASE; ?>/assets/vendor/jquery.marquee/jquery.marquee.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/jquery.rotate/jquery.rotate.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <!--<script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/dataTables.buttons.min.js"></script>-->
  <!--<script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.html5.min.js"></script>-->
  <!--<script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.flash.min.js"></script>-->
  <!--<script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.print.min.js"></script>-->
  <script src="<?php echo $BASE; ?>/assets/js/jClocksGMT.min.js"></script>
  <!--<?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['markets'] : $tpl['js']['markets'],$this->mime,get_defined_vars(),0); ?>-->
<?php endif; ?>

<?php if ($PATH=='/trade'): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/amstock/plugins/export/export.css">
  <script src="<?php echo $BASE; ?>/assets/vendor/amstock/amcharts.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amstock/serial.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amstock/amstock.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amstock/plugins/export/export.min.js"></script>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['trade'] : $tpl['js']['trade'],$this->mime,get_defined_vars(),0); ?>
  <?php if ($USER['is_admin']) echo $this->render($MINIFIED_JS ? $tpl['min']['js']['usersearch'] : $tpl['js']['usersearch'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/portfolio'): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.css">
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/dataTables.buttons.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.html5.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.flash.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.print.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/amcharts.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/serial.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.min.js"></script>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['portfolio'] : $tpl['js']['portfolio'],$this->mime,get_defined_vars(),0); ?>
  <?php if ($USER['is_admin']) echo $this->render($MINIFIED_JS ? $tpl['min']['js']['usersearch'] : $tpl['js']['usersearch'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/offers'): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.css">
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/dataTables.buttons.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.html5.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.flash.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.print.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/amcharts.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/serial.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.min.js"></script>
  <!--<script src="<?php echo $BASE; ?>/<?php echo $MINIFIED_JS ? $tpl['min']['js']['offers'] : $tpl['js']['offers']; ?>"></script>-->
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['offers'] : $tpl['js']['offers'],$this->mime,get_defined_vars(),0); ?>
  <?php if ($USER['is_admin']) echo $this->render($MINIFIED_JS ? $tpl['min']['js']['usersearch'] : $tpl['js']['usersearch'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/transactions'): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.css">
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/dataTables.buttons.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.html5.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.flash.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.print.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/amcharts.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/serial.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.min.js"></script>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['transactions'] : $tpl['js']['transactions'],$this->mime,get_defined_vars(),0); ?>
  <?php if ($USER['is_admin']) echo $this->render($MINIFIED_JS ? $tpl['min']['js']['usersearch'] : $tpl['js']['usersearch'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/signals'): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.css">
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/dataTables.buttons.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.html5.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.flash.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.print.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/amcharts.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/serial.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.min.js"></script>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['signals'] : $tpl['js']['signals'],$this->mime,get_defined_vars(),0); ?>
  <?php if ($USER['is_admin']) echo $this->render($MINIFIED_JS ? $tpl['min']['js']['usersearch'] : $tpl['js']['usersearch'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/ipokonto'): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.css">
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/amcharts.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/serial.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.min.js"></script>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['ipokonto'] : $tpl['js']['ipokonto'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/cryptopayments'): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.css">
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/amcharts.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/serial.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/amcharts/plugins/export/export.min.js"></script>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['trade'] : $tpl['js']['trade'],$this->mime,get_defined_vars(),0); ?>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['crypto'] : $tpl['js']['crypto'],$this->mime,get_defined_vars(),0); ?>
  <?php if ($USER['is_admin']) echo $this->render($MINIFIED_JS ? $tpl['min']['js']['usersearch'] : $tpl['js']['usersearch'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>
 
<?php if ($PATH=='/profile'): ?>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['profile'] : $tpl['js']['profile'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/subscribe'): ?>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['subscribe'] : $tpl['js']['subscribe'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/credits'): ?>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['credits'] : $tpl['js']['credits'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/admin/settings'): ?>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['settings'] : $tpl['js']['settings'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

<?php if ($PATH=='/admin/users'): ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.dataTables.css">
  <!--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">-->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <!--<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>-->
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/dataTables.buttons.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.html5.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.flash.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/datatables-buttons/buttons.print.min.js"></script>
  <?php echo $this->render($MINIFIED_JS ? $tpl['min']['js']['users'] : $tpl['js']['users'],$this->mime,get_defined_vars(),0); ?>
<?php endif; ?>

