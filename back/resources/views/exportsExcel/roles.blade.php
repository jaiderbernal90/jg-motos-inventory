<table>
    <thead>
        <tr>
            <th width="250px"><b>Nombre</b></th>
            <th width="500px"><b>Descripción</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $fact)
            <tr>
                <td align="left">{{ @$fact->name }}</td>
                <td align="left">{{ @$fact->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
