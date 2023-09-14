@csrf
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add Transaction</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row" id="test-r">
        <label for="firstname" class="form-label">Reason</label>
        <div class="main-search px-4">
            <input id="i-reason" name="reason" class="form-control" type="text" placeholder="Enter your search key word">
            <div class="card border-0 shadow rounded-2 search-result slidedown">
                <div class="card-body text-start">
                    <div class=" bg-transparent text-wrap">
                        @foreach($reasons as $reason)
                            <a class="badge a-reason {{ $reason->is_group ? 'bg-secondary' : 'btn ' }}">
                                {{ $reason->name }}
                                @if ($reason->is_group)
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
            <label for="firstname" class="form-label">Type</label>
            <br>
            <ul class="nav nav-tabs tab-body-header rounded d-inline-flex" role="tablist">
                <li class="nav-item" role="presentation"><a data-type="1" class="btn-earn nav-link active" data-bs-toggle="tab" href="#btn-normal" role="tab" aria-selected="true">Earn</a></li>
                <li class="nav-item" role="presentation"><a data-type="0" class="btn-earn nav-link" data-bs-toggle="tab" href="#btn-group" role="tab" aria-selected="false" tabindex="-1">Spend</a></li>
            </ul>
        </div>
    </div>
</div>
<input id="i-type" type="hidden" name="type" value="1">
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Create</button>
</div>
