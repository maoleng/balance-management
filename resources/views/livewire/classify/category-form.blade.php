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
                            <div class="row">
                                @isset($category)
                                    <div class="col">
                                        <button type="button" class="btn-destroy-category btn btn-danger btn-block btn-lg" data-bs-dismiss="modal">Xóa</button>
                                    </div>
                                @endisset
                                <div class="col">
                                    <button type="button" class="btn-save-category btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">
                                        {{ isset($category) ? 'Sửa' : 'Thêm' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@isset($category)
    <div class="modal fade dialogbox" id="modal-delete-{{ $category->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa {{ $category->name }}</h5>
                </div>
                <div class="modal-body">
                    Bạn chắc chứ?
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">Hủy</a>
                        <button data-id="{{ $category->id }}" class="btn-confirm-destroy-category btn btn-text-primary" data-bs-dismiss="modal">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endisset
