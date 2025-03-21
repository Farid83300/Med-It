<?php
/**
 * Script de correction pour les problèmes de compatibilité PHP 8 dans WordPress
 * 
 * Ce script ajoute l'attribut #[\ReturnTypeWillChange] aux méthodes des classes
 * qui implémentent les interfaces ArrayAccess et IteratorAggregate dans la 
 * bibliothèque Requests de WordPress.
 */

// Chemins des fichiers à modifier
$files = [
    // Vous devez ajuster ce chemin selon votre installation
    'wp-includes/Requests/Utility/CaseInsensitiveDictionary.php',
    'wp-includes/Requests/Cookie/Jar.php'
];

// Racine WordPress
$wpRoot = 'C:/wamp64/www/medit/';

// Fonction pour ajouter l'attribut #[\ReturnTypeWillChange] aux méthodes
function addReturnTypeAttribute($filePath) {
    if (!file_exists($filePath)) {
        echo "Le fichier $filePath n'existe pas.\n";
        return false;
    }

    // Lire le contenu du fichier
    $content = file_get_contents($filePath);
    if ($content === false) {
        echo "Impossible de lire le fichier $filePath.\n";
        return false;
    }

    // Sauvegarder une copie de sécurité
    $backupPath = $filePath . '.bak';
    if (!file_exists($backupPath)) {
        file_put_contents($backupPath, $content);
        echo "Sauvegarde créée : $backupPath\n";
    }

    // Ajouter l'attribut aux méthodes ArrayAccess
    $methods = ['offsetExists', 'offsetGet', 'offsetSet', 'offsetUnset', 'getIterator'];
    $modified = false;

    foreach ($methods as $method) {
        // Recherche le motif de la déclaration de méthode sans l'attribut
        $pattern = '/public\s+function\s+' . $method . '\s*\(/';
        
        // Vérifie si la méthode existe et ne possède pas déjà l'attribut
        if (preg_match($pattern, $content) && !preg_match('/#\[\\\\ReturnTypeWillChange\]\s+public\s+function\s+' . $method . '\s*\(/', $content)) {
            // Ajoute l'attribut avant la déclaration de la méthode
            $replacement = "#[\ReturnTypeWillChange]\n    public function " . $method . "(";
            $content = preg_replace($pattern, $replacement, $content);
            $modified = true;
            echo "Attribut ajouté à la méthode $method dans $filePath\n";
        }
    }

    if (!$modified) {
        echo "Aucune modification nécessaire dans $filePath\n";
        return true;
    }

    // Écrire le contenu modifié dans le fichier
    if (file_put_contents($filePath, $content) === false) {
        echo "Impossible d'écrire dans le fichier $filePath\n";
        return false;
    }

    echo "Fichier $filePath modifié avec succès\n";
    return true;
}

// Exécuter les corrections
echo "Début des corrections...\n";
foreach ($files as $file) {
    $filePath = $wpRoot . $file;
    echo "Traitement du fichier : $filePath\n";
    addReturnTypeAttribute($filePath);
    echo "-----------------------------------\n";
}
echo "Corrections terminées.\n";

