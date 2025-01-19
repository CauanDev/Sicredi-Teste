<div id="chart"></div>
<script>
    const uploadsData = <?php echo json_encode($uploads); ?>;
    const documentsData = <?php echo json_encode($documents); ?>;

    const dates = [...new Set([
        ...uploadsData.map(item => item.date),
        ...documentsData.map(item => item.date)
    ])].sort();

    const uploads = dates.map(date => {
        const found = uploadsData.find(item => item.date === date);
        return found ? found.total_uploads : 0;
    });

    const documents = dates.map(date => {
        const found = documentsData.find(item => item.date === date);
        return found ? found.total_documents : 0;
    });

    const options = {
        chart: {
            type: 'line',
            height: 350
        },
        stroke: {
            curve: 'smooth',
        },
        series: [{
                name: 'Uploads',
                data: uploads
            },
            {
                name: 'Documents',
                data: documents
            }
        ],
        xaxis: {
            categories: dates,
            title: {
                text: 'Data'
            }
        },
        yaxis: {
            title: {
                text: 'Quantidade'
            }
        },
        title: {
            text: "<?php echo $title; ?>", 
            align: 'center'
        },
        colors: ['#008FFB', '#FF4560']
    };

    const chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
