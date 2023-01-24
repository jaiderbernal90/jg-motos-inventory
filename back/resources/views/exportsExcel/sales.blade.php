<table>
    <thead>
        <tr>
            <th width="100px"><b>Referencia</b></th>
            <th width="150px"><b>Cliente</b></th>
            <th width="150px"><b>Fecha</b></th>
            <th width="150px"><b>Método de pago</b></th>
            <th width="150px"><b>Subtotal</b></th>
            <th width="150px"><b>Impuesto</b></th>
            <th width="150px"><b>Total</b></th>
            <th width="500px"><b>Productos</b></th>
            <th width="150px"><b>Estado venta</b></th>
            <th width="500px"><b>Abonos</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $fact)
            <tr>
                <td align="left">{{ @$fact->reference }}</td>
                <td align="left">{{ @$fact->documentClient }} - {{ @$fact->nameClient }}</td>
                <td align="left">{{ @$fact->created_at }}</td>
                <td align="left">{{ @$fact->paymentMethod }}</td>
                <td align="left">{{ number_format(@$fact->subtotal) }}</td>
                <td align="left">{{ @$fact->tax }}%</td>
                <td align="left">{{ number_format(@$fact->total) }}</td>
                <td align="left">
                    @foreach (@$fact['products'] as $key => $product)
                        ({{ $key +1 }}) Referencia:{{ $product['reference'] }}/ Nombre:{{ $product['name'] }}/ Cantidad:{{ $product['amount'] }}/ Precio:{{ $product['price'] }}
                    @endforeach
                </td>
                <td align="left">
                    @if (@$fact->status == 1)
                        Pagada
                    @elseif(@$fact->status == 2)
                        Abonada
                    @else
                        Pendiente
                    @endif
                </td>
                <td align="left">
                    @foreach (@$fact['bails'] as $key => $bail)
                        ({{ $key +1 }}) Fecha:{{ $bail['dateBail'] }}/ Valor:{{ $bail['price'] }}
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
