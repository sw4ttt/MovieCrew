<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Crew;
use App\User;
use Validator;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class CrewController extends Controller
{
    public function index()
    {
        //
        $crews = Crew::all();
        if ($crews->count() == 0)
        {
            return response()->json(['result'=>'empty']);
        }
        return $crews;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        $input = $request->only(
            'name',
            'user_id'
        );        
        
        $validator = Validator::make($input, [
            'name' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);

        foreach ($user->crews as $crewsOfUser) 
        {
            if($crewsOfUser->name == $request->name)
            {
                return response()->json(['result'=>'false']);
            }
        }

        $crew = new Crew;

        $crew->name = $request->name;

        $crew->save();
        //$crew->users()->attach([$request->user_id => ['role'=>'admin']]);

        DB::table('crew_user')->insert(
        ['user_id' => $request->user_id, 'crew_id' => $crew->id,'role' => 'admin']
        );
        //$crew->users()->attach($request->user_id, ['role' => 'admin']);

        return response()->json(['result'=>'true']);
    }    

    public function addCrewToUser(Request $request)
    {
        //
        
        $input = $request->only(
            'crew_id',
            'user_id'
        );        
        
        $validator = Validator::make($input, [
            'crew_id' => 'required|exists:crews,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);
        $crew = Crew::find($request->crew_id);

        foreach ($user->crews as $crewsOfUser) 
        {
            if($crewsOfUser->name == $crew->name)
            {
                return response()->json(['result'=>'false']);
            }
        }        

        $crew->users()->attach($request->user_id, ['role' => 'simple']);

        return response()->json(['result'=>'true']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $input = $request->only(
            'crew_id'
        );

        $validator = Validator::make($input, [
            'crew_id' => 'required|exists:crews,id'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $crew = Crew::find($request->crew_id);

        if (is_null($crew))
        {
            return response()->json(['result' => 'empty']);
        }
        
        return response()->json(
            ['result' => true],
            ['id' => $crew->id],
            ['name' => $crew->name]
            );
    }

    public function showCrewUser(Request $request)
    {
        $input = $request->only(
            'crew_id'
        );

        $validator = Validator::make($input, [
            'crew_id' => 'required|exists:crews,id'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }
        
        $crew = Crew::find($request->id);

        if (is_null($crew))
        {
            return response()->json(['result' => 'empty']);
        }

        //return $crew->user->email;
        return $crew->users->toJson();
    }

    public function showUserCrews(Request $request)
    {
        $input = $request->only(
            'user_id'
        );

        $validator = Validator::make($input, [
            'user_id' => 'required|exists:users,id'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }
        
        $user = User::find($request->user_id);

        if (is_null($user))
        {
            return response()->json(['result' => 'empty']);
        }

        //return $crew->user->email;
        return $user->crews->toJson();
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete (Request $request)
    {
        $input = $request->only(
            'crew_id',
            'user_id'
        );

        $validator = Validator::make($input, [
            'crew_id' => 'required|exists:crews,id',
            'user_id' => 'required|exists:users,id'
        ]);

        if($validator->fails()) {
            //throw new ValidationHttpException($validator->errors()->all());
            return response()->json($validator->errors());
        }

        $crew = Crew::find($request->crew_id);

        //$creow->users()->count();

        //$user->roles()->detach($roleId);


        //$crew->delete();   

        //return response()->json(['Usuarios en Crew:'=>$crew->users()->count()]);   

        //->where('id', $request->user_id)->get(); 

        //return $crew->users()->where('id',1)->first()->role;

        return response()->json(['result STUFF' => $crew->users()->where('id',1)->first()->role]);

        //return $crew->users()->orderBy('id')->get()->toJson();
    }
}
