<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$faker = \Faker\Factory::create('fr_FR');

$pdo = new PDO('mysql:host=localhost;dbname=db_myframework', 'root', 'root');
$pdo->exec('TRUNCATE TABLE post');
for ($i = 0; $i < 100; $i++) {
    $query = $pdo->prepare('INSERT INTO post SET 
                            name=:name,
                            slug=:slug,
                            content=:content,
                            created_at=:created_at,
                            updated_at=:updated_at');
    $date = $faker->date() . ' ' . $faker->time();
    $query->execute([
        'name' => $faker->words(3, true),
        'slug' => $faker->slug,
        'content' => $faker->paragraphs(10, true),
        'created_at' => $date,
        'updated_at' => $date
    ]);
}
