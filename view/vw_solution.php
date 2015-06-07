<?php
/**
 * Форма вывода текста статьи
 * Date: 26.05.15
 */
?>
<strong>
    Статистика. Всего расчетов: <?=$statisticTotal;?><br>
    Действительных решений :<?=$statisticReal;?>&nbsp;&nbsp;
    Комплексных решений :<span style="background-color:yellowgreen"><?=$statisticImage;?> </span>
</strong>
<table border="4"
       cellspacing="1"
       cellpadding=“1” class="galFformEdit" >
    <caption>Таблица решений</caption>
    <tr>
        <th>(A*x**2+B*x+C)</th>
        <th>D</th>
        <th>Корень X1</th>
        <th>Корень X2</th>
        <th>Дельта(X1)</th>
        <th>Дельта(X2)</th>
    </tr>
    <?php
    if (is_array($allSolutions)  ) {
        $n = sizeof($allSolutions) ;
        for ($i = $n-1 ; $i >= 0; $i-- ) {
            $solutionElem = $allSolutions[$i] ;
            $coeff = $solutionElem['coeff'] ;
            $solutionX1 = $solutionElem['solution']['x1'] ;
            $solutionX2 = $solutionElem['solution']['x2'] ;
            $D = $solutionElem['D'] ;
            $deltaX1 = $solutionElem['delta']['x1'] ;
            $deltaX2 = $solutionElem['delta']['x2'] ;
            $tdstyle = ($D <0) ? 'style="background-color:yellowgreen"' : '' ;
            echo '<tr>' ;
            if ($D <= 0){
                echo '<div style="background-color:yellowgreen">' ;
            }else {
                echo '<div>' ;
            }

            $td = '<td %s>' ;
            echo sprintf($td,$tdstyle) ;
            echo 'A:'.$coeff['a'].'<br> '.'B:'.$coeff['b'].' <br> '.'C:'.$coeff['c'] ;
            echo '</td>' ;

            $td = '<td %s>' ;
            echo sprintf($td,$tdstyle) ;
            echo 'D:'.$D ;
            echo '</td>' ;

            $td = '<td %s>' ;
            echo sprintf($td,$tdstyle) ;
               echo 'r:'.$solutionX1['real'].'<br>  i:'.$solutionX1['image'] ;
            echo '</td>' ;

            $td = '<td %s>' ;
            echo sprintf($td,$tdstyle) ;
               echo 'r:'.$solutionX2['real'].' <br> i:'.$solutionX2['image'] ;
            echo '</td>' ;

            $td = '<td %s>' ;
            echo sprintf($td,$tdstyle) ;
            echo 'r:'.$deltaX1['real'].' <br> i:'.$deltaX1['image'] ;
            echo '</td>' ;

            $td = '<td %s>' ;
            echo sprintf($td,$tdstyle) ;
            echo 'r:'.$deltaX2['real'].' <br> i:'.$deltaX2['image'] ;
            echo '</td>' ;
            echo '</div>' ;

            echo '</tr>' ;
        }


    }
    ?>
</table>

