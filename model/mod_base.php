<?php
/**
 * Базовый класс модели
 * Time: 16:16
 */

abstract class mod_base {
    protected $msg ;  // объект - вывод сообщений
    public function __construct() {
        $this->msg = TaskStore::getParam('message') ;
    }

}