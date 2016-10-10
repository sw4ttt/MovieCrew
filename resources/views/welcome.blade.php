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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if (isset($crews))
                            <h2>USERS CREWS</h2>
                            <table class="table table-hover table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>User_id</th>
                                        <th>Crew_id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @foreach ($user->crews as $crew_user)
                                            <tr>
                                                <td>{{ $crew_user->pivot->user_id }}</td>
                                                <td>{{ $crew_user->pivot->crew_id }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        @endif                        
                    @endif

                    @if (isset($crews))
                        <h2>CREWS</h2>
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($crews as $crew)
                                    <tr>
                                        <td>{{ $crew->id }}</td>
                                        <td>{{ $crew->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if (isset($movies))
                            <h2>CREWS MOVIES</h2>
                            <table class="table table-hover table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>Crew_id</th>
                                        <th>Movie_id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movies as $movie)
                                        @foreach ($movie->crews as $crew_movie)
                                            <tr>
                                                <td>{{ $crew_movie->pivot->crew_id }}</td>
                                                <td>{{ $crew_movie->pivot->movie_id }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        @endif 

                    @endif

                    @if (isset($movies))
                        <h2>MOVIES</h2>
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Id</th>
                                    <th>IMDBid</th>
                                    <th>Title</th>
                                    <th>ratingIMDB</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movies as $movie)
                                    <tr>
                                        <td>{{ $movie->urlPoster }}</td>
                                        <td>{{ $movie->id }}</td>
                                        <td>{{ $movie->IMDBid }}</td>
                                        <td>{{ $movie->title }}</td>
                                        <td>{{ $movie->ratingIMDB }}</td>
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