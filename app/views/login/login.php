<div class="ui middle aligned center aligned grid centered-container">
  <div class="column">
    <form id="form-login" class="ui large form" style="opacity:65%;" method="POST" action="{{ @BASE }}{{ @PATH }}">
      <div class="ui stacked segment">
        <h2 class="ui {{ @SITE.MAIN_COLOR }} image header">
          <center><a class="ui image" style="background-color: rgb(255,255,255);padding-top: 4px;" href="{{ @BASE }}/"><img src="{{ @BASE }}/assets/images/alpen_invest-logo.png" style="max-width: 80%;"></a></center>
          <div class="content" style="padding-top: 14px;">
            <div class="sub header">{{ @login.form.title }}</div>
          </div>
        </h2>
        <div class="field">
          <div class="ui left icon input">
            <i class="mail icon"></i>
            <input type="text" name="email" placeholder="{{ @login.form.email.placeholder }}">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="key icon"></i>
            <input type="password" name="password" placeholder="{{ @login.form.password.placeholder }}">
          </div>
        </div>
        <button type="submit" class="ui fluid large {{ @SITE.MAIN_COLOR }} submit button">{{ @login.form.submit }}</button>
        <p></p>
        <p><i class="lock icon"></i> {{ @login.text.msg }}</p>
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