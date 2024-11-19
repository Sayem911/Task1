<div class="ui middle aligned center aligned grid centered-container">
    <div class="column">
        <form class="ui large form" method="POST" action="{{ @BASE }}{{ @PATH }}">
            <div class="ui stacked segment">
                <h2 class="ui {{ @SITE.MAIN_COLOR }} image header">
                    <a class="ui image" href="{{ @BASE }}/"><img src="{{ @BASE }}/assets/images/logo-{{ @SITE.MAIN_COLOR }}.png"></a>
                    <div class="content">
                    {{ @website.title }}
                    <div class="sub header">{{ @gtfa.register.form.title }}</div>
                    </div>
                </h2>
                <div class="field">
                    <p>
                        {{ @gtfa.register.form.description }}
                    </p>
                </div>
                <div class="field">
                    <img src="{{ @qrCodeUrl }}">
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="text telephone icon"></i>
                    <input type="text" name="code" placeholder="{{ @gtfa.register.form.code.placeholder }}">
                  </div>
                </div>
                <button type="submit" class="ui fluid large {{ @SITE.MAIN_COLOR }} submit button">{{ @gtfa.register.form.submit }}</button>
                <check if="{{ @SESSION.message }}">
                    <div class="ui {{ @SESSION.message.type }} message">
                        <i class="close icon"></i>
                        <p>{{ @SESSION.message.text|raw }}</p>
                    </div>
                </check>
                <div class="ui error message"></div>
            </div>
        </form>
    </div>
</div>