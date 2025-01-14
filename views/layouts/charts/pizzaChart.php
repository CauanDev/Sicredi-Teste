<div id="pizza_chart_<?php echo $title; ?>"></div>


<script>
    const chartData = <?php echo json_encode($data); ?>;

    const userNames = chartData.map(item => item.user_name);
    const counts = chartData.map(item => item.total_uploads); 

    const pieOptions = {
        chart: {
            type: 'pie',
            height: 350
        },
        series: counts,
        labels: userNames,
        title: {
            text: '<?php echo $title; ?>',
            align: 'center'
        },
        colors: ['#008FFB', '#FF4560', '#00E396', '#775DD0', '#FEB019']
    };

    const pieChart = new ApexCharts(
        document.querySelector("#pizza_chart_<?php echo $title; ?>"), 
        pieOptions
    );
    pieChart.render();
</script>
