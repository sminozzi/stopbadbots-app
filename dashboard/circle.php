<?php /**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:57:53
 */ 
  //  http://ignitersworld.com/lab/radialIndicator.html#example
?>
<style>
    prg-cont.canvas {
        width: 200px !important;
    }
</style>
<script src="js/radialIndicator.js"></script>
<center>
    <div class="prg-cont rad-prg" id="indicatorContainer" style="width:200px; height:200px"></div>
</center>
<!--
$('#indicatorContainer').radialIndicator({
    barColor: {
        0: '#FF0000',
        33: '#FFFF00',
        66: '#0066FF',
        100: '#33CC33'
    },
    percentage: true
});
-->
<?php
$initValue = sbb_find_perc();
?>
<script>
    $('#indicatorContainer').radialIndicator({
        barColor: 'red',
        /*  '#87CEEB', */
        barWidth: 10,
        initValue: <?php echo $initValue; ?>,
        roundCorner: true,
        percentage: true,
        radius: 60,
        barWidth: 10,
    });
</script>