@csrf
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add Category</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Category</label>
            <input type="text" class="form-control" name="name" value="{{ $category->name ?? null }}" required="">
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-md-12">
            <label for="firstname" class="form-label">Money</label>
            <input type="number" value="{{ $category->money ?? null }}" class="form-control" name="money">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button class="btn btn-primary">Create</button>
</div>
