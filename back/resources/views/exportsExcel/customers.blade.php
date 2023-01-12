<table>
    <thead>
        <tr>
            <th width="250px"><b>Tipo de persona</b></th>
            <th width="250px"><b>Nombre completo</b></th>
            <th width="250px"><b>Tipo de documento</b></th>
            <th width="250px"><b>Documento</b></th>
            <th width="250px"><b>Celular</b></th>
            <th width="250px"><b>Correo</b></th>
            <th width="250px"><b>Dirección</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $fact)
            <tr>
                <td align="left">{{ @$fact->typePerson }}</td>
                <td align="left">{{ @$fact->full_name }}</td>
                <td align="left">{{ @$fact->typeDocument }}</td>
                <td align="left">{{ @$fact->document }}</td>
                <td align="left">{{ @$fact->cellphone }}</td>
                <td align="left">{{ @$fact->email }}</td>
                <td align="left">{{ @$fact->address }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
