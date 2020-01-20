<?php
// CHECKBOX
require_once 'functions.php';
$title = "Page d'accueil";
require 'header.php';
?>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="GET">
  <h5>Veuillez choisir les parfums de votre glace : </h5>

  <!-- PARFUMS -->
  <?php foreach ($parfums as $parfum => $price) : ?>
  <div class="checkbox">
    <label>
      <?= checkbox('parfums', $parfum, $_GET) ?> - <?= $price ?> €
    </label>
  </div>

  <?php endforeach ?>

  <!-- CORNETS -->
  <h5>Choisissez le type du cornet : </h5>
  <?php foreach ($cornets as $cornetType => $price) : ?>
  <div class="radio">
    <label>
      <?= radio('cornets', $cornetType, $_GET) ?> - <?= $price ?> €
    </label>
  </div>

  <?php endforeach ?>

  <h5>Choisissez des supplements : </h5>
  <!-- SUPPLEMENTS -->
  <?php foreach ($supplements as $supplement => $price) : ?>
  <div class="checkbox">
    <label>
      <?= checkbox('supplements', $supplement, $_GET) ?> - <?= $price ?> €
    </label>
  </div>

  <?php endforeach ?>

  <button class="btn btn-primary" type="submit" style="margin-top:20px">Caluler le prix</button>

  <div>
    <h4>Le prix est de : <?= calculate_price(); ?></h4>
  </div>
</form>



<!--  FOOTER -->
<?php require 'footer.php' ?>