<div class="ui <?php echo $SITE['MAIN_COLOR']; ?> inverted vertical footer segment">
    <div class="ui center aligned container">
        <div class="ui inverted section divider"></div>
        <div class="tablet-and-below-center column"><h4 class="ui inverted copyright header"><img src="<?php echo $BASE; ?>/assets/images/logo-zinsfox.png" class="ui image" style="width: 8.5em;top:-12px;">
        ZinsFox (SB Beratungs und Vermögensverwaltungs AG) <?php echo $footer['text']; ?>

      <div class="ui inverted section divider"></div>
    </div>

<?php echo $this->render($tpl['analytics'],$this->mime,get_defined_vars(),0); ?>