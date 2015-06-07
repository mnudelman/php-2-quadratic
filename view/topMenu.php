<?php
//session_start();
/**
 *  Меню - шапка страницы
 */
?>
<?php
 $htmlDirTop = TaskStore::$htmlDirTop ;
 $dirTop = TaskStore::$dirTop ;
?>
<div id="topMenu">
    <strong>ШП. PHP-2.Занятие-2.  Упражнение.</strong> <br>

    <a href="<?php echo $htmlDirTop.'/index.php?cnt=cnt_quadratic' ?>" class="menu">
        <img src="<?php echo $htmlDirTop ?>/images/i_2494.png" style="width:24px" title="Квадратное уравнение"
             alt="Квадратное уравнение">
        Решение квадратных уравнений
    </a>&nbsp;&nbsp;


    <a href="<?php echo  $htmlDirTop.'/index.php?cnt=cnt_about' ?>" class="menu">
     <img src="<?php echo  $htmlDirTop ?>/images/help-about.png" title="about" alt="about"></a>

</div>
&nbsp;&nbsp;
