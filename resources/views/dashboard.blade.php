@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Dashboard</strong> : {{Auth::user()->email}}</div>

                <div class="panel-body">
                    You are logged in! 
                    @if (isset($error))
                        {{$error}}
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
