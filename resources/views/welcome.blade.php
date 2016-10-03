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

                    @if (isset($crews))
                        <h2>CREWS</h2>
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>User ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($crews as $crew)
                                    <tr>
                                        <td>{{ $crew->id }}</td>
                                        <td>{{ $crew->name }}</td>
                                        <td>{{ $crew->user_id }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if (isset($movies))
                        <h2>MOVIES</h2>
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>IMDBid</th>
                                    <th>Title</th>
                                    <th>ratingIMDB</th>
                                    <th>ByUser</th>
                                    <th>Crew_id</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movies as $movie)
                                    <tr>
                                        <td>{{ $movie->id }}</td>
                                        <td>{{ $movie->IMDBid }}</td>
                                        <td>{{ $movie->title }}</td>
                                        <td>{{ $movie->ratingIMDB }}</td>
                                        <td>{{ $movie->byUser }}</td>
                                        <td>{{ $movie->crew_id }}</td>
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