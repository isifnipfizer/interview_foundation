@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                    Account Login
                </div>
                <div class="card-body">
                    <p>Welcome to Github Repositories Star system. Please login to proceed.</p><br/>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
