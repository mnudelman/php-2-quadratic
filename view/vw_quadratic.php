<?php
/**
 * Форма выбора текущей галереи
 * Date: 25.05.15
 */
?>
<div align="center">
<form action="<?php echo $urlToQuadratic?>" method="post">
    <label>
        A:
        <input type="text"  name="k_a" class="fieldShort" >
    </label>*x**2&nbsp;+&nbsp;
    <label>
          B:
            <input type="text"  name="k_b" class="fieldShort" >
     </label>*x&nbsp;+&nbsp;
    <label>
     C:
     <input type="text"  name="k_c" class="fieldShort" >
    </label>&nbsp;&nbsp;
    <button name="calculate" class="btGal">Вычислить корни</button><br><br>
    <button name="clear" class="btGal">очистить таблицу</button>&nbsp;&nbsp;
    <button name="generate" class="btGalLong">Запустить генератор решений</button><br>
</form>
</div>