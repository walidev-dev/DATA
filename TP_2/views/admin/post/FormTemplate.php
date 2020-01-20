<form action="" method="POST">

    <!-- DATE -->

    <?= $form->input("La Date", "date"); ?>

    <!-- NAME -->

    <?= $form->input("Le Nom", "name"); ?>

    <!-- SLUG -->

    <?= $form->input("URL", "slug"); ?>

    <!-- CONTENT -->

    <?= $form->textArea("Le Contenu", "content"); ?>

    <!-- CATEGORIES -->

    <?= $form->select("categories", "Les Catégories", $options, $categoriesID_post); ?>

    <!-- SUBMIT -->

    <?= $form->submit("Enregistrer") ?>

</form>