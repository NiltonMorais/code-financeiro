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
                                <?php
                                    $modalId = "modal-delete-$item->id";
                                    $deleteRoute = route('admin.banks.destroy',['bank'=>$item->id]);
                                ?>
                                <a id="link-modal-{{$item->id}}" href="#{{$modalId}}">Excluir</a>
                                <modal :modal="{{json_encode(['id'=>$modalId])}}" style="display: none">
                                    <div slot="content">
                                        <h5>Mensagem de confirmação</h5>
                                        <p><strong>Deseja excluir esse banco?</strong></p>
                                        <div class="divider"></div>
                                        <p>Nome: <strong>{{$item->name}}</strong></p>
                                        <div class="divider"></div>
                                    </div>
                                    <div slot="footer">
                                        <button id="link-delete-{{$item->id}}" class="btn btn-flat waves-effect green lighten-2 modal-close modal-action">Ok</button>
                                        <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
                                    </div>
                                </modal>
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