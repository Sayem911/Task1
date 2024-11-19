<div class="ui middle aligned center aligned grid centered-container">
  <div class="column">
    <form id="form-password-reset" class="ui large form" method="POST" action="{{ @BASE }}{{ @PATH }}">
      <div class="ui stacked segment">
        <h2 class="ui {{ @SITE.MAIN_COLOR }} image header">
          <a class="ui image" href="{{ @BASE }}/"><img src="{{ @BASE }}/assets/images/logo-{{ @SITE.MAIN_COLOR }}.png"></a>
          <div class="content">
            {{ @website.title }}
            <div class="sub header">{{ @password.reset.form.title }}</div>
          </div>
        </h2>
        <div class="field">
          <div class="ui left icon input">
            <i class="key icon"></i>
            <input type="password" name="password" placeholder="{{ @password.reset.form.password.placeholder }}">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="key icon"></i>
            <input type="password" name="password2" placeholder="{{ @password.reset.form.password2.placeholder }}">
          </div>
        </div>
        <div class="ui fluid large {{ @SITE.MAIN_COLOR }} submit button">{{ @password.reset.form.submit }}</div>
      </div>
      <check if="{{ @SESSION.message }}">
        <div class="ui {{ @SESSION.message.type }} message">
          <i class="close icon"></i>
          <p>{{ @SESSION.message.text|raw }}</p>
        </div>
      </check>
      <div class="ui error message"></div>
    </form>
  </div>
</div>