<?php include(__dir__.'/../includes/header.php'); ?>

<div id="particles"></div>

<center style="margin-top:100px;"><h1>Siden blev ikke fundet...</h1></center>

<pre><code class="php">class BaseController {

  public function notFound(){
    $this->view('/error/404');
  }

  public function model($model){
    require_once '../app/models/'.$model.'.php';
    return new $model();
  }

  public function view($view, $data = []){
    require_once '../app/views'.$view.'.php';
  }

}
</code></pre>
  
<?php include(__dir__.'/../includes/footer.php'); ?>