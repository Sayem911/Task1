<div class="ui container">
    <div class="ui stackable one column grid">
        <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
        <div class="row">
            <div class="column">
                <div class="ui piled segment">
                    <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="line chart icon"></i> <a href="{{ @BASE }}/cryptopayments">{{ @title.cryptopayments }}</a></span>
                    <span>{{ @crypto.paypage.hint }}</span>
                    <div class="ui centered grid">
                        <div class="row"></div>
                        <div class="row">
                            <div class="six wide column">
                                <div class="ui center aligned segment">
                                    <h2 class="ui header">{{ @vars.symbol }}</h2>
                                    <p>
                                        <img src="{{ @BASE }}/api/actions/qrcode/generate/{{ @vars.wallet }}" width="300" />
                                    </p>
                                    <p>Diese Brieftaschenadresse unterstützt nur {{ @vars.symbol }} Zahlungen. Es unterstützt nicht-fungibele Token.</p>
                                    <h4>{{ @crypto.payment.wallet.title }}</h4>
                                    <p><span class="ui {{ @SITE.MAIN_COLOR }} label">{{ @vars.wallet }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui centered grid">
                        <div class="row">
                            <div class="six wide column">
                                <form class="ui form" method="POST" action="{{ @BASE }}/cryptopayments/save">
                                    <div class="ui fluid action icon input">
                                        <input type="text" name="amount" id="amount" placeholder="{{ @crypto.payment.amount.placeholder }} ({{ @vars.symbol }})" />
                                        <input type="hidden" name="symbol" value="{{ @vars.symbol }}" />
                                        <input type="hidden" name="wallet" value="{{ @vars.wallet }}" />
                                        <button id="add-payment" type="button" class="ui button">OK</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-payment-message" class="ui large action modal">
        <i class="close icon"></i>
        <div class="header">
          {{ @crypto.payment.message }}
        </div>
        <div class="content">
            <div class="message-area"></div>
        </div>
        <div class="actions">
            <div class="ui {{ @SITE.MAIN_COLOR }} cancel button">{{ @crypto.payment.message.close_button }}</i></div>
        </div>
    </div>
</div>

