@php use App\Enums\ReasonType; @endphp
@csrf
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Exchange Funding</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <label for="firstname" class="form-label">Reason</label>
        <div class="main-search px-4">
            <input id="i-reason" name="reason" class="form-control" type="text" placeholder="Enter your search key word">
            <div class="card border-0 shadow rounded-2 search-result slidedown">
                <div class="card-body text-start">
                    <div class=" bg-transparent text-wrap">
                        @foreach($reasons as $reason)
                            <a data-type="{{ $reason->type }}" class="badge a-reason border-primary btn">
                                {{ $reason->name }}
                                @if ($reason->is_group)
                                    <i class="fa fa-group ms-1"></i>
                                @elseif ($reason->type === ReasonType::EARN)
                                    <i class="fa fa-plus ms-1"></i>
                                @elseif ($reason->type === ReasonType::SPEND)
                                    <i class="fa fa-minus ms-1"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Amount</label>
            <input type="number" class="form-control" name="price" required="">
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-6">
            <label for="firstname" class="form-label">From</label>
            <br>
            <div class="btn-group-vertical" role="group" aria-label="Basic radio toggle button group">
                @foreach (\App\Enums\ReasonMethod::asArray() as $name => $value)
                    <input type="radio" class="btn-check" name="from" value="{{ $value }}" id="r-f-{{ $name }}" autocomplete="off">
                    <label class="btn btn-outline-primary" for="r-f-{{ $name }}">{{ $name }}</label>
                @endforeach
            </div>
        </div>
        <div class="col-6">
            <label for="firstname" class="form-label">To</label>
            <br>
            <div class="btn-group-vertical" role="group" aria-label="Basic radio toggle button group">
                @foreach (\App\Enums\ReasonMethod::asArray() as $name => $value)
                    <input type="radio" class="btn-check" name="to" value="{{ $value }}" id="r-t-{{ $name }}" autocomplete="off">
                    <label class="btn btn-outline-primary" for="r-t-{{ $name }}">{{ $name }}</label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row pt-3 pb-3">

    </div>
</div>
<input id="i-type" type="hidden" name="type">
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Create</button>
</div>
