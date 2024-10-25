@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>Panel</h1>
@stop

@section('content')
    @livewire('admin.home-index')
@stop

@section('footer')
    <div class="footer text-center py-3">
        © 2024 Todos los derechos reservados.
    </div>
@stop

@section('css')
    <style>
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            bottom: 0;
            width: 100%;
            z-index: 1030; /* Ensure it is above other elements */
            box-shadow: 0 -1px 5px rgba(0,0,0,.1); /* Optional shadow for better separation */
        }
    </style>
@stop

@section('js')
<canvas id="revenue-chart-canvas"></canvas>
<canvas id="sales-chart-canvas"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- <script> 
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/salidas-mensuales')
        .then(response => response.json())
        .then(data => {
            console.log(data); // Verificar los datos en la consola
            const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            const labels = data.map(item => monthNames[item.mes - 1]);
            const salidasData = data.map(item => item.total);

            // Gráfico lineal
            var ctxRevenue = document.getElementById('revenue-chart-canvas').getContext('2d');
var revenueChart = new Chart(ctxRevenue, {
    type: 'bar', // Cambiado de 'line' a 'bar'
    data: {
        labels: labels,
        datasets: [{
            data: salidasData,
            backgroundColor: 'rgba(60, 141, 188, 0.9)',
            borderColor: 'rgba(60, 141, 188, 0.8)',
            borderWidth: 1,
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60, 141, 188, 1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60, 141, 188, 1)'
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false
                }
            }],
            yAxes: [{
                gridLines: {
                    display: false
                }
            }]
        }
    }
});

            // Gráfico circular
            var ctxSales = document.getElementById('sales-chart-canvas').getContext('2d');
            var salesChart = new Chart(ctxSales, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: salidasData,
                        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#8e44ad', '#3498db', '#e74c3c', '#2ecc71', '#e67e22', '#1abc9c', '#34495e'],
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
</script> --}}
@stop
