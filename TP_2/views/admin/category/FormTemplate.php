<form action="" method="POST">

    <!-- NAME -->

    <?= $form->input("Le Nom", "name"); ?>

    <!-- SLUG -->

    <?= $form->input("URL", "slug"); ?>

    <!-- SUBMIT -->

    <?= $form->submit("Enregistrer") ?>

</form>