<div class="ui container">
  <div class="left aligned sixteen wide column">
    <div class="column">
      <check if="{{ @SESSION.message }}">
        <div class="ui {{ @SESSION.message.type }} message">
          <i class="close icon"></i>
          <p>{{ @SESSION.message.text|raw }}</p>
        </div>
      </check>
      <check if="{{ @USER.identity_img != '' && @USER.approved==0 }}">
        <div class="ui warning message">
          <i class="close icon"></i>
          <p>{{ @profile.identity.approval_warn|raw }}</p>
        </div>
      </check>
          
      <div class="ui piled segment">
      <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="user icon"></i> {{ @profile.title }}
      </span>
      </div>

      </div>
      <div class="ui piled segment">
        <form class="ui form" method="POST" action="{{ @BASE }}{{ @PATH }}"  enctype="multipart/form-data">
          <div class="ui stackable two column grid">
            <div class="four wide column">
              <div class="field">
                <label>{{ @profile.avatar.title }}</label>
                <div id="profile-avatar">
                  <check if="{{ @USER.avatar }}">
                    <true>
                      <img class="ui medium bordered image" src="{{ @BASE }}/files/avatars/{{ @USER.avatar }}">
                    </true>
                    <false>
                      <img class="ui medium bordered image" src="{{ @BASE }}/assets/images/default_avatar.png">
                    </false>
                  </check>
                </div>
                <div>
                  <input type="file" name="avatar">
                </div>
              </div>
            </div>
            <div class="twelve wide column">
              <div class="disabled field">
                <label>{{ @profile.firstname.title }}</label>
                <input type="text" name="" value="{{ @USER.first_name }}">
              </div>
              <div class="disabled field">
                <label>{{ @profile.lastname.title }}</label>
                <input type="text" name="" value="{{ @USER.last_name }}">
              </div>
              <div class="disabled field">
                <label>{{ @profile.email.title }}</label>
                <input type="text" name="email" value="{{ @USER.email }}">
              </div>
              <div class="field">
                <label>{{ @profile.phone.title }}</label>
                <input type="text" name="phone" value="{{ @USER.phone }}" placeholder="{{ @signup.form.phone.placeholder }}">
              </div>
              <div class="field">
                <label>{{ @profile.land_phone.title }}</label>
                <input type="text" name="land_phone" value="{{ @USER.land_phone }}" placeholder="{{ @signup.form.land_phone.placeholder }}">
              </div>
              <div class="field">
                <label>{{ @profile.fax.title }}</label>
                <input type="text" name="fax" value="{{ @USER.fax }}" placeholder="{{ @signup.form.fax.placeholder }}">
              </div>
              <h5 class="ui dividing header">{{ @profile.address.title }}</h4>
            <div class="two fields">
                <div class="field">
                  <div class="ui input">
                    <input type="text" name="street_nr" value="{{ @USER.street_nr }}" placeholder="{{ @signup.form.street_nr.placeholder }}">
                  </div>
                </div>
                <div class="field">
                  <div class="ui input">
                    <input type="text" name="post_nr" value="{{ @USER.post_nr }}" placeholder="{{ @signup.form.post_nr.placeholder }}">
                  </div>
                </div>
            </div>
            <div class="field">
              <div class="ui input">
                <input type="text" name="town" value="{{ @USER.town }}" placeholder="{{ @signup.form.town.placeholder }}">
              </div>
            </div>
              <div class="field">
                <label>{{ @profile.timezone.title }}</label>
                <select id="timezone-dropdown" class="ui search selection dropdown" name="timezone">
                </select>
              </div>
              <div class="field">
                <label>{{ @profile.language.title }}</label>
                <div class="ui fluid selection dropdown">
                  <input type="hidden" name="language" value="{{ @USER.language ? @USER.language : @SITE.LANGUAGE }}">
                  <i class="dropdown icon"></i>
                  <div class="default text">{{ @profile.language.dropdown }}</div>
                  <div class="menu">
                    <repeat group="{{ @vars.languages }}" value="{{ @language }}">
                      <div class="item" data-value="{{ @language }}"><i class="{{ str_replace('en','us',@language) }} flag"></i>{{ @language }}</div>
                    </repeat>
                  </div>
                </div>
              </div>
              <div class="ui hidden divider"></div>
              <button class="ui submit {{ @SITE.MAIN_COLOR }} right floated button" type="submit">{{ @profile.form.save }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
</div>
<br>



<div class="ui container">
  <div class="left aligned sixteen wide column">
    <div class="column">
<div class="ui piled segment">
      <h2 class="ui {{ @SITE.MAIN_COLOR }} ribbon label">{{ @profile.identity.title }}</h2>
      <div class="ui identity-upload segment">
        <switch expr="{{ @USER.approved }}">
            <case value="{{ 0 }}" break="{{ TRUE }}">
                <form class="ui identity-form form" method="POST" data-action="upload" enctype="multipart/form-data">
                  <div class="ui error message"></div>
                  <div class="ui result message"></div>
                  <div class="ui stackable one column grid">
                      <div class="column">
                          <p>{{ @profile.identity.description }}</p>
                      </div>
                    <div class="column">
                      <div class="field">
                        <label>{{ @profile.identity.label }}</label>
                        
                        <div class="ui placeholder segment">
                          <div class="ui icon header">
                            <i class="pdf file outline icon"></i>
                            No documents are listed for this customer.
                          </div>
                          <input type="file" name="identity" class="ui primary button">
                        </div>
                    </div>
                    <div class="column">
                      <div class="ui hidden divider"></div>
                      <div class="ui submit {{ @SITE.MAIN_COLOR }} right floated button">{{ @profile.identity.upload }}</div>
                    </div>
                  </div>
                </form>
            </case>
            <case value="{{ 1 }}" break="{{ TRUE }}">
                <div class="ui column">
                <i class="info circle orange icon"></i> &nbsp; {{ @profile.identity.awaiting }} 
                <a href="files/ids/{{ @USER.identity_img }}" target="_blank">{{ @profile.identity.view_file }}</a>
                </div>
                <div></div>
            </case>
            <case value="{{ 2 }}" break="{{ TRUE }}">
                <div class="ui column">
                <i class="check green icon"></i> {{ @profile.identity.approved }}. &nbsp;
                <a href="files/ids/{{ @USER.identity_img }}" target="_blank">{{ @profile.identity.view_file }}</a>
                </div>
            </case>
            <default>
            message
            </default>
        </switch>
      </div>
    </div>   
    </div> 
    </div> 
    </div> 
    </div> 