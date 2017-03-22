@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h4>Listagem de bancos</h4>
            <a href="{{route('admin.banks.create')}}" class="btn waves-effect">Novo banco</a>

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
                        <td>{{$item->name}}</td>
                        <td>
                            <a href="{{route('admin.banks.edit',['bank'=>$item->id])}}">Editar</a>
                            <delete-action action="{{route('admin.banks.destroy',['bank'=>$item->id])}}" action-element="link-delete-{{$item->id}}" csrf-token="{{csrf_token()}}">
                                <a id="link-delete-{{$item->id}}" href="{{route('admin.banks.destroy',['bank'=>$item->id])}}">Excluir</a>
                            </delete-action>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $banks->links() !!}
        </div>
    </div>
@endsection