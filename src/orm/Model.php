<?php
class Model
{
    protected $table = '';
    protected $attributes = [];
    protected $columns = [];
    protected $pdo;
    public function __construct($attrs = [])
    {
        $this->connectDatabase();
        $this->table == '' ? strtolower(get_class($this)) : $this->table;
        $this->getColmns();
        foreach ($attrs as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    public function all()
    {
        $collection = array();
        $sql = "select * from " . $this->table;
        $stmt = $this->pdo->query($sql);
        while ($row = $stmt->fetch()) {
            $atts = array();
            foreach ($this->columns as $field) {
                try {
                    $atts[$field] = $row[$field];
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
            $clsName = get_class($this);
            $collection[] = new $clsName($atts);
        }
        return $collection;
    }

    public function getColmns()
    {
        $sql = "SHOW COLUMNS FROM orm." . $this->table;
        $stmt = $this->pdo->prepare($sql);
        try {
            if ($stmt->execute()) {
                $raw_column_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($raw_column_data as $key => $value) {
                    $this->columns[] = $value['Field'];
                }
            }
            return $this->columns;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function connectDatabase()
    {
        $this->pdo = MySQL::getInstance()->getPdo();
    }

    public function toString()
    {
        return strtolower(get_class($this));
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get($key)
    {
        return $this->attributes[$key];
    }
}
