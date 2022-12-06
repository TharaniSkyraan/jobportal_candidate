<?php

namespace App\Traits;

use App\Model\UserSummary;
use App\Http\Requests\User\UserSummaryFormRequest;

trait UserSummaryTrait
{

    public function updateUserSummary($user_id, UserSummaryFormRequest $request)
    {
        UserSummary::where('user_id', '=', $user_id)->delete();
        $summary = $request->input('summary');
        $UserSummary = new UserSummary();
        $UserSummary->user_id = $user_id;
        $UserSummary->summary = $summary;
        $UserSummary->save();
        /*         * ************************************ */
        return response()->json(array('success' => true, 'status' => 200), 200);
    }

}
