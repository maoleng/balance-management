@php use App\Enums\ReasonLabel; @endphp
@csrf
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add Reason</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Reason</label>
            <input type="text" class="form-control" name="name" value="{{ $reason->name ?? null }}" required="">
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <label for="firstname" class="form-label">Label</label>
        <div class="dropdown">
            <button class="btn-label btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ isset($reason->label) ? ReasonLabel::getKey($reason->label) : 'Choose label' }}
            </button>
            <ul class="dropdown-menu border-0 shadow p-3">
                @foreach(ReasonLabel::asArray() as $label => $value)
                    <li><a data-label="{{ $value }}" data-id="{{ $reason->id ?? null }}" class="sl-label dropdown-item py-2 rounded" href="#">{{ $label }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Group Reason</label>
            <br>
            <ul class="nav nav-tabs tab-body-header rounded d-inline-flex" role="tablist">
                <li class="nav-item" role="presentation"><a data-is_group="1" data-id="{{ $reason->id ?? null }}" class="btn-reason nav-link {{ isset($reason) && $reason->is_group ? 'active' : '' }}" data-bs-toggle="tab" href="#btn-normal" role="tab" aria-selected="true">Yes</a></li>
                <li class="nav-item" role="presentation"><a data-is_group="0" data-id="{{ $reason->id ?? null }}" class="btn-reason nav-link {{ isset($reason) && ! $reason->is_group ? 'active' : '' }}" data-bs-toggle="tab" href="#btn-group" role="tab" aria-selected="false" tabindex="-1">No</a></li>
            </ul>
        </div>
    </div>
</div>
<input id="i-{{ $reason->id ?? null }}-label" type="hidden" name="label" value="{{ $reason->label ?? null }}">
<input id="i-{{ $reason->id ?? null }}-is_group" type="hidden" name="is_group" value="{{ $reason->is_group ?? null }}">
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">{{ isset($reason) ? 'Update' : 'Create' }}</button>
</div>
