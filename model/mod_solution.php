<?php
/**
 * класс - решение квадратного уравнения
 * Date: 08.06.15
 *
 */

class mod_solution extends mod_base {
    protected $msg ;  // объект - вывод сообщений
    //-------------------------------------------------//
    private $modQuadr ;              // объект класса mod_quadratic - квадратное уравнение
    private $solutions = [];        // список всех решений
    private $error = false ;
    //-------- параметры генерации решений   -------------//
    //-------------------------------------------------//
    public function __construct() {
        parent::__construct() ;
        $this->modQuadr = new mod_quadratic() ;
    }

    /**
     * получает от контроллера тек состояние спискаРешений
     * @param $allS
     */
    public function setSolutions($allS) {
        $this->solutions = $allS ;
    }
    public function getSolutions() {
        return $this->solutions ;
    }
    public function clearSolutions() {
        $this->solutions = [] ;
    }
    public function calculate($a,$b,$c) {
        $res = $this->modQuadr->setCoefficients($a, $b, $c);    // задать коэффициенты
        if (false === $res) {
            $this->msg->addMessage('ERROR: Коэффициенты:A = '.$a.' B = '.$b.' C='.$c. 'не дают квадратное уравнение!') ;
            $this->error = true ;
            return false ;
        }
        $this->modQuadr->calculate() ;
        $this->storeResult() ;       // сохранить результат
    }

    /**
     * Добавляет в список всех решений текущееРешение
     */
    private function storeResult() {
        $this->solutions[] = [
            'coeff'    => $this->modQuadr->getCoefficients() ,   // коэффициенты уравнения
            'solution' => $this->modQuadr->getSolution() ,       // решение - корни
            'D'        => $this->modQuadr->getDiscriminant() ,
            'delta'    => $this->modQuadr->getDelta() ] ;        //  результат подстановки корней
    }

    /**
     * запускает генератор уравнений
     */
    public function clcGenerate() {
        $nGenerate = TaskStore::NUMBER_GENERATE ;    // число генераций
        $min = TaskStore::MIN_GENERATE ;         // интервал для формирования коэффициентов
        $max = TaskStore::MAX_GENERATE ;         // ---------""-----------------------
        for ($i = 1; $i <= $nGenerate; $i++) {
            $a = rand($min,$max) ;
            $b = rand($min,$max) ;
            $c = rand($min,$max) ;
            $this->calculate($a,$b,$c) ;

        }

    }

    /**
     * статистака расчетов (распределние действительных и комплексных решений)
     * @return array
     */
    public function getStatistic() {
        $nReal = 0 ;
        foreach ($this->solutions as $elemS) {
            $nReal += ( $elemS['D'] >= 0 ) ? 1 : 0 ;
        }
        $n = sizeof($this->solutions) ;
        $statisticReal = ( $n > 0 ) ? $nReal/$n : 0 ;
        $statisticImage = ( 0 == $n ) ? 0 : 1 - $statisticReal ;
        return [
            'real' => $statisticReal,
            'image' => $statisticImage,
            'total' => $n ] ;
    }

}