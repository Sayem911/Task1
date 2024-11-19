<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title><?php echo $website['title'] . ' | ' . $ERROR['status']; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/vendor/semantic/2.4.1/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $BASE; ?>/assets/css/app.css">
  <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
  <script src="<?php echo $BASE; ?>/assets/vendor/semantic/2.4.1/semantic.min.js"></script>
</head>
<body class="<?php echo $SITE['BACKGROUND']; ?>-background">
  <div class="full-screen-background">
    <div class="ui middle aligned center aligned grid centered-container">
      <div class="column">
        <div class="ui stacked segment">
          <h2 class="ui <?php echo $SITE['MAIN_COLOR']; ?> image header">
            <a class="ui image" href="<?php echo $BASE; ?>/"><img src="<?php echo $BASE; ?>/assets/images/logo-<?php echo $SITE['MAIN_COLOR']; ?>.png"></a>
            <div class="content">
              <?php echo $website['title']; ?>
              <div class="sub header"><?php echo $error['title']; ?></div>
            </div>
          </h2>
          <div class="ui divider"></div>
          <div class="ui huge <?php echo $SITE['MAIN_COLOR']; ?> statistic">
            <div class="value">
              <?php echo $ERROR['code']; ?>
            </div>
            <div class="label">
              <?php echo $ERROR['status']; ?>
            </div>
          </div>
          <div class="ui divider"></div>
          <?php switch ($ERROR['code']): ?><?php case 403: ?>
              <p><?php echo $error[403]; ?></p>
            <?php if (TRUE) break; ?><?php case 404: ?>
              <p><?php echo $error[404]; ?></p>
            <?php if (TRUE) break; ?><?php case 500: ?>
              <p><?php echo $error[500]; ?></p>
            <?php if (TRUE) break; ?><?php default: ?>
              <p><?php echo $error['other']; ?></p>
            <?php break; ?><?php endswitch; ?>
        </div>
        <?php if ($SESSION['message']): ?>
          <div class="ui <?php echo $SESSION['message']['type']; ?> message">
            <p><?php echo $this->raw($SESSION['message']['text']); ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>