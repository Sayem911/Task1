<div class="ui middle aligned center aligned grid centered-container">
  <div class="column">
    <form id="form-signup" class="ui large form" method="POST" action="{{ @BASE }}{{ @PATH }}">
      <div class="ui stacked segment">
        <h2 class="ui {{ @SITE.MAIN_COLOR }} image header">
          <a class="ui image" href="{{ @BASE }}/"><img src="{{ @BASE }}/assets/images/logo-{{ @SITE.MAIN_COLOR }}.png"></a>
          <div class="content">
            {{ @website.title }}
            <div class="sub header">{{ @signup.form.title }}</div>
          </div>
        </h2>
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="first_name" placeholder="{{ @signup.form.first.name.placeholder }}">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="last_name" placeholder="{{ @signup.form.last.name.placeholder }}">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="at icon"></i>
            <input type="text" name="email" placeholder="{{ @signup.form.email.placeholder }}">
          </div>
        </div>
        <div class="two fields">
            <div class="field">
              <div class="ui left icon input">
                <i class="envelope icon"></i>
                <input type="text" name="street_nr" placeholder="{{ @signup.form.street_nr.placeholder }}">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="envelope icon"></i>
                <input type="text" name="post_nr" placeholder="{{ @signup.form.post_nr.placeholder }}">
              </div>
            </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="envelope icon"></i>
            <input type="text" name="town" placeholder="{{ @signup.form.town.placeholder }}">
          </div>
        </div>
        <check if="{{ @SECURITY.TFA_ENABLED }}">
          <div class="field">
            <div class="ui left icon input">
              <i class="phone icon"></i>
              <input type="text" name="phone" placeholder="{{ @signup.form.phone.placeholder }}">
            </div>
          </div>
        </check>
        <check if="{{ !@SITE.EMAIL_VERIFICATION }}">
          <div class="field">
            <div class="ui left icon input">
              <i class="key icon"></i>
              <input type="password" name="password" placeholder="{{ @signup.form.password.placeholder }}">
            </div>
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="key icon"></i>
              <input type="password" name="password2" placeholder="{{ @signup.form.password2.placeholder }}">
            </div>
          </div>
        </check>
        <check if="{{ @SECURITY.RECAPTCHA_ENABLED }}">
          <div class="g-recaptcha" data-sitekey="{{ @SECURITY.RECAPTCHA_PUBLIC_KEY }}"></div>
        </check>
        <div class="ui fluid large {{ @SITE.MAIN_COLOR }} submit button">{{ @signup.form.submit }}</div>
      </div>
      <check if="{{ @SESSION.message }}">
        <div class="ui {{ @SESSION.message.type }} message">
          <i class="close icon"></i>
          <p>{{ @SESSION.message.text|raw }}</p>
        </div>
      </check>
      <div class="ui error message"></div>
      <check if="{{ @GET.ref }}">
        <input type="hidden" name="referrer" value="{{ @GET.ref }}">
      </check>
    </form>
    <div class="ui message">
      <span>{{ @signup.form.have_account }}</span><a href="{{ @BASE }}/login">{{ @signup.form.login }}</a>
    </div>
  </div>
</div>