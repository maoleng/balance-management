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
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="type" value="{{ ReasonType::BUY_CRYPTO }}" id="r-buy" autocomplete="off">
                <label class="btn btn-outline-primary" for="r-buy">BUY_CRYPTO</label>

                <input type="radio" class="btn-check" name="type" value="{{ ReasonType::SELL_CRYPTO }}" id="r-sell" autocomplete="off">
                <label class="btn btn-outline-primary" for="r-sell">SELL_CRYPTO</label>
            </div>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Coin</label>
            <input type="text" class="form-control" name="name" required="">
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Coin Amount</label>
            <input type="text" class="form-control" name="quantity" required="">
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" required="">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Create</button>
</div>
