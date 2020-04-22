<?php


namespace App\Entity;


class AbstractEntity implements EntityInterface
{

    private array $entityParams = [];

    private ?array $columns = null;

    private ?string $primaryKey = null;

    public function getTableName(): string
    {
        $entity_params = $this->getEntityParams();
        $table_name = $entity_params["tableName"];
        if (!$table_name) throw new \Exception("Table Name not found in entity ");
        return  $table_name;
    }

    public function getRepositoryClass(): string
    {
        $entity_params = $this->getEntityParams();
        $repository_class =  $entity_params["repositoryClass"];
        if (!$repository_class) throw new \Exception("Repository Class not found in entity ");
        return  $repository_class;
    }

    public function getPrimaryKey(): string
    {
        if (is_null($this->primaryKey)){
            $this->parseEntityFields();
        }
        if (!$this->primaryKey) {
            var_dump($this);
            throw new \Exception("Primary Key not found");
        }

       return $this->primaryKey;
    }

    public function getColumns(): array
    {
       if (is_null($this->columns)){
           $this->parseEntityFields();
       }
        if (empty($this->columns)) throw new \Exception("Columns not found");
       return $this->columns;
    }
    private function getEntityParams()
    {
        if (empty($this->entityParams)){
            $this->parseEntityDoc();
        }
        return $this->entityParams;
    }
    private function parseEntityDoc()
    {
        $reflection_class = new \ReflectionClass($this);
        $doc = $reflection_class->getDocComment();

        $this->entityParams = $this->getParamsFromDoc("Entity", $doc);
    }
    private function parseEntityFields()
    {
        $this->primaryKey = '';
        $this->columns = [];

        $reflection_class = new \ReflectionClass($this);
        $properties = $reflection_class->getProperties();
        foreach ( $properties as $property){
            $doc = $property->getDocComment();
            $primary_key = $this->getParamsFromDoc('Entity\\\PrimaryKey', $doc);
            if ($primary_key !== false) $this->primaryKey = $property->getName();

            $column = $this->getParamsFromDoc('Entity\\\Column', $doc);
            if ($column !== false) $this->columns[] = $property->getName();
        }
    }
    private function getParamsFromDoc(string $key, string $doc)
    {
        preg_match_all("/@$key\((.*)\)/m", $doc, $finded);

        if (is_null($finded[0][0] ?? null)) return false;
        $params = explode(',', $finded[1][0]);
        $result = [];
        if (is_null($params{1} ?? null)) return [];
        foreach ($params as $param){
            $param = explode("=", $param);
            $result[trim($param[0])] = trim($param[1], '"');
        }

        return $result;
    }

    public function getPrimaryKeyValue()
    {
        $getter = $this->getPropertyGetter($this->getPrimaryKey());
        try {
            $value = $this->{$getter}();
        }catch (\Exception $e){
            $value = null;
        }
        return $value;
    }
    protected function getPropertyGetter(string $property)
    {
        $property = explode("_",$property);
        $property = array_map(function ($item){
            return ucfirst($item);
        }, $property);
        $property = implode("", $property);
        $result = "get$property";
        if (!method_exists($this, $result)){
            throw new \Exception("Method $result does not exists");
        } return $result;
    }
    protected function getPropertySetter(string $property)
    {
        $property = explode("_",$property);
        $property = array_map(function ($item){
            return ucfirst($item);
        }, $property);
        $property = implode("", $property);
        $result = "set$property";
        if (!method_exists($this, $result)){
            throw new \Exception("Method $result does not exists");
        } return $result;
    }

    public function getColumnValue(string $column): ?string
    {
        $this->isColumnExists($column);

        $getter = $this->getPropertyGetter($column);
        return $this->{$getter}();
    }
    private function isColumnExists(string $column):bool
    {
        if (is_null($this->columns)) {
            $this->parseEntityFields();
        }
        if (!in_array($column, $this->columns)) throw new \Exception("Column $column not found");

        return true;
    }

}
