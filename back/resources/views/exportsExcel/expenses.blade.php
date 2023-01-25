<table>
    <thead>
        <tr>
            <th width="250px"><b>Descripción</b></th>
            <th width="200px"><b>Valor</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $fact)
            <tr>
                <td align="left">{{ @$fact->description }}</td>
                <td align="left">{{ @$fact->value }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
