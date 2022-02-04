<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public $number = '1234 5678 9012 3456';
    private $balance = 950;
    private $pin_code = '1000';

    public function get_balance()
    {
        return $this->balance;
    }


    public function add_balance($sum)
    {
        if ($sum < 1000) {
            $this->make_transaction($sum);
        } else {
            echo '>1000';
        }
    }


    private function make_transaction($sum)
    {
        $this->balance = $this->balance + $sum;
    }




    // зміна паролю
    public function rand_pin_code()
    {
        return rand(998, 1002);
    }


    public function get_pin_code()
    {
        return $this->pin_code;
    }



    public function new_pin_code($code)
    {
        if( !is_numeric($code)){
            return 'Це не число';
        } elseif( mb_strlen($code)!=4 ){
            return 'Тут не 4 цифри';
        } else {
            $this->pin_code = $code;
            return 'Супер';
        }
    }



    // Знімаю гроші

    private function minus_money($sum)
    {
        if($this->balance >= $sum){
            $this->balance = $this->balance - $sum;
        }
        return $this->balance;

    }
   
    
    public function minus_transaction($sum, $pin_code)
    {
        if($this->balance < $sum){
            return 'Недостатньо грошів';
        }
        elseif($this->pin_code != $pin_code){
            return 'Невірний пароль';
        } else {
            $this->balance = $this->minus_money($sum);
            return 'Залишок:'. $this->balance .' грн';
        }

    }
}
