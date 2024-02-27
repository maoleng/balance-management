@php use App\Enums\ReasonLabel; use App\Enums\ReasonType; @endphp

<div class="col-6 mb-2">
    <div class="bill-box">
        <div data-bs-toggle="modal" data-bs-target="#modal-reason-{{ $reason->id }}" class="img-wrapper">
            <img width src="{{ getFullPath($reason->image) }}" alt="img" class="image-block imaged w-75">
        </div>
        <div class="price">{{ $reason->name }}</div>
        @if ($reason->type === ReasonType::SPEND && $reason->label !== null)
            {!! ReasonLabel::getBadge($reason->label) !!}
        @endif
    </div>
</div>
