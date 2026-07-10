<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaitingList;

class AdminWaitingListController extends Controller
{
    public function __invoke()
    {
        return view('admin.waitinglist', [
            'waitingLists' => WaitingList::query()
                ->with(['user', 'schedule.courseClass'])
                ->orderBy('schedule_id')
                ->orderBy('queue_number')
                ->get(),
        ]);
    }
}
