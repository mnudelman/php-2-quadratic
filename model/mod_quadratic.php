<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 06.06.15
 * Time: 19:58
 */

class mod_quadratic {
    // коэффициенты уравнения
    private $a ;     // $a - a*x**2
    private $b ;     // $b - b*x
    private $c ;     // $c - c
    private $x1  ;     // 1 корень уравнения - действительная част
    private $x2  ;     // 2 корень уравнения - действительная часть
    private $x1_i  ;     // 1 корень уравнения - мнимая часть
    private $x2_i  ;     // 2 корень уравнения - мнимая часть
    private $delta = [] ;  // результат подстановки корней
    private $solution = [] ; // решение
    private $D ;           // дескриминант
    private $error = false ;

    //---------------------------------------//
    public function __construction() {
    }
    public function setCoefficients($A,$B,$C) {
        $this->a = (float) $A ;
        $this->b = (float) $B ;
        $this->c = (float) $C ;
        if (abs($this->a) < TaskStore::EPSILON) {
            $this->error = true ;
            return false ;
        }
        return true ;
    }
    public function getCoefficients() {
        return  [
            'a'  => $this->a ,
            'b'  => $this->b ,
            'c'  => $this->c ] ;

    }

        public function calculate() {
        $epsilon = TaskStore::EPSILON ;
        $x1 = 0;
        $x2 = 0;
        $x1_i = 0 ;
        $x2_i = 0 ;
        /* !!  - opCod == "clc" - расчет корней **/
        $d = $this->b * $this->b - 4 * $this->a * $this->c;
        /** Дескриминант  */
        $d = (abs($d) < $epsilon) ? 0 : $d;
        /** малое d - считаем за 0   */
        $dSign = ($d < 0) ? -1 : (($d > 0) ? 1 : 0);
        switch ($dSign) {
            case 1:
                $q = sqrt($d);
                $x1 = (-$this->b + $q) / (2 * $this->a);
                $x2 = (-$this->b - $q) / (2 * $this->a);
                break;
            case 0:
                $x1 = -$this->b / (2 * $this->a);
                $x2 = $x1;
                break;
            case -1;
                $q = sqrt(-$d);
                $x1 = -$this->b/ (2 * $this->a) ;
                $x1_i = $q / (2 * $this->a);
                $x2 = -$this->b / (2 * $this->a);
                $x2_i = -$q / (2 * $this->a);
                break;
        }
        $this->x1 = $x1 ;
        $this->x2 = $x2 ;
        $this->x1_i = $x1_i ;
        $this->x2_i = $x2_i ;
        $this->D = $d ;
        $this->solution['x1'] = [
            'real' => $this->x1,
            'image'=> $this->x1_i ] ;
        $this->solution['x2'] = [
            'real' => $this->x2,
            'image'=> $this->x2_i ] ;
        $this->delta['x1'] = $this->deltaClc($this->x1,$this->x1_i) ;
        $this->delta['x2'] = $this->deltaClc($this->x2,$this->x2_i) ;
    }

    /**
     * вычисляет результат подстановки корня
     * @param $x
     * @param $x_i
     * @return array
     */
    private function deltaClc($x,$x_i) {
        $real = 0 ;
        $image = 0 ;
        $delta = [] ;
        if ($this->D < 0) {
            $real = $this->a * $x * $x +  $this->b * $x + $this->c - $this->a * $x_i * $x_i ;
            $image = 2*$this->a * $x * $x_i + $this->b*$x_i ;
        }else {
            $real = $this->a * $x * $x + $this->b * $x + $this->c ;
        }
        $delta = ['real' => $real,
                  'image' => $image ] ;
        return $delta;
    }
    public function getDiscriminant() {
        return $this->D ;
    }
    public function getSolution() {
        return $this->solution ;
    }
    public function getDelta() {
        return $this->delta ;
    }

}