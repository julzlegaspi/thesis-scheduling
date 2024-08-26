<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Schedule;
use App\Models\Manuscript;
use App\Models\Rsc;
use Livewire\WithFileUploads;

class ScheduleDetail extends Component
{
    use WithFileUploads;

    public Schedule $schedule;

    // RSC
    public $typeOfDefense = '';
    public $manuscriptChapter = '';
    public $rscManuscriptContent = '';
    public $rscSoftwareProgramDfdNumber = '';
    public $rscSoftwareProgramContent = '';
    public $generalComments = '';
    public $reDefense = false;
    public $reDefenseOn = '';
    public $isDraft = false;

    public $rscForAdmin;

    // Manuscript
    public $manuscript;
    public $isDetailsTabSelected = 'false';
    public $isRSCTabSelected = 'false';
    public $isManuscriptTabSelected = 'false';
    public $isHappeningNowStatus = 'false';

    public function mount(Schedule $schedule)
    {
        $schedule->load('team', 'venue', 'team.approvalStatus');

        $this->schedule = $schedule;

        if (isset(request()->tabSelected))
        {
            if (request()->tabSelected === 'details')
            {
                $this->isDetailsTabSelected = 'true';
            } 

            if (request()->tabSelected === 'rsc')
            {
                $this->isRSCTabSelected = 'true';
            } 

            if (request()->tabSelected === 'manuscript')
            {
                $this->isManuscriptTabSelected = 'true';
            }
        }

        $this->happeningNowStatus();
    }

    public function uploadRSCForAdmin()
    {
        $this->validate([
            'rscForAdmin' => 'required|file|mimes:pdf,doc,docx'
        ]);

        $file = $this->rscForAdmin->store('rsc');

        Rsc::create([
            'team_id' => $this->schedule->team->id,
            'user_id' => auth()->user()->id,
            'status' => 0,
            'manuscript_rsc' => '',
            'software_program_dfd_number' => $this->rscSoftwareProgramDfdNumber,
            'software_program_rsc' => '',
            'redefense_status' => 0,
            'is_draft' => $this->isDraft,
            'is_admin' => true,
            'file_name' => $file,
        ]);

        session()->flash('success', 'RSC uploaded.');

        return redirect()->route('schedule.show', [
            'schedule' => $this->schedule->id,
            'tabSelected' => 'rsc'
        ]);
    }

    public function uploadManuscript()
    {
        $this->validate([
            'manuscript' => 'required|file|mimes:pdf,doc,docx'
        ]);

        $file = $this->manuscript->store('manuscripts');
        Manuscript::create([
            'team_id' => $this->schedule->team->id,
            'user_id' => auth()->user()->id,
            'file_name' => $file
        ]);

        session()->flash('success', 'Manuscript uploaded.');

        return redirect()->route('schedule.show', [
            'schedule' => $this->schedule->id,
            'tabSelected' => 'manuscript'
        ]);
    }

    public function uploadRsc()
    {
        $this->validate([
            'typeOfDefense' => 'required|string',
            'rscManuscriptContent' => 'required|string',
            'rscSoftwareProgramContent' => 'required|string',
            'reDefenseOn' => 'required_if:reDefense,true'
        ]);

        if ($this->reDefense)
        {
            $start = Carbon::parse($this->reDefenseOn)->format('Y-m-d H:i:s');
            $end = Carbon::parse($this->reDefenseOn)->addHours(2)->format('Y-m-d H:i:s');
    
            $conflict = Schedule::where(function($query) use ($start, $end) {
                $query->where('start', '<', $end)
                      ->where('end', '>', $start);
            })->exists();
    
            if ($conflict)
            {
                return $this->addError('reDefenseOn', 'The selected time slot conflicts with an existing schedule.');
            }
        }
        
        Rsc::create([
            'team_id' => $this->schedule->team->id,
            'user_id' => auth()->user()->id,
            'status' => $this->typeOfDefense,
            'manuscript_chapter' => $this->manuscriptChapter,
            'manuscript_rsc' => $this->rscManuscriptContent,
            'software_program_dfd_number' => $this->rscSoftwareProgramDfdNumber,
            'software_program_rsc' => $this->rscSoftwareProgramContent,
            'general_comments' => $this->generalComments,
            'redefense_status' => $this->reDefense,
            'is_draft' => $this->isDraft
        ]);

        if ($this->reDefense)
        {
            $start = Carbon::parse($this->reDefenseOn)->format('Y-m-d H:i:s');
            $end = Carbon::parse($this->reDefenseOn)->addHours(2)->format('Y-m-d H:i:s');

            $this->schedule->start = $start;
            $this->schedule->end = $end;
            $this->schedule->save();
        }

        session()->flash('success', 'RSC uploaded.');

        return redirect()->route('schedule.show', [
            'schedule' => $this->schedule->id,
            'tabSelected' => 'rsc'
        ]);
    }

    public function clearManuscript()
    {
        $this->reset('manuscript');
    }

    public function happeningNowStatus()
    {
        $start = Carbon::now()->format('Y-m-d H:i:s');
        $end = Carbon::now()->addHours(2)->format('Y-m-d H:i:s');

        $schedule = Schedule::where(function($query) use ($start, $end) {
            $query->where('start', '<', $end)
                  ->where('end', '>', $start);
        })->exists();

        if ($schedule)
        {
            $this->isHappeningNowStatus = 'false';
        }
    }

    public function clear()
    {
        $this->resetValidation();
    }

    public function render()
    {
        $manuscripts = $this->schedule->team->manuscripts;

        $rscs = $this->schedule->team->rscs()->where('is_draft', false)->get();

        return view('livewire.schedule-detail', [
            'schedule' => $this->schedule,
            'manuscripts' => $manuscripts,
            'rscs' => $rscs,
        ]);
    }
}
