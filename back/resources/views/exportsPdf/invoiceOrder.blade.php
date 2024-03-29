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

        </style>
    </head>
     <body>
        <div class="ticket">
            <!-- <img src="https://yt3.ggpht.com/-3BKTe8YFlbA/AAAAAAAAAAI/AAAAAAAAAAA/ad0jqQ4IkGE/s900-c-k-no-mo-rj-c0xffffff/photo.jpg" alt="Logotipo"> -->
            <p class="center">
                <b>{{ @$data['nameLocal'] }}</b>
                <br>NIT: {{ @$data['nitLocal'] }} Cel: {{ @$data['cellphoneLocal'] }}
                <br>{{ @$data['cityLocal'] }}, {{ @$data['departmentLocal'] }} {{ @$data['directionLocal'] }}
            </p>
            <p class="center">
                <b>Referencia de compra # {{ @$data['referenceOrder'] }}</b>
                <br>{{ @$data['date'] }}
            </p>
            <p class="left">
                <b>Proveedor: </b>
                <br>Nombre: {{ @$data['nameProvider'] }}
                <br>Nit: {{ @$data['nitProvider'] }} 
                <br>Celular: {{ @$data['cellphoneProvider'] }}
                <br>Dirección: {{ @$data['addressProvider'] }}, {{ @$data['cityProvider'] }} {{ @$data['departmentProvider'] }}
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
                        <td>{{ @$data['observations'] }}</td>
                        <td>1</td>
                        <td>${{ number_format(@$data['subtotal']) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>Subtotal:</b></td>
                        <td>${{ number_format(@$data['subtotal']) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>Iva:</b></td>
                        <td>{{ @$data['tax'] }}%</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>Total:</b></td>
                        <td>${{ number_format(@$data['total']) }}</td>
                    </tr><br>
                    <tr>
                        <td><b>Estado:</b> </td>
                        <td></td>
                        <td>
                            @if(@$data['paymentStatus'] === 1)
                                Pagada
                            @elseif(@$data['paymentStatus'] === 2)
                                Abonada
                            @else
                                Pendiente
                            @endif
                        </td>
                    </tr>
                    @if(@$data['paymentStatus'] === 1)
                        <tr>
                            <td><b>Método de pago:</b> </td>
                            <td></td>
                            <td>{{ @$data['paymentMethod'] }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </body>
</html>