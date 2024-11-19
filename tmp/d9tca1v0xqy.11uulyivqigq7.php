<div class="ui container">
  <div class="ui stackable one column grid">
    <?php if ($ADSENSE['CLIENT_ID'] && $ADSENSE['SLOT_ID']) echo $this->render($tpl['adsense'],$this->mime,get_defined_vars(),0); ?>
    <div class="column">
      <div class="ui piled segment">
      <span class="ui <?php echo $SITE['MAIN_COLOR']; ?> ribbon label"><i class="exchange icon"></i> <?php echo $title['transactions']; ?></span>
      </span>
      </div>

    </div>
    <div id="transactions-wrapper" class="column">
        <div class="ui hidden divider"></div>
        <?php if ($USER['is_admin']): ?>
          <div class="ui stackable grid">
            <div class="four column left row">
              <div class="column">
                <div class="ui fluid selection dropdown">
                    <div class="text"><?php echo $depot['transactions']['list']['option']; ?></div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                      <div class="item" data-value="all"><?php echo $depot['transactions']['list']['view']; ?></div>
                      <div class="item" data-value="search"><?php echo $depot['transactions']['list']['search']; ?></div>
                    </div>
                </div>
              </div>
              <div class="column">
                <div class="ui fluid user search" data-callback="refreshTransactionsList" data-user="<?php echo $USER['id']; ?>" data-balance="<?php echo $USER['balance']; ?>">
                  <div class="ui icon input">
                    <input class="prompt" type="text" value="<?php echo $USER['first_name'].' '.$USER['last_name']; ?>">
                    <i class="user icon"></i>
                  </div>
                  <div class="results"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="ui hidden divider"></div>
        <?php endif; ?>
        <?php if (!$USER['is_admin']): ?>
        <div class="ui piled segment">
            <button id="depot" class="ui purple basic button"><?php echo $depot['transactions']['list']['button']['title']; ?></button>
        </div>
        <form id="modal-depot" class="ui skip-submission-check form small action modal" enctype="multipart/form-data">
            <i class="close icon"></i>
            <div class="header">
              <?php echo $depot['transactions']['list']['button']['make']; ?>

            </div>
            <div class="content">
                <div class="ui error message"></div>
                <div class="ui result message"></div>
                <div class="two fields">
                    <div class="field">
                      <label for="amount"><?php echo $depot['transactions']['amount']; ?></label>
                      <div class="ui left icon right input">
                        <i class="euro icon"></i>
                        <input type="text" name="amount" value="">
                      </div>
                    </div>
                    <div class="field">
                      <label for="type"><?php echo $depot['transactions']['ticket']; ?></label>
                      <div class="ui left labeled input right input">
                        <div class="ui fluid selection dropdown">
                            <input type="hidden" name="type">
                            <i class="dropdown icon"></i>
                            <div class="default text"><?php echo $depot['transactions']['select']; ?></div>
                            <div class="menu">
                                <div class="item" data-value="0"><?php echo $depot['transactions']['disbursement']; ?></div>
                                <div class="item" data-value="1"><?php echo $depot['transactions']['einzahlung']; ?></div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                      <label for="date"><?php echo $depot['transactions']['datum']; ?></label>
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <input type="date" name="date" value="" placeholder="">
                            <i class="calendar icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <label for="time"><?php echo $depot['transactions']['zeit']; ?></label>
                      <div class="ui left labeled input right icon">
                        <input type="time" name="time" value="" placeholder="">
                        <i class="clock icon"></i>
                      </div>
                    </div>
                </div>
                <div class="field">
                    <label for="receipt_doc"><?php echo $depot['transactions']['dokument']['title']; ?></label>
                    <input type="file" id="receipt_doc" name="receipt_doc">
                </div>
                <div class="field">
                    <label for="notes"><?php echo $depot['transactions']['notes']; ?></label>
                    <textarea name="notes" rows="3">Empfänger: &#13;&#10;Iban: &#13;&#10;BIC: </textarea>
                </div>
            </div>
            <div class="actions">
                <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button">Anfrage <i class="checkmark icon"></i></div>
            </div>
        </form>
        <?php endif; ?>
        <?php if ($USER['is_admin']): ?>
          <form id="modal-depot-delete"  class="ui skip-submission-check form small modal" data-action="delete" action="/api/actions/depot/delete" method="post">
              <i class="close icon"></i>
              <div class="header">
                <?php echo $depot['transactions']['delete']; ?>

              </div>
              <div class="content">
                  <input type="hidden" name="depot_id" value="" />
                  <p><?php echo $depot['transactions']['delete']['sure']; ?></p>
              </div>
              <div class="actions">
                <div class="ui black deny button">
                  Nein
                </div>
                <div class="ui <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button">
                  Ja
                  <i class="checkmark icon"></i>
                </div>
              </div>
          </form>
            <form id="modal-depot-update" class="ui skip-submission-check form small action modal" data-action="update" action="/api/actions/depot/update"  method="post">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $depot['transactions']['request']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="depot_id" value="" />
                    <div class="two fields">
                        <div class="field">
                          <label for="amount"><?php echo $depot['transactions']['amount']; ?></label>
                          <div class="ui left icon right input disabled">
                            <i class="euro icon"></i>
                            <input type="text" name="amount" value="">
                          </div>
                        </div>
                        <div class="field">
                          <label for="type"><?php echo $depot['transactions']['ticket']; ?></label>
                          <div class="ui left input right icon disabled">
                            <input type="text" name="type" value="" />
                            <i class="dropdown icon"></i>
                          </div>
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="field">
                          <label for="date"><?php echo $depot['transactions']['datum']; ?></label>
                          <div class="ui calendar">
                            <div class="ui left labeled input right icon disabled">
                                <input type="date" name="date" value="" placeholder="" />
                                <i class="calendar icon"></i>
                            </div>
                          </div>
                        </div>
                        <div class="field">
                          <label for="time"><?php echo $depot['transactions']['zeit']; ?></label>
                          <div class="ui left labeled input right icon disabled">
                            <input type="time" name="time" value="" placeholder="" />
                            <i class="clock icon"></i>
                          </div>
                        </div>
                    </div>
                    <div class="field">
                        <label for="receipt_doc"><?php echo $depot['transactions']['dokument']; ?></label>
                        <div class="ui piled segment">
                            <a name="doc_path" href="" class="ui button centered" target="_blank"><?php echo $depot['transactions']['dokument']['view']; ?></a>
                        </div>
                    </div>
                    <div class="field">
                        <label for="notes"><?php echo $portfolio['anleihen']['notes']; ?></label>
                        <div class="ui input disabled">
                            <textarea name="notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="actions">
                    <div class="ui large revert right labeled icon revert button">Revert <i class="undo icon"></i></div>
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $depot['transactions']['save']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
        <?php endif; ?>
        <table id="transactions-list" class="ui sortable celled <?php echo $SITE['MAIN_COLOR']; ?> table">
          <thead>
          <tr>
            <th></th>
            <?php if ($USER['is_admin']): ?><th><?php echo $depot['transactions']['username']; ?></th><?php endif; ?>
            <th><?php echo $depot['transactions']['type']; ?></th>
            <th><?php echo $depot['transactions']['amount']; ?></th>
            <th><?php echo $depot['transactions']['date']; ?></th>
            <th><?php echo $depot['transactions']['time']; ?></th>
            <th><?php echo $depot['transactions']['document']; ?></th>
            <th><?php echo $depot['transactions']['approval_date']; ?></th>
            <?php if ($USER['is_admin']): ?><th class="right aligned"></th><?php endif; ?>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
    
    </div>


