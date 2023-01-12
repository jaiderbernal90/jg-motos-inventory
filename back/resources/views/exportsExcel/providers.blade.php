<table>
    <thead>
        <tr>
            <th width="250px"><b>NIT</b></th>
            <th width="250px"><b>Nombre completo</b></th>
            <th width="250px"><b>Teléfono fijo</b></th>
            <th width="250px"><b>Celular</b></th>
            <th width="250px"><b>Correo</b></th>
            <th width="250px"><b>Departamento</b></th>
            <th width="250px"><b>Ciudad</b></th>
            <th width="250px"><b>Dirección</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $fact)
            <tr>
                <td align="left">{{ @$fact->nit }}</td>
                <td align="left">{{ @$fact->full_name }}</td>
                <td align="left">{{ @$fact->landline }}</td>
                <td align="left">{{ @$fact->cellphone }}</td>
                <td align="left">{{ @$fact->email }}</td>
                <td align="left">{{ @$fact->department }}</td>
                <td align="left">{{ @$fact->city }}</td>
                <td align="left">{{ @$fact->address }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
