@csrf
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add Transaction</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
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
                <li class="nav-item" role="presentation"><a data-type="null" class="btn-earn nav-link" data-bs-toggle="tab" href="#btn-group" role="tab" aria-selected="false" tabindex="-1">Invest</a></li>
            </ul>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <label for="firstname" class="form-label">Reason</label>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="sl-reason" data-bs-toggle="dropdown" aria-expanded="false">
                Choose reason
            </button>
            <ul class="dropdown-menu border-0 shadow p-3">
                @foreach($reasons as $reason)
                    <li><a data-id="{{ $reason->id }}" class="sl-reason dropdown-item py-2 rounded" href="#">{{ $reason->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">
        <label class="form-label">Or create new reason</label>

        <div class="col-md-6">
            <div class="form-floating">
                <input name="new_reason" class="form-control" placeholder="Reason...">
                <label>Reason</label>
            </div>
        </div>

    </div>
</div>
<input id="i-reason" type="hidden" name="reason_id">
<input id="i-type" type="hidden" name="type" value="1">
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Create</button>
</div>
