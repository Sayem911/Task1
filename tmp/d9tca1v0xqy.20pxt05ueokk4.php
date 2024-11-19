<!DOCTYPE html>
<html>
<head>
  <?php echo $this->render($tpl['meta'],$this->mime,get_defined_vars(),0); ?>
</head>
<body class="<?php echo $SITE['BACKGROUND']; ?>-background">
  <?php echo $this->render($tpl['header'],$this->mime,get_defined_vars(),0); ?>
  <div id="content-container">
    <?php echo $this->render($tpl['content'],$this->mime,get_defined_vars(),0); ?>
  </div>
  <?php echo $this->render($tpl['footer'],$this->mime,get_defined_vars(),0); ?>
</body>