<!DOCTYPE html>
<html>
<head>
  <?php echo $this->render($tpl['meta'],$this->mime,get_defined_vars(),0); ?>
</head>
<body>
  <div class="full-screen-background">
    <?php echo $this->render($tpl['content'],$this->mime,get_defined_vars(),0); ?>
  </div>
  <?php echo $this->render($tpl['footer'],$this->mime,get_defined_vars(),0); ?>
</body>