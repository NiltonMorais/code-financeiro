@if($errors->any())
    <ul class="collection">
        @foreach($errors->all() as $error)
            <li class="collection-item red white-text">
                <strong>Foram encontrados alguns erros:</strong>
            </li>
            <li class="collection-item">{{$error}}</li>
        @endforeach
    </ul>
@endif