<div class="ui middle aligned center aligned grid centered-container">
  <div class="column">
    <form id="form-login" class="ui large form" style="opacity:65%;" method="POST" action="<?php echo $BASE; ?><?php echo $PATH; ?>">
      <div class="ui stacked segment">
        <h2 class="ui <?php echo $SITE['MAIN_COLOR']; ?> image header">
          <center><a class="ui image" style="background-color: rgb(255,255,255);padding-top: 4px;" href="<?php echo $BASE; ?>/"><img src="<?php echo $BASE; ?>/assets/images/logo-zinsfox.png" style="max-width: 80%;"></a></center>
          <div class="content" style="padding-top: 14px;">
            <div class="sub header"><?php echo $login['form']['title']; ?></div>
          </div>
        </h2>
        <div class="field">
          <div class="ui left icon input">
            <i class="mail icon"></i>
            <input type="text" name="email" placeholder="<?php echo $login['form']['email']['placeholder']; ?>">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="key icon"></i>
            <input type="password" name="password" placeholder="<?php echo $login['form']['password']['placeholder']; ?>">
          </div>
        </div>
        <button type="submit" class="ui fluid large <?php echo $SITE['MAIN_COLOR']; ?> submit button"><?php echo $login['form']['submit']; ?></button>
        <p></p>
        <p><i class="lock icon"></i> <?php echo $login['text']['msg']; ?></p>
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