<div class="ui middle aligned center aligned grid centered-container">
  <div class="column">
    <form id="form-password-recovery" class="ui large form" method="POST" action="<?php echo $BASE; ?><?php echo $PATH; ?>">
      <div class="ui stacked segment">
        <h2 class="ui <?php echo $SITE['MAIN_COLOR']; ?> image header">
          <a class="ui image" href="<?php echo $BASE; ?>/"><img src="<?php echo $BASE; ?>/assets/images/logo-<?php echo $SITE['MAIN_COLOR']; ?>.png"></a>
          <div class="content">
            <?php echo $website['title']; ?>
            <div class="sub header"><?php echo $password['form']['title']; ?></div>
          </div>
        </h2>
        <div class="field">
          <div class="ui left icon input">
            <i class="mail icon"></i>
            <input type="text" name="email" placeholder="<?php echo $password['form']['email']['placeholder']; ?>">
          </div>
        </div>
        <div class="ui fluid large <?php echo $SITE['MAIN_COLOR']; ?> submit button"><?php echo $password['form']['submit']; ?></div>
      </div>
      <?php if ($SESSION['message']): ?>
        <div class="ui <?php echo $SESSION['message']['type']; ?> message">
          <i class="close icon"></i>
          <p><?php echo $this->raw($SESSION['message']['text']); ?></p>
        </div>
      <?php endif; ?>
      <div class="ui error message"></div>
    </form>
  </div>
</div>