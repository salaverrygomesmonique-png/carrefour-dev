<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Checkout example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/form-validation.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2>Pagamento Online</h2>
        <p class="lead">Aprenda a criar uma página no seu ecommerce para receber pagamentos online com Bootstrap e PHP.</p>
      </div>

      <div class="row">
        
        <div class="col-md-12">
			<?php
			if(isset($_GET['cod'])){
			if($_GET['cod'] == "0"){ ?>
			<div class="alert alert-success" role="alert">
			  Pagamento realizado com sucesso! <?php echo "TID " . $_GET['TID']; ?>
			</div>
			<?php }else if($_GET['cod'] == "1"){ ?>
			<div class="alert alert-danger" role="alert">
			  Falha ao realizar o pagamento! <?php echo "Status: " . $_GET['status'] . " | Erro: " . $_GET['erro']; ?>
			</div>
			<?php }else{ ?>
			<div class="alert alert-danger" role="alert">
			  Falha ao realizar o pagamento! <?php echo "Erro Integração : " . $_GET['erro']; ?>
			</div>				
			<?php }}?>
			
        </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2018 Company Name</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#">Privacy</a></li>
          <li class="list-inline-item"><a href="#">Terms</a></li>
          <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/holder.min.js"></script>
    
  </body>
</html>
