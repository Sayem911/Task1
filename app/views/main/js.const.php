<script type="text/javascript">
  var DEBUG = parseInt('{{ @APPDEBUG.JS_LOGGING }}');
  var LIVE_QUOTES_URI = '{{ @BASE }}/api/data/quotes';
  var LIVE_QUOTES_INTERVAL = 60000; // 1min
  var SERVER_TIMEZONE = '{{ @SITE.TIMEZONE }}';
  var USER_TIMEZONE = '{{ @USER.timezone }}';
  var DATE_TIME_FORMAT = 'YYYY-MM-DD HH:mm:ss';
  var NEWS_DATE_TIME_FORMAT = 'ddd, DD MMM YYYY HH:mm:ss ZZ';
  // datatables translations
  var DATATABLES_TRANSLATIONS = {
    sSearch:       '',
    sInfo:         '{{ @datatables.info }}',
    sInfoFiltered: '{{ @datatables.infoFiltered }}',
    sEmptyTable:   '{{ @datatables.emptyTable }}',
    oPaginate: {
      sFirst:     '{{ @datatables.first }}',
      sLast:      '{{ @datatables.last }}',
      sNext:      '{{ @datatables.next }}',
      sPrevious:  '{{ @datatables.previous }}'
    }
  };
  // datatables pagination buttons classes
  $(document).ready(function () {
    if (typeof $.fn.dataTable != 'undefined') {
      $.fn.dataTable.ext.classes.sPageButton = 'ui basic tiny button';
    }
  });
</script>