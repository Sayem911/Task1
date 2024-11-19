<div class="ui container">
  <div class="left aligned sixteen wide column">
    <div class="column">
      <?php if ($SESSION['message']): ?>
        <div class="ui <?php echo $SESSION['message']['type']; ?> message">
          <i class="close icon"></i>
          <p><?php echo $this->raw($SESSION['message']['text']); ?></p>
        </div>
      <?php endif; ?>
      <?php if ($USER['identity_img'] != '' && $USER['approved']==0): ?>
        <div class="ui warning message">
          <i class="close icon"></i>
          <p><?php echo $this->raw($profile['identity']['approval_warn']); ?></p>
        </div>
      <?php endif; ?>
          
      <div class="ui piled segment">
      <span class="ui <?php echo $SITE['MAIN_COLOR']; ?> ribbon label"><i class="user icon"></i> <?php echo $profile['title']; ?>

      </span>
      </div>

      </div>
      <div class="ui piled segment">
        <form class="ui form" method="POST" action="<?php echo $BASE; ?><?php echo $PATH; ?>"  enctype="multipart/form-data">
          <div class="ui stackable two column grid">
            <div class="four wide column">
              <div class="field">
                <label><?php echo $profile['avatar']['title']; ?></label>
                <div id="profile-avatar">
                  <?php if ($USER['avatar']): ?>
                    
                      <img class="ui medium bordered image" src="<?php echo $BASE; ?>/files/avatars/<?php echo $USER['avatar']; ?>">
                    
                    <?php else: ?>
                      <img class="ui medium bordered image" src="<?php echo $BASE; ?>/assets/images/default_avatar.png">
                    
                  <?php endif; ?>
                </div>
                <div>
                  <input type="file" name="avatar">
                </div>
              </div>
            </div>
            <div class="twelve wide column">
              <div class="disabled field">
                <label><?php echo $profile['firstname']['title']; ?></label>
                <input type="text" name="" value="<?php echo $USER['first_name']; ?>">
              </div>
              <div class="disabled field">
                <label><?php echo $profile['lastname']['title']; ?></label>
                <input type="text" name="" value="<?php echo $USER['last_name']; ?>">
              </div>
              <div class="disabled field">
                <label><?php echo $profile['email']['title']; ?></label>
                <input type="text" name="email" value="<?php echo $USER['email']; ?>">
              </div>
              <div class="field">
                <label><?php echo $profile['phone']['title']; ?></label>
                <input type="text" name="phone" value="<?php echo $USER['phone']; ?>" placeholder="<?php echo $signup['form']['phone']['placeholder']; ?>">
              </div>
              <div class="field">
                <label><?php echo $profile['land_phone']['title']; ?></label>
                <input type="text" name="land_phone" value="<?php echo $USER['land_phone']; ?>" placeholder="<?php echo $signup['form']['land_phone']['placeholder']; ?>">
              </div>
              <div class="field">
                <label><?php echo $profile['fax']['title']; ?></label>
                <input type="text" name="fax" value="<?php echo $USER['fax']; ?>" placeholder="<?php echo $signup['form']['fax']['placeholder']; ?>">
              </div>
              <h5 class="ui dividing header"><?php echo $profile['address']['title']; ?></h4>
            <div class="two fields">
                <div class="field">
                  <div class="ui input">
                    <input type="text" name="street_nr" value="<?php echo $USER['street_nr']; ?>" placeholder="<?php echo $signup['form']['street_nr']['placeholder']; ?>">
                  </div>
                </div>
                <div class="field">
                  <div class="ui input">
                    <input type="text" name="post_nr" value="<?php echo $USER['post_nr']; ?>" placeholder="<?php echo $signup['form']['post_nr']['placeholder']; ?>">
                  </div>
                </div>
            </div>
            <div class="field">
              <div class="ui input">
                <input type="text" name="town" value="<?php echo $USER['town']; ?>" placeholder="<?php echo $signup['form']['town']['placeholder']; ?>">
              </div>
            </div>
              <div class="field">
                <label><?php echo $profile['timezone']['title']; ?></label>
                <select id="timezone-dropdown" class="ui search selection dropdown" name="timezone">
                </select>
              </div>
              <div class="field">
                <label><?php echo $profile['language']['title']; ?></label>
                <div class="ui fluid selection dropdown">
                  <input type="hidden" name="language" value="<?php echo $USER['language'] ? $USER['language'] : $SITE['LANGUAGE']; ?>">
                  <i class="dropdown icon"></i>
                  <div class="default text"><?php echo $profile['language']['dropdown']; ?></div>
                  <div class="menu">
                    <?php foreach (($vars['languages']?:array()) as $language): ?>
                      <div class="item" data-value="<?php echo $language; ?>"><i class="<?php echo str_replace('en','us',$language); ?> flag"></i><?php echo $language; ?></div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
              <div class="ui hidden divider"></div>
              <button class="ui submit <?php echo $SITE['MAIN_COLOR']; ?> right floated button" type="submit"><?php echo $profile['form']['save']; ?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
</div>
<br>



<div class="ui container">
  <div class="left aligned sixteen wide column">
    <div class="column">
<div class="ui piled segment">
      <h2 class="ui <?php echo $SITE['MAIN_COLOR']; ?> ribbon label"><?php echo $profile['identity']['title']; ?></h2>
      <div class="ui identity-upload segment">
        <?php switch ($USER['approved']): ?><?php case 0: ?>
                <form class="ui identity-form form" method="POST" data-action="upload" enctype="multipart/form-data">
                  <div class="ui error message"></div>
                  <div class="ui result message"></div>
                  <div class="ui stackable one column grid">
                      <div class="column">
                          <p><?php echo $profile['identity']['description']; ?></p>
                      </div>
                    <div class="column">
                      <div class="field">
                        <label><?php echo $profile['identity']['label']; ?></label>
                        
                        <div class="ui placeholder segment">
                          <div class="ui icon header">
                            <i class="pdf file outline icon"></i>
                            No documents are listed for this customer.
                          </div>
                          <input type="file" name="identity" class="ui primary button">
                        </div>
                    </div>
                    <div class="column">
                      <div class="ui hidden divider"></div>
                      <div class="ui submit <?php echo $SITE['MAIN_COLOR']; ?> right floated button"><?php echo $profile['identity']['upload']; ?></div>
                    </div>
                  </div>
                </form>
            <?php if (TRUE) break; ?><?php case 1: ?>
                <div class="ui column">
                <i class="info circle orange icon"></i> &nbsp; <?php echo $profile['identity']['awaiting']; ?> 
                <a href="files/ids/<?php echo $USER['identity_img']; ?>" target="_blank"><?php echo $profile['identity']['view_file']; ?></a>
                </div>
                <div></div>
            <?php if (TRUE) break; ?><?php case 2: ?>
                <div class="ui column">
                <i class="check green icon"></i> <?php echo $profile['identity']['approved']; ?>. &nbsp;
                <a href="files/ids/<?php echo $USER['identity_img']; ?>" target="_blank"><?php echo $profile['identity']['view_file']; ?></a>
                </div>
            <?php if (TRUE) break; ?><?php default: ?>
            message
            <?php break; ?><?php endswitch; ?>
      </div>
    </div>   
    </div> 
    </div> 
    </div> 
    </div> 