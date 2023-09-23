@php use App\Enums\ReasonLabel; use App\Enums\ReasonType; @endphp
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
        <div class="col-md-12">
            <label for="firstname" class="form-label">Reason type</label>
            <br>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="type" value="1" id="type_1-{{ $reason->id ?? null }}" autocomplete="off" {{ isset($reason) && $reason->type === ReasonType::EARN ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="type_1-{{ $reason->id ?? null }}">Earn</label>

                <input type="radio" class="btn-check" name="type" value="0" id="type_2-{{ $reason->id ?? null }}" autocomplete="off" {{ isset($reason) && $reason->type === ReasonType::SPEND ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="type_2-{{ $reason->id ?? null }}">Spend</label>
            </div>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Label</label>
            <br>
            <div class="btn-group-vertical" role="group" aria-label="Basic radio toggle button group">
                @foreach(ReasonLabel::asArray() as $label => $value)
                    <input type="radio" class="btn-check" name="label" value="{{ $value }}" id="r-{{ $label }}-{{ $reason->id ?? null }}" autocomplete="off" {{ isset($reason) && $reason->label === $value ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary" for="r-{{ $label }}-{{ $reason->id ?? null }}">{{ $label }}</label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Group Reason</label>
            <br>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="is_group" value="1" id="is_group_1-{{ $reason->id ?? null }}" autocomplete="off" {{ isset($reason) && $reason->is_group ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="is_group_1-{{ $reason->id ?? null }}">Yes</label>

                <input type="radio" class="btn-check" name="is_group" value="0" id="is_group_2-{{ $reason->id ?? null }}" autocomplete="off" {{ isset($reason) && ! $reason->is_group ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="is_group_2-{{ $reason->id ?? null }}">No</label>
            </div>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <label for="firstname" class="form-label">Category</label>
        <div class="dropdown">
            <button id="btn-{{ $reason->id ?? null }}-category_id" class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ isset($reason->category_id) ? $reason->category?->name : 'Choose label' }}
            </button>
            <ul class="dropdown-menu border-0 shadow p-3">
                @foreach($categories as $category)
                    <li><a data-category_id="{{ $category->id }}" data-id="{{ $reason->id ?? null }}" class="sl-category_id dropdown-item py-2 rounded" href="#">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Type</label>
            <br>
            <input class="form-control" type="file" name="image">
        </div>
    </div>
</div>
<input id="i-{{ $reason->id ?? null }}-category_id" type="hidden" name="category_id" value="{{ $reason->category_id ?? null }}">
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">{{ isset($reason) ? 'Update' : 'Create' }}</button>
</div>
