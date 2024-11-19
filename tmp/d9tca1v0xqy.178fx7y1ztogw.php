<div id="main-menu" class="ui <?php echo $SITE['MAIN_COLOR']; ?> borderless blue inverted secondary menu">
  <div class="ui container">
    <a class="<?php echo $PATH=='/markets' ? 'active' : ''; ?> item" href="<?php echo $BASE; ?>/markets"><i class="line chart icon"></i><?php echo $website['menu']['markets']; ?></a>
    <a class="<?php echo $PATH=='/trade' ? 'active' : ''; ?> item" href="<?php echo $BASE; ?>/trade"><i class="money icon"></i><?php echo $website['menu']['trade']; ?></a>
    <a class="<?php echo $PATH=='/portfolio' ? 'active' : ''; ?> item" href="<?php echo $BASE; ?>/portfolio"><i class="travel icon"></i><?php echo $website['menu']['portfolio']; ?></a>
    <a class="<?php echo $PATH=='/offers' ? 'active' : ''; ?> item" href="<?php echo $BASE; ?>/offers"><i class="bell icon"></i><?php echo $website['menu']['offers']; ?></a>

            <div class="right menu">
              <div class="ui inline top right secondary dropdown">
                <div class="item">
                 <div class="ui sub header">
                  <div class="ui large celled list">
                 <div class="ui left labeled button" tabindex="0">
                      <span class="ui basic label">
                        <?php echo $USER['first_name']; ?> <?php echo $USER['last_name']; ?>

                      </span>
                      <div class="ui icon button">
                        <i class="angle double down icon"></i>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu">
            
            <div class="avatar-image">
          <?php if ($USER['avatar']): ?>
            
              <center><img class="ui small bordered image" src="<?php echo $BASE; ?>/files/avatars/<?php echo $USER['avatar']; ?>"></center>
            
            <?php else: ?>
              <center><img class="ui small bordered image" src="<?php echo $BASE; ?>/assets/images/default_avatar.png"></center>
            
          <?php endif; ?>
        </div>

          <?php if ($ADMIN['GENERATE_ACCOUNT_NUMBER'] && $USER['account_number']): ?>
            <div class="header">
                <div class="ui buttons">
                  <button class="ui <?php echo $SITE['MAIN_COLOR']; ?> button"><?php echo $profile['account_number']['title']; ?></button>
                  <button class="ui grey button"><?php echo $USER['account_number']; ?></button>
                </div>
            </div>
          <?php endif; ?>

          <?php if ($ADMIN['GENERATE_ACCOUNT_NUMBER'] && $USER['account_number']): ?>
            <div class="header">
                <div class="ui labeled button" tabindex="0">
                  <div class="ui <?php echo $SITE['MAIN_COLOR']; ?> button">
                    <?php echo $portfolio['trades']['balance']; ?>

                  </div>
                  <a class="ui basic <?php echo $SITE['MAIN_COLOR']; ?> left pointing label">
                    <?php echo Helper::formatNumber($USER['balance'],2); ?> <?php echo $USER['currency']; ?>

                  </a>
                </div>
            </div>
          <?php endif; ?>
          <a class="item" href="<?php echo $BASE; ?>/profile">
            <i class="user icon"></i><?php echo $website['menu']['profile']; ?>

          </a>
          <?php if ($SUBSCRIPTION['SUBSCRIPTION_ENABLED'] && !$USER['is_admin']): ?>
            <a class="item" href="<?php echo $BASE; ?>/subscribe">
              <i class="payment icon"></i><?php echo $website['menu']['subscription']; ?>

            </a>
          <?php endif; ?>
          <?php if ($CREDITS['ENABLED']): ?>
            <a class="item" href="<?php echo $BASE; ?>/credits">
              <i class="shop icon"></i><?php echo $website['menu']['credits']; ?>

            </a>
          <?php endif; ?>
          <?php if ($REFERRALS['ENABLED']): ?>
            <a class="item" href="<?php echo $BASE; ?>/invite">
              <i class="send outline icon"></i><?php echo $website['menu']['invite']; ?>

            </a>
          <?php endif; ?>
          <?php if ($USER['is_admin']): ?>
            <a class="item" href="<?php echo $BASE; ?>/admin/settings">
              <i class="settings icon"></i><?php echo $website['menu']['settings']; ?>

            </a>
            <a class="item" href="<?php echo $BASE; ?>/admin/users">
              <i class="users icon"></i><?php echo $website['menu']['users']; ?>

            </a>
          <?php endif; ?>
          <a class="item" href="<?php echo $BASE; ?>/password-update">
            <i class="key icon"></i><?php echo $website['menu']['password']; ?>

          </a>
          <a class="item" href="<?php echo $BASE; ?>/logout">
            <i class="sign out icon"></i><?php echo $website['menu']['logout']; ?>

          </a>
        </div>
      </div>
    </div>
  </div>
</div>
