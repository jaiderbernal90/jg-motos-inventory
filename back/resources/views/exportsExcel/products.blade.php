<table>
    <thead>
        <tr>
            <th width="100px"><b>Código</b></th>
            <th width="250px"><b>Nómbre</b></th>
            <th width="250px"><b>Descripción</b></th>
            <th width="250px"><b>Aplicación</b></th>
            <th width="250px"><b>Referencia</b></th>
            <th width="250px"><b>Marca</b></th>
            <th width="250px"><b>Stock</b></th>
            <th width="250px"><b>Estado</b></th>
            <th width="250px"><b>Original</b></th>
            <th width="250px"><b>Costo</b></th>
            <th width="250px"><b>Precio venta</b></th>
            <th width="250px"><b>Iva</b></th>
            <th width="250px"><b>Descuento</b></th>
            <th width="250px"><b>Precio total</b></th>
            <th width="250px"><b>Sección</b></th>
            <th width="250px"><b>Columna</b></th>
            <th width="250px"><b>Fila</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $fact)
            <tr>
                <td align="left">{{ @$fact->code }}</td>
                <td align="left">{{ @$fact->name }}</td>
                <td align="left">{{ @$fact->description }}</td>
                <td align="left">{{ @$fact->applications }}</td>
                <td align="left">{{ @$fact->reference }}</td>
                <td align="left">{{ @$fact->brand }}</td>
                <td align="left">{{ @$fact->stock }}</td>
                <td align="left">
                    @if ($fact->status == 'out-stock')
                        Sin stock
                    @elseif ($fact->status == 'in-stock')
                        Disponible
                    @elseif ($fact->status == 'low-stock')
                        Bajo stock
                    @endif
                </td>
                <td align="left">
                    @if ($fact->original == 0)
                        No
                    @elseif ($fact->original == 1)
                        Si
                    @endif
                </td>
                <td align="left">{{ @$fact->cost }}</td>
                <td align="left">{{ @$fact->price }}</td>
                <td align="left">{{ @$fact->tax }}</td>
                <td align="left">{{ @$fact->discount }}</td>
                <td align="left">{{ @$fact->price_total }}</td>
                <td align="left">{{ @$fact->section }}</td>
                <td align="left">{{ @$fact->column }}</td>
                <td align="left">{{ @$fact->row }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
