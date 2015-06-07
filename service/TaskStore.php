<?php
/**
 * Хранение  параметров задачи
 *
 * User: mnudelman@yandex.ru
 * Date: 22.05.15
 */
class TaskStore {
    public static $dirTop = false ;
    public static $dirController = false ;
    public static $dirModel = false ;
    public static $dirView = false ;
    public static $dirLayout = false ;
    public static $htmlDirTop = false ;
    public static $dirService = false ;
    //-----------------------------------//
    //-- параметры состояния --//
    private static $solutions = [] ;        // нокопленные решения
    private static $equation = [] ;         // текущее уравнение
    private static $message = false ;
    private static $cnt_quadraticStore ;
    //-----память контроллеров ---//
    //-------Список сохраняемых параметров-------//
    private static $storedParams = [
        'solutions',           // накопленные решения
        'equation',            // текущее уравнение
        'cnt_quadraticStore'
        ];

    //------ константы ------------//

    const LINE_FEED = '<br>';
    const LINE_END = '"\n"';
    const EPSILON = 0.00000000000001 ; // малое значение, принимаемое за 0
    const MIN_GENERATE = 0 ;           // min значение для генерации коэффициентов
    const MAX_GENERATE = 100 ;         // max значение для генерации коэффициентов
    const NUMBER_GENERATE = 50 ;       // число шагов генерации

    /** статус определяет функциональные возможности */
    public static function init($dirTop, $htmlDirTop) {
        self::$dirTop = $dirTop;
        self::$htmlDirTop = $htmlDirTop;

        self::$dirController = self::$dirTop . '/controller';
        self::$dirModel = self::$dirTop . '/model';
        self::$dirView = self::$dirTop . '/view';
        self::$dirLayout = self::$dirView .'/layouts' ;
        self::$dirService = self::$dirTop . '/service';
        // восстановить параметры //
        $params = self::$storedParams ;
        foreach($params as $parName) {
            self::$$parName = self::restoreParam($parName) ;
        }
    }

    /**
     * Сохранить параметр
     * @param $paramName
     * @param $paramMean
     */
    private static function storeParam($paramName,$paramMean) {
        $_SESSION[$paramName] = $paramMean ;
    }

    /**
     * Восстановить параметр
     * @param $paramName
     * @return bool
     */
    private static function restoreParam($paramName) {
        if (isset($_SESSION[$paramName])) {
            return $_SESSION[$paramName] ;
        } else {
            return false ;
        }
    }
    /**
     * @return array -  список директорий для поиска классов по __autoload
     */
    public static function getClassDirs()
    {
        return [self::$dirController,
            self::$dirModel,
            self::$dirService];
    }

    /**
     * получить параметр
     * @param $paramName
     * @return если (парамметрЕсть) ? ЗначениеПараметра : null
     */
    public static function getParam($paramName) {
        if (isset(self::$$paramName)) {
            return self::$$paramName ;
        }else {    // error:
            return null ;
        }
    }

    /**
     * Установить значение пераметра
     * @param $paramName
     * @param $paramMean
     * @return bool
     */
    public static function setParam($paramName,$paramMean) {
        if (isset(self::$$paramName)) {
            self::$$paramName = $paramMean ;
            self::storeParam($paramName,$paramMean) ;
            return true ;
        }else { // error:
            return false ;
        }
    }

    public static function setMessage($msg) {
        self::$message = $msg ;
    }
    public static function getMessage() {
        return self::$message ;
    }
}