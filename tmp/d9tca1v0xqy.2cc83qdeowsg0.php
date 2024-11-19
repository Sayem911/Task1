<div class="ui container">
  <div class="ui stackable one column grid">
    <?php if ($ADSENSE['CLIENT_ID'] && $ADSENSE['SLOT_ID']) echo $this->render($tpl['adsense'],$this->mime,get_defined_vars(),0); ?>
    <div class="column">
    <div class="ui piled segment">
      <span class="ui <?php echo $SITE['MAIN_COLOR']; ?> ribbon label"><i class="bell icon"></i> <?php echo $title['signals']; ?></span>
      </span>
      </div>
    </div>
    <div id="transactions-wrapper" class="column">
        <div class="ui hidden divider"></div>
        <?php if ($USER['is_admin']): ?>
          <div class="ui stackable grid">
            <div class="four column left row">
              <div class="column">
                <div class="ui fluid user search" data-callback="refreshSignalsList" data-user="" data-balance="">
                  <div class="ui icon input">
                    <input class="prompt" type="text" value="" placeholder="<?php echo $signals['search']['placeholder']; ?>" />
                    <i class="user icon"></i>
                  </div>
                  <div class="results"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="ui hidden divider"></div>
            <form id="modal-signal-approve"  class="ui skip-submission-check form small modal" data-action="approve" action="/api/actions/signal/approve" method="post">
                <i class="close icon"></i>
                <div class="header">
                    <?php echo $signals['approve']['title']; ?>

                </div>
                <div class="content">
                    <input type="hidden" name="signal_id" value="" />
                    <p><?php echo $signals['approve']['description']; ?></p>
                </div>
                <div class="actions">
                    <div class="ui black deny button">
                      <?php echo $signals['approve']['no']['title']; ?>

                    </div>
                    <div class="ui <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button">
                      <?php echo $signals['approve']['yes']['title']; ?>

                      <i class="checkmark icon"></i>
                    </div>
                </div>
            </form>
        <?php endif; ?>
        <form id="modal-signal-delete"  class="ui skip-submission-check form small modal" data-action="delete" action="/api/actions/signal/delete" method="post">
            <i class="close icon"></i>
            <div class="header">
                <?php echo $signals['delete']['title']; ?>

            </div>
            <div class="content">
                <input type="hidden" name="signal_id" value="" />
                <p><?php echo $signals['delete']['description']; ?></p>
            </div>
            <div class="actions">
                <div class="ui black deny button">
                  <?php echo $signals['delete']['no']['title']; ?>

                </div>
                <div class="ui <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button">
                  <?php echo $signals['delete']['yes']['title']; ?>

                  <i class="checkmark icon"></i>
                </div>
            </div>
        </form>
        <table id="signals-list" class="ui sortable celled <?php echo $SITE['MAIN_COLOR']; ?> table">
          <thead>
          <tr>
            <th><?php echo $portfolio['signals']['ticketno']; ?></th>
            <th><?php echo $signals['date']; ?></th>
            <?php if ($USER['is_admin']): ?><th><?php echo $signals['username']; ?></th><?php endif; ?>
            <th><?php echo $signals['name']; ?></th>
            <th><?php echo $signals['purchase_price']; ?></th>
            <th><?php echo $signals['order_action']['title']; ?></th>
            <th><?php echo $signals['order_type']['title']; ?></th>
            <th><?php echo $signals['order_details']['title']; ?></th>
            <?php if (!$USER['is_admin']): ?><th class="left aligned">Status</th><?php endif; ?>
            <th class="right aligned"></th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
  </div>
</div>

