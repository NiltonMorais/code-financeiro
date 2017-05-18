@extends('layouts.site')

@section('content')
    <div class="container">
        @if(Session::has('error'))
            <div class="row">
                <div class="col s12">
                    <div class="card-panel red">
                        <span class="white-text">{{Session::get('error')}}</span>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <subscription-create
                :plan="{{json_encode($plan->toArray())}}"
                csrf_token="{{csrf_token()}}"
                action="{{route('site.subscriptions.store')}}">
            </subscription-create>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://js.iugu.com/v2"></script>
@endpush
