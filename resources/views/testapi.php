@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>GENERAL INFO</strong></div>

                <div class="panel-body">                    
                    @if (isset($users))
                        <h2>USERS</h2>
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                      
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection