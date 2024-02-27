<div class="modal fade action-sheet" id="modal-category-{{ $category->id ?? null }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ isset($category) ? 'Sửa' : 'Thêm' }} danh mục</h5>
            </div>
            <div class="modal-body">
                <div class="action-sheet-content">
                    <form data-category_id="{{ $category->id ?? null }}">
                        <div class="form-group basic animated pt-2">
                            <div class="input-wrapper">
                                <label class="label" for="i-name">Tên</label>
                                <input value="{{ $category->name ?? null }}" name="name" type="text" class="form-control" id="i-name" placeholder="Tên">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <div class="form-group basic animated pb-3">
                            <div class="input-wrapper">
                                <label class="label" for="i-money">Số tiền</label>
                                <input value="{{ empty($category->money) ? null : $category->money }}" name="money" type="number" class="form-control" id="i-money" placeholder="Số tiền">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <button type="button" class="btn-save-category btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
