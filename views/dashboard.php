<!DOCTYPE html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <h1>Bem vindo ao DashBoard</h1>
    <div id="chart"></div>

    <?php
        renderLayout('../views/layouts/charts/pizzaChart',[
            "title" => "users_upload",
            "data" => $uploads
        ]);
    ?>
    <script>
        // Dados passados pelo PHP (convertidos para JSON)
        const uploadsData = <?php echo json_encode($uploads); ?>;
        const documentsData = <?php echo json_encode($documents); ?>;

        // Convertendo os dados para o formato correto do gráfico
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

        // Configuração do gráfico
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
                text: 'Uploads e Documentos por Dia',
                align: 'center'
            },
            colors: ['#008FFB', '#FF4560']
        };

        // Renderizando o gráfico
        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
</body>

</html>