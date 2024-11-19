<!DOCTYPE html>
<html>
<head>
  <include href="{{ @tpl.meta }}" />
</head>
<body class="{{ @SITE.BACKGROUND }}-background">
  <include href="{{ @tpl.header }}" />
  <div id="content-container">
    <include href="{{ @tpl.content }}" />
  </div>
  <include href="{{ @tpl.footer }}" />
</body>