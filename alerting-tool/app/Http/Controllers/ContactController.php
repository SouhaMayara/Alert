<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Group;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        $contacts = Contact::with('groups')->get();

        return response()->json(['contacts' => $contacts], 200);
    }

    public function index(Request $request)
    {
        $id = $request->route('id');

        $contact = Contact::with('groups')->findOrFail($id);
        return response()->json(['contact' => $contact], 200);
    }

    public function store(ContactRequest $request)
    {
        $contact = new Contact();
        $contact->fill($request->validated());
        $contact->save();

        /** add contact to group(s) if provided */
        if (!is_null($request->get('groups'))) {
            $contact->groups()->attach($request->get('groups'));
        }

        return response()->json(['contact' => $contact], 200);
    }

    public function update(ContactRequest $request)
    {
        $id = $request->route('id');
        $contact = Contact::findOrFail($id);
        $contact->fill($request->validated());
        $contact->save();

        /** update contact group(s) if provided */
        if (!is_null($request->get('groups'))) {
            $contact->groups()->detach();
            $contact->groups()->attach($request->get('groups'));
        }

        return response()->json(['contact' => $contact], 200);
    }

    public function destroy(Request $request)
    {
        $id = $request->route('id');
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json('deleted', 200);
    }
}
