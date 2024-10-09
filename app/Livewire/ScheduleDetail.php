<?php

namespace App\Livewire;

use App\Models\CommentManuscript;
use App\Models\CommentRsc;
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

    public $rscId = '';
    // RSC
    public $typeOfDefense = '';
    public array $comments = [];
    public $commentFor = '';

    public $rscForAdmin;

    // Manuscript
    public $manuscript;
    public $isDetailsTabSelected = 'false';
    public $isRSCTabSelected = 'false';
    public $isManuscriptTabSelected = 'false';

    public $manuscriptId;
    public string $manuscriptPath = '';
    public string $manuscriptComment = '';

    public array $manuscriptComments = [];

    public function mount(Schedule $schedule)
    {
        $schedule->load('team', 'venue', 'team.approvalStatus');

        $this->schedule = $schedule;
        $this->typeOfDefense = $schedule->type_of_defense;

        array_push($this->comments, [
            'chapter' => '',
            'pageNumber' => '',
            'comments' => '',
        ]);

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
    }

    public function addComment()
    {
        array_push($this->comments, [
            'chapter' => '',
            'pageNumber' => '',
            'comments' => '',
        ]);
    }

    public function removeComment($key)
    {
        unset($this->comments[$key]);
        array_values($this->comments);
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
            'type' => Schedule::TD,
            'comment_for' => Rsc::MANUSCRIPT,
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
            'manuscript' => 'required|file|mimes:pdf'
        ]);

        $file = $this->manuscript->store('manuscripts', 'public');
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

        $validated = $this->validate([
            'typeOfDefense' => 'required',
            'commentFor' => 'required',
            'comments.*.chapter' => 'nullable',
            'comments.*.pageNumber' => 'nullable',
            'comments.*.comments' => 'required|string',
        ], [
            'comments.*.comments.required' => 'Comment is required.',
        ]);
        
        $rsc = Rsc::create([
            'team_id' => $this->schedule->team->id,
            'user_id' => auth()->user()->id,
            'type' => $validated['typeOfDefense'],
            'comment_for' => $validated['commentFor']
        ]);

        foreach ($validated['comments'] as $comment) {
            $rsc->comments()->create([
                'chapter' => $comment['chapter'],
                'page_number' => $comment['pageNumber'],
                'comments' => $comment['comments']
            ]);
        }

        session()->flash('success', 'RSC uploaded.');

        return redirect()->route('schedule.show', [
            'schedule' => $this->schedule->id,
            'tabSelected' => 'rsc'
        ]);
    }

    public function editRsc(Rsc $rsc)
    {
        $this->comments = [];
        $this->rscId = $rsc->id;
        $this->typeOfDefense = $rsc->type;
        $this->commentFor = $rsc->comment_for;

        foreach ($rsc->comments as $comment) {
            array_push($this->comments, [
                'id' => $comment->id,
                'chapter' => $comment->chapter,
                'pageNumber' => $comment->page_number,
                'comments' => $comment->comments,
                'action_taken' => $comment->action_taken
            ]);
        }
    }

    public function updateRsc()
    {
        $this->validate([
            'typeOfDefense' => 'required',
            'commentFor' => 'required',
            'comments.*.chapter' => 'nullable',
            'comments.*.pageNumber' => 'nullable',
            'comments.*.comments' => 'required|string',
        ], [
            'comments.*.comments.required' => 'Comment is required.',
        ]);

        $rsc = Rsc::find($this->rscId);
        $rsc->type = $this->typeOfDefense;
        $rsc->comment_for = $this->commentFor;
        $rsc->save();

        foreach ($this->comments as $comment) {
            if (isset($comment['id']))
            {
                $rsc->comments()->where('id', $comment['id'])->update([
                    'chapter' => $comment['chapter'],
                    'page_number' => $comment['pageNumber'],
                    'comments' => $comment['comments']
                ]);
            } else {
                $rsc->comments()->create([
                    'chapter' => $comment['chapter'],
                    'page_number' => $comment['pageNumber'],
                    'comments' => $comment['comments']
                ]);
            }
        }

        session()->flash('success', 'RSC updated.');

        return redirect()->route('schedule.show', [
            'schedule' => $this->schedule->id,
            'tabSelected' => 'rsc'
        ]);
    }

    public function studentUpdateActionTaken()
    {
        foreach ($this->comments as $comment) {
            CommentRsc::where('id', $comment['id'])->update([
                'action_taken' => null ?? $comment['action_taken'],
                'user_id' => auth()->user()->id,
            ]);
        }

        session()->flash('success', 'RSC updated.');

        return redirect()->route('schedule.show', [
            'schedule' => $this->schedule->id,
            'tabSelected' => 'rsc'
        ]);
    }

    public function deleteComment(CommentRsc $comment)
    {
        $comment->delete();

        unset($this->comments[$comment]);
        array_values($this->comments);
    }

    public function deleteRsc(Rsc $rsc)
    {
        $rsc->delete();

        session()->flash('success', 'RSC deleted.');

        return redirect()->route('schedule.show', [
            'schedule' => $this->schedule->id,
            'tabSelected' => 'rsc'
        ]);
    }

    public function clearManuscript()
    {
        $this->reset('manuscript');
    }

    public function clear()
    {
        $this->rscId = '';
        $this->typeOfDefense = $this->schedule->type_of_defense;
        $this->commentFor = '';
        $this->comments = [];
        $this->addComment();
        $this->manuscriptId = '';
        $this->manuscriptPath = '';
        $this->manuscriptComment = '';
        $this->manuscriptComments = [];
        $this->resetValidation();
    }

    public function getManuscriptFilename($id, $filename)
    {
        $this->clear();
        
        $this->manuscriptId = $id;
        $this->manuscriptPath = $filename;
        $this->getManuscriptComments($id);

    }

    public function storeManuscriptComment()
    {
        $this->validate([
            'manuscriptComment' => 'required|string'
        ]);

        CommentManuscript::create([
            'manuscript_id' => $this->manuscriptId,
            'user_id' => auth()->user()->id,
            'comment' => $this->manuscriptComment
        ]);

        $this->manuscriptComment = '';
        $this->manuscriptComments = [];

        $this->getManuscriptComments($this->manuscriptId);
    }

    public function getManuscriptComments($manuscriptId)
    {
        $manuscript = Manuscript::find($manuscriptId);

        foreach ($manuscript->comments as $comment) {
            $this->manuscriptComments[] = [
                'id' => $comment->id,
                'user' => $comment->user?->name ?? 'Deleted user',
                'comment' => $comment->comment,
                'created_at' => Carbon::parse($comment->created_at)->diffForHumans()
            ];
        }
    }

    public function render()
    {
        $manuscripts = $this->schedule->team->manuscripts;

        $rscs = $this->schedule->team->rscs()->get();

        return view('livewire.schedule-detail', [
            'schedule' => $this->schedule,
            'manuscripts' => $manuscripts,
            'rscs' => $rscs,
        ]);
    }
}
