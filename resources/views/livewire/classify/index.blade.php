@php use App\Enums\ReasonLabel; @endphp
@php use App\Enums\ReasonType; @endphp
@extends('components.main-layout.app')

@section('title') Phân loại @endsection
@section('back') {{ route('index') }} @endsection
@section('right')
    <div class="right">
        <a id="btn-create" href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#modal-category-">
            <ion-icon name="add-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
        </a>
    </div>
@endsection

@section('content')
    <div class="extraHeader pe-0 ps-0">
        <ul class="nav nav-tabs lined" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-value="category" data-bs-toggle="tab" href="#category" role="tab">
                    Danh mục
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-value="reason" data-bs-toggle="tab" href="#reason" role="tab">
                    Lí do
                </a>
            </li>
        </ul>
    </div>
    <div id="appCapsule" class="extra-header-active full-height">
        @include('livewire.classify.category-form')
        @include('livewire.classify.reason-form')

        <div class="section tab-content mt-2 mb-1">
            <div class="tab-pane fade show active" id="category" role="tabpanel">
                <ul class="listview link-listview inset">
                    @foreach($this->categories as $category)
                        @include('livewire.classify.category-card')
                    @endforeach
                </ul>
            </div>
            <div class="tab-pane fade" id="reason" role="tabpanel">
                <div class="row">
                    @foreach($this->categories as $category)
                        <h2>{{ $category->name }}</h2>
                        @foreach($category->reasons as $reason)
                            @include('livewire.classify.reason-card')
                        @endforeach
                    @endforeach

                    <h2>Thu nhập</h2>
                    @foreach($this->earn_reasons as $reason)
                        @include('livewire.classify.reason-card')
                    @endforeach

                    <h2>Chưa phân loại</h2>
                    @foreach($this->other_reasons as $reason)
                        @include('livewire.classify.reason-card')
                    @endforeach
                </div>
            </div>
        </div>

        @foreach($reasons as $reason)
            @include('livewire.classify.reason-form')
        @endforeach

        @foreach($this->categories as $category)
            @include('livewire.classify.category-form')
        @endforeach
    </div>
@endsection

@script
    <script>
        $('.nav-link').on('click', function () {
            $('#btn-create').attr('data-bs-target', `#modal-${$(this).data('value')}-`)
        })
        $('.btn-destroy-category').on('click', function () {
            const form = $(this).closest('form')
            form.closest('.modal').modal('toggle')
            $(`#modal-delete-category-${form.data('category_id')}`).modal('toggle')
        })
        $('.btn-destroy-reason').on('click', function () {
            const form = $(this).closest('form')
            form.closest('.modal').modal('toggle')

            $.ajax({
                type: 'DELETE',
                url: '{{ route('classify.reason.destroy') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: form.data('reason_id'),
                },
                success: function (e) {
                    if (e.status) {
                        $(`#modal-delete-reason-${form.data('reason_id')}`).modal('toggle')
                    } else {
                        showErrorDialog(e.message)
                    }
                }
            })
        })
        $('.btn-confirm-destroy-category').on('click', function () {
            $.ajax({
                type: 'DELETE',
                url: '{{ route('classify.category.destroy') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: $(this).data('id'),
                },
                success: function (e) {
                    if (e.status) {
                        $wire.$call('loadCategories')
                    }
                    e.status === true
                        ? showSuccessDialog(e.message)
                        : showErrorDialog(e.message)
                }
            })
        })
        $('.btn-confirm-destroy-reason').on('click', function () {
            $wire.$call('loadReasons')
        })
        $('.btn-save-category').on('click', function () {
            const form = $(this).closest('form')
            const nameInput = form.find('input[name="name"]')
            if (nameInput.val().trim() === '') {
                return showErrorDialog('Vui lòng điền đầy đủ thông tin')
            }
            const category_id = form.data('category_id') === '' ? null : form.data('category_id')
            const moneyInput = form.find('input[name="money"]')
            $.ajax({
                type: 'POST',
                url: '{{ route('classify.category.store') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: category_id,
                    name: nameInput.val(),
                    money: moneyInput.val(),
                },
                success: function () {
                    showSuccessDialog(`${category_id === null ? 'Tạo mới': 'Cập nhật'} thành công`)
                    if (category_id === null) {
                        nameInput.val('')
                        moneyInput.val('')
                    }
                    $wire.$call('loadCategories')
                },
            })
        })
        $('.btn-save-reason').on('click', function () {
            const form = $(this).closest('form')
            const nameInput = form.find('input[name="name"]')
            const typeInput = form.find('input[name="type"]:checked')
            if (nameInput.val().trim() === '' || typeInput.val() == null) {
                return showErrorDialog('Vui lòng điền đầy đủ thông tin')
            }

            const reason_id = form.data('reason_id') === '' ? null : form.data('reason_id')
            const labelInput = form.find('input[name="label"]:checked')
            const category_idInput = form.find('input[name="category_id"]:checked')
            const imageInput = form.find('input[name="image"]')
            $.ajax({
                type: 'POST',
                url: '{{ route('classify.reason.store') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: reason_id,
                    name: nameInput.val(),
                    type: typeInput.val(),
                    label: labelInput.val(),
                    category_id: category_idInput.val(),
                    image: imageInput.val(),
                },
                success: function() {
                    $wire.$call('loadReasons')
                    showSuccessDialog(`${reason_id === null ? 'Tạo mới': 'Cập nhật'} thành công`)
                    if (reason_id === null) {
                        nameInput.val('')
                        typeInput.prop('checked', false)
                        labelInput.prop('checked', false)
                        category_idInput.prop('checked', false)
                        imageInput.val('')
                    }
                },
            })

        })

        $('.i-image').on('change', function(e) {
            const form = $(this).closest('form')
            const reason_id = form.data('reason_id')
            const file = $(this)[0].files[0]
            const reader = new FileReader()
            reader.onload = function(e) {
                const imageData = e.target.result
                $.ajax({
                    type: 'POST',
                    url: '{{ route('classify.image.store') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        image: imageData,
                        reason_id: reason_id,
                    },
                    success: function() {
                        form.closest('.modal').modal('toggle');
                        $wire.$call('loadReasons')
                        showSuccessDialog('Đổi ảnh thành công')
                    },
                })
            }
            reader.readAsDataURL(file)
        })
    </script>
@endscript
