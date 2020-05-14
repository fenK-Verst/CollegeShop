<?php

define("PROJECT_DIR", __DIR__ . "/../");
require_once(PROJECT_DIR . "/vendor/autoload.php");

use App\Config;
use App\Db\ArrayDataManager;
use App\Db\Interfaces\ConnectionInterface;
use App\Db\Interfaces\ObjectDataManagerInterface;
use App\Db\Interfaces\ObjectManagerInterface;
use App\Db\ObjectDataManager;
use App\Db\ObjectManager;
use App\Di\Container;
use App\Db\Connection;
use App\Db\Interfaces\ArrayDataManagerInterface;
use App\Entity\AbstractEntity;
use App\Entity\EntityInterface;
use App\Entity\Folder;
use App\Entity\Product;
use App\Entity\Vendor;
use App\Repository\FolderRepository;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;


$container = new Container([
    ConnectionInterface::class => Connection::class,
    ArrayDataManagerInterface::class => ArrayDataManager::class,
    ObjectDataManagerInterface::class => ObjectDataManager::class,
    ObjectManagerInterface::class => ObjectManager::class,
]);
$container->singletone(Container::class, function () use ($container) {
    return $container;
});
$dotenv = \Dotenv\Dotenv::createImmutable(PROJECT_DIR, '.env.local');
$dotenv->load();
$container->singletone(Config::class);
$container->singletone(ObjectManager::class);
$container->singletone(ArrayDataManager::class);
$container->singletone(ObjectDataManager::class);
$container->singletone(Connection::class, function () {
    $host = getenv("DB_HOST");
    $db_name = getenv("DB_NAME");
    $password = getenv("DB_PASSWORD");
    $user = getenv("DB_USER");
    $port = (int)getenv("DB_PORT");
    return new Connection($host, $user, $password, $db_name, $port);
});

$faker = \Faker\Factory::create();
$folderRepository = $container->get(FolderRepository::class);
$vendorRepository = $container->get(VendorRepository::class);
$productRepository = $container->get(ProductRepository::class);
$object_manager = $container->get(ObjectManager::class);


for($i=1;$i<11;$i++){

    $vendor = new Vendor();
    $vendor->setName($faker->unique()->company);

    $folder = new Folder();
    $folder->setName($faker->unique()->word);
    $folder->setLvl(1);
    $folder->setLeft($i*2-1);
    $folder->setRight($i*2);

    $object_manager->save($folder);
    $object_manager->save($vendor);

}

for($i=0; $i<100;$i++){
    $product = new Product();

    $product->setName($faker->unique()->word);
    $product->setCount(rand(5,100));
    $product->setPrice(rand(5000,20000));
    $product->setDescription($faker->text(350));
    $product->setArticle($faker->text(5));

    $vendor = $vendorRepository->find(rand(0,9));
    $product->setVendor($vendor);

    $folder_count = rand(1,3);
    for($j=0;$j<$folder_count;$j++){
        $folder = $folderRepository->find(rand(0,9));
        if ($folder) $product->addFolder($folder);
    }
    $object_manager->save($product);
}