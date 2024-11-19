<div class="ui container">
  <div class="ui stackable one column grid">
    <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
    <div class="column">
      <div class="ui piled segment">
      <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="travel icon"></i> {{ @title.portfolio }}</span>
      </div>
    </div>
    <div class="column">
      <div id="portfolio-menu" class="ui pointing {{ @SITE.BACKGROUND=='black'?'inverted':'' }} {{ @SITE.MAIN_COLOR }} menu">
        <a class="item active" data-tab="tab-funds">{{ @portfolio.menu.funds }}</a>
        <a class="item" data-tab="tab-anleihen">{{ @portfolio.menu.anleihen }}</a>
        <a class="item" data-tab="tab-trades">{{ @portfolio.menu.trades }}</a>
        <a class="item" data-tab="tab-fonds">{{ @portfolio.menu.fonds }}</a>
        <?php /*
        <a class="item" data-tab="tab-positions">{{ @portfolio.menu.positions }}</a>
        <a class="item" data-tab="tab-positions">{{ @portfolio.menu.commodities }}</a>
        
        <a class="item" data-tab="tab-fixed-deposit">{{ @portfolio.menu.fixed_deposit }}</a>
        */ ?>
      </div>
      <div class="ui hidden divider"></div>
      <div id="tab-positions" class="ui tab" data-tab="tab-positions">
        <check if="{{ @USER.is_admin }}">
          <div class="ui stackable grid">
            <div class="four column left row">
              <div class="column">
                <div class="ui fluid user search" data-callback="refreshPositionsList" data-user="{{ @USER.id }}" data-balance="{{ @USER.balance }}">
                  <div class="ui icon input">
                    <input class="prompt" type="text" value="{{ @USER.first_name.' '.@USER.last_name }}">
                    <i class="user icon"></i>
                  </div>
                  <div class="results"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="ui hidden divider"></div>
        </check>
        <table id="positions-list" class="ui sortable celled {{ @SITE.MAIN_COLOR }} table">
          <thead>
          <tr>
            <th class="left aligned">{{ @portfolio.positions.symbol }}</th>
            <th class="left aligned">{{ @portfolio.positions.name }}</th>
            <th class="center aligned">{{ @portfolio.positions.quantity }}</th>
            <th class="center aligned">{{ @portfolio.positions.lastprice }}</th>
            <th class="center aligned">{{ @portfolio.positions.currency }}</th>
            <th class="center aligned">{{ @portfolio.positions.fxrate }}</th>
            <th class="center aligned">{{ @portfolio.positions.historicalcost }}</th>
            <th class="center aligned">{{ @portfolio.positions.marketvalue }}</th>
            <th class="center aligned">{{ @portfolio.positions.unrealizedpnl }}</th>
            <th class="center aligned">{{ @portfolio.positions.unrealizedpnl }}</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
          <tr>
            <th class="right aligned header" colspan="9">{{ @portfolio.positions.totalhistoricalcost }} {{ @USER.currency }}</th>
            <th id="total-historical-cost" class="center aligned"></th>
          </tr>
          <tr>
            <th class="right aligned header" colspan="9">{{ @portfolio.positions.totalmarketvalue }} {{ @USER.currency }}</th>
            <th id="total-market-value" class="center aligned"></th>
          </tr>
          <tr>
            <th class="right aligned header" colspan="9">{{ @portfolio.positions.totalunrealizedpnl }} {{ @USER.currency }}</th>
            <th id="total-unrealized-pnl" class="center aligned"></th>
          </tr>
          <tr>
            <th class="right aligned header" colspan="9">{{ @portfolio.positions.totalcash }} {{ @USER.currency }}</th>
            <th id="total-cash" class="center aligned" data-value="{{ @USER.balance }}"></th>
          </tr>
          <tr>
            <th class="right aligned header" colspan="9">{{ @portfolio.positions.netassets }} {{ @USER.currency }}</th>
            <th id="net-assets" class="center aligned"></th> 
          </tr>
          </tfoot>
        </table>
        <div class="ui piled segment ignored info icon message">
      <i class="info circle icon"></i>
      <div class="content">
        <h3 class="header">{{ @portfolio.lock.up.title }}</h3>
        <p>{{ @portfolio.lock.up.message }}</p>
      </div>
    </div>

      </div>

      <div id="tab-trades" class="ui tab" data-tab="tab-trades">
        <check if="{{ @USER.is_admin }}">
          <div class="ui stackable grid">
            <div class="four column left row">
              <div class="column">
                <div class="ui fluid user search" data-callback="refreshTradesList" data-user="{{ @USER.id }}">
                  <div class="ui icon input">
                    <input class="prompt" type="text" value="{{ @USER.first_name.' '.@USER.last_name }}">
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
              {{ @portfolio.trades.edit.title }}
            </div>
            <div class="content">
                <div class="ui error message"></div>
                <div class="ui result message"></div>
                <input type="hidden" name="trade_id" value="">
                <input type="hidden" name="user_id" value="">
                <div class="field">
                  <div class="ui left labeled input right icon">
                    <div class="ui label">{{ @portfolio.trades.price }}</div>
                    <input type="text" name="price" value="" placeholder="{{ @portfolio.trades.price }}">
                    <i class="euro icon"></i>
                  </div>
                </div>
                <div class="field">
                  <div class="ui left labeled input right input">
                    <div class="ui label">{{ @portfolio.trades.quantity }}</div>
                    <input type="text" name="quantity" value="" placeholder="{{ @portfolio.trades.quantity }}">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left labeled input right icon">
                    <div class="ui label">{{ @portfolio.trades.fxrate }}</div>
                    <input type="text" name="rate" value="" placeholder="{{ @portfolio.trades.fxrate }}">
                    <i class="percent icon"></i>
                  </div>
                </div>
                <div class="field">
                  <div class="ui left labeled input right icon">
                    <div class="ui label">{{ @portfolio.trades.total }}</div>
                    <input type="text" name="total" value="" placeholder="{{ @portfolio.trades.total }}" />
                    <i class="euro icon"></i>
                  </div>
                </div>
                <div class="field">
                  <div class="ui calendar">
                    <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.trades.startdate }}</div>
                        <input type="date" name="start_date" value="" placeholder="{{ @portfolio.trades.startdate }}" />
                        <i class="calendar icon"></i>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <div class="ui left labeled input right icon">
                      <div class="ui label">{{ @portfolio.trades.enddate }}</div>
                    <input type="date" name="end_date" value="" placeholder="{{ @portfolio.trades.enddate }}">
                    <i class="calendar icon"></i>
                  </div>
                </div>
                <div class="field">
                  <div class="ui left labeled input right input">
                    <div class="ui label">{{ @portfolio.trades.duration }}</div>
                    <input type="text" name="duration" value="" placeholder="{{ @portfolio.trades.duration }}">
                  </div>
                </div>
            </div>
            <div class="actions">
                <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
            </div>
          </form>
            <form id="modal-delete-portfolio" class="ui skip-submission-check form small action modal" data-action="delete">
                <input type="hidden" name="id" value="">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.trades.delete_title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <p>{{ @portfolio.trades.delete_message }}</p>
                </div>
                <div class="actions">
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @portfolio.trades.delete_button }} <i class="checkmark icon"></i></div>
                </div>
            </form>            
        </check>
        <table id="trades-list" class="ui sortable celled {{ @SITE.MAIN_COLOR }} table">
          <thead>
          <tr>
            <th>{{ @portfolio.trades.symbol }}</th>
            <th>{{ @portfolio.trades.name }}</th>
            <th>{{ @portfolio.trades.action }}</th>
            <th class="center aligned">{{ @portfolio.trades.quantity }}</th>
            <th class="center aligned">{{ @portfolio.trades.price }}</th>
            <th class="center aligned">{{ @portfolio.trades.fxrate }}</th>
            <th class="center aligned">{{ @portfolio.trades.total }}</th>
            <th class="center aligned">{{ @portfolio.trades.startdate }}</th>
            <th class="center aligned">{{ @portfolio.trades.enddate }}</th>
            <th class="center aligned">{{ @portfolio.trades.duration }}</th>
            <check if="{{ @USER.is_admin }}"><th class="center aligned"></th></check>
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
        <h3 class="header">{{ @portfolio.lock.up.title }}</h3>
        <p>{{ @portfolio.lock.up.message }}</p>
      </div>
    </div>

      </div>
      <div id="tab-anleihen" class="ui tab" data-tab="tab-anleihen">
        <check if="{{ @USER.is_admin }}">
            <form id="modal-add-anleihen" name="anleihen-form" class="ui anleihen-form skip-submission-check form small action modal" method="post">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.add.anleihen.title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="{{  @USER.id }}">
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label">{{ @portfolio.anleihen.name }}</div>
                            <div class="ui fluid search selection dropdown" tabindex="-1">
                                <input type="hidden" name="symbol">
                                <i class="dropdown icon"></i>
                                <div class="default text">{{ @portfolio.anleihen.select }}</div>
                                <div class="menu"></div>
                            </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label">{{ @portfolio.anleihen.quantity }}</div>
                        <input type="text" tabindex="0" name="quantity" value="" placeholder="{{ @portfolio.anleihen.quantity }}" />
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.anleihen.fxrate }}</div>
                        <i class="euro icon"></i>
                        <input type="text" name="fx_rate" value="" placeholder="{{ @portfolio.anleihen.fxrate }}" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon focus">
                        <div class="ui label">{{ @portfolio.anleihen.price }}</div>
                        <input type="text" name="price" disabled value="" placeholder="{{ @portfolio.anleihen.price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @portfolio.anleihen.startdate }}</div>
                            <input type="date" name="start_date" value="" placeholder="{{ @portfolio.anleihen.startdate }}" />
                            <i class="calendar icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.anleihen.enddate }}</div>
                        <input type="date" name="end_date" value="" placeholder="{{ @portfolio.anleihen.enddate }}" />
                        <i class="calendar icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.anleihen.current_fx }}</div>
                        <i class="percent icon"></i>
                        <input type="text" name="current_fx" value="" placeholder="{{ @portfolio.anleihen.current_fx }}" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.anleihen.total }}<br>{{ @USER.currency }}</div>
                        <input type="text" name="total" disabled value="" placeholder="{{ @portfolio.anleihen.total }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.anleihen.current_price }} in <br>{{ @USER.currency }}</div>
                        <input type="text" name="current_price" disabled value="" placeholder="{{ @portfolio.anleihen.current_price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <h4 class="ui dividing header">{{ @portfolio.anleihen.notes }}</h4>
                      <div class="ui input">
                        <textarea name="notes" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="interest-controls">
                        <div class="three fields">
                            <div class="fourteen wide field">
                                <h4 class="ui dividing header">{{ @portfolio.anleihen.interest_date }}</h4>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button add-interest" title="Adds an interest term to the end of the list">
                                <i class="plus icon"></i>
                              </div>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button remove-interest" title="Removes the last interest term from the list except latest">
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
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-edit-anleihen" name="anleihen-form" class="ui anleihen-form skip-submission-check form small action modal" post="/api/actions/anleihen/edit" method="post">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.edit.anleihen.title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="">
                    <input type="hidden" name="anleihen_id" value="">
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label">{{ @portfolio.anleihen.name }}</div>
                            <div class="ui fluid search selection dropdown" tabindex="-1">
                                <input type="hidden" name="symbol">
                                <i class="dropdown icon"></i>
                                <div class="default text">{{ @portfolio.anleihen.select }}</div>
                                <div class="menu"></div>
                            </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label">{{ @portfolio.anleihen.quantity }}</div>
                        <input type="text" tabindex="0" name="quantity" value="" placeholder="{{ @portfolio.anleihen.quantity }}" />
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.anleihen.fxrate }}</div>
                        <input type="text" name="fx_rate" value="" placeholder="{{ @portfolio.anleihen.fxrate }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon focus">
                        <div class="ui label">{{ @portfolio.anleihen.price }}</div>
                        <input type="text" name="price" disabled value="" placeholder="{{ @portfolio.anleihen.price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @portfolio.anleihen.startdate }}</div>
                            <input type="date" name="start_date" value="" placeholder="{{ @portfolio.anleihen.startdate }}" />
                            <i class="calendar icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                          <div class="ui label">{{ @portfolio.anleihen.enddate }}</div>
                        <input type="date" name="end_date" value="" placeholder="{{ @portfolio.anleihen.enddate }}" />
                        <i class="calendar icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.anleihen.current_fx }}</div>
                        <input type="text" name="current_fx" value="" placeholder="{{ @portfolio.anleihen.current_fx }}" />
                        <i class="percent icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.anleihen.total }}<br>{{ @USER.currency }}</div>
                        <input type="text" name="total" disabled value="" placeholder="{{ @portfolio.anleihen.total }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.anleihen.current_price }} in<br>{{ @USER.currency }}</div>
                        <input type="text" name="current_price" disabled value="" placeholder="{{ @portfolio.anleihen.current_price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <h4 class="ui dividing header">{{ @portfolio.anleihen.notes }}</h4>
                      <div class="ui input">
                        <textarea name="notes" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="interest-controls">
                        <div class="three fields">
                            <div class="fourteen wide field">
                                <h4 class="ui dividing header">{{ @portfolio.anleihen.interest_date }}</h4>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button add-interest" title="Adds an interest term to the end of the list">
                                <i class="plus icon"></i>
                              </div>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button remove-interest" title="Removes the last interest term from the list except latest">
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
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-delete-anleihen" class="ui skip-submission-check form small action modal" data-action="delete">
                <input type="hidden" name="id" value="">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.anleihen.delete_title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <p>{{ @portfolio.anleihen.delete_message }}</p>
                </div>
                <div class="actions">
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @portfolio.anleihen.delete_button }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <div class="ui stackable grid">
                <div class="four column row">
                    <div class="center aligned column">
                        <div class="ui fluid anleihen user search" data-callback="refreshAnleihenList" data-user="{{ @USER.id }}">
                            <div class="ui icon input">
                                <input class="prompt" type="text" value="{{ @USER.first_name.' '.@USER.last_name }}" />
                                <i class="user icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="right aligned column">
                        <button id="add-anleihen" class="ui {{ @SITE.MAIN_COLOR }} labeled icon button"><i class="add icon"></i>{{ @portfolio.anleihen.add }}</button>
                    </div>                        
                </div>
            </div>
            <div class="ui hidden divider"></div>
        </check>
        <div id="modal-anleihen-notes" class="ui large action modal">
            <i class="close icon"></i>
            <div class="header">
              {{ @portfolio.anleihen.notes }}
            </div>
            <div class="content">
                <div class="notes-area"></div>
            </div>
            <div class="actions">
                <div class="ui {{ @SITE.MAIN_COLOR }} cancel button">{{ @portfolio.anleihen.close_button }}</i></div>
            </div>
        </div>
        <table id="anleihen-list" class="ui sortable celled {{ @SITE.MAIN_COLOR }} table">
          <thead>
          <tr>
            <th>{{ @portfolio.anleihen.name }}</th>
            <th class="center aligned">{{ @portfolio.anleihen.quantity }}</th>
            <th class="center aligned">{{ @portfolio.anleihen.fxrate }}</th>
            <th class="center aligned">{{ @portfolio.anleihen.price }}</th>
            <th class="center aligned">{{ @portfolio.anleihen.startdate }}</th>
            <th class="center aligned">{{ @portfolio.anleihen.enddate }}</th>
            <th class="center aligned">{{ @portfolio.anleihen.current_fx }}</th>
            <th class="center aligned">{{ @portfolio.anleihen.current_price }} in <br>{{ @USER.currency }}</th>
            <th class="center aligned">{{ @portfolio.anleihen.interest_date }}</th>
            <check if="{{ @USER.is_admin }}"><th class="center aligned"></th></check>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    <?php /*
    <div class="ui piled segment ignored info icon message">
      <i class="info circle icon"></i>
      <div class="content">
        <h3 class="header">{{ @portfolio.lock.up.title }}</h3>
        <p>{{ @portfolio.lock.up.message }}</p>
      </div>
    </div>
    */ ?>  

        </div>
      <!------- fonds ------->
      <div id="tab-fonds" class="ui tab" data-tab="tab-fonds">
        <check if="{{ @USER.is_admin }}">
            <form id="modal-add-fonds" name="fonds-form" class="ui fonds-form skip-submission-check form small action modal" method="post">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.add.fonds.title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="{{  @USER.id }}">
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label">{{ @portfolio.fonds.name }}</div>
                            <div class="ui fluid search selection dropdown" tabindex="-1">
                                <input type="hidden" name="symbol">
                                <i class="dropdown icon"></i>
                                <div class="default text">{{ @portfolio.fonds.select }}</div>
                                <div class="menu"></div>
                            </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label">{{ @portfolio.fonds.quantity }}</div>
                        <input type="text" tabindex="0" name="quantity" value="" placeholder="{{ @portfolio.fonds.quantity }}" />
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fonds.fxrate }}</div>
                        <i class="euro icon"></i>
                        <input type="text" name="fx_rate" value="" placeholder="{{ @portfolio.fonds.fxrate }}" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon focus">
                        <div class="ui label">{{ @portfolio.fonds.price }}</div>
                        <input type="text" name="price" disabled value="" placeholder="{{ @portfolio.fonds.price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @portfolio.fonds.startdate }}</div>
                            <input type="date" name="start_date" value="" placeholder="{{ @portfolio.fonds.startdate }}" />
                            <i class="calendar icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fonds.enddate }}</div>
                        <input type="date" name="end_date" value="" placeholder="{{ @portfolio.fonds.enddate }}" />
                        <i class="calendar icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fonds.current_fx }}</div>
                        <i class="percent icon"></i>
                        <input type="text" name="current_fx" value="" placeholder="{{ @portfolio.fonds.current_fx }}" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fonds.total }}<br>{{ @USER.currency }}</div>
                        <input type="text" name="total" disabled value="" placeholder="{{ @portfolio.fonds.total }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fonds.current_price }} in <br>{{ @USER.currency }}</div>
                        <input type="text" name="current_price" disabled value="" placeholder="{{ @portfolio.fonds.current_price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <h4 class="ui dividing header">{{ @portfolio.fonds.notes }}</h4>
                      <div class="ui input">
                        <textarea name="notes" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="interest-controls">
                        <div class="three fields">
                            <div class="fourteen wide field">
                                <h4 class="ui dividing header">{{ @portfolio.fonds.interest_date }}</h4>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button add-interest" title="Adds an interest term to the end of the list">
                                <i class="plus icon"></i>
                              </div>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button remove-interest" title="Removes the last interest term from the list except latest">
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
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-edit-fonds" name="fonds-form" class="ui fonds-form skip-submission-check form small action modal" post="/api/actions/fonds/edit" method="post">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.edit.fonds.title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="">
                    <input type="hidden" name="fonds_id" value="">
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label">{{ @portfolio.fonds.name }}</div>
                            <div class="ui fluid search selection dropdown" tabindex="-1">
                                <input type="hidden" name="symbol">
                                <i class="dropdown icon"></i>
                                <div class="default text">{{ @portfolio.fonds.select }}</div>
                                <div class="menu"></div>
                            </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right input">
                        <div class="ui label">{{ @portfolio.fonds.quantity }}</div>
                        <input type="text" tabindex="0" name="quantity" value="" placeholder="{{ @portfolio.fonds.quantity }}" />
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fonds.fxrate }}</div>
                        <input type="text" name="fx_rate" value="" placeholder="{{ @portfolio.fonds.fxrate }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon focus">
                        <div class="ui label">{{ @portfolio.fonds.price }}</div>
                        <input type="text" name="price" disabled value="" placeholder="{{ @portfolio.fonds.price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @portfolio.fonds.startdate }}</div>
                            <input type="date" name="start_date" value="" placeholder="{{ @portfolio.fonds.startdate }}" />
                            <i class="calendar icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                          <div class="ui label">{{ @portfolio.fonds.enddate }}</div>
                        <input type="date" name="end_date" value="" placeholder="{{ @portfolio.fonds.enddate }}" />
                        <i class="calendar icon"></i>
                      </div>
                    </div>
                    <div class="required field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fonds.current_fx }}</div>
                        <input type="text" name="current_fx" value="" placeholder="{{ @portfolio.fonds.current_fx }}" />
                        <i class="percent icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fonds.total }}<br>{{ @USER.currency }}</div>
                        <input type="text" name="total" disabled value="" placeholder="{{ @portfolio.fonds.total }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fonds.current_price }} in<br>{{ @USER.currency }}</div>
                        <input type="text" name="current_price" disabled value="" placeholder="{{ @portfolio.fonds.current_price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <h4 class="ui dividing header">{{ @portfolio.fonds.notes }}</h4>
                      <div class="ui input">
                        <textarea name="notes" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="interest-controls">
                        <div class="three fields">
                            <div class="fourteen wide field">
                                <h4 class="ui dividing header">{{ @portfolio.fonds.interest_date }}</h4>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button add-interest" title="Adds an interest term to the end of the list">
                                <i class="plus icon"></i>
                              </div>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button remove-interest" title="Removes the last interest term from the list except latest">
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
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-delete-fonds" class="ui skip-submission-check form small action modal" data-action="delete">
                <input type="hidden" name="id" value="">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.fonds.delete_title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <p>{{ @portfolio.fonds.delete_message }}</p>
                </div>
                <div class="actions">
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @portfolio.fonds.delete_button }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <div class="ui stackable grid">
                <div class="four column row">
                    <div class="center aligned column">
                        <div class="ui fluid fonds user search" data-callback="refreshAnleihenList" data-user="{{ @USER.id }}">
                            <div class="ui icon input">
                                <input class="prompt" type="text" value="{{ @USER.first_name.' '.@USER.last_name }}" />
                                <i class="user icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="right aligned column">
                        <button id="add-fonds" class="ui {{ @SITE.MAIN_COLOR }} labeled icon button"><i class="add icon"></i>{{ @portfolio.fonds.add }}</button>
                    </div>                        
                </div>
            </div>
            <div class="ui hidden divider"></div>
        </check>
        <div id="modal-fonds-notes" class="ui large action modal">
            <i class="close icon"></i>
            <div class="header">
              {{ @portfolio.fonds.notes }}
            </div>
            <div class="content">
                <div class="notes-area"></div>
            </div>
            <div class="actions">
                <div class="ui {{ @SITE.MAIN_COLOR }} cancel button">{{ @portfolio.fonds.close_button }}</i></div>
            </div>
        </div>
        <table id="fonds-list" class="ui sortable celled {{ @SITE.MAIN_COLOR }} table">
          <thead>
          <tr>
            <th>{{ @portfolio.fonds.name }}</th>
            <th class="center aligned">{{ @portfolio.fonds.quantity }}</th>
            <th class="center aligned">{{ @portfolio.fonds.fxrate }}</th>
            <th class="center aligned">{{ @portfolio.fonds.price }}</th>
            <th class="center aligned">{{ @portfolio.fonds.startdate }}</th>
            <th class="center aligned">{{ @portfolio.fonds.enddate }}</th>
            <th class="center aligned">{{ @portfolio.fonds.current_fx }}</th>
            <th class="center aligned">{{ @portfolio.fonds.current_price }} in <br>{{ @USER.currency }}</th>
            <th class="center aligned">{{ @portfolio.fonds.interest_date }}</th>
            <check if="{{ @USER.is_admin }}"><th class="center aligned"></th></check>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    <?php /*
    <div class="ui piled segment ignored info icon message">
      <i class="info circle icon"></i>
      <div class="content">
        <h3 class="header">{{ @portfolio.lock.up.title }}</h3>
        <p>{{ @portfolio.lock.up.message }}</p>
      </div>
    </div>
    */ ?>  

        </div>
      <!-- fonds -->
      <div id="tab-funds" class="ui active tab" data-tab="tab-funds">
        <check if="{{ @USER.is_admin }}">
            <form id="modal-add-fund" name="add-fund-form" class="ui add-fund-form skip-submission-check form small action modal" method="post">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.fund.add_title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="{{  @USER.id }}">
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label">{{ @portfolio.fund.name }}</div>
                        <div class="ui fluid search selection dropdown" tabindex="-1">
                            <input type="hidden" name="symbol">
                            <i class="dropdown icon"></i>
                            <div class="default text">{{ @portfolio.fund.select }}</div>
                            <div class="menu"></div>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label">{{ @portfolio.fund.quantity }}</div>
                        <input type="text" name="quantity" value="" placeholder="{{ @portfolio.fund.quantity }}" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fund.price }}</div>
                        <input type="text" name="price" value="" placeholder="{{ @portfolio.fund.price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fund.issue_price }}</div>
                        <input type="date" name="issue_price" value="" placeholder="{{ @portfolio.fund.issue_price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fund.current_price }}</div>
                        <input type="date" name="current_price" value="" placeholder="{{ @portfolio.fund.current_price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fund.total_price }}</div>
                        <input type="text" name="total_price" value="" placeholder="{{ @portfolio.fund.total_price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                        <h5 class="ui dividing header">{{ @portfolio.fund.notes }}</h5>
                        <div class="ui input">
                            <textarea name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="interest-controls">
                        <div class="three fields">
                            <div class="fourteen wide field">
                                <h4 class="ui dividing header">{{ @portfolio.fund.interest_date }}</h4>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button add-interest" title="Adds an interest term to the end of the list">
                                <i class="plus icon"></i>
                              </div>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button remove-interest" title="Removes the last interest term from the list except latest">
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
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-edit-fund" name="edit-fund-form" class="ui edit-fund-form skip-submission-check form small action modal" post="/api/actions/fund/edit" method="post">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.fund.edit_title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="">
                    <input type="hidden" name="fund_id" value="">
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label">{{ @portfolio.fund.name }}</div>
                        <div class="ui fluid search selection dropdown" tabindex="-1">
                            <input type="hidden" name="symbol">
                            <i class="dropdown icon"></i>
                            <div class="default text">{{ @portfolio.fund.select }}</div>
                            <div class="menu"></div>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label">{{ @portfolio.fund.quantity }}</div>
                        <input type="text" name="quantity" value="" placeholder="{{ @portfolio.fund.quantity }}" />
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fund.price }}</div>
                        <input type="text" name="price" value="" placeholder="{{ @portfolio.anleihen.price }}" />
                        <i class="percent icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fund.issue_price }}</div>
                        <input type="date" name="issue_price" value="" placeholder="{{ @portfolio.fund.issue_price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fund.current_price }}</div>
                        <input type="date" name="current_price" value="" placeholder="{{ @portfolio.fund.current_price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fund.total_price }}</div>
                        <input type="text" name="total_price" value="" placeholder="{{ @portfolio.fund.total_price }}" />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                        <h5 class="ui dividing header">{{ @portfolio.fund.notes }}</h5>
                        <div class="ui input">
                            <textarea name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="interest-controls">
                        <div class="three fields">
                            <div class="fourteen wide field">
                                <h4 class="ui dividing header">{{ @portfolio.fund.interest_date }}</h4>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button add-interest" title="Adds an interest term to the end of the list">
                                <i class="plus icon"></i>
                              </div>
                            </div>
                            <div class="one wide field right floated">
                              <div class="ui mini {{ @SITE.MAIN_COLOR }} circular icon button remove-interest" title="Removes the last interest term from the list except latest">
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
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-delete-fund" class="ui skip-submission-check form small action modal" data-action="delete">
                <input type="hidden" name="id" value="">
                <i class="close icon"></i>
                <div class="header">
                    {{ @portfolio.fund.delete_title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <p>{{ @portfolio.fund.delete_message }}</p>
                </div>
                <div class="actions">
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @portfolio.fund.delete_button }} <i class="checkmark icon"></i></div>
                </div>
            </form>            
            <div class="ui stackable grid">
                <div class="four column row">
                    <div class="center aligned column">
                        <div class="ui fluid funds user search" data-callback="refreshFundsList" data-user="{{ @USER.id }}">
                            <div class="ui icon input">
                                <input class="prompt" type="text" value="{{ @USER.first_name.' '.@USER.last_name }}" />
                                <i class="user icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="right aligned column">
                        <button id="add-fund" class="ui {{ @SITE.MAIN_COLOR }} labeled icon button"><i class="add icon"></i>{{ @portfolio.fund.add }}</button>
                    </div>                        
                </div>
            </div>
        </check>
            <div id="modal-funds-notes" class="ui large action modal">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.fixed_deposit.notes }}
                </div>
                <div class="content">
                    <div class="notes-area"></div>
                </div>
                <div class="actions">
                    <div class="ui {{ @SITE.MAIN_COLOR }} cancel button">{{ @portfolio.fixed_deposit.close_button }}</i></div>
                </div>
            </div>

            <table id="funds-list" class="ui sortable celled {{ @SITE.MAIN_COLOR }} table">
              <thead>
              <tr>
                <th>{{ @portfolio.fund.name }}</th>
                <th class="center aligned">{{ @portfolio.fund.quantity }}</th>
                <th class="center aligned">{{ @portfolio.fund.price }}</th>
                <th class="center aligned">{{ @portfolio.fund.issue_price }}</th>
                <th class="center aligned">{{ @portfolio.fund.current_price }}</th>
                <th class="center aligned">{{ @portfolio.fund.total_price }} <br>{{ @USER.currency }}</th>
                <th class="center aligned">{{ @portfolio.fund.interest_date }}</th>
                <check if="{{ @USER.is_admin }}"><th class="center aligned"></th></check>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <?php /*
             <div class="ui piled segment ignored info icon message">
              <i class="info circle icon"></i>
              <div class="content">
                <h3 class="header">{{ @portfolio.lock.up.title }}</h3>
                <p>{{ @portfolio.lock.up.message }}</p>
              </div>
            */ ?>
        </div>
      </div>
      <div id="tab-fixed-deposit" class="ui tab" data-tab="tab-fixed-deposit">
        <check if="{{ @USER.is_admin }}">
            <form id="modal-add-fixed-deposit" name="add-fixed-deposit-form" class="ui add-fixed-deposit-form skip-submission-check form small action modal" method="post">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.fixed_deposit.add_title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="{{  @USER.id }}">
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label">{{ @portfolio.fixed_deposit.name }}</div>
                        <div class="ui fluid search selection dropdown" tabindex="-1">
                            <input type="hidden" name="symbol">
                            <i class="dropdown icon"></i>
                            <div class="default text">{{ @portfolio.fixed_deposit.select }}</div>
                            <div class="menu"></div>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input">
                            <div class="ui label">{{ @portfolio.fixed_deposit.amount }}</div>
                            <input type="text" name="amount" value="" placeholder="{{ @portfolio.fixed_deposit.amount }}" />
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @portfolio.fixed_deposit.interest_rate }}</div>
                            <input type="text" name="interest_rate" value="" placeholder="{{ @portfolio.fixed_deposit.interest_rate }}" />
                            <i class="percent icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fixed_deposit.total }}</div>
                        <input type="text" name="total" value="" placeholder="{{ @portfolio.fixed_deposit.total }}" disabled  />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @portfolio.fixed_deposit.building }}</div>
                            <input type="text" name="building" value="" placeholder="{{ @portfolio.fixed_deposit.building }}" />
                            <i class="percent icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @portfolio.fixed_deposit.totalvalue }}</div>
                            <input type="text" name="totalvalue" value="" placeholder="{{ @portfolio.fixed_deposit.totalvalue }}" disabled />
                            <i class="euro icon"></i>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="actions">
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-edit-fixed-deposit" name="edit-fixed-deposit-form" class="ui edit-fixed-deposit-form skip-submission-check form small action modal" post="/api/actions/deposit/edit" method="post">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.fixed_deposit.edit_title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user_id" value="">
                    <input type="hidden" name="deposit_id" value="">
                    <div class="field">
                      <div class="ui left labeled input">
                        <div class="ui label">{{ @portfolio.fixed_deposit.name }}</div>
                        <div class="ui fluid search selection dropdown" tabindex="-1">
                            <input type="hidden" name="symbol">
                            <i class="dropdown icon"></i>
                            <div class="default text">{{ @portfolio.fixed_deposit.select }}</div>
                            <div class="menu"></div>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input">
                            <div class="ui label">{{ @portfolio.fixed_deposit.amount }}</div>
                            <input type="text" name="amount" value="" placeholder="{{ @portfolio.fixed_deposit.amount }}"  />
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @portfolio.fixed_deposit.interest_rate }}</div>
                            <input type="text" name="interest_rate" value="" placeholder="{{ @portfolio.fixed_deposit.interest_rate }}" />
                            <i class="percent icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                        <div class="ui label">{{ @portfolio.fixed_deposit.total }}</div>
                        <input type="text" name="total" value="" placeholder="{{ @portfolio.fixed_deposit.total }}" disabled />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @portfolio.fixed_deposit.building }}</div>
                            <input type="text" name="building" value="" placeholder="{{ @portfolio.fixed_deposit.building }}" />
                            <i class="percent icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left labeled input right icon">
                          <div class="ui label">{{ @portfolio.fixed_deposit.totalvalue }}</div>
                        <input type="text" name="totalvalue" value="" placeholder="{{ @portfolio.fixed_deposit.totalvalue }}" disabled />
                        <i class="euro icon"></i>
                      </div>
                    </div>
                </div>
                <div class="actions">
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <form id="modal-delete-fixed-deposit" name="delete-fixed-deposit" class="ui skip-submission-check form small action modal" data-action="delete">
                <input type="hidden" name="id" value="">
                <i class="close icon"></i>
                <div class="header">
                    {{ @portfolio.fixed_deposit.delete_title }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <p>{{ @portfolio.fixed_deposit.delete_message }}</p>
                </div>
                <div class="actions">
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @portfolio.fixed_deposit.delete_button }} <i class="checkmark icon"></i></div>
                </div>
            </form>            
            <div class="ui stackable grid">
                <div class="four column row">
                    <div class="center aligned column">
                        <div class="ui fluid fixed-deposit user search" data-callback="refreshFixedDepositList" data-user="{{ @USER.id }}">
                            <div class="ui icon input">
                                <input class="prompt" type="text" value="{{ @USER.first_name.' '.@USER.last_name }}" />
                                <i class="user icon"></i>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                    <div class="column"></div>
                    <div class="column"></div>
                    <div class="right aligned column">
                        <button id="add-fixed-deposit" class="ui {{ @SITE.MAIN_COLOR }} labeled icon button"><i class="add icon"></i>{{ @portfolio.fixed_deposit.add }}</button>
                    </div>                        
                </div>
            </div>
        </check>
            <div id="modal-fixed-notes" class="ui large action modal">
                <i class="close icon"></i>
                <div class="header">
                  {{ @portfolio.fixed_deposit.notes }}
                </div>
                <div class="content">
                    <div class="notes-area"></div>
                </div>
                <div class="actions">
                    <div class="ui {{ @SITE.MAIN_COLOR }} cancel button">{{ @portfolio.fixed_deposit.close_button }}</i></div>
                </div>
            </div>
        
            <table id="fixed-deposit-list" class="ui sortable celled {{ @SITE.MAIN_COLOR }} table">
              <thead>
              <tr>
                <th>{{ @portfolio.fixed_deposit.name }}</th>
                <th class="center aligned">{{ @portfolio.fixed_deposit.amount }}</th>
                <th class="center aligned">{{ @portfolio.fixed_deposit.interest_rate }} €</th>
                <th class="center aligned">{{ @portfolio.fixed_deposit.total }} €</th>
                <th class="center aligned">{{ @portfolio.fixed_deposit.building }} %</th>
                <th class="center aligned">{{ @portfolio.fixed_deposit.totalvalue }} €</th>
                <check if="{{ @USER.is_admin }}"><th class="center aligned"></th></check>
              </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        
    <div class="ui piled segment ignored info icon message">
      <i class="info circle icon"></i>
      <div class="content">
        <h3 class="header">{{ @portfolio.lock.up.title }}</h3>
        <p>{{ @portfolio.lock.up.message }}</p>
      </div>
    </div>
        
      </div>
    </div>
  </div>
</div>

