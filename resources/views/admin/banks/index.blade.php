@extends('layouts.admin')

@section('content')
<div class="container">
    <h4>Listagem de bancos</h4>
    <table class="striped responsive-table centered highline responsive-table z-depth-5">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($banks as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td> <td>
                    Ações
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $banks->links() !!}
</div>
@endsection