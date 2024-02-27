<?php

namespace App\Livewire;

use App\Enums\ReasonType;
use App\Livewire\Forms\CategoryForm;
use App\Livewire\Forms\ReasonForm;
use App\Models\Category;
use App\Models\Reason;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ClassifyComponent extends Component
{

    use WithFileUploads;


    public Collection $categories;
    public Collection $other_reasons;
    public Collection $earn_reasons;
    public CategoryForm $category_form;
    public ReasonForm $reason_form;
    public \Illuminate\Support\Collection $reasons;

    public function render(): View
    {
        return view('livewire.classify');
    }

    public function mount(): void
    {
        $this->loadCategories();
        $this->loadReasons();
    }

    public function storeCategory(Request $request): void
    {
        $data = [
            'name' => $request->get('name'),
            'money' => $request->get('money') ?? 0,
        ];
        $category_id = $request->get('id');
        $category_id
            ? Category::query()->where('id', $category_id)->update($data)
            : Category::query()->create($data);
        $this->loadCategories();
    }

    public function storeImage(Request $request): void
    {
        $reason = Reason::query()->find($request->get('reason_id'));
        $content = base64_decode(explode(';base64,', $request->get('image'))[1]);
        $mime = $this->getMimeType($request->get('image'));
        $path = 'reasons/'.($reason ? (Str::slug($reason->name).".$mime") : "_.$mime");
        $reason?->update(['image' => $path]);

        Storage::disk('local')->put('public/'.$path, $content);
    }

    public function storeReason(Request $request): void
    {
        $reason_id = $request->get('id');
        if ($reason_id) {
            Reason::query()->where('id', $reason_id)->update($request->except(['id', '_token']));
        } else {
            Reason::query()->create($request->except('_token'));
        }
    }

    public function loadCategories(): void
    {
        $this->categories = Category::query()->with(['reasons' => function ($q) {
            $q->whereIn('type', ReasonType::getCashReasonTypes())->orderBy('name');
        }])->orderBy('name')->get();
    }

    public function loadReasons(): void
    {
        $this->loadCategories();
        $reasons = $this->categories->pluck('reasons')->flatten();
        $category_ids = $reasons->pluck('id');
        $cash_reasons = Reason::query()->whereIn('type', ReasonType::getCashReasonTypes())
            ->whereNotIn('id', $category_ids)->orderBy('name')->get();
        $this->earn_reasons = $cash_reasons->where('type', ReasonType::EARN);
        $this->other_reasons = $cash_reasons->where('type', ReasonType::SPEND);
        $this->reasons = $reasons->merge($this->earn_reasons)->merge($this->other_reasons);
    }

    private function getMimeType($base64): ?string
    {
        if (str_starts_with($base64, 'data:image/bmp')) {
            return 'bmp';
        }
        if (str_starts_with($base64, 'data:image/jpeg')) {
            return 'jpg';
        }
        if (str_starts_with($base64, 'data:image/png')) {
            return 'png';
        }
        if (str_starts_with($base64, 'data:image/x-icon')) {
            return 'ico';
        }
        if (str_starts_with($base64, 'data:image/webp')) {
            return 'webp';
        }
        if (str_starts_with($base64, 'data:image/gif')) {
            return 'gif';
        }

        return 'jpg';
    }

}
