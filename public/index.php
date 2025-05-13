<?php

// Ajout d'une fonction minimale pour éviter les erreurs de code vide lors de l'analyse avec PHP_CodeSniffer (phpcs).
// Cette fonction ne fait rien mais permet de valider les fichiers sans logique métier.

function exampleFunctionCI()
{
    return true;
}
