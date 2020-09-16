<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
   
    public $type;
    public $price;
    public $weight;

    public function __construct($type, $price, $weight)
    {
        $this->type = $type;
        $this->price = $price;
        $this->weight = $weight;
    }
  

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setWeight($grams){
        $this->weight = $grams * 3.2;
    }

    public function getName()
    {
       return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getWeight()
    {
        return $this->weight;    
    }   


}