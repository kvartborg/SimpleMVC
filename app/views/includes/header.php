<html>
<head>
  <meta charset="utf-8"> 
  <meta http-equiv="cache-control" content="max-age=0" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="expires" content="0" />
  <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
  <meta http-equiv="pragma" content="no-cache" />

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Velkommen til Kvartborg.net</title>

  <script src="//use.typekit.net/oqz0pmk.js"></script>
  <script>try{Typekit.load();}catch(e){}</script>
  
  <base href="https://kvartborg.net/public/" />
  <link rel="stylesheet" type="text/css" href="assets/css/main.css" />
  <link rel="stylesheet" type="text/css" href="assets/highlighter/codepen-embed.css">
  <script type='text/javascript' src='assets/js/jquery-1.11.2.min.js'></script>
  <script>
    $(document).ready(function() {
      $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
      });

      var t = new Trianglify({ x_gradient: ["#ae454f", "#c84e28", "#9a0911"]});
      var pattern = t.generate(document.body.clientWidth, document.body.clientHeight);
      document.body.setAttribute('style', 'background-image: '+pattern.dataUrl);
    });
  </script>

</head>

<body>

  <nav class="nav">
    <div class="logo">Fk</div>
      <!--<ul>
        <a href="/hello"><li>Blog</li></a>
        <a href="/portfolio"><li>Portfolio</li></a>
        <a href="/about"><li>About</li></a>
      </ul>-->
  </nav>
