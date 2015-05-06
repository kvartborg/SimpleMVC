<html>
<head>

  <!--<base href="https://<?= $_SERVER['SERVER_NAME'] ?>/public/" />-->
</head>

<body>
<img src="/public/svg/simple-mvc.svg" />

  <?php
    //var_dump($users);

    $array = ['Frederik', 'test', ['test' => 'banana', 'yes' => 'no'], 'hello world!'];

    var_dump($array);

    echo json_encode($array);
  ?>
</body>
</html>