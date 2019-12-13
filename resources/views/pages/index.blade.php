@extends('layouts.app')
@section('content')
<br><br>
<table class="table table" style="background:green">
<thead>
    <tr>
    <th scope="col">#</th>
    <th scope="col">Date de la facture : </th>
    <th scope="col">Interlocuteur</th>
    <th scope="col">Client</th>
    <th scope="col">Période</th>
    <th scope="col">Editer</th>
    <th scope="col">Imprimer</th>
    </tr>
</thead>
<tbody>
    @if (count($locations) > 0)
        @foreach ($locations as $item)
            <tr>
                <th scope="row">1</th>
                <td>{{$item->date_facture}}</td>
                <td>{{$item->interlocuteur}}</td>
                <td>{{$item->client}}</td>
                <td>{{$item->periodeDebut}} <br> {{$item->periodeFin}}</td>
                <td><a href="/location/{{$item->id}}/edit" >Editer</a></td>
                <td><a href="/location/{{$item->id}}" target="_blank">Imprimer</a></td>
            </tr>
        @endforeach
    @endif
</tbody>
</table>
<p class="panel ">{{$locations->links()}}</p>
@endsection
