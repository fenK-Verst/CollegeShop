<?php


namespace App\Repository;


use App\Db\ObjectDataManager;
use App\Entity\Flag;

/**
 * Class FlagRepository
 *
 * @package App\Repository
 * @method Flag find(string $primary_key_value)
 * @method Flag findOrCreate(string $primary_key_value)
 * @method Flag[] findAll()
 */
class FlagRepository extends AbstractRepository
{
    public function __construct(ObjectDataManager $dataManager)
    {
        parent::__construct($dataManager, Flag::class);
    }
}