<?php

namespace App\Http\Controllers;

use App\Http\NotificationTrait;
use App\Http\Requests\AlertRequest;
use App\Models\Alert;
use App\Models\Commit;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlertController extends NotificationTrait
{
    public function show()
    {
        $alerts = Alert::orderBy('create_timestamp', 'desc')->get();

        return response()->json(['alerts' => $alerts], 200);
    }

    public function store(AlertRequest $request)
    {
        $alert = new Alert();
        $alert->message = $request->get('message');

        /** get the last snooze created */
        $snooze = DB::table('commits')
            ->where('last_commit', '=', 'snooze')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($snooze) {
            /** $snooze_minutes from .env file */
            $snooze_minutes = env('SNOOZE_MINUTES', "10");
            $snoozeCreatedAt = new Carbon($snooze->created_at);
            if ($snoozeCreatedAt->addMinutes($snooze_minutes) > Carbon::now()) {
                $alert->confirmed = true;
                $alert->confirm_timestamp = Carbon::now();
            } else {
                $alert->confirmed = false;
            }
        } else {
            $alert->confirmed = false;
        }
        $alert->save();

        /** if alert is not confirmed notify all active contacts (contacts in active groups) */
        if (!$alert->confirmed) {
            $activeGroups = Group::where('standby', true)->get();
            foreach ($activeGroups as $activeGroup) {
                foreach ($activeGroup->contacts as $contact) {
                    switch ($contact->type) {
                        case 'sms':
                            $this->sendSms($contact->name, $alert->message);
                            break;
                        case 'pager':
                            $this->sendPager($contact->name, $alert->message);
                            break;
                        case 'email':
                            $this->sendEmail($contact->name, $alert->message);
                            break;
                    }
                }
            }
        }

        return response()->json(['alert' => $alert], 200);
    }

    public function aknowledgeAll(Request $request)
    {
        $updated = Alert::query()
            ->where('confirmed', '=', false)
            ->update(
                [
                    'confirmed' => true,
                    'confirm_timestamp' => Carbon::now()
                ]
            );

        /** if the db transaction succeeded */
        if ($updated) {
            $commit = new Commit();
            $commit->last_commit = 'aknowledge';
            $commit->save();
        }

        return response()->json('alerts aknowledged', 200);
    }

    public function aknowledgeAlert(Request $request)
    {
        $id = $request->route('id');

        $alert = Alert::findOrFail($id);
        $alert->confirmed = true;
        $alert->confirm_timestamp = Carbon::now();
        $alert->save();

        return response()->json('alert aknowledged', 200);
    }

    public function snooze(Request $request)
    {
        $commit = new Commit();
        $commit->last_commit = 'snooze';
        $commit->save();

        return response()->json('snooze created', 200);
    }
}
