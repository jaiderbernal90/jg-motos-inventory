<table>
    <thead>
        <tr>
            <th width="300px"><b>Nombre de la sección</b></th>
            <th width="500px"><b>Columnas</b></th>
            <th width="500px"><b>Filas</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $fact)
            <tr>
                <td align="left">{{ @$fact->nameSection }}</td>
                <td align="left">
                    @foreach (@$fact['columns'] as $key => $column)
                        {{ $column['nameColumn'] }}
                        @if($key < ($fact['sizeColumns'] - 1))
                            -
                        @endif
                    @endforeach
                </td>
                <td align="left">
                    @foreach (@$fact['rows'] as $key => $row)
                        {{ $row['nameRow'] }}
                        @if($key < ($fact['sizeRows'] - 1))
                            -
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
