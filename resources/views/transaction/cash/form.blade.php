@php use App\Enums\ReasonType; @endphp
@csrf
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add Transaction</h5>
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
                        @foreach($reasons->whereIn('type', ReasonType::getCashReasonTypes()) as $reason)
                            <a data-type="{{ $reason->type }}" class="badge a-reason border-primary btn">
                                {{ $reason->name }}
                                @if ($reason->type === ReasonType::GROUP)
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
        <div class="col-md-12">
            <label for="firstname" class="form-label">Icon</label>
            <br>
            <ul class="nav nav-tabs tab-body-header rounded d-inline-flex" role="tablist">
                <li class="nav-item" role="presentation"><a data-type="1" class="btn-type nav-link" data-bs-toggle="tab" href="#btn-normal" role="tab" aria-selected="true">Earn</a></li>
                <li class="nav-item" role="presentation"><a data-type="0" class="btn-type nav-link" data-bs-toggle="tab" href="#btn-group" role="tab" aria-selected="false" tabindex="-1">Spend</a></li>
            </ul>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Is using credit</label>
            <br>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input value="1" type="radio" class="btn-check" name="is_credit" id="i-is_credit_1" autocomplete="off">
                <label class="btn btn-outline-primary" for="i-is_credit_1">Yes</label>

                <input value="0" checked type="radio" class="btn-check" name="is_credit" id="i-is_credit_2" autocomplete="off">
                <label class="btn btn-outline-primary" for="i-is_credit_2">No</label>
            </div>
        </div>
    </div>
</div>
<input id="i-type" type="hidden" name="type">
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Create</button>
</div>
