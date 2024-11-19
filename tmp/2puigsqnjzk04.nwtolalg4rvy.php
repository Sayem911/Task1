<div class="ui container">
  <div class="center aligned sixteen wide column">
    <div class="twelve wide column">
      <?php if ($SESSION['message']): ?>
        <div class="ui <?php echo $SESSION['message']['type']; ?> message">
          <i class="close icon"></i>
          <p><?php echo $this->raw($SESSION['message']['text']); ?></p>
        </div>
      <?php endif; ?>
      <div class="ui piled segment">
      <span class="ui <?php echo $SITE['MAIN_COLOR']; ?> ribbon label"><i class="key icon"></i> <?php echo $password['update']['form']['title']; ?>

      </span>
      </div>
      
      <div class="ui piled segment">
        <form class="ui form" method="POST" action="<?php echo $BASE; ?><?php echo $PATH; ?>">
          <div class="ui stackable two column grid">
            <div class="column">
              <div class="field">
                <label><?php echo $password['update']['form']['old_password']['placeholder']; ?></label>
                <input type="password" name="old_password" placeholder="<?php echo $password['update']['form']['old_password']['placeholder']; ?>">
              </div>
            </div>
            <div class="column">
              <div class="field">
                <label><?php echo $password['update']['form']['new_password']['placeholder']; ?></label>
                <input type="password" name="new_password" placeholder="<?php echo $password['update']['form']['new_password']['placeholder']; ?>">
              </div>
              <div class="field">
                <label><?php echo $password['update']['form']['new_password2']['placeholder']; ?></label>
                <input type="password" name="new_password2" placeholder="<?php echo $password['update']['form']['new_password2']['placeholder']; ?>">
              </div>
              <div class="ui hidden divider"></div>
              <button class="ui submit <?php echo $SITE['MAIN_COLOR']; ?> right floated button" type="submit"><?php echo $profile['form']['save']; ?></button>
            </div>
          </div>
          <div class="ui error message"></div>
        </form>
      </div>
    </div>
  </div>
</div>