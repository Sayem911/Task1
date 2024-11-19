<script type="text/javascript">
  $(document).ready(function () {
    // fill timezone selection dropdown
    var $timezone = $('#timezone-dropdown');
    $.each(moment.tz.names(), function (i, timezone) {
      $timezone.append('<option value="'+timezone+'" '+(timezone=='{{ @USER.timezone }}'?'selected':'')+'>'+timezone+'</option>');
    });
    $('.ui.dropdown').dropdown();
    
    $('.ui.checkbox').on('change', function(e){
       if(e.target.checked){
         $('#modal-gtfa-register').modal();
         alert('clicked');
       }
    });
      
  });
</script>