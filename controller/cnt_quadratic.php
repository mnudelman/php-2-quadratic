<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 06.06.15
 * Time: 21:25
 */

class cnt_quadratic extends cnt_base
{
    protected $msg;    // сообщения класса - объект Message
    protected $parListGet = [];  // параметры класса
    protected $parListPost = [];  // параметры класса
    protected $msgTitle = '';
    protected $msgName = '';
    protected $modelName = 'mod_quadratic';
    protected $mod;
    protected $parForView = [];   // параметры для передачи view
    protected $nameForView = 'cnt_quadratic';  // имя для передачи в ViewDriver
    protected $nameForStore = 'cnt_quadraticStore'; // имя строки параметров в TaskStore
    protected $ownStore = [];     // собственные сохраняемые параметры
    protected $forwardCntName = false; // контроллер, которому передается управление
    //-----------------------------------------------------//
    private $allSolutions = [];        // список всех решений
    private $solution = [];     // тек решение
    private $D;                 // дескриминант
    private $coefficients = [];    // тек уравнение  ['a'=>a,'b'=>b,'c'=>c]
    private $delta = [];        // постановка корней в уравнение
    private $error = false ;
    private $URL_TO_QUADRATIC ;
    private $statisticReal;            // % действительных корней(D>0)
    private $statisticImage;            // % комплексных корней
    private $statisticTotal ;          // общее число расчетов
    //-------- параметры генерации решений   -------------//
    private $MIN_GENERATE = 0 ;
    private $MAX_GENERATE = 100 ;
    private $NUMBER_GENERATE = 50 ;
    //----------------------------------------------------//
    public function __construct($getArray, $postArray)
    {
        parent::__construct($getArray, $postArray);

    }

    protected function prepare() {
        $this->URL_TO_QUADRATIC = TaskStore::$htmlDirTop .'/index.php?cnt=cnt_quadratic' ;
        //------- работа   ------------//
        if (is_array($this->ownStore) ){             // полный список всех уравнений с решениями
            if (!empty($this->ownStore['allSolutions'])) {
                $this->allSolutions = $this->ownStore['allSolutions'] ;
            }
        }
        if (isset($this->parListPost['calculate'])) {   // выполнить расчет
            $a = $this->parListPost['k_a'] ;   // коэффициенты уравнения
            $b = $this->parListPost['k_b'] ;
            $c = $this->parListPost['k_c'] ;
            $this->calculate($a,$b,$c) ;
        }
        if (isset($this->parListPost['generate'])) {    // генерировать коэффициенты уравнения
            $this->clcGenerate() ;
        }
        if (isset($this->parListPost['clear'])) {    // очистить таблицу
           $this->allSolutions = [] ;
        }

        parent::prepare();
    }

    private function calculate($a,$b,$c) {
        $res = $this->mod->setCoefficients($a, $b, $c);    // задать коэффициенты
        if (false === $res) {
            $this->msg->addMessage('ERROR: Коэффициенты:A = '.$a.' B = '.$b.' C='.$c. 'не дают квадратное уравнение!') ;
            $this->error = true ;
            return false ;
        }
        $this->mod->calculate() ;
        $this->storeResult() ;       // сохранить результат
    }

    private function storeResult() {
        $this->coefficients = $this->mod->getCoefficients() ;
        $this->solution = $this->mod->getSolution() ;
        $this->D = $this->mod->getDiscriminant() ;
        $this->delta = $this->mod->getDelta() ;
        $this->allSolutions[] = [
           'coeff' =>  $this->coefficients ,
           'solution' => $this->solution,
           'D'        => $this->D ,
           'delta'  => $this->delta ] ;
    }

    private function clcGenerate() {
        for ($i = 1; $i <= $this->NUMBER_GENERATE; $i++) {
            $min = $this->MIN_GENERATE ;
            $max = $this->MAX_GENERATE ;
            $a = rand($min,$max) ;
            $b = rand($min,$max) ;
            $c = rand($min,$max) ;
            $this->calculate($a,$b,$c) ;

        }

    }
    private function statistic() {
        $nReal = 0 ;
        $nImage = 0 ;
        foreach ($this->allSolutions as $elem) {
            if ( $elem['D'] >= 0 ) {
                $nReal++ ;
            }else {
                $nImage++ ;
            }
        }
        $n = $nReal + $nImage ;
        $this->statisticReal = ( $n > 0 ) ? $nReal/$n : 0 ;
        $this->statisticImage = ( 0 == $this->statisticReal ) ? 0 : 1 - $this->statisticReal ;
        $this->statisticTotal = $n ;
    }

    /**
     *  построить массив $ownStore - собственные параметры
     */
    protected function buildOwnStore()
    {
        $this->ownStore = ['allSolutions' => $this->allSolutions ] ;
    }

    protected function saveOwnStore()
    {
        parent::saveOwnStore() ;

    }

    /**
     * выдает имя контроллера для передачи управления
     * альтернатива viewGo
     * Через  $pListGet , $pListPost можно передать новые параметры
     */
    public function getForwardCntName(&$plistGet, &$pListPost)
    {
        parent::getForwardCntName($plistGet, $pListPost) ;

    }

    public function viewGo() {
        $this->statistic() ;
        $this->parForView = [
            'allSolutions' => $this->allSolutions,
            'urlToQuadratic' => $this->URL_TO_QUADRATIC,
            'statisticTotal' => $this->statisticTotal,
            'statisticReal' => $this->statisticReal,
            'statisticImage' => $this->statisticImage
        ] ;
        parent::viewGo() ;
    }
}