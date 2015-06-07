<?php
/**
 * @link http://www.lyapp.com/
 * @copyright Copyright (c) 2014 领域工作室
 * @license http://www.lyapp.com/
 */
use yii\helpers\Html;
?>
<table id="" class="table table-striped table-bordered responsive">
    <thead>
        <tr>
            <th>用户名</th>
            <th>预约</th>
            <th>到院</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalReserve = 0;
        $totalArrived = 0;
        foreach ($model as $m) {
            $totalReserve +=$m['reservecount'];
            $totalArrived +=$m['arrivedcount'];
            ?>
            <tr>
                <td class="center"><?= $m['username'] ?></td>
                <td class="center"><?= $m['reservecount'] ?></td>
                <td class="center"><?= $m['arrivedcount'] ?></td>
            </tr>
        <?php } ?>
            <tr class="success">
                <td class="center"><label>合计</label></td>
                <td class="center"><?= $totalReserve ?></td>
                <td class="center"><?= $totalArrived ?></td>
            </tr>
    </tbody>
</table>