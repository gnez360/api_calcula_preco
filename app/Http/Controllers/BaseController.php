<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Product;
use App\Parser;

class BaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void     * 
     */
    public function dolar(Request $request)
    {
        //https://www.facebook.com/groups/641831569255074/permalink/1119587728146120/?__tn__=K-R

       
        $data = array();

        if(!$request->valor){
            $data['status'] = "400";
            $data['message'] = "valor do produto é obrigatório";
            return response()->json($data,400);
        }

        $value = $request->valor;
        $type =$request->tipo;
        $weight = $request->peso;  

        if(!$type){
            $type = 1;
        }      

        if(!$weight){
            $weight = 1000;
        }

        if(is_numeric($value) && is_numeric($type) && is_numeric($weight))
        {        
            $product = new Product($type,$value,$weight);   

            try {

                $response = Http::get('https://economia.awesomeapi.com.br/json/daily/USD-BRL');

                $body = json_decode($response->getBody());

                $dolar = $body[0]->bid;
                
                $parser = new Parser($dolar, $product);    
                            
                $produto_real = number_format($parser->value, 2, '.', '');
                $final = number_format($parser->total, 2, '.', '');            
                $taxa = number_format($parser->price_tax, 2, '.', '');
                $iof = number_format($parser->iof, 2, '.', '');
                $peso = number_format($parser->price_weight, 2, '.', '');

                $data['status'] = "200";
                $data['message'] = "success";
                $data['data']['valor_dolar_hoje'] = "$dolar";
                $data['data']['valor_produto'] = "$value";
                $data['data']['valor_produto_real'] = "$produto_real";
                $data['data']['peso'] = "$peso";
                $data['data']['valor_taxa'] = "$taxa";
                $data['data']['valor_iof'] = "$iof";
                $data['data']['valor_final'] = "$final";
                

            } catch (\Throwable $th) {
                $final = $th->getMessage();
            }        
            
            return response()->json($data,200);
        }
        else
        {
            $data['status'] = "400";
            $data['message'] = "apenas numeros sao permitidos";
            return response()->json($data,400);
        }
    }

    //
}
