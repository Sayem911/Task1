<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta property="og:title" content="{{ @website.title }}" />
  <meta property="og:description" content="{{ @website.slogan }}. {{ @website.slogan2 }}." />
  <meta property="og:url" content="{{ Helper::baseUrl() }}" />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="{{ Helper::baseUrl() }}assets/images/background-header.png" />

  <title>{{ @website.title . ' | ' . @vars.title }}</title>

  <link rel="apple-touch-icon" sizes="57x57" href="{{ @BASE }}/assets/images/icons/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ @BASE }}/assets/images/icons/apple-touch-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ @BASE }}/assets/images/icons/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ @BASE }}/assets/images/icons/apple-touch-icon-76x76.png">
  <link rel="icon" type="image/png" href="{{ @BASE }}/assets/images/icons/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="{{ @BASE }}/assets/images/icons/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/png" href="{{ @BASE }}/assets/images/icons/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="{{ @BASE }}/assets/images/icons/manifest.json">
  <link rel="mask-icon" href="{{ @BASE }}/assets/images/icons/safari-pinned-tab.svg" color="#5bbad5">
  <link rel="shortcut icon" href="{{ @BASE }}/assets/images/icons/favicon.ico">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="msapplication-config" content="{{ @BASE }}/assets/images/icons/browserconfig.xml">
  <meta name="theme-color" content="#ffffff">

  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/vendor/semantic/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/vendor/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/vendor/slick/slick-theme.css"/>
  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/css/app.css">

  <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
  <script src="{{@BASE}}/assets/vendor/semantic/semantic.min.js"></script>
  <script src="{{@BASE}}/assets/vendor/slick/slick.min.js"></script>
  <script src="{{@BASE}}/assets/vendor/typed/typed.min.js"></script>
  <script src="{{@BASE}}/assets/js/app{{ @MINIFIED_JS?'.min':'' }}.js"></script>

  <script>
    $(document).ready(function () {
      $('#stock-exchanges-carousel').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        autoplay: true,
        variableWidth: false,
        mobileFirst: true,
        pauseOnFocus: false,
        pauseOnHover: false
      });

      $('#key-boxes .column').mouseover(function () {
        $(this).find('.icon').addClass('blue loading');
      }).mouseout(function () {
        $(this).find('.icon').removeClass('blue loading');
      });

      $('.admin-screenshot.image').dimmer({
        on: 'hover'
      });

      $('.masthead h2').typed({
        strings: ['{{ @website.slogan }}','{{ @website.slogan2 }}','{{ @website.slogan3 }}'],
        startDelay: 1000,
        typeSpeed: 50
      });
    });
  </script>
</head>
<body class="index-page">
  <div class="ui inverted vertical masthead center aligned segment">
    <div class="ui text container">
      <h1 class="ui inverted header">
        {{ @website.title }}
      </h1>
      <div><h2>&nbsp;</h2></div>
      <a href="{{ @BASE }}/signup" class="ui huge blue inverted button">{{ @index.button.demo }} <i class="right arrow icon"></i></a>
    </div>
  </div>

  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>

  <div class="ui container">
    <div class="ui stackable padded center aligned grid">
      <div class="column">
        <p class="large-text">
          Virtual Stock Exchange is a web application, which gives people a chance to try trading stocks without investing real money.
        </p>
      </div>
    </div>
  </div>

  <div class="ui container">
    <div class="ui stackable padded stripe center aligned grid">
      <div class="column">
        <img src="{{ @BASE }}/assets/images/index/virtual-stock-exchange-laptop.png" class="ui image">
      </div>
    </div>
  </div>

  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>

  <div class="ui alternate vertical stripe segment">
    <div class="ui center aligned grid container">
      <div class="column">
        <h2 class="ui header">
          Master your trading skills
          <div class="sub header">Trade on world stock exchanges with ease</div>
        </h2>
        <div id="stock-exchanges-carousel">
          <div><img class="ui image" src="{{ @BASE }}/assets/images/index/nasdaq.png"></div>
          <div><img class="ui image" src="{{ @BASE }}/assets/images/index/nyse.png"></div>
          <div><img class="ui image" src="{{ @BASE }}/assets/images/index/lse.png"></div>
          <div><img class="ui image" src="{{ @BASE }}/assets/images/index/asx.png"></div>
          <div><img class="ui image" src="{{ @BASE }}/assets/images/index/xetra.png"></div>
          <div><img class="ui image" src="{{ @BASE }}/assets/images/index/frankfurt.png"></div>
          <div><img class="ui image" src="{{ @BASE }}/assets/images/index/six.png"></div>
          <div><img class="ui image" src="{{ @BASE }}/assets/images/index/bovespa.png"></div>
          <div><img class="ui image" src="{{ @BASE }}/assets/images/index/toronto.png"></div>
          <div><img class="ui image" src="{{ @BASE }}/assets/images/index/hkex.png"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>

  <div class="ui container">
    <div class="ui hidden divider"></div>
    <div class="ui hidden divider"></div>
    <div class="ui divider"></div>
    <div class="ui stackable padded stripe center aligned grid">
      <div class="column">
        <h2 class="ui header">Main features</h2>
      </div>
    </div>
    <div class="ui hidden divider"></div>
    <div class="ui hidden divider"></div>
  </div>

  <div id="key-features" class="ui container">
    <div class="ui stackable padded stripe grid">
      <div class="row">
        <div class="ui stackable mobile reversed centered grid">
          <div class="five wide right aligned column product-image-container">
            <img class="ui image" src="{{ @BASE }}/assets/images/index/virtual-stock-exchange-markets.png" alt="{{ @website.title }}" title="{{ @website.title }}">
          </div>
          <div class="one wide column"></div>
          <div class="six wide column">
            <h3 class="ui header">
              Markets screen
            </h3>
            <p>Markets page provides a quick overview of the current state of global markets. </p>
            <ul>
              <li>Breaking news ticker</li>
              <li>Major currencies rates</li>
              <li>Major stock indices values</li>
              <li>Personalized watchlist</li>
              <li>Stock exchanges schedule</li>
              <li>Dynamic quotes updates</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="ui stackable grid">
          <div class="six wide column">
            <h3 class="ui header">
              Trade screen
            </h3>
            <p>Trade page provides click & trade functionality, displays key statistics, news headlines and interactive charts for the selected stock. </p>
            <ul>
              <li>Stock search</li>
              <li>Buy and sell stocks</li>
              <li>Add or remove stocks to / from watchlist</li>
              <li>Key Statistics (Market capitalization, Shares outstanding, Trading volume etc)</li>
              <li>News headlines</li>
              <li>Interactive stock chart with comparison capabilities</li>
            </ul>
          </div>
          <div class="ten wide center aligned column product-image-container">
            <img class="ui image" src="{{ @BASE }}/assets/images/index/virtual-stock-exchange-trade.png" alt="{{ @website.title }}" title="{{ @website.title }}">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="ui stackable mobile reversed grid">
          <div class="ten wide center aligned column product-image-container">
            <img class="ui image" src="{{ @BASE }}/assets/images/index/virtual-stock-exchange-portfolio.png" alt="{{ @website.title }}" title="{{ @website.title }}">
          </div>
          <div class="six wide column">
            <h3 class="ui header">
              Portfolio screen
            </h3>
            <p>Portfolio page allows user to manage own position in stocks and view history of trades. </p>
            <ul>
              <li>Historical Cost, Market Value and Unrealized P/L of current position</li>
              <li>Trades history</li>
              <li>Balance change history chart</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>

  <div class="ui container">
    <div class="ui stackable padded stripe center aligned one column grid">
      <div class="column">
        <h2 class="ui header">
          Too good to be true?
          <div class="sub header">Create a virtual trading account and see for yourself</div>
        </h2>
      </div>
      <div class="column">
        <a href="{{ @BASE }}/signup" class="ui huge blue inverted button">Demo</a>
      </div>
      <p>All users are provided with virtual $100,000 USD to practice stock trading.</p>
    </div>
  </div>

  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>

  <div class="ui inverted vertical footer segment">
    <div class="ui container">
      <div class="ui inverted equal width height stackable bottom aligned grid">
        <div class="left aligned column">
          Copyright &copy; <?=date('Y')?>&nbsp;<a href="http://financialplugins.com">FinancialPlugins.com</a>
        </div>
        <div class="right aligned column">
          <p>We accept</p>
          <i class="big visa icon"></i>
          <i class="big mastercard icon"></i>
          <i class="big american express icon"></i>
          <i class="big paypal card icon"></i>
        </div>
      </div>
    </div>
  </div>

  <include href="{{ @tpl.analytics }}" />
</body>
</html>