<div class="ui container">
  <div class="center aligned sixteen wide column">
    <div class="twelve wide column">
      <check if="{{ @SESSION.message }}">
        <div class="ui {{ @SESSION.message.type }} message">
          <i class="close icon"></i>
          <p>{{ @SESSION.message.text|raw }}</p>
        </div>
      </check>
      <div class="ui piled segment">
      <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="key icon"></i> {{ @password.update.form.title }}
      </span>
      </div>
      
      <div class="ui piled segment">
        <form class="ui form" method="POST" action="{{ @BASE }}{{ @PATH }}">
          <div class="ui stackable two column grid">
            <div class="column">
              <div class="field">
                <label>{{ @password.update.form.old_password.placeholder }}</label>
                <input type="password" name="old_password" placeholder="{{ @password.update.form.old_password.placeholder }}">
              </div>
            </div>
            <div class="column">
              <div class="field">
                <label>{{ @password.update.form.new_password.placeholder }}</label>
                <input type="password" name="new_password" placeholder="{{ @password.update.form.new_password.placeholder }}">
              </div>
              <div class="field">
                <label>{{ @password.update.form.new_password2.placeholder }}</label>
                <input type="password" name="new_password2" placeholder="{{ @password.update.form.new_password2.placeholder }}">
              </div>
              <div class="ui hidden divider"></div>
              <button class="ui submit {{ @SITE.MAIN_COLOR }} right floated button" type="submit">{{ @profile.form.save }}</button>
            </div>
          </div>
          <div class="ui error message"></div>
        </form>
      </div>
    </div>
  </div>
</div>