<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class CountriesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = (int) $request->input('limit', 5);
        return response()->json(Country::autoWhere()->autoWith()->latest()->paginate($paginate));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = $request->validated();

        $user = User::create([
            'username' => $user['username'],
            'email'    => $user['email'],
            'password' => $user['password'],
            'uuid'     => Uuid::generate(4)->string,
        ]);

        return response()->json(array('success' => 'success'));
    }

    public function login(RegisterRequest $request)
    {
        $user = $request->validated();

        $user = User::create([
            'username' => $user['username'],
            'email'    => $user['email'],
            'password' => $user['password'],
            'uuid'     => Uuid::generate(4)->string,
        ]);

        return response()->json(array('success' => 'success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
