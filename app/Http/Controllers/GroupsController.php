<?php

namespace App\Http\Controllers;
use App\Contact;
use App\Group;
use App\Http\Requests;
use App\Http\Requests\GroupRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\DB;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $groups = Group::where('user_id', Auth::id())->paginate(5);

        foreach($groups as $group)
        {
            $group->mCount = $group->contacts()->count();
        }
        $tRow = 1;
        return view('groups.index', compact('groups', 'tRow'));
	
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$contacts = Auth::user()
                    ->contacts()
                    ->select(DB::raw("CONCAT(fname,' ', lname) AS fullname, id"))
                    ->orderBy('fullname')
                    ->lists('fullname', 'id');

        return view('groups.create', compact('contacts'));
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
		$group = new Group($request->all());
        Auth::user()->groups()->save($group);
        $group->contacts()->attach($request->input('contacts'));

        return redirect('groups');
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
		$group = Group::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();;

        $contacts = $group
            ->contacts()
            ->select(DB::raw("CONCAT(fname,' ', lname) AS fullname, id"))
            ->orderBy('fullname')
            ->lists('fullname', 'id');

        return view('groups.show', compact('group', 'contacts'));
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
		$group = Group::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();;

        $contacts = $group
                    ->contacts()
                    ->select(DB::raw("CONCAT(fname,' ', lname) AS fullname, id"))
                    ->orderBy('fullname')
                    ->lists('fullname', 'id');

        $notselected = Contact::where('user_id', Auth::id())
                    ->whereNotIn('id', array_keys($contacts))
                    ->select(DB::raw("CONCAT(fname,' ', lname) AS fullname, id"))
                    ->lists('fullname', 'id');

        return view('groups.edit', compact('group', 'contacts', 'notselected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request, GroupRequest $request, $id)
    {
        //
		$group = Group::where('user_id', Auth::id())
                ->where('id', $id)
                ->first();

        $group->update($request->all());
        $group->contacts()->sync($request->input('contacts'));

        return redirect('groups');
		
		
		
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
		$group = Group::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $group->delete();

        return redirect('groups');
    }
}
