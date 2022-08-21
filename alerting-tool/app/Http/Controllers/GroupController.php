<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function show()
    {
        $groups = Group::with('contacts')->get();

        return response()->json(['groups' => $groups], 200);
    }

    public function index(Request $request)
    {
        $id = $request->route('id');

        $group = Group::with('contacts')->findOrFail($id);
        return response()->json(['group' => $group], 200);
    }

    public function store(GroupRequest $request)
    {
        $group = new Group();
        $group->fill($request->validated());
        $group->save();

        /** add contacts to group if provided */
        if (!is_null($request->get('contacts'))) {
            $group->contacts()->attach($request->get('contacts'));
        }

        return response()->json(['group' => $group], 200);
    }

    public function update(GroupRequest $request)
    {
        $id = $request->route('id');
        $group = Group::findOrFail($id);
        $group->fill($request->validated());
        $group->save();

        /** update contacts if provided */
        if (!is_null($request->get('contacts'))) {
            $group->contacts()->detach();
            \Log::info($request->get('contacts'));
            $group->contacts()->attach($request->get('contacts'));
        }

        return response()->json(['group' => $group], 200);
    }

    public function destroy(Request $request)
    {
        $id = $request->route('id');
        $group = Group::findOrFail($id);
        $group->delete();

        return response()->json('deleted', 200);
    }

    public function addContacts(Request $request)
    {
        $request->validate(
            [
                'contacts' => 'required'
            ]
        );

        $id = $request->route('id');
        $group = Group::with('contacts')->findOrFail($id);

        $contacts = $request->get('contacts');

        $group->contacts()->attach($contacts);

        return response()->json('contacts added', 200);
    }

    public function deleteContacts(Request $request)
    {
        $request->validate(
            [
                'contacts' => 'required'
            ]
        );

        $id = $request->route('id');
        $group = Group::with('contacts')->findOrFail($id);

        $contacts = $request->get('contacts');

        $group->contacts()->detach($contacts);

        return response()->json('contacts deleted', 200);
    }
}
