<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReasonRequest;
use App\Models\Reason;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReasonController extends Controller
{

    public function index(): View
    {
        $reasons = Reason::query()->orderBy('name')->get();

        return view('reason.index', [
            'reasons' => $reasons,
        ]);
    }

    public function store(ReasonRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Reason::query()->create([
            'name' => $data['name'],
            'type' => $data['type'],
            'label' => $data['label'],
            'is_group' => $data['is_group'],
        ]);

        return back()->with('success', 'Create reason successfully');
    }

    public function update(ReasonRequest $request, Reason $reason): RedirectResponse
    {
        $data = $request->validated();
        $reason->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'label' => $data['label'],
            'is_group' => $data['is_group'],
        ]);

        return back()->with('success', 'Update reason successfully');
    }

    public function destroy(Reason $reason): RedirectResponse
    {
        if ($reason->transactions->isNotEmpty()) {
            return back()->with('errors', 'There is transaction relate to this reason');
        }
        $reason->delete();

        return back()->with('success', 'Delete reason successfully');
    }

}
