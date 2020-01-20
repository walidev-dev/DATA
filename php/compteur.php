<?php
function ajouter_vue(): void
{
    $fichier = 'data' . DIRECTORY_SEPARATOR . 'compteur-' . date('Y-m-d');
    if (file_exists($fichier)) {
        $compteur = (int) file_get_contents($fichier);
        $compteur++;
        $fichier = fopen($fichier, 'r+');
        unset($fichier[0]); // SUPPRIME LA 1ERE LIGNE
        /* ftruncate($fichier,0);   //  REDUIT LA TAILLE DU FICHIER A 0 */
        fwrite($fichier, $compteur);
        fclose($fichier);
    } else {
        file_put_contents($fichier, '1');
    }
}
function nombre_vue(): string
{
    $fichier = 'data' . DIRECTORY_SEPARATOR . 'compteur-' . date('Y-m-d');
    $compteur = file_get_contents($fichier);
    return $compteur;
}
