<div class="ui container">
  <div class="ui stackable one column grid">
    <?php if ($ADSENSE['CLIENT_ID'] && $ADSENSE['SLOT_ID']) echo $this->render($tpl['adsense'],$this->mime,get_defined_vars(),0); ?>
    <div class="column">
      <div class="ui piled segment">
      <span class="ui <?php echo $SITE['MAIN_COLOR']; ?> ribbon label"><i class="travel icon"></i> <?php echo $title['portfolio']; ?></span>
      </div>
    </div>
    <div class="column">
      <div id="portfolio-menu" class="ui pointing <?php echo $SITE['BACKGROUND']=='black'?'inverted':''; ?> <?php echo $SITE['MAIN_COLOR']; ?> menu">
        <a class="item active" data-tab="tab-funds"><?php echo $portfolio['menu']['funds']; ?></a>
        <a class="item" data-tab="tab-anleihen"><?php echo $portfolio['menu']['anleihen']; ?></a>
        <a class="item" data-tab="tab-trades"><?php echo $portfolio['menu']['trades']; ?></a>
        <a class="item" data-tab="tab-fonds"><?php echo $portfolio['menu']['fonds']; ?></a>

        <a class="item" data-tab="tab-fixed-deposit"><?php echo $portfolio['menu']['fixed_deposit']; ?></a>
      </div>
      <div class="ui hidden divider"></div>
      <div id="tab-positions" class="ui tab" data-tab="tab-positions">
        <?php if ($USER['is_admin']): ?>
          <div class="ui stackable grid">
            <div class="four column left row">
              <div class="column">
                <div class="ui fluid user search" data-callback="refreshPositionsList" data-user="<?php echo $USER['id']; ?>" data-balance="<?php echo $USER['balance']; ?>">
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
        <table id="positions-list" class="ui sortable celled <?php echo $SITE['MAIN_COLOR']; ?> table">
          <thead>
          <tr>
            <th class="left aligned"><?php echo $portfolio['positions']['symbol']; ?></th>
            <th class="left aligned"><?php echo $portfolio['positions']['name']; ?></th>
            <th class="center aligned"><?php echo $portfolio['positions']['quantity']; ?></th>
            <th class="center aligned"><?php echo $portfolio['positions']['lastprice']; ?></th>
            <th class="center aligned"><?php echo $portfolio['positions']['currency']; ?></th>
            <th class="center aligned"><?php echo $portfolio['positions']['fxrate']; ?></th>
            <th class="center aligned"><?php echo $portfolio['positions']['historicalcost']; ?></th>
            <th class="center aligned"><?php echo $portfolio['positions']['marketvalue']; ?></th>
            <th class="center aligned"><?php echo $portfolio['positions']['unrealizedpnl']; ?></th>
            <th class="center aligned"><?php echo $portfolio['positions']['unrealizedpnl']; ?></th>
          </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
          <tr>
            <th class="right aligned header" colspan="9"><?php echo $portfolio['positions']['totalhistoricalcost']; ?> <?php echo $USER['currency']; ?></th>
            <th id="total-historical-cost" class="center aligned"></th>
          </tr>
          <tr>
            <th class="right aligned header" colspan="9"><?php echo $portfolio['positions']['totalmarketvalue']; ?> <?php echo $USER['currency']; ?></th>
            <th id="total-market-value" class="center aligned"></th>
          </tr>
          <tr>
            <th class="right aligned header" colspan="9"><?php echo $portfolio['positions']['totalunrealizedpnl']; ?> <?php echo $USER['currency']; ?></th>
            <th id="total-unrealized-pnl" class="center aligned"></th>
          </tr>
          <tr>
            <th class="right aligned header" colspan="9"><?php echo $portfolio['positions']['totalcash']; ?> <?php echo $USER['currency']; ?></th>
            <th id="total-cash" class="center aligned" data-value="<?php echo $USER['balance']; ?>"></th>
          </tr>
          <tr>
            <th class="right aligned header" colspan="9"><?php echo $portfolio['positions']['netassets']; ?> <?php echo $USER['currency']; ?></th>
            <th id="net-assets" class="center aligned"></th> 
          </tr>
          </tfoot>
        </table>
        <div class="ui piled segment ignored info icon message">
      <i class="info circle icon"></i>
      <div class="content">
        <h3 class="header"><?php echo $portfolio['lock']['up']['title']; ?></h3>
        <p><?php echo $portfolio['lock']['up']['message']; ?></p>
      </div>
    </div>

      </div>

      <div id="tab-trades" class="ui tab" data-tab="tab-trades">
        <?php if ($USER['is_admin']): ?>
          <div class="ui stackable grid">
            <div class="four column left row">
              <div class="column">
                <div class="ui fluid user search" data-callback="refreshTradesList" data-user="<?php echo $USER['id']; ?>">
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
          <form id="modal-edit-portfolio" class="ui portfolio-form skip-submission-check form small action modal" method="post">
            <i class="close icon"></i>
            <div class="header">
              <?php echo $portfolio['trades']['edit']['title']; ?>

            </div>
            <div class="content">
                <div class="ui error message"></div>
                <div class="ui result message"></div>
                <input type="hidden" name="trade_id" value="">
                <input type="hidden" name="user_id" value="">
                <div class="field">
                  <div class="ui left labeled input right icon">
                    <div class="ui label"><?php echo $portfolio['trades']['price']; ?></div>
                    <input type="text" name="price" value="" placeholder="<?php echo $portfolio['trades']['price']; ?>">
                    <i class="euro icon"></i>
                  </div>
                </div>
                <div class="field">
                  <div class="ui left labeled input right input">
                    <div class="ui label"><?php echo $portfolio['trades']['quantity']; ?></div>
                    <input type="text" name="quantity" value="" placeholder="<?php echo $portfolio['trades']['quantity']; ?>">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left labeled input right icon">
                    <div class="ui label"><?php echo $portfolio['trades']['fxrate']; ?></div>
                    <input type="text" name="rate" value="" placeholder="<?php echo $portfolio['trades']['fxrate']; ?>">
                    <i class="percent icon"></i>
                  </div>
                </div>
                <div class="field">
                  <div class="ui left labeled input right icon">
                    <div class="ui label"><?php echo $portfolio['trades']['total']; ?></div>
                    <input type="text" name="total" value="" placeholder="<?php echo $portfolio['trades']['total']; ?>" />
                    <i class="euro icon"></i>
                  </div>
                </div>
                <div class="field">
                  <div class="ui calendar">
                    <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['trades']['startdate']; ?></div>
                        <input type="date" name="start_date" value="" placeholder="<?php echo $portfolio['trades']['startdate']; ?>" />
                        <i class="calendar icon"></i>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <div class="ui left labeled input right icon">
                      <div class="ui label"><?php echo $portfolio['trades']['enddate']; ?></div>
                    <input type="date" name="end_date" value="" placeholder="<?php echo $portfolio['trades']['enddate']; ?>">
                    <i class="calendar icon"></i>
                  </div>
                </div>
                <div class="field">
                  <div class="ui left labeled input right input">
                    <div class="ui label"><?php echo $portfolio['trades']['duration']; ?></div>
                    <input type="text" name="duration" value="" placeholder="<?php echo $portfolio['trades']['duration']; ?>">
                  </div>
                </div>
            </div>
            <div class="actions">
                <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $settings['form']['save']; ?> <i class="checkmark icon"></i></div>
            </div>
          </form>
            <form id="modal-delete-portfolio" class="ui skip-submission-check form small action modal" data-action="delete">
                <input type="hidden" name="id" value="">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['trades']['delete_title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <p><?php echo $portfolio['trades']['delete_message']; ?></p>
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $portfolio['trades']['delete_button']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>            
        <?php endif; ?>
        <table id="trades-list" class="ui sortable celled <?php echo $SITE['MAIN_COLOR']; ?> table">
          <thead>
          <tr>
            <th><?php echo $portfolio['trades']['symbol']; ?></th>
            <th><?php echo $portfolio['trades']['name']; ?></th>
            <th><?php echo $portfolio['trades']['action']; ?></th>
            <th class="center aligned"><?php echo $portfolio['trades']['quantity']; ?></th>
            <th class="center aligned"><?php echo $portfolio['trades']['price']; ?></th>
            <th class="center aligned"><?php echo $portfolio['trades']['fxrate']; ?></th>
            <th class="center aligned"><?php echo $portfolio['trades']['total']; ?></th>
            <th class="center aligned" style="display: none;"><?php echo $portfolio['trades']['startdate']; ?></th>
            <th class="center aligned"><?php echo $portfolio['trades']['enddate']; ?></th>
            <th class="center aligned" style="display: none;"><?php echo $portfolio['trades']['duration']; ?></th>
            <?php if ($USER['is_admin']): ?><th class="center aligned"></th><?php endif; ?>
          </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
          <tr>
            <th colspan="9">
              <div class="ui right floated small pagination menu">
                <a class="icon item" data-direction="prev">
                  <i class="left chevron icon"></i>
                </a>
                <span class="item counter">1</span>
                <a class="icon item" data-direction="next">
                  <i class="right chevron icon"></i>
                </a>
              </div>
            </th>
          </tr>
          </tfoot>
        </table>
        <div class="ui piled segment ignored info icon message">
      <i class="info circle icon"></i>
      <div class="content">
        <h3 class="header"><?php echo $portfolio['lock']['up']['title']; ?></h3>
        <p><?php echo $portfolio['lock']['up']['message']; ?></p>
      </div>
    </div>

      </div>
      <div id="tab-anleihen" class="ui tab" data-tab="tab-anleihen">
        <?php if ($USER['is_admin']): ?>
            <form id="modal-add-anleihen" name="anleihen-form" class="ui anleihen-form skip-submission-check form small action modal" method="post">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['add']['anleihen']['title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="<?php echo $USER['id']; ?>">
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label"><?php echo $portfolio['anleihen']['name']; ?></div>
                            <div class="ui fluid search selection dropdown" tabindex="-1">
                                <input type="hidden" name="symbol">
                                <i class="dropdown icon"></i>
                                <div class="default text"><?php echo $portfolio['anleihen']['select']; ?></div>
                                <div class="menu"></div>
                            </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label"><?php echo $portfolio['anleihen']['quantity']; ?></div>
                        <input type="text" tabindex="0" name="quantity" value="" placeholder="<?php echo $portfolio['anleihen']['quantity']; ?>" />
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['anleihen']['fxrate']; ?></div>
                        <i class="euro icon"></i>
                        <input type="text" name="fx_rate" value="" placeholder="<?php echo $portfolio['anleihen']['fxrate']; ?>" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon focus">
                        <div class="ui label"><?php echo $portfolio['anleihen']['price']; ?></div>
                        <input type="text" name="price" disabled value="" placeholder="<?php echo $portfolio['anleihen']['price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label"><?php echo $portfolio['anleihen']['startdate']; ?></div>
                            <input type="date" name="start_date" value="" placeholder="<?php echo $portfolio['anleihen']['startdate']; ?>" />
                            <i class="calendar icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['anleihen']['enddate']; ?></div>
                        <input type="date" name="end_date" value="" placeholder="<?php echo $portfolio['anleihen']['enddate']; ?>" />
                        <i class="calendar icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['anleihen']['current_fx']; ?></div>
                        <i class="percent icon"></i>
                        <input type="text" name="current_fx" value="" placeholder="<?php echo $portfolio['anleihen']['current_fx']; ?>" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['anleihen']['total']; ?><br><?php echo $USER['currency']; ?></div>
                        <input type="text" name="total" disabled value="" placeholder="<?php echo $portfolio['anleihen']['total']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['anleihen']['current_price']; ?> in <br><?php echo $USER['currency']; ?></div>
                        <input type="text" name="current_price" disabled value="" placeholder="<?php echo $portfolio['anleihen']['current_price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <h4 class="ui dividing header"><?php echo $portfolio['anleihen']['notes']; ?></h4>
                      <div class="ui input">
                        <textarea name="notes" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="interest-controls">
                        <div class="three fields">
                            <div class="fourteen wide field">
                                <h4 class="ui dividing header"><?php echo $portfolio['anleihen']['interest_date']; ?></h4>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini <?php echo $SITE['MAIN_COLOR']; ?> circular icon button add-interest" title="Adds an interest term to the end of the list">
                                <i class="plus icon"></i>
                              </div>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini <?php echo $SITE['MAIN_COLOR']; ?> circular icon button remove-interest" title="Removes the last interest term from the list except latest">
                                <i class="minus icon"></i>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="interest-container">
                        <div class="four fields interest-line">
                            <div class="twelve wide field">
                                <div class="ui right input left icon">
                                    <input type="date" name="interest_date" value="" placeholder="dd.mm.yyyy" />
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="twelve wide field">
                                <div class="ui right input left icon">
                                    <input type="text" name="interest_price" value="" placeholder="Price" />
                                    <i class="euro icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $settings['form']['save']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-edit-anleihen" name="anleihen-form" class="ui anleihen-form skip-submission-check form small action modal" post="/api/actions/anleihen/edit" method="post">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['edit']['anleihen']['title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="">
                    <input type="hidden" name="anleihen_id" value="">
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label"><?php echo $portfolio['anleihen']['name']; ?></div>
                            <div class="ui fluid search selection dropdown" tabindex="-1">
                                <input type="hidden" name="symbol">
                                <i class="dropdown icon"></i>
                                <div class="default text"><?php echo $portfolio['anleihen']['select']; ?></div>
                                <div class="menu"></div>
                            </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label"><?php echo $portfolio['anleihen']['quantity']; ?></div>
                        <input type="text" tabindex="0" name="quantity" value="" placeholder="<?php echo $portfolio['anleihen']['quantity']; ?>" />
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['anleihen']['fxrate']; ?></div>
                        <input type="text" name="fx_rate" value="" placeholder="<?php echo $portfolio['anleihen']['fxrate']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon focus">
                        <div class="ui label"><?php echo $portfolio['anleihen']['price']; ?></div>
                        <input type="text" name="price" disabled value="" placeholder="<?php echo $portfolio['anleihen']['price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label"><?php echo $portfolio['anleihen']['startdate']; ?></div>
                            <input type="date" name="start_date" value="" placeholder="<?php echo $portfolio['anleihen']['startdate']; ?>" />
                            <i class="calendar icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                          <div class="ui label"><?php echo $portfolio['anleihen']['enddate']; ?></div>
                        <input type="date" name="end_date" value="" placeholder="<?php echo $portfolio['anleihen']['enddate']; ?>" />
                        <i class="calendar icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['anleihen']['current_fx']; ?></div>
                        <input type="text" name="current_fx" value="" placeholder="<?php echo $portfolio['anleihen']['current_fx']; ?>" />
                        <i class="percent icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['anleihen']['total']; ?><br><?php echo $USER['currency']; ?></div>
                        <input type="text" name="total" disabled value="" placeholder="<?php echo $portfolio['anleihen']['total']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['anleihen']['current_price']; ?> in<br><?php echo $USER['currency']; ?></div>
                        <input type="text" name="current_price" disabled value="" placeholder="<?php echo $portfolio['anleihen']['current_price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <h4 class="ui dividing header"><?php echo $portfolio['anleihen']['notes']; ?></h4>
                      <div class="ui input">
                        <textarea name="notes" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="interest-controls">
                        <div class="three fields">
                            <div class="fourteen wide field">
                                <h4 class="ui dividing header"><?php echo $portfolio['anleihen']['interest_date']; ?></h4>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini <?php echo $SITE['MAIN_COLOR']; ?> circular icon button add-interest" title="Adds an interest term to the end of the list">
                                <i class="plus icon"></i>
                              </div>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini <?php echo $SITE['MAIN_COLOR']; ?> circular icon button remove-interest" title="Removes the last interest term from the list except latest">
                                <i class="minus icon"></i>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="interest-container">
                        <div class="four fields interest-line">
                            <div class="twelve wide field">
                                <div class="ui right input left icon">
                                    <input type="date" name="interest_date" value="" placeholder="dd.mm.yyyy" />
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="twelve wide field">
                                <div class="ui right input left icon">
                                    <input type="text" name="interest_price" value="" placeholder="Price" />
                                    <i class="euro icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $settings['form']['save']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-delete-anleihen" class="ui skip-submission-check form small action modal" data-action="delete">
                <input type="hidden" name="id" value="">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['anleihen']['delete_title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <p><?php echo $portfolio['anleihen']['delete_message']; ?></p>
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $portfolio['anleihen']['delete_button']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
            <div class="ui stackable grid">
                <div class="four column row">
                    <div class="center aligned column">
                        <div class="ui fluid anleihen user search" data-callback="refreshAnleihenList" data-user="<?php echo $USER['id']; ?>">
                            <div class="ui icon input">
                                <input class="prompt" type="text" value="<?php echo $USER['first_name'].' '.$USER['last_name']; ?>" />
                                <i class="user icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="right aligned column">
                        <button id="add-anleihen" class="ui <?php echo $SITE['MAIN_COLOR']; ?> labeled icon button"><i class="add icon"></i><?php echo $portfolio['anleihen']['add']; ?></button>
                    </div>                        
                </div>
            </div>
            <div class="ui hidden divider"></div>
        <?php endif; ?>
        <div id="modal-anleihen-notes" class="ui large action modal">
            <i class="close icon"></i>
            <div class="header">
              <?php echo $portfolio['anleihen']['notes']; ?>

            </div>
            <div class="content">
                <div class="notes-area"></div>
            </div>
            <div class="actions">
                <div class="ui <?php echo $SITE['MAIN_COLOR']; ?> cancel button"><?php echo $portfolio['anleihen']['close_button']; ?></i></div>
            </div>
        </div>
        <table id="anleihen-list" class="ui sortable celled <?php echo $SITE['MAIN_COLOR']; ?> table">
          <thead>
          <tr>
            <th><?php echo $portfolio['anleihen']['name']; ?></th>
            <th class="center aligned"><?php echo $portfolio['anleihen']['quantity']; ?></th>
            <th class="center aligned"><?php echo $portfolio['anleihen']['fxrate']; ?></th>
            <th class="center aligned"><?php echo $portfolio['anleihen']['price']; ?></th>
            <th class="center aligned"><?php echo $portfolio['anleihen']['startdate']; ?></th>
            <th class="center aligned"><?php echo $portfolio['anleihen']['enddate']; ?></th>
            <th class="center aligned"><?php echo $portfolio['anleihen']['current_fx']; ?></th>
            <th class="center aligned"><?php echo $portfolio['anleihen']['current_price']; ?> in <br><?php echo $USER['currency']; ?></th>
            <th class="center aligned"><?php echo $portfolio['anleihen']['interest_date']; ?></th>
            <?php if ($USER['is_admin']): ?><th class="center aligned"></th><?php endif; ?>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>


        </div>
      <!------- fonds ------->
      <div id="tab-fonds" class="ui tab" data-tab="tab-fonds">
        <?php if ($USER['is_admin']): ?>
            <form id="modal-add-fonds" name="fonds-form" class="ui fonds-form skip-submission-check form small action modal" method="post">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['add']['fonds']['title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="<?php echo $USER['id']; ?>">
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label"><?php echo $portfolio['fonds']['name']; ?></div>
                            <div class="ui fluid search selection dropdown" tabindex="-1">
                                <input type="hidden" name="symbol">
                                <i class="dropdown icon"></i>
                                <div class="default text"><?php echo $portfolio['fonds']['select']; ?></div>
                                <div class="menu"></div>
                            </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label"><?php echo $portfolio['fonds']['issuer']; ?></div>
                        <input type="text" tabindex="0" name="issuer" value="" placeholder="<?php echo $portfolio['fonds']['issuer']; ?>" />
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label"><?php echo $portfolio['fonds']['domicile']; ?></div>
                        <input type="text" name="domicile" value="" placeholder="<?php echo $portfolio['fonds']['domicile']; ?>" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon focus">
                        <div class="ui label"><?php echo $portfolio['fonds']['current_value']; ?></div>
                        <input type="text" name="current_value"  value="" placeholder="<?php echo $portfolio['fonds']['current_value']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fonds']['origin_value']; ?> in <br><?php echo $USER['currency']; ?></div>
                        <input type="text" name="origin_value" value="" placeholder="<?php echo $portfolio['fonds']['origin_value']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fonds']['profit_loss']; ?></div>
                        <i class="euro icon"></i>
                        <input type="text" name="profit_loss" value="" placeholder="<?php echo $portfolio['fonds']['profit_loss']; ?>" />
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fonds']['roi']; ?></div>
                        <i class="percent icon"></i>
                        <input type="text" name="roi" value="" placeholder="<?php echo $portfolio['fonds']['roi']; ?>" />
                      </div>
                    </div>
                    <div class="field">
                      <h4 class="ui dividing header"><?php echo $portfolio['fonds']['notes']; ?></h4>
                      <div class="ui input">
                        <textarea name="notes" rows="3"></textarea>
                      </div>
                    </div>
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $settings['form']['save']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-edit-fonds" name="fonds-form" class="ui fonds-form skip-submission-check form small action modal" post="/api/actions/fonds/edit" method="post">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['edit']['fonds']['title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="">
                    <input type="hidden" name="fonds_id" value="">
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label"><?php echo $portfolio['fonds']['name']; ?></div>
                            <div class="ui fluid search selection dropdown" tabindex="-1">
                                <input type="hidden" name="symbol">
                                <i class="dropdown icon"></i>
                                <div class="default text"><?php echo $portfolio['fonds']['select']; ?></div>
                                <div class="menu"></div>
                            </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label"><?php echo $portfolio['fonds']['issuer']; ?></div>
                        <input type="text" tabindex="0" name="issuer" value="" placeholder="<?php echo $portfolio['fonds']['issuer']; ?>" />
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label"><?php echo $portfolio['fonds']['domicile']; ?></div>
                        <input type="text" name="domicile" value="" placeholder="<?php echo $portfolio['fonds']['domicile']; ?>" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon focus">
                        <div class="ui label"><?php echo $portfolio['fonds']['current_value']; ?></div>
                        <input type="text" name="current_value"  value="" placeholder="<?php echo $portfolio['fonds']['current_value']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fonds']['origin_value']; ?> in<br><?php echo $USER['currency']; ?></div>
                        <input type="text" name="origin_value"  value="" placeholder="<?php echo $portfolio['fonds']['origin_value']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fonds']['profit_loss']; ?></div>
                        <input type="text" name="profit_loss" value="" placeholder="<?php echo $portfolio['fonds']['profit_loss']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fonds']['roi']; ?></div>
                        <input type="text" name="roi" value="" placeholder="<?php echo $portfolio['fonds']['roi']; ?>" />
                        <i class="percent icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <h4 class="ui dividing header"><?php echo $portfolio['fonds']['notes']; ?></h4>
                      <div class="ui input">
                        <textarea name="notes" rows="3"></textarea>
                      </div>
                    </div>
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $settings['form']['save']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-delete-fonds" class="ui skip-submission-check form small action modal" data-action="delete">
                <input type="hidden" name="id" value="">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['fonds']['delete_title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <p><?php echo $portfolio['fonds']['delete_message']; ?></p>
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $portfolio['fonds']['delete_button']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
            <div class="ui stackable grid">
                <div class="four column row">
                    <div class="center aligned column">
                        <div class="ui fluid fonds user search" data-callback="refreshFondsList" data-user="<?php echo $USER['id']; ?>">
                            <div class="ui icon input">
                                <input class="prompt" type="text" value="<?php echo $USER['first_name'].' '.$USER['last_name']; ?>" />
                                <i class="user icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="right aligned column">
                        <button id="add-fonds" class="ui <?php echo $SITE['MAIN_COLOR']; ?> labeled icon button"><i class="add icon"></i><?php echo $portfolio['fonds']['add']; ?></button>
                    </div>                        
                </div>
            </div>
            <div class="ui hidden divider"></div>
        <?php endif; ?>
        <div id="modal-fonds-notes" class="ui large action modal">
            <i class="close icon"></i>
            <div class="header">
              <?php echo $portfolio['fonds']['notes']; ?>

            </div>
            <div class="content">
                <div class="notes-area"></div>
            </div>
            <div class="actions">
                <div class="ui <?php echo $SITE['MAIN_COLOR']; ?> cancel button"><?php echo $portfolio['fonds']['close_button']; ?></i></div>
            </div>
        </div>
        <table id="fonds-list" class="ui sortable celled <?php echo $SITE['MAIN_COLOR']; ?> table">
          <thead>
          <tr>
            <th><?php echo $portfolio['fonds']['name']; ?></th>
            <th class="center aligned"><?php echo $portfolio['fonds']['issuer']; ?></th>
            <th class="center aligned"><?php echo $portfolio['fonds']['domicile']; ?></th>
            <th class="center aligned"><?php echo $portfolio['fonds']['current_value']; ?> in <br><?php echo $USER['currency']; ?></th>
            <th class="center aligned"><?php echo $portfolio['fonds']['origin_value']; ?> in <br><?php echo $USER['currency']; ?></th>
            <th class="center aligned"><?php echo $portfolio['fonds']['profit_loss']; ?></th>
            <th class="center aligned"><?php echo $portfolio['fonds']['roi']; ?></th>
            <?php if ($USER['is_admin']): ?><th class="center aligned"></th><?php endif; ?>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>


        </div>
      <!-- fonds -->
      <div id="tab-funds" class="ui active tab" data-tab="tab-funds">
        <?php if ($USER['is_admin']): ?>
            <form id="modal-add-fund" name="add-fund-form" class="ui add-fund-form skip-submission-check form small action modal" method="post">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['fund']['add_title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="<?php echo $USER['id']; ?>">
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label"><?php echo $portfolio['fund']['name']; ?></div>
                        <div class="ui fluid search selection dropdown" tabindex="-1">
                            <input type="hidden" name="symbol">
                            <i class="dropdown icon"></i>
                            <div class="default text"><?php echo $portfolio['fund']['select']; ?></div>
                            <div class="menu"></div>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label"><?php echo $portfolio['fund']['quantity']; ?></div>
                        <input type="text" name="quantity" value="" placeholder="<?php echo $portfolio['fund']['quantity']; ?>" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fund']['price']; ?></div>
                        <input type="text" name="price" value="" placeholder="<?php echo $portfolio['fund']['price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fund']['issue_price']; ?></div>
                        <input type="date" name="issue_price" value="" placeholder="<?php echo $portfolio['fund']['issue_price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fund']['current_price']; ?></div>
                        <input type="date" name="current_price" value="" placeholder="<?php echo $portfolio['fund']['current_price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fund']['total_price']; ?></div>
                        <input type="text" name="total_price" value="" placeholder="<?php echo $portfolio['fund']['total_price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                        <h5 class="ui dividing header"><?php echo $portfolio['fund']['notes']; ?></h5>
                        <div class="ui input">
                            <textarea name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="interest-controls">
                        <div class="three fields">
                            <div class="fourteen wide field">
                                <h4 class="ui dividing header"><?php echo $portfolio['fund']['interest_date']; ?></h4>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini <?php echo $SITE['MAIN_COLOR']; ?> circular icon button add-interest" title="Adds an interest term to the end of the list">
                                <i class="plus icon"></i>
                              </div>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini <?php echo $SITE['MAIN_COLOR']; ?> circular icon button remove-interest" title="Removes the last interest term from the list except latest">
                                <i class="minus icon"></i>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="interest-container">
                        <div class="four fields interest-line">
                            <div class="twelve wide field">
                                <div class="ui right input left icon">
                                    <input type="date" name="interest_date" value="" placeholder="dd.mm.yyyy" />
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="twelve wide field">
                                <div class="ui right input left icon">
                                    <input type="text" name="interest_price" value="" placeholder="Price" />
                                    <i class="euro icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $settings['form']['save']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-edit-fund" name="edit-fund-form" class="ui edit-fund-form skip-submission-check form small action modal" post="/api/actions/fund/edit" method="post">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['fund']['edit_title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="">
                    <input type="hidden" name="fund_id" value="">
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label"><?php echo $portfolio['fund']['name']; ?></div>
                        <div class="ui fluid search selection dropdown" tabindex="-1">
                            <input type="hidden" name="symbol">
                            <i class="dropdown icon"></i>
                            <div class="default text"><?php echo $portfolio['fund']['select']; ?></div>
                            <div class="menu"></div>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label"><?php echo $portfolio['fund']['quantity']; ?></div>
                        <input type="text" name="quantity" value="" placeholder="<?php echo $portfolio['fund']['quantity']; ?>" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fund']['price']; ?></div>
                        <input type="text" name="price" value="" placeholder="<?php echo $portfolio['anleihen']['price']; ?>" />
                        <i class="percent icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fund']['issue_price']; ?></div>
                        <input type="date" name="issue_price" value="" placeholder="<?php echo $portfolio['fund']['issue_price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fund']['current_price']; ?></div>
                        <input type="date" name="current_price" value="" placeholder="<?php echo $portfolio['fund']['current_price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fund']['total_price']; ?></div>
                        <input type="text" name="total_price" value="" placeholder="<?php echo $portfolio['fund']['total_price']; ?>" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                        <h5 class="ui dividing header"><?php echo $portfolio['fund']['notes']; ?></h5>
                        <div class="ui input">
                            <textarea name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="interest-controls">
                        <div class="three fields">
                            <div class="fourteen wide field">
                                <h4 class="ui dividing header"><?php echo $portfolio['fund']['interest_date']; ?></h4>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini <?php echo $SITE['MAIN_COLOR']; ?> circular icon button add-interest" title="Adds an interest term to the end of the list">
                                <i class="plus icon"></i>
                              </div>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini <?php echo $SITE['MAIN_COLOR']; ?> circular icon button remove-interest" title="Removes the last interest term from the list except latest">
                                <i class="minus icon"></i>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="interest-container">
                        <div class="four fields interest-line">
                            <div class="twelve wide field">
                                <div class="ui right input left icon">
                                    <input type="date" name="interest_date" value="" placeholder="dd.mm.yyyy" />
                                    <i class="calendar icon"></i>
                                </div>
                            </div>
                            <div class="twelve wide field">
                                <div class="ui right input left icon">
                                    <input type="text" name="interest_price" value="" placeholder="Price" />
                                    <i class="euro icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $settings['form']['save']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-delete-fund" class="ui skip-submission-check form small action modal" data-action="delete">
                <input type="hidden" name="id" value="">
                <i class="close icon"></i>
                <div class="header">
                    <?php echo $portfolio['fund']['delete_title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <p><?php echo $portfolio['fund']['delete_message']; ?></p>
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $portfolio['fund']['delete_button']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>            
            <div class="ui stackable grid">
                <div class="four column row">
                    <div class="center aligned column">
                        <div class="ui fluid funds user search" data-callback="refreshFundsList" data-user="<?php echo $USER['id']; ?>">
                            <div class="ui icon input">
                                <input class="prompt" type="text" value="<?php echo $USER['first_name'].' '.$USER['last_name']; ?>" />
                                <i class="user icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="right aligned column">
                        <button id="add-fund" class="ui <?php echo $SITE['MAIN_COLOR']; ?> labeled icon button"><i class="add icon"></i><?php echo $portfolio['fund']['add']; ?></button>
                    </div>                        
                </div>
            </div>
        <?php endif; ?>
            <div id="modal-funds-notes" class="ui large action modal">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['fixed_deposit']['notes']; ?>

                </div>
                <div class="content">
                    <div class="notes-area"></div>
                </div>
                <div class="actions">
                    <div class="ui <?php echo $SITE['MAIN_COLOR']; ?> cancel button"><?php echo $portfolio['fixed_deposit']['close_button']; ?></i></div>
                </div>
            </div>

            <table id="funds-list" class="ui sortable celled <?php echo $SITE['MAIN_COLOR']; ?> table">
              <thead>
              <tr>
                <th><?php echo $portfolio['fund']['name']; ?></th>
                <th class="center aligned"><?php echo $portfolio['fund']['quantity']; ?></th>
                <th class="center aligned"><?php echo $portfolio['fund']['price']; ?></th>
                <th class="center aligned"><?php echo $portfolio['fund']['issue_price']; ?></th>
                <th class="center aligned"><?php echo $portfolio['fund']['current_price']; ?></th>
                <th class="center aligned"><?php echo $portfolio['fund']['total_price']; ?> <br><?php echo $USER['currency']; ?></th>
                <th class="center aligned"><?php echo $portfolio['fund']['interest_date']; ?></th>
                <?php if ($USER['is_admin']): ?><th class="center aligned"></th><?php endif; ?>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

        </div>
      <div id="tab-fixed-deposit" class="ui tab" data-tab="tab-fixed-deposit">
        <?php if ($USER['is_admin']): ?>
            <form id="modal-add-fixed-deposit" name="add-fixed-deposit-form" class="ui add-fixed-deposit-form skip-submission-check form small action modal" method="post">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['fixed_deposit']['add_title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="<?php echo $USER['id']; ?>">
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label"><?php echo $portfolio['fixed_deposit']['name']; ?></div>
                        <div class="ui fluid search selection dropdown" tabindex="-1">
                            <input type="hidden" name="symbol">
                            <i class="dropdown icon"></i>
                            <div class="default text"><?php echo $portfolio['fixed_deposit']['select']; ?></div>
                            <div class="menu"></div>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input">
                            <div class="ui label"><?php echo $portfolio['fixed_deposit']['amount']; ?></div>
                            <input type="text" name="amount" value="" placeholder="<?php echo $portfolio['fixed_deposit']['amount']; ?>" />
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label"><?php echo $portfolio['fixed_deposit']['interest_rate']; ?></div>
                            <input type="text" name="interest_rate" value="" placeholder="<?php echo $portfolio['fixed_deposit']['interest_rate']; ?>" />
                            <i class="euro icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fixed_deposit']['total']; ?></div>
                        <input type="text" name="total" value="" placeholder="<?php echo $portfolio['fixed_deposit']['total']; ?>" disabled  />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fixed_deposit']['notes']; ?></div>
                        <input type="text" name="notes" value="" placeholder="<?php echo $portfolio['fixed_deposit']['notes']; ?>" />
                        <i class="text icon"></i>
                      </div>
                    </div>
                    <!--
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label"><?php echo $portfolio['fixed_deposit']['building']; ?></div>
                            <input type="text" name="building" value="" placeholder="<?php echo $portfolio['fixed_deposit']['building']; ?>" />
                            <i class="percent icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label"><?php echo $portfolio['fixed_deposit']['totalvalue']; ?></div>
                            <input type="text" name="totalvalue" value="" placeholder="<?php echo $portfolio['fixed_deposit']['totalvalue']; ?>" disabled />
                            <i class="euro icon"></i>
                        </div>
                      </div>
                    </div>
                    -->
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $settings['form']['save']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-edit-fixed-deposit" name="edit-fixed-deposit-form" class="ui edit-fixed-deposit-form skip-submission-check form small action modal" post="/api/actions/deposit/edit" method="post">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['fixed_deposit']['edit_title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="">
                    <input type="hidden" name="deposit_id" value="">
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label"><?php echo $portfolio['fixed_deposit']['name']; ?></div>
                        <div class="ui fluid search selection dropdown" tabindex="-1">
                            <input type="hidden" name="symbol">
                            <i class="dropdown icon"></i>
                            <div class="default text"><?php echo $portfolio['fixed_deposit']['select']; ?></div>
                            <div class="menu"></div>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input">
                            <div class="ui label"><?php echo $portfolio['fixed_deposit']['amount']; ?></div>
                            <input type="text" name="amount" value="" placeholder="<?php echo $portfolio['fixed_deposit']['amount']; ?>"  />
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label"><?php echo $portfolio['fixed_deposit']['interest_rate']; ?></div>
                            <input type="text" name="interest_rate" value="" placeholder="<?php echo $portfolio['fixed_deposit']['interest_rate']; ?>" />
                            <i class="euro icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fixed_deposit']['total']; ?></div>
                        <input type="text" name="total" value="" placeholder="<?php echo $portfolio['fixed_deposit']['total']; ?>" disabled />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label"><?php echo $portfolio['fixed_deposit']['notes']; ?></div>
                        <input type="text" name="notes" value="" placeholder="<?php echo $portfolio['fixed_deposit']['notes']; ?>" />
                        <i class="text icon"></i>
                      </div>
                    </div>
                    <!--
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label"><?php echo $portfolio['fixed_deposit']['building']; ?></div>
                            <input type="text" name="building" value="" placeholder="<?php echo $portfolio['fixed_deposit']['building']; ?>" />
                            <i class="percent icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                          <div class="ui label"><?php echo $portfolio['fixed_deposit']['totalvalue']; ?></div>
                        <input type="text" name="totalvalue" value="" placeholder="<?php echo $portfolio['fixed_deposit']['totalvalue']; ?>" disabled />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    -->
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $settings['form']['save']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-delete-fixed-deposit" name="delete-fixed-deposit" class="ui skip-submission-check form small action modal" data-action="delete">
                <input type="hidden" name="id" value="">
                <i class="close icon"></i>
                <div class="header">
                    <?php echo $portfolio['fixed_deposit']['delete_title']; ?>

                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <p><?php echo $portfolio['fixed_deposit']['delete_message']; ?></p>
                </div>
                <div class="actions">
                    <div class="ui large <?php echo $SITE['MAIN_COLOR']; ?> right labeled icon submit button"><?php echo $portfolio['fixed_deposit']['delete_button']; ?> <i class="checkmark icon"></i></div>
                </div>
            </form>            
            <div class="ui stackable grid">
                <div class="four column row">
                    <div class="center aligned column">
                        <div class="ui fluid fixed-deposit user search" data-callback="refreshFixedDepositList" data-user="<?php echo $USER['id']; ?>">
                            <div class="ui icon input">
                                <input class="prompt" type="text" value="<?php echo $USER['first_name'].' '.$USER['last_name']; ?>" />
                                <i class="user icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="right aligned column">
                        <button id="add-fixed-deposit" class="ui <?php echo $SITE['MAIN_COLOR']; ?> labeled icon button"><i class="add icon"></i><?php echo $portfolio['fixed_deposit']['add']; ?></button>
                    </div>                        
                </div>
            </div>
        <?php endif; ?>
            <div id="modal-fixed-notes" class="ui large action modal">
                <i class="close icon"></i>
                <div class="header">
                  <?php echo $portfolio['fixed_deposit']['notes']; ?>

                </div>
                <div class="content">
                    <div class="notes-area"></div>
                </div>
                <div class="actions">
                    <div class="ui <?php echo $SITE['MAIN_COLOR']; ?> cancel button"><?php echo $portfolio['fixed_deposit']['close_button']; ?></i></div>
                </div>
            </div>
        
            <table id="fixed-deposit-list" class="ui sortable celled <?php echo $SITE['MAIN_COLOR']; ?> table">
              <thead>
              <tr>
                <th><?php echo $portfolio['fixed_deposit']['name']; ?></th>
                <th class="center aligned"><?php echo $portfolio['fixed_deposit']['amount']; ?></th>
                <th class="center aligned"><?php echo $portfolio['fixed_deposit']['interest_rate']; ?> €</th>
                <th class="center aligned"><?php echo $portfolio['fixed_deposit']['total']; ?> €</th>
                <th class="center aligned"><?php echo $portfolio['fixed_deposit']['notes']; ?> </th>
                <!--
                <th class="center aligned"><?php echo $portfolio['fixed_deposit']['building']; ?> %</th>
                <th class="center aligned"><?php echo $portfolio['fixed_deposit']['totalvalue']; ?> €</th>
                -->
                <?php if ($USER['is_admin']): ?><th class="center aligned"></th><?php endif; ?>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        
    <div class="ui piled segment ignored info icon message">
      <i class="info circle icon"></i>
      <div class="content">
        <h3 class="header"><?php echo $portfolio['lock']['up']['title']; ?></h3>
        <p><?php echo $portfolio['lock']['up']['message']; ?></p>
      </div>
    </div>
        
      </div>
    </div>
  </div>
</div>

