<div class="ui middle aligned center aligned grid centered-container">
  <div class="column">
    <form id="form-signup" class="ui large form" method="POST" action="<?php echo $BASE; ?><?php echo $PATH; ?>">
      <div class="ui stacked segment">
        <h2 class="ui <?php echo $SITE['MAIN_COLOR']; ?> image header">
          <a class="ui image" href="<?php echo $BASE; ?>/"><img src="<?php echo $BASE; ?>/assets/images/logo-<?php echo $SITE['MAIN_COLOR']; ?>.png"></a>
          <div class="content">
            <?php echo $website['title']; ?>
            <div class="sub header"><?php echo $signup['form']['title']; ?></div>
          </div>
        </h2>
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="first_name" placeholder="<?php echo $signup['form']['first']['name']['placeholder']; ?>">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="last_name" placeholder="<?php echo $signup['form']['last']['name']['placeholder']; ?>">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="at icon"></i>
            <input type="text" name="email" placeholder="<?php echo $signup['form']['email']['placeholder']; ?>">
          </div>
        </div>
        <div class="two fields">
            <div class="field">
              <div class="ui left icon input">
                <i class="envelope icon"></i>
                <input type="text" name="street_nr" placeholder="<?php echo $signup['form']['street_nr']['placeholder']; ?>">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="envelope icon"></i>
                <input type="text" name="post_nr" placeholder="<?php echo $signup['form']['post_nr']['placeholder']; ?>">
              </div>
            </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="envelope icon"></i>
            <input type="text" name="town" placeholder="<?php echo $signup['form']['town']['placeholder']; ?>">
          </div>
        </div>
        <?php if ($SECURITY['TFA_ENABLED']): ?>
          <div class="field">
            <div class="ui left icon input">
              <i class="phone icon"></i>
              <input type="text" name="phone" placeholder="<?php echo $signup['form']['phone']['placeholder']; ?>">
            </div>
          </div>
        <?php endif; ?>
        <?php if (!$SITE['EMAIL_VERIFICATION']): ?>
          <div class="field">
            <div class="ui left icon input">
              <i class="key icon"></i>
              <input type="password" name="password" placeholder="<?php echo $signup['form']['password']['placeholder']; ?>">
            </div>
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="key icon"></i>
              <input type="password" name="password2" placeholder="<?php echo $signup['form']['password2']['placeholder']; ?>">
            </div>
          </div>
        <?php endif; ?>
        <?php if ($SECURITY['RECAPTCHA_ENABLED']): ?>
          <div class="g-recaptcha" data-sitekey="<?php echo $SECURITY['RECAPTCHA_PUBLIC_KEY']; ?>"></div>
        <?php endif; ?>
        <div class="ui fluid large <?php echo $SITE['MAIN_COLOR']; ?> submit button"><?php echo $signup['form']['submit']; ?></div>
      </div>
      <?php if ($SESSION['message']): ?>
        <div class="ui <?php echo $SESSION['message']['type']; ?> message">
          <i class="close icon"></i>
          <p><?php echo $this->raw($SESSION['message']['text']); ?></p>
        </div>
      <?php endif; ?>
      <div class="ui error message"></div>
      <?php if ($GET['ref']): ?>
        <input type="hidden" name="referrer" value="<?php echo $GET['ref']; ?>">
      <?php endif; ?>
    </form>
    <div class="ui message">
      <span><?php echo $signup['form']['have_account']; ?></span><a href="<?php echo $BASE; ?>/login"><?php echo $signup['form']['login']; ?></a>
    </div>
  </div>
</div>