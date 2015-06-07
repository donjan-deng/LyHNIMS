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
            <th>渠道名称</th>
            <th>消费</th>
            <th>总对话</th>
            <th>对话成本</th>
            <th>有效咨询</th>
            <th>咨询成本</th>
            <th>有效预约</th>
            <th>预约成本</th>
            <th>到院</th>
            <th>到院成本</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalCost = 0;
        $totalRecord = 0;
        $totalValid = 0;
        $totalReserve = 0;
        $totalArrived = 0;
        foreach ($model as $m) {
            $totalCost += $m['cost'];
            $totalRecord+=$m['total'];
            $totalValid +=$m['validcount'];
            $totalReserve +=$m['reservecount'];
            $totalArrived +=$m['arrivedcount'];
            ?>
            <tr>
                <td class="center"><?= $m['name'] ?></td>
                <td class="center"><?= $m['cost'] ?></td>
                <td class="center"><?= $m['total'] ?></td>
                <td class="center"><?= ($m['cost']>0&&$m['total']>0)?round($m['cost']/$m['total'],2):0 ?></td>
                <td class="center"><?= $m['validcount'] ?></td>
                <td class="center"><?= ($m['cost']>0&&$m['validcount']>0)?round($m['cost']/$m['validcount'],2):0 ?></td>
                <td class="center"><?= $m['reservecount'] ?></td>
                <td class="center"><?= ($m['cost']>0&&$m['reservecount']>0)?round($m['cost']/$m['reservecount'],2):0 ?></td>
                <td class="center"><?= $m['arrivedcount'] ?></td>
                <td class="center"><?= ($m['cost']>0&&$m['arrivedcount']>0)?round($m['cost']/$m['arrivedcount'],2):0 ?></td>
            </tr>
        <?php } ?>
            <tr class="success">
                <td class="center"><label>合计</label></td>
                <td class="center"><?= $totalCost ?></td>
                <td class="center"><?= $totalRecord ?></td>
                <td class="center"><?= ($totalCost>0&&$totalRecord>0)?round($totalCost/$totalRecord,2):0 ?></td>
                <td class="center"><?= $totalValid ?></td>
                <td class="center"><?= ($totalCost>0&&$totalValid>0)?round($totalCost/$totalValid,2):0 ?></td>
                <td class="center"><?= $totalReserve ?></td>
                <td class="center"><?= ($totalCost>0&&$totalReserve>0)?round($totalCost/$totalReserve,2):0 ?></td>
                <td class="center"><?= $totalArrived ?></td>
                <td class="center"><?= ($totalCost>0&&$totalArrived>0)?round($totalCost/$totalArrived,2):0 ?></td>
            </tr>
    </tbody>
</table>