@php use App\Enums\ReasonLabel; @endphp
@csrf
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add Category</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Category</label>
            <input type="text" class="form-control" name="name" value="{{ $category->name ?? old('name') }}" required="">
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <label for="firstname" class="form-label">Label</label>
        <div class="dropdown">
            <button class="btn-label btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ isset($category) ? ReasonLabel::getKey($category->label) : 'Choose label' }}
            </button>
            <ul class="dropdown-menu border-0 shadow p-3">
                @foreach(ReasonLabel::asArray() as $label => $value)
                    <li><a data-label="{{ $value }}" class="sl-label dropdown-item py-2 rounded" href="#">{{ $label }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Money</label>
            <input type="number" value="{{ $category->money ?? old('money') }}" class="form-control" name="money" required="">
        </div>
    </div>
</div>
<input id="i-label" type="hidden" name="label" value="{{ $category->label ?? old('label') }}">
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Create</button>
</div>
