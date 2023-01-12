<table>
    <thead>
        <tr>
            <th width="250px"><b>Nombre completo</b></th>
            <th width="250px"><b>Tipo de documento</b></th>
            <th width="250px"><b>Documento</b></th>
            <th width="250px"><b>Fecha de cumpleaños</b></th>
            <th width="250px"><b>Celular</b></th>
            <th width="250px"><b>Estado</b></th>
            <th width="250px"><b>Correo</b></th>
            <th width="250px"><b>Rol</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $fact)
            <tr>
                <td align="left">{{ @$fact->full_name }}</td>
                <td align="left">{{ @$fact->typeDocument }}</td>
                <td align="left">{{ @$fact->document }}</td>
                <td align="left">{{ @$fact->date_birth }}</td>
                <td align="left">{{ @$fact->phone }}</td>
                <td align="left">
                    @if ($fact->status == 1)
                        Activo
                    @else
                        Inactivo
                    @endif
                </td>
                <td align="left">{{ @$fact->email }}</td>
                <td align="left">{{ @$fact->role }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
