@php use App\Enums\ReasonType; @endphp
@csrf
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Create Transaction</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <label for="firstname" class="form-label">Type</label>
            <br>
            <div class="btn-group-vertical" role="group" aria-label="Basic radio toggle button group">
                @foreach (ReasonType::getFundExchangeReasonTypes() as $name => $value)
                    <input type="radio" class="btn-check" name="type" value="{{ $value }}" id="r-f-{{ $name }}" autocomplete="off">
                    <label class="btn btn-outline-primary" for="r-f-{{ $name }}">{{ $name }}</label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Amount</label>
            <input type="number" class="form-control" name="price" required="">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Create</button>
</div>
