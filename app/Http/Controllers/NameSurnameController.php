<?php

namespace App\Http\Controllers;

use App\Http\Requests\NameStoreRequest;
use App\Http\Requests\SurnameStoreRequest;
use App\Models\Country;
use App\Models\Name;
use App\Models\Surname;
use Illuminate\Http\Client\Request;

class NameSurnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check for search input
        if (request('search')) {
            $name = Name::where('name', 'like', '%' . request('search') . '%')->autoWhere()->with('country')->paginate(10);
            $surname = Surname::where('surname', 'like', '%' . request('search') . '%')->autoWhere()->with('country')->paginate(10);
            $search = true;
        } else {
            $name = Name::autoWhere()->with('country')->orderby('name')->paginate(10);
            $surname = Surname::autoWhere()->with('country')->orderby('surname')->paginate(10);
            $search = false;
        }
        return view(
            'namesSurnames.index',
            [
                'search'    => $search,
                'names'     => $name,
                'surnames'  => $surname,
                'countries' => Country::all(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeName(NameStoreRequest $request)
    {
        $name = Name::create([
            'name'       => ucfirst(mb_strtolower($request->name, 'UTF-8')),
            'country_id' => $request->country_id,
            'popularity' => (int) $request->popularity,
        ]);

        return redirect()->route('nameSurname')->with('status_success', 'Name ' . $name->name . ' was added to names pool.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSurname(SurnameStoreRequest $request)
    {
        $surname = Surname::create([
            'surname'    => ucfirst(mb_strtolower($request->surname, 'UTF-8')),
            'country_id' => $request->country_id,
            'popularity' => (int) $request->popularity,
        ]);

        return redirect()->route('nameSurname')->with('status_success', 'Surname ' . $surname->surname . ' was added to surnames pool.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Name  $name
     * @return \Illuminate\Http\Response
     */
    public function updateName(NameStoreRequest $request, $id)
    {
        $name = Name::findOrFail($id);
        $name->fill($request->all());
        $name->save();

        return redirect()->route('nameSurname')->with('status_success', 'Name ' . $name->name . ' was updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Surname  $surname
     * @return \Illuminate\Http\Response
     */
    public function updateSurname(SurnameStoreRequest $request, $id)
    {
        $surname = Surname::findOrFail($id);
        $surname->fill($request->all());
        $surname->save();

        return redirect()->route('nameSurname')->with('status_success', 'Name ' . $surname->surname . ' was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Surname  $surname
     * @return \Illuminate\Http\Response
     */
    public function destroyName($id)
    {
        $name = Name::findOrFail($id);
        $name->delete();
        return redirect()->route('nameSurname')->with('status_success', 'Name ' . $name->name . ' was removed from names pool.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Surname  $surname
     * @return \Illuminate\Http\Response
     */
    public function destroySurname($id)
    {
        $surname = Surname::findOrFail($id);

        $surname->delete();
        return redirect()->route('nameSurname')->with('status_success', 'Surname ' . $surname->surname . ' was removed from surnames pool.');
    }
}
