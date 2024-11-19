<div class="ui container">
  <div class="ui stackable one column grid">
    <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
    <div class="column">
      <div class="ui piled segment">
      <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="exchange icon"></i> {{ @title.transactions }}</span>
      </span>
      </div>

    </div>
    <div id="transactions-wrapper" class="column">
        <div class="ui hidden divider"></div>
        <check if="{{ @USER.is_admin }}">
          <div class="ui stackable grid">
            <div class="four column left row">
              <div class="column">
                <div class="ui fluid selection dropdown">
                    <div class="text">{{ @depot.transactions.list.option }}</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                      <div class="item" data-value="all">{{ @depot.transactions.list.view }}</div>
                      <div class="item" data-value="search">{{ @depot.transactions.list.search }}</div>
                    </div>
                </div>
              </div>
              <div class="column">
                <div class="ui fluid user search" data-callback="refreshTransactionsList" data-user="{{ @USER.id }}" data-balance="{{ @USER.balance }}">
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
        <check if="{{ !@USER.is_admin }}">
        <div class="ui piled segment">
            <button id="depot" class="ui purple basic button">{{ @depot.transactions.list.button.title }}</button>
        </div>
        <form id="modal-depot" class="ui skip-submission-check form small action modal" enctype="multipart/form-data">
            <i class="close icon"></i>
            <div class="header">
              {{ @depot.transactions.list.button.make }}
            </div>
            <div class="content">
                <div class="ui error message"></div>
                <div class="ui result message"></div>
                <div class="two fields">
                    <div class="field">
                      <label for="amount">{{ @depot.transactions.amount }}</label>
                      <div class="ui left icon right input">
                        <i class="euro icon"></i>
                        <input type="text" name="amount" value="">
                      </div>
                    </div>
                    <div class="field">
                      <label for="type">{{ @depot.transactions.ticket }}</label>
                      <div class="ui left labeled input right input">
                        <div class="ui fluid selection dropdown">
                            <input type="hidden" name="type">
                            <i class="dropdown icon"></i>
                            <div class="default text">{{ @depot.transactions.select }}</div>
                            <div class="menu">
                                <div class="item" data-value="0">{{ @depot.transactions.disbursement }}</div>
                                <div class="item" data-value="1">{{ @depot.transactions.einzahlung }}</div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                      <label for="date">{{ @depot.transactions.datum }}</label>
                      <div class="ui calendar">
                        <div class="ui left labeled input right icon">
                            <input type="date" name="date" value="" placeholder="">
                            <i class="calendar icon"></i>
                        </div>
                      </div>
                    </div>
                    <div class="field">
                      <label for="time">{{ @depot.transactions.zeit }}</label>
                      <div class="ui left labeled input right icon">
                        <input type="time" name="time" value="" placeholder="">
                        <i class="clock icon"></i>
                      </div>
                    </div>
                </div>
                <div class="field">
                    <label for="receipt_doc">{{ @depot.transactions.dokument.title }}</label>
                    <input type="file" id="receipt_doc" name="receipt_doc">
                </div>
                <div class="field">
                    <label for="notes">{{ @depot.transactions.notes }}</label>
                    <textarea name="notes" rows="3">Empfänger: &#13;&#10;Iban: &#13;&#10;BIC: </textarea>
                </div>
            </div>
            <div class="actions">
                <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">Anfrage <i class="checkmark icon"></i></div>
            </div>
        </form>
        </check>
        <check if="{{ @USER.is_admin }}">
          <form id="modal-depot-delete"  class="ui skip-submission-check form small modal" data-action="delete" action="/api/actions/depot/delete" method="post">
              <i class="close icon"></i>
              <div class="header">
                {{ @depot.transactions.delete }}
              </div>
              <div class="content">
                  <input type="hidden" name="depot_id" value="" />
                  <p>{{ @depot.transactions.delete.sure }}</p>
              </div>
              <div class="actions">
                <div class="ui black deny button">
                  Nein
                </div>
                <div class="ui {{ @SITE.MAIN_COLOR }} right labeled icon submit button">
                  Ja
                  <i class="checkmark icon"></i>
                </div>
              </div>
          </form>
            <form id="modal-depot-update" class="ui skip-submission-check form small action modal" data-action="update" action="/api/actions/depot/update"  method="post">
                <i class="close icon"></i>
                <div class="header">
                  {{ @depot.transactions.request }}
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="depot_id" value="" />
                    <div class="two fields">
                        <div class="field">
                          <label for="amount">{{ @depot.transactions.amount }}</label>
                          <div class="ui left icon right input disabled">
                            <i class="euro icon"></i>
                            <input type="text" name="amount" value="">
                          </div>
                        </div>
                        <div class="field">
                          <label for="type">{{ @depot.transactions.ticket }}</label>
                          <div class="ui left input right icon disabled">
                            <input type="text" name="type" value="" />
                            <i class="dropdown icon"></i>
                          </div>
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="field">
                          <label for="date">{{ @depot.transactions.datum }}</label>
                          <div class="ui calendar">
                            <div class="ui left labeled input right icon disabled">
                                <input type="date" name="date" value="" placeholder="" />
                                <i class="calendar icon"></i>
                            </div>
                          </div>
                        </div>
                        <div class="field">
                          <label for="time">{{ @depot.transactions.zeit }}</label>
                          <div class="ui left labeled input right icon disabled">
                            <input type="time" name="time" value="" placeholder="" />
                            <i class="clock icon"></i>
                          </div>
                        </div>
                    </div>
                    <div class="field">
                        <label for="receipt_doc">{{ @depot.transactions.dokument }}</label>
                        <div class="ui piled segment">
                            <a name="doc_path" href="" class="ui button centered" target="_blank">{{ @depot.transactions.dokument.view }}</a>
                        </div>
                    </div>
                    <div class="field">
                        <label for="notes">{{ @portfolio.anleihen.notes }}</label>
                        <div class="ui input disabled">
                            <textarea name="notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="actions">
                    <div class="ui large revert right labeled icon revert button">Revert <i class="undo icon"></i></div>
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @depot.transactions.save }} <i class="checkmark icon"></i></div>
                </div>
            </form>
        </check>
        <table id="transactions-list" class="ui sortable celled {{ @SITE.MAIN_COLOR }} table">
          <thead>
          <tr>
            <th></th>
            <check if="{{ @USER.is_admin }}"><th>{{ @depot.transactions.username }}</th></check>
            <th>{{ @depot.transactions.type }}</th>
            <th>{{ @depot.transactions.amount }}</th>
            <th>{{ @depot.transactions.date }}</th>
            <th>{{ @depot.transactions.time }}</th>
            <th>{{ @depot.transactions.document }}</th>
            <th>{{ @depot.transactions.approval_date }}</th>
            <check if="{{ @USER.is_admin }}"><th class="right aligned"></th></check>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
    
    </div>


