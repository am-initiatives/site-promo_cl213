@extends('layouts.master')

@section('content')

@unless(count($users))
    <p>Aucun utilisateur.</p>
@else
    <table class="small-12">
        <caption>Liste des utilisateurs</caption>
        <thead>
            <th>Buque</th>
            <th>Nom, Prénom</th>
            <th>e-mail</th>
            <th>Tel</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->nickname }}</td>
                <td>{{ $user->last_name }} {{ $user->given_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endunless

@endsection