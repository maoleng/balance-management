@php use App\Enums\ReasonLabel; use App\Enums\ReasonType; @endphp

<div class="modal fade action-sheet" id="modal-reason-{{ $reason->id ?? null }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ isset($reason) ? 'Sửa' : 'Thêm' }} lí do</h5>
            </div>
            <div class="modal-body">
                <div class="action-sheet-content">
                    <form data-reason_id="{{ $reason->id ?? null }}">
                        <div class="form-group basic animated pt-2">
                            <div class="input-wrapper">
                                <label class="label" for="i-name">Tên</label>
                                <input value="{{ $reason->name ?? null }}" name="name" type="text" class="form-control" id="i-name" placeholder="Tên">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <div class="pt-2">
                            <label class="label" for="i-money">Loại</label>
                            <div class="input-list pt-1">
                                <div class="btn-group" role="group">
                                    @foreach (ReasonType::getCashReasonTypes() as $name => $value)
                                        <input type="radio" class="btn-check" name="type" value="{{ $value }}" id="type_{{ $value }}-{{ $reason->id ?? null }}" autocomplete="off" {{ isset($reason) && $reason->type === $value ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="type_{{ $value }}-{{ $reason->id ?? null }}">{{ $name }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if (empty($reason) || $reason->type === ReasonType::SPEND)
                            <div class="pt-2">
                                <label class="label" for="i-money">Nhãn</label>
                                <div class="input-list pt-1">
                                    <div class="btn-group" role="group">
                                        @foreach(ReasonLabel::asArray() as $label => $value)
                                            <input type="radio" class="btn-check" name="label" value="{{ $value }}" id="r-{{ $label }}-{{ $reason->id ?? null }}" autocomplete="off" {{ isset($reason) && $reason->label === $value ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="r-{{ $label }}-{{ $reason->id ?? null }}">{{ $label }}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2">
                                <label class="label" for="i-money">Danh mục</label>
                                <div class="input-list pt-1">
                                    @foreach($this->categories as $category)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="{{ $category->id }}" name="category_id" id="i-{{ $category->id }}-{{ $reason->id ?? null }}" {{ isset($reason) && $reason->category_id === $category->id ? 'checked' : '' }}>
                                            <label class="form-check-label" for="i-{{ $category->id }}-{{ $reason->id ?? null }}">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @isset($reason)
                            <div class="pt-2 pb-3">
                                <label class="label pb-1" for="i-money">Ảnh</label>
                                <div class="custom-file-upload" id="file-upload-{{ $reason->id }}">
                                    <input type="file" class="i-image" id="file-{{ $reason->id }}" accept=".png, .jpg, .jpeg">
                                    <label style="background-image: url({{ $reason->image ?? null ? getFullPath($reason->image) : '' }})" class="{{ $reason->image ? 'file-uploaded' : '' }}" for="file-{{ $reason->id }}">
                                        <span>
                                            <strong>
                                                <ion-icon name="arrow-up-circle-outline"></ion-icon>
                                                <i>Tải ảnh lên</i>
                                            </strong>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="image" value="{{ $reason->image }}">
                        @endif
                        <div class="form-group basic">
                            <div class="row">
                                @isset($category)
                                    <div class="col">
                                        <button type="button" class="btn-destroy-reason btn btn-danger btn-block btn-lg" data-bs-dismiss="modal">Xóa</button>
                                    </div>
                                @endisset
                                <div class="col">
                                    <button type="button" class="btn-save-reason btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">
                                        {{ isset($reason) ? 'Sửa' : 'Thêm' }}
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

@isset($reason)
    <div class="modal fade dialogbox" id="modal-delete-reason-{{ $reason->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa {{ $reason->name }}</h5>
                </div>
                <div class="modal-body">
                    Bạn chắc chứ?
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">Hủy</a>
                        <button wire:click="deleteReason({{ $reason }})" class="btn-confirm-destroy-reason btn btn-text-primary" data-bs-dismiss="modal">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endisset
