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
    protected $modelName = 'mod_solution';
    protected $mod;
    protected $parForView = [];   // параметры для передачи view
    protected $nameForView = 'cnt_quadratic';  // имя для передачи в ViewDriver
    protected $nameForStore = 'cnt_quadraticStore'; // имя строки параметров в TaskStore
    protected $ownStore = [];     // собственные сохраняемые параметры
    protected $forwardCntName = false; // контроллер, которому передается управление
    //-----------------------------------------------------//
    private $error = false ;
    private $URL_TO_QUADRATIC ;
    //----------------------------------------------------//
    public function __construct($getArray, $postArray)
    {
        parent::__construct($getArray, $postArray);

    }

    protected function prepare() {
        $this->URL_TO_QUADRATIC = TaskStore::$htmlDirTop .'/index.php?cnt=cnt_quadratic' ;
        //------- работа   ------------//
        $allSolutions = [] ;    //  список всех решений
        if (is_array($this->ownStore) ){
            if (!empty($this->ownStore['allSolutions'])) {
                $allSolutions = $this->ownStore['allSolutions'] ;
            }
        }
        $this->mod->setSolutions($allSolutions) ; // передать список решений

        if (isset($this->parListPost['calculate'])) {   // выполнить расчет
            $a = $this->parListPost['k_a'] ;   // коэффициенты уравнения
            $b = $this->parListPost['k_b'] ;
            $c = $this->parListPost['k_c'] ;
            $this->mod->calculate($a,$b,$c) ;
        }
        if (isset($this->parListPost['generate'])) {    // генерировать коэффициенты уравнения
            $this->mod->clcGenerate() ;
        }
        if (isset($this->parListPost['clear'])) {    // очистить список решений
           $this->mod->clearSolutions() ;
        }
        parent::prepare();
    }
    /**
     *  построить массив $ownStore - собственные параметры
     */
    protected function buildOwnStore() {
        $this->ownStore = ['allSolutions' => $this->mod->getSolutions() ] ;
    }

    protected function saveOwnStore() {
        parent::saveOwnStore() ;
    }
    /**
     * выдает имя контроллера для передачи управления
     * альтернатива viewGo
     * Через  $pListGet , $pListPost можно передать новые параметры
     */
    public function getForwardCntName(&$plistGet, &$pListPost)  {
        parent::getForwardCntName($plistGet, $pListPost) ;
    }
    public function viewGo() {
        $this->parForView = [
            'allSolutions' => $this->mod->getSolutions() ,
            'urlToQuadratic' => $this->URL_TO_QUADRATIC,
            'statistic'      => $this->mod->getStatistic() ] ;
        parent::viewGo() ;
    }
}