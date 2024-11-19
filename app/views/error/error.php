<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>{{ @website.title . ' | ' . @ERROR.status }}</title>
  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/vendor/semantic/2.4.1/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/css/app.css">
  <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
  <script src="{{@BASE}}/assets/vendor/semantic/2.4.1/semantic.min.js"></script>
</head>
<body class="{{ @SITE.BACKGROUND }}-background">
  <div class="full-screen-background">
    <div class="ui middle aligned center aligned grid centered-container">
      <div class="column">
        <div class="ui stacked segment">
          <h2 class="ui {{ @SITE.MAIN_COLOR }} image header">
            <a class="ui image" href="{{ @BASE }}/"><img src="{{ @BASE }}/assets/images/logo-{{ @SITE.MAIN_COLOR }}.png"></a>
            <div class="content">
              {{ @website.title }}
              <div class="sub header">{{ @error.title }}</div>
            </div>
          </h2>
          <div class="ui divider"></div>
          <div class="ui huge {{ @SITE.MAIN_COLOR }} statistic">
            <div class="value">
              {{ @ERROR.code }}
            </div>
            <div class="label">
              {{ @ERROR.status }}
            </div>
          </div>
          <div class="ui divider"></div>
          <switch expr="{{ @ERROR.code }}">
            <case value="{{ 403 }}" break="{{ TRUE }}">
              <p>{{ @error.403 }}</p>
            </case>
            <case value="{{ 404 }}" break="{{ TRUE }}">
              <p>{{ @error.404 }}</p>
            </case>
            <case value="{{ 500 }}" break="{{ TRUE }}">
              <p>{{ @error.500 }}</p>
            </case>
            <default>
              <p>{{ @error.other }}</p>
            </default>
          </switch>
        </div>
        <check if="{{ @SESSION.message }}">
          <div class="ui {{ @SESSION.message.type }} message">
            <p>{{ @SESSION.message.text|raw }}</p>
          </div>
        </check>
      </div>
    </div>
  </div>
</body>
</html>