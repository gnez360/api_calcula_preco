<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Parser extends Model {

    public $tax;
    public $price_tax;
    public $price_weight;
    public $product;
    public $value;
    public $iof;
    public $total;
    public $dolar;

    public function __construct($dolar, $product)
    {      
       $this->product = $product;
       $this->dolar = $dolar;
       $this->tax = $this->setTax();
       $this->value = $this->setValue();
       $this->price_tax = $this->setPriceTax();
       $this->iof = $this->setIOF();
       $this->price_weight = $this->setWeightPrice();
       $this->total = $this->setTotal();
    }

    public function setDolar($dolar){
        $this->dolar = $dolar;
    }
   
    public function setTax(){

        $type = $this->product->type;  

        switch ($type) {
            case '1':
            case '2':
            case '3':
            case '4':
            case '8':
                return 0.2;              
                break;            
             case '5':
             case '7':                
                return 0.25;
                break;        
             case '6':
                return 0.3;
                break;   
             case '9':
                return 0.4;
                break;   

            default:  
                return 0.2;             
                break;
        }
       
    }

    public function setPriceTax()
    {
        $tax = $this->tax;
        return (float)$this->product->price * (float)$tax * $this->dolar;
    }

    public function setValue(){
        $price = $this->product->price;
        return (float)$price * (float)$this->dolar;       
    }

    public function setIOF(){
        $iof = $this->value * 0.0634;
        return (float)$iof;
    }

    public function setWeightPrice()
    {
        return $this->product->weight * 0.032 * $this->dolar;
    }

    public function setTotal(){
        return $this->value + $this->price_tax + $this->iof + $this->price_weight;        
    }

}