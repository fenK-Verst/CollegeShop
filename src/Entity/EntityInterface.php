<?php


namespace App\Entity;


interface EntityInterface
{
    public function getTableName(): string;

    public function getRepositoryClass(): string;

    public function getPrimaryKey(): string;

    public function getPrimaryKeyValue();

    public function getColumns(): array;

    public function getColumnValue(string $column):?string;

    public function getSingleDependencies():array;
}