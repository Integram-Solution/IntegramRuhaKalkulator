<?php

try {
    $pdo = new PDO('mysql:host=backend-mysql-1;dbname=laravel', 'sail', 'password');
    echo "Sikeres MySQL kapcsolat!";
} catch (PDOException $e) {
    echo "Kapcsolódási hiba: " . $e->getMessage();
}