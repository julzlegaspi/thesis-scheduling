<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Schedule;
use Livewire\WithPagination;
use App\Mail\ScheduleCreated;
use App\Mail\ScheduleApproved;
use App\Mail\ScheduleDeclined;
use App\Models\ApprovalStatus;
use Illuminate\Support\Facades\Mail;

class Approval extends Component
{
    use WithPagination;

    public int $scheduleId;

    public int $teamId;

    public string $thesisTitle = '';

    public string $teamName = '';

    public string $teamMembers = "";

    public string $panelists = "";

    public string $start = '';

    public string $venue = '';

    public string $type = '';

    public string $remarks = '';

    public function showApprovalModal($id)
    {
        $schedule = Schedule::where('id', $id)->with('team', 'venue')->first();
        $this->scheduleId = $id;
        $this->teamId = $schedule->team->id;
        $this->thesisTitle = $schedule->team->thesis_title;
        $this->teamName = $schedule->team->name;
        foreach ($schedule->team->members as $key => $member) {
            $this->teamMembers .= $key +1 . '. ' . $member->name . "<br />";
        }
        foreach ($schedule->team->panelists as $key => $panelist) {
            $this->panelists .= $key +1 . '. ' . $panelist->name . "<br />";
        }

        $this->start = Carbon::parse($schedule->start)->format('F j, Y @ h:i A');
        $this->venue = $schedule->venue->name;
        $this->type = Schedule::DEFENSE_STATUS[$schedule->type_of_defense];
    }

    public function approve()
    {
        $approvalStatus = ApprovalStatus::where('team_id', $this->teamId)
            ->where('user_id', auth()->user()->id)
            ->first();

        $approvalStatus->status = Schedule::APPROVED;
        $approvalStatus->remarks = $this->remarks ?? null;
        $approvalStatus->save();

        $approveStatusCount = ApprovalStatus::where('team_id', $this->teamId)
            ->where('status', Schedule::APPROVED)
            ->count();

        $approverCount = ApprovalStatus::where('team_id', $this->teamId)->count();

        if ($approveStatusCount === $approverCount)
        {
            $schedule = Schedule::where('id', $this->scheduleId)->first();
            $schedule->status = Schedule::APPROVED;
            $schedule->save();

            $this->approvedNotification();
        }

        session()->flash('success', 'Schedule has been approved.');

        $this->redirect(Approval::class);
    }

    public function decline()
    {
        $approvalStatus = ApprovalStatus::where('team_id', $this->teamId)
            ->where('user_id', auth()->user()->id)
            ->first();

        $approvalStatus->status = Schedule::DECLINED;
        $approvalStatus->remarks = null ?? $this->remarks;
        $approvalStatus->save();

        $schedule = Schedule::where('id', $this->scheduleId)->first();
        $schedule->status = Schedule::DECLINED;
        $schedule->save();

        $this->declinedNotification();

        session()->flash('success', 'Schedule has been declined.');

        $this->redirect(Approval::class);
    }

    public function approvedNotification()
    {
        $schedule = Schedule::find($this->scheduleId);
        //Students
        if (count($schedule->team->members) > 0)
        {
            foreach ($schedule->team->members as $member) {
                Mail::to($member->email)->queue(new ScheduleApproved($schedule));
            }
        }

        //Panelist
        if (count($schedule->team->panelists) > 0)
        {
            foreach ($schedule->team->panelists as $panelist) {
                Mail::to($panelist->email)->queue(new ScheduleApproved($schedule));
            }
        }

        //Admin
        $adminUsers = User::role('admin')->get();
        foreach ($adminUsers as $adminUser) {
            Mail::to($adminUser->email)->queue(new ScheduleApproved($schedule));
        }

        //Secretary
        $secretaryUsers = User::role('secretary')->get();
        foreach ($secretaryUsers as $secretaryUser) {
            Mail::to($secretaryUser->email)->queue(new ScheduleApproved($schedule));
        }

        //Experts
        if ($schedule->team->capa)
        {
            Mail::to($schedule->team->capa->email)->queue(new ScheduleApproved($schedule));
        }
        if ($schedule->team->consultant)
        {
            Mail::to($schedule->team->consultant->email)->queue(new ScheduleApproved($schedule));
        }
        if ($schedule->team->grammarian)
        {
            Mail::to($schedule->team->grammarian->email)->queue(new ScheduleApproved($schedule));
        }
    }

    public function declinedNotification()
    {
        $schedule = Schedule::find($this->scheduleId);
        //Students
        if (count($schedule->team->members) > 0)
        {
            foreach ($schedule->team->members as $member) {
                Mail::to($member->email)->queue(new ScheduleDeclined($schedule));
            }
        }

        //Panelist
        if (count($schedule->team->panelists) > 0)
        {
            foreach ($schedule->team->panelists as $panelist) {
                if (auth()->user()->id != $panelist->id)
                {
                    Mail::to($panelist->email)->queue(new ScheduleDeclined($schedule));
                }
            }
        }

        //Admin
        $adminUsers = User::role('admin')->get();
        foreach ($adminUsers as $adminUser) {
            Mail::to($adminUser->email)->queue(new ScheduleDeclined($schedule));
        }

        //Secretary
        $secretaryUsers = User::role('secretary')->get();
        foreach ($secretaryUsers as $secretaryUser) {
            Mail::to($secretaryUser->email)->queue(new ScheduleDeclined($schedule));
        }

        //Experts
        if ($schedule->team->capa)
        {
            Mail::to($schedule->team->capa->email)->queue(new ScheduleDeclined($schedule));
        }
        if ($schedule->team->consultant)
        {
            Mail::to($schedule->team->consultant->email)->queue(new ScheduleDeclined($schedule));
        }
        if ($schedule->team->grammarian)
        {
            Mail::to($schedule->team->grammarian->email)->queue(new ScheduleDeclined($schedule));
        }
    }

    public function adminApprove()
    {
        $schedule = Schedule::where('id', $this->scheduleId)->first();
        $schedule->status = Schedule::FOR_PANELIST_APPROVAL;
        $schedule->save();

        //Notify all the panelist
        if(count($schedule->team->panelists) > 0)
        {
            foreach ($schedule->team->panelists as $panelist) {
                Mail::to($panelist->email)->queue(new ScheduleCreated($panelist, $schedule));
            }
        }

        session()->flash('success', 'Schedule has been approved and forwared to all panelist for approval.');

        $this->redirect(Approval::class);
    }

    public function adminDecline()
    {
        $schedule = Schedule::where('id', $this->scheduleId)->first();
        $schedule->status = Schedule::DECLINED;
        $schedule->custom_status = null;
        $schedule->save();

        $this->declinedNotification();

        session()->flash('success', 'Schedule has been declined.');

        $this->redirect(Approval::class);
    }

    public function clear()
    {
        $this->resetValidation();
        $this->scheduleId;
        $this->teamId;
        $this->thesisTitle = '';
        $this->teamName = '';
        $this->teamMembers = "";
        $this->panelists = "";
        $this->start = '';
        $this->venue = '';
        $this->type = '';
        $this->remarks = '';
    }

    public function render()
    {
        $userId = auth()->user()->id;

        if (auth()->user()->roles->pluck('name')[0] == 'admin')
        {
            $pendingSchedules = Schedule::paginate(10);
        } else {
            $pendingSchedules = Schedule::whereHas('team.approvalStatus', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->paginate(10);
        }


        return view('livewire.approval', [
            'pendingSchedules' => $pendingSchedules,
        ]);
    }
}
