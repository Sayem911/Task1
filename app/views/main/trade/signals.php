<div class="ui container">
  <div class="ui stackable one column grid">
    <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
    <div class="column">
    <div class="ui piled segment">
      <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="bell icon"></i> {{ @title.signals }}</span>
      </span>
      </div>
    </div>
    <div id="transactions-wrapper" class="column">
        <div class="ui hidden divider"></div>
        <check if="{{ @USER.is_admin }}">
          <div class="ui stackable grid">
            <div class="four column left row">
              <div class="column">
                <div class="ui fluid user search" data-callback="refreshSignalsList" data-user="" data-balance="">
                  <div class="ui icon input">
                    <input class="prompt" type="text" value="" placeholder="{{ @signals.search.placeholder }}" />
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
                    {{ @signals.approve.title }}
                </div>
                <div class="content">
                    <input type="hidden" name="signal_id" value="" />
                    <p>{{ @signals.approve.description }}</p>
                </div>
                <div class="actions">
                    <div class="ui black deny button">
                      {{ @signals.approve.no.title }}
                    </div>
                    <div class="ui {{ @SITE.MAIN_COLOR }} right labeled icon submit button">
                      {{ @signals.approve.yes.title }}
                      <i class="checkmark icon"></i>
                    </div>
                </div>
            </form>
        </check>
        <form id="modal-signal-delete"  class="ui skip-submission-check form small modal" data-action="delete" action="/api/actions/signal/delete" method="post">
            <i class="close icon"></i>
            <div class="header">
                {{ @signals.delete.title }}
            </div>
            <div class="content">
                <input type="hidden" name="signal_id" value="" />
                <p>{{ @signals.delete.description }}</p>
            </div>
            <div class="actions">
                <div class="ui black deny button">
                  {{ @signals.delete.no.title }}
                </div>
                <div class="ui {{ @SITE.MAIN_COLOR }} right labeled icon submit button">
                  {{ @signals.delete.yes.title }}
                  <i class="checkmark icon"></i>
                </div>
            </div>
        </form>
        <table id="signals-list" class="ui sortable celled {{ @SITE.MAIN_COLOR }} table">
          <thead>
          <tr>
            <th>{{ @portfolio.signals.ticketno }}</th>
            <th>{{ @signals.date }}</th>
            <check if="{{ @USER.is_admin }}"><th>{{ @signals.username }}</th></check>
            <th>{{ @signals.name }}</th>
            <th>{{ @signals.purchase_price }}</th>
            <th>{{ @signals.order_action.title }}</th>
            <th>{{ @signals.order_type.title }}</th>
            <th>{{ @signals.order_details.title }}</th>
            <check if="{{ !@USER.is_admin }}"><th class="left aligned">Status</th></check>
            <th class="right aligned"></th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
    </div>
  </div>
</div>

