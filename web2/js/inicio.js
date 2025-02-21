        var ctx = document.getElementById('graficoPeso').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
                datasets: [{
                    label: 'Peso (kg)',
                    data: [70, 69, 68, 67], // Aquí se deben insertar los datos reales desde la BD
                    borderColor: 'blue',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true
            }
        });