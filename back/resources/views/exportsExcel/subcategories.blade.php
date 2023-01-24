<table>
    <thead>
        <tr>
            <th width="100px"><b>Código</b></th>
            <th width="250px"><b>Nombre</b></th>
            <th width="250px"><b>Categoría</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $fact)
            <tr>
                <td align="left">{{ @$fact->code }}</td>
                <td align="left">{{ @$fact->name }}</td>
                <td align="left">{{ @$fact->nameCategory }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
