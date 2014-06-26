<html>
<head>
<title>Form Testing</title>
<link type="text/css" rel="stylesheet" href="/stylesheets/stylesheet.css" />
</head>
  <body>
    <?php
      if (array_key_exists('content', $_POST)) {
        echo "You wrote:<pre>\n";
        echo htmlspecialchars($_POST['content']);
        echo "\n</pre>";
      }
    ?>
    <form action="/formtest" method="post">
      <div><textarea name="content" rows="3" cols="60"></textarea></div>
      <div><input type="submit" value="Submit Test"></div>
    </form>
  </body>
</html>