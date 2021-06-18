@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            Welcome {{Auth::user()->name}}.
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Github token: <span id="gtoken">{{$gtoken}}</span></h2>
                            @if(empty($gtoken))
                            <span id="notoken">No Token? Click <a href="https://docs.github.com/en/github/authenticating-to-github/keeping-your-account-and-data-secure/creating-a-personal-access-token" target="_blank">here</a> to learn how to make a token.</span>
                            @else
                            <a id="changeToken" href="#">Change Token</a>
                            @endif
                        </div>
                    </div>
                    <div id="formTokenVisibility" @if(!empty($gtoken)) class="d-none" @endif>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <token-form-component/>
                        </div>
                    </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <github-list-component/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}" defer></script>
@endpush