<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
        <style> @import url('https://fonts.googleapis.com/css2?family=Dosis:wght@300;400;500;600;700&family=Fugaz+One&family=Noto+Sans+Ethiopic:wght@200;300;400;500;600&family=Silkscreen&display=swap'); </style>
        <style>
            * {
                font-size: 12px;
                font-family: 'poppins', sans-serif;
            }
            .ticket {
                width: 100%;
                max-width: 100%;
            }
            .detail {
                border-top: 1px solid black;
                border-bottom: 1px solid black;
                border-collapse: collapse;
            }
            .table {
                border-top: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
                text-align: left
            }
            table {
                width: 100%;
            }
            .center {
                text-align: center;
                align-content: center;
            }
            .left {
                text-align: left;
            }
            .right {
                text-align: right;
            }
            img {
                width: 30%;
                margin-left: 85px;
            }
            .container {
                border: 1px solid black;
                padding: 2%;
            }
            .d-flex {
                display: flex;
            }
            .ml-2 {
                margin-left: 5px;
            }
        </style>
    </head>
     <body>
        <div class="ticket">
            <!-- <img src="https://yt3.ggpht.com/-3BKTe8YFlbA/AAAAAAAAAAI/AAAAAAAAAAA/ad0jqQ4IkGE/s900-c-k-no-mo-rj-c0xffffff/photo.jpg" alt="Logotipo"> -->
            <p class="center">
                <b>{{ @$data['local']['name'] }}</b>
                <br>NIT: {{ @$data['local']['nit'] }} Cel: {{ @$data['local']['cellphone'] }}
                <br>{{ @$data['local']['city'] }}, {{ @$data['local']['department'] }} {{ @$data['local']['direction'] }}
            </p>
            <p class="center">
                <b>Resumen cierre 
                    @if (@$data['type'] == 'month')
                        mes:
                    @else
                        día:
                    @endif
                </b>
                <br>{{ @$data['date'] }}
            </p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cant.</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="detail">
                        <td>Ventas</td>
                        <td>{{ @$data['sales']['num'] }}</td>
                        <td>${{ number_format(@$data['sales']['valueDay']) }}</td>
                    </tr>
                    <tr class="detail">
                        <td>Abonos ventas</td>
                        <td>{{ @$data['bails']['num'] }}</td>
                        <td>${{ number_format(@$data['bails']['valueDayAll']) }}</td>
                    </tr>
                    <tr class="detail">
                        <td>Facturas</td>
                        <td>{{ @$data['invoices']['num'] }}</td>
                        <td>${{ number_format(@$data['invoices']['valueDay']) }}</td>
                    </tr>
                    <tr class="detail">
                        <td>Abonos facturas</td>
                        <td>{{ @$data['bailsInvoices']['num'] }}</td>
                        <td>${{ number_format(@$data['bailsInvoices']['valueDay']) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>Ganancia:</b></td>
                        <td>${{ number_format(@$data['balance']['revenue']) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>Gastos:</b></td>
                        <td>${{ number_format(@$data['expenses']['valueDay']) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>Balance:</b></td>
                        <td>${{ number_format(@$data['balance']['general']) }}</td>
                    </tr><br>
                </tbody>
            </table>
        </div>
    </body>
</html>