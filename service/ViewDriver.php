<?php

/**
 *
 * Управление выводом
 * Date: 23.05.15
 */
class ViewDriver
{
    private $contView = [];       // таблица имяКонтроллера => формаОтображения
    private $viewLayout = [];     // таблица форма => шаблонСтраницы
    private $viewComponent = [];  // таблица форма => компонентСтраницы для вывода

    private $msg ;
    //--- тек атрибуты ---//
    private $curCnt = '';       // контроллерИмя
    private $curView = '';      // формаОтображения
    private $curLayOut = '';    // шаблонСтраницы
    private $curParams = [];    // парараметрыПодстановки в форму
    private $curComponent = [] ; // компонент страницы для вывода формы

    public function __construct($cntName) {
        $this->init();
        $this->curCnt = $cntName ;
        $this->curView = $this->contView[$this->curCnt] ;
        $this->curLayOut= $this->viewLayout[$this->curView] ;
        $this->curComponent = $this->viewComponent[$this->curView] ;
        $this->msg = TaskStore::getMessage() ;

//        $this->msg->addMessage('DEBUG:'.__METHOD__.':curCnt:'.$this->curCnt) ;
//        $this->msg->addMessage('DEBUG:'.__METHOD__.':curView:'.$this->curView) ;
//        $this->msg->addMessage('DEBUG:'.__METHOD__.':curLayOut:'.$this->curLayOut) ;

        //  подстановка curView
        foreach ($this->curComponent as $key=>$value) {
            if (true === $value) {
                $this->curComponent[$key] = $this->curView;
            }
        }


    }

    /**
     * Вводит таблицы соответствий
     */
    private function init() {
        $this->contView = [
            'cnt_quadratic' => 'vw_quadratic',
            'cnt_default' => 'vw_default',
            'cnt_about' => 'vw_about' ];

        $this->viewLayout = [
            'vw_quadratic' => 'lt_footerHalf',
            'vw_default' => 'lt_footerNo',
            'vw_about' => 'lt_footerNo'];


        $this->viewComponent['vw_quadratic'] = [  // формы в 2 частях страницы
            'content' => 'vw_solution',
            'footer' => 'vw_quadratic'];
        $this->viewComponent['vw_default'] = [  // форма отсутствует
            'content' => false,
            'footer' => false];
        $this->viewComponent['vw_about'] = [  //
            'content' => true,
            'footer' => false];
    }
    public function viewExec($paramList) {
        $dir = TaskStore::$dirView ;
        $footer = $this->curComponent['footer'] ;
        $content = $this->curComponent['content'] ;
        if (false !== $footer) {
            $footer = $dir.'/'.$footer.'.php' ;
        }
        if (false !== $content) {
            $content = $dir.'/'.$content.'.php' ;
        }
        //----  подстановка параметров ---- //
        if (is_array($paramList)) {
            foreach ($paramList as $parName => $parMean) {
                $$parName = $parMean;
            }
        }
         $dir = TaskStore::$dirLayout ;

        include_once $dir.'/'.$this->curLayOut.'.php' ;
    }

}