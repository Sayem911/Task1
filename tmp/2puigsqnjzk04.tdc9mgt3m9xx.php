<div class="ui container">
  <div class="ui stackable one column grid">
    <?php if ($ADSENSE['CLIENT_ID'] && $ADSENSE['SLOT_ID']) echo $this->render($tpl['adsense'],$this->mime,get_defined_vars(),0); ?>
    <div class="column">
    <div class="ui piled segment">
      <span class="ui <?php echo $SITE['MAIN_COLOR']; ?> ribbon label"><i class="users icon"></i> <?php echo $title['users']; ?>

      </span>
      </div>
      
    </div>
    <div class="right aligned column">
      <button id="add-user" class="ui right labeled icon button"><i class="users icon"></i> <?php echo $users['add']['title']; ?></button>
      <div id="modal-add-user" class="ui small modal">
        <i class="close icon"></i>
        <div class="header">
          <?php echo $users['add']['title']; ?>

        </div>
        <div class="content">
          <form id="form-add-user" class="ui skip-submission-check form">
            <div class="ui error message"></div>
            <div class="ui result message"></div>
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
                <i class="mail icon"></i>
                <input type="text" name="email" placeholder="<?php echo $signup['form']['email']['placeholder']; ?>">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="phone icon"></i>
                <input type="text" name="phone" placeholder="<?php echo $signup['form']['phone']['placeholder']; ?>">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="fax icon"></i>
                <input type="text" name="fax" value="" placeholder="<?php echo $signup['form']['fax']['placeholder']; ?>">
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
            <div class="field">
              <div class="ui left icon right labeled input">
                <i class="euro icon"></i>
                <input type="text" name="balance" placeholder="<?php echo $users['add']['balance']['placeholder']; ?>">
                <div class="ui label"><?php echo $TRADE['ACCOUNT_CURRENCY']; ?></div>
              </div>
            </div>
            <?php if ($ADMIN['GENERATE_ACCOUNT_NUMBER']): ?>
              <div class="field">
                <div class="ui left icon input">
                  <i class="folder outline icon"></i>
                  <input type="text" name="account_number" placeholder="<?php echo $users['add']['account']['placeholder']; ?>">
                </div>
              </div>
            <?php endif; ?>
            <div class="field">
              <div class="ui checkbox">
                <input type="checkbox" tabindex="0" class="hidden" name="admin">
                <label><?php echo $users['add']['is_admin']; ?></label>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                <input type="checkbox" tabindex="0" class="hidden" name="g2fa_enabled">
                <label><?php echo $users['security']['gtfa']['title']; ?></label>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                <input type="checkbox" tabindex="0" class="hidden" name="welcome_email">
                <label><?php echo $users['add']['notification']; ?></label>
              </div>
            </div>
            <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> submit button"><?php echo $users['add']['submit']; ?></div>
          </form>
        </div>
      </div>
      <div id="modal-edit-user" class="ui small action modal">
        <i class="close icon"></i>
        <div class="header">
          <?php echo $users['edit']['title']; ?>

        </div>
        <div class="content">
            <div id="account-details-menu" class="ui pointing <?php echo $SITE['BACKGROUND']=='black'?'inverted':''; ?> <?php echo $SITE['MAIN_COLOR']; ?> menu">
                <a class="active item" data-tab="tab-details"><?php echo $users['tab']['details']; ?></a>
                <a class="item" data-tab="tab-identity"><?php echo $users['tab']['identify']['notes']; ?></a>
            </div>
            <div id="tab-details" class="ui active tab" data-tab="tab-details">
              <form class="ui skip-submission-check form" data-action="edit">
                <div class="ui error message"></div>
                <div class="ui result message"></div>
                <input type="hidden" name="id" value="">
                <div class="field">
                  <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" name="first_name" value="">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" name="last_name" value="">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="mail icon"></i>
                    <input type="email" name="email" value="">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="mobile alternate icon"></i>
                    <input type="text" name="phone" value="" placeholder="<?php echo $signup['form']['phone']['placeholder']; ?>">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="phone icon"></i>
                    <input type="text" name="land_phone" value="" placeholder="<?php echo $signup['form']['land_phone']['placeholder']; ?>">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="fax icon"></i>
                    <input type="text" name="fax" value="" placeholder="<?php echo $signup['form']['fax']['placeholder']; ?>">
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
                <div class="field">
                  <div class="ui left icon input">
                    <i class="key icon"></i>
                    <input type="password" name="password" placeholder="<?php echo $users['edit']['password']['placeholder']; ?>">
                  </div>
                </div>
                <div class="field">
                  <div class="ui checkbox blocked">
                    <input type="checkbox" tabindex="0" class="hidden" name="blocked" />
                    <label><?php echo $users['edit']['blocked']['title']; ?></label>
                  </div>
                </div>
                <div class="field">
                  <div class="ui checkbox g2fa-enabled">
                    <input type="checkbox" tabindex="0" class="hidden" name="g2fa_enabled" />
                    <label><?php echo $users['security']['gtfa']['title']; ?></label>
                  </div>
                </div>
                <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> submit button"><?php echo $users['add']['submit']; ?></div>
              </form>                
            </div>
            <div id="tab-identity" class="ui tab" data-tab="tab-identity">
                <div class="ui result message"></div>
                <div class="ui one column centered grid">
                    <form class="ui form identity-form row" data-action='approval'>
                        <div class="ui column identity-document center aligned">
                            <div class="column">
                                <a href="" title=""><img src="" width="400"></a>
                            </div>
                        </div>
                        <div class="ui column approval-buttons">
                            <div class="ui approve-button <?php echo $SITE['MAIN_COLOR']; ?> right floated primary button" data-id="" data-status="valid"><?php echo $profile['identity']['approve']; ?></div>
                            <div class="ui update-request-button <?php echo $SITE['MAIN_COLOR']; ?> left floated orange button" data-id="" data-status="renew"><?php echo $profile['identity']['request_update']; ?></div>
                        </div>
                        <div class="row approved-text">
                            <div class="column"><?php echo $profile['identity']['approved']; ?> <i class="check green icon"></i></div>
                        </div>
                    </form>
                    <div class="ui document-not-found centered column">
                        <div>
                            <h2><center><?php echo $profile['identity']['waiting_upload']; ?></center></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div id="modal-add-remove-funds" class="ui small action modal">
        <i class="close icon"></i>
        <div class="header">
          <?php echo $users['funds']['title']; ?>

        </div>
        <div class="content">
          <form class="ui skip-submission-check form" data-action="funds">
            <div class="ui error message"></div>
            <div class="ui result message"></div>
            <input type="hidden" name="id" value="">
            <div class="field">
              <div class="ui left icon right labeled input">
                <i class="euro icon"></i>
                <input type="text" name="amount" placeholder="0.00">
                <div class="ui label"></div>
              </div>
            </div>
            <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> submit button"><?php echo $users['funds']['submit']; ?></div>
          </form>
        </div>
      </div>
      <div id="modal-delete-user" class="ui small action modal">
        <i class="close icon"></i>
        <div class="header">
          <?php echo $users['delete']['title']; ?>

        </div>
        <div class="content">
          <p><?php echo $users['delete']['message']; ?></p>
          <form class="ui skip-submission-check form" data-action="delete">
            <div class="ui error message"></div>
            <div class="ui result message"></div>
            <input type="hidden" name="id" value="">
            <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> submit button"><?php echo $users['delete']['submit']; ?></div>
          </form>
        </div>
      </div>
    </div>
    <div class="column">
      <table id="users-list" class="ui selectable basic data table">
        <thead>
        <tr>
          <th></th>
          <th><?php echo $users['list']['name']; ?></th>
          <th><?php echo $users['list']['email']; ?></th>
          <th class="right aligned"><?php echo $users['list']['balance']; ?></th>
          <th class="right aligned"><?php echo $users['list']['trades_count']; ?></th>
          <th><?php echo $users['list']['created']; ?></th>
          <th><?php echo $users['list']['last_login']; ?></th>
          <th><?php echo $users['list']['ip']; ?></th>
        </tr>
        </thead>
        <tbody>
          <?php foreach (($vars['users']?:array()) as $user): ?>
            <tr class="<?php echo $user['blocked'] ? 'negative' : ''; ?>">
              <td class="users-actions">
                <div class="button-container">
                  <button class="ui basic circular icon edit-user button" data-id="<?php echo $user['id']; ?>" data-first-name="<?php echo $user['first_name']; ?>" data-last-name="<?php echo $user['last_name']; ?>" data-email="<?php echo $user['email']; ?>" data-phone="<?php echo $user['phone']; ?>" data-land-phone="<?php echo $user['land_phone']; ?>" data-fax="<?php echo $user['fax']; ?>" data-streetnr="<?php echo $user['street_nr']; ?>" data-postnr="<?php echo $user['post_nr']; ?>" data-town="<?php echo $user['town']; ?>" data-g2fa-enabled="<?php echo $user['g2fa_enabled']; ?>" data-blocked="<?php echo $user['blocked']; ?>" data-identity="<?php echo $user['identity_img']; ?>" data-status="<?php echo $user['approved']; ?>"><i class="pencil icon"></i></button>
                </div>
                <div class="button-container">
                  <button class="ui basic circular icon add-remove-funds button" data-id="<?php echo $user['id']; ?>" data-balance="<?php echo intval($user['balance']); ?>" data-currency="<?php echo $user['currency']; ?>"><i class="money icon"></i></button>
                </div>
                <div class="button-container">
                  <button class="ui basic circular icon delete-user button" data-id="<?php echo $user['id']; ?>"><i class="trash icon"></i></button>
                </div>
              </td>
              <td class="user-name" data-order="<?php echo $user['first_name'].' '.$user['last_name']; ?>">
                <div><img class="ui avatar image" src="<?php echo $user['avatar'] ? $BASE.'/files/avatars/'.$user['avatar'] : $BASE.'/assets/images/default_avatar.png'; ?>">
                    <b class="export-user-name"><?php echo $user['first_name'].' '.$user['last_name']; ?></b>
                    <?php switch ($user['approved']): ?><?php case 0: ?>
                            &nbsp; <i class="exclamation circle icon" title="<?php echo $profile['identity']['napproved_label']; ?>"></i>
                        <?php if (TRUE) break; ?><?php case 1: ?>
                            &nbsp; <i class="exclamation circle orange icon" title="<?php echo $profile['identity']['awaiting_label']; ?>"></i>
                        <?php if (TRUE) break; ?><?php case 2: ?>
                            &nbsp; <i class="check circle green icon" title="<?php echo $profile['identity']['approved_label']; ?>"></i>
                        <?php if (TRUE) break; ?><?php endswitch; ?>
                    <?php if ($user['is_admin']): ?>
                        <span class="ui small red label"><?php echo $users['list']['admin']; ?></span>
                    <?php endif; ?>
                  
                </div>
                <div class="ui divider"></div>
                <div>
                  <i class="grey hashtag icon"></i>&nbsp; <?php echo $user['account_number'] ? $user['account_number'] : $users['list']['empty']['value']; ?>

                </div>
                <div>
                  <i class="grey mobile alternate icon"></i>&nbsp; <?php echo $user['phone'] ? $user['phone'] : $users['list']['empty']['value']; ?>

                </div>
                <div>
                  <i class="grey language icon"></i>&nbsp; <?php echo $user['language'] ? $user['language'] : $users['list']['empty']['value']; ?>

                </div>
                <div>
                  <i class="grey world half icon"></i>&nbsp; <?php echo $user['timezone'] ? $user['timezone'] : $users['list']['empty']['value']; ?>

                </div>
                <?php if ($SUBSCRIPTION['SUBSCRIPTION_ENABLED']): ?>
                  <div>
                    <i class="grey paypal icon"></i>&nbsp; <?php echo $users['list']['subscription_paid_until']; ?> <?php echo $user['subscription_paid_until']; ?>

                  </div>
                <?php endif; ?>
              </td>
              <td><a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a></td>
              <td data-order="<?php echo $user['balance'],2; ?>" class="right aligned"><?php echo Helper::formatNumber($user['balance'],2).' '.$user['currency']; ?></td>
              <td data-order="<?php echo $user['trades_count']; ?>" class="right aligned"><?php echo Helper::formatNumber($user['trades_count']); ?></td>
              <td data-order="<?php echo strtotime($user['created']); ?>"><?php echo $user['created']; ?></td>
              <td data-order="<?php echo strtotime($user['last_login']); ?>"><?php echo $user['last_login']; ?></td>
              <td><?php echo $user['ip']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>