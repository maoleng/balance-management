@extends('components.main-layout.app')

@section('title') Hóa đơn @endsection
@section('back') {{ route('index') }} @endsection
@section('right')
    <div class="right">
        <a id="btn-create" href="#" class="headerButton">
            <ion-icon name="add-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
        </a>
    </div>
@endsection

@section('content')
    <div id="appCapsule">
        <div class="listview-title mt-2">Danh sách các hóa đơn</div>
        <ul class="listview simple-listview"></ul>
    </div>

    <div class="modal fade action-sheet" id="modal-bill" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cài đặt hóa đơn</h5>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content">
                        <form>
                            <input type="hidden" name="id" id="i-id">
                            <div class="form-group basic animated pt-2">
                                <div class="input-wrapper">
                                    <label class="label" for="i-name">Tên</label>
                                    <input required name="name" type="text" class="form-control" id="i-name" placeholder="Tên">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="i-price">Số tiền</label>
                                    <input required name="price" type="tel" class="form-control" id="i-price" placeholder="Số tiền">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic animated pb-3">
                                <div class="input-wrapper">
                                    <label class="label" for="i-pay_at">Trả vào lúc</label>
                                    <input required name="pay_at" type="date" class="form-control" id="i-pay_at">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <button id="btn-save" type="button" class="btn btn-primary btn-block btn-lg" data-bs-dismiss="modal">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@script
    <script>
        const iId =  $('#i-id')
        const iName =  $('#i-name')
        const iPrice =  $('#i-price')
        const iPayAt =  $('#i-pay_at')
        const modalBill =  $('#modal-bill')

        refreshData()

        iPrice.on('input', function() {
            $(this).val($(this).val().replace(/\D/g,'').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        })

        $('#btn-create').on('click', function () {
            resetForm()
            modalBill.modal('toggle')
        })

        $(document).on('click', '.modal-edit_bill', function () {
            const bill = $(this).data('bill')
            console.log(bill)
            iId.val(bill.id)
            iName.val(bill.name)
            iPrice.val(bill.price)
            iPayAt.val(bill.pay_at)
            modalBill.modal('toggle')
        })

        $('#btn-save').on('click', async function (e) {
            if (iName.val().trim() === '' || iPrice.val().trim() === '' || iPayAt.val().trim() === '') {
                e.preventDefault()
                return showErrorDialog('Vui lòng điền đầy đủ thông tin')
            } else {
                showSuccessToast('Cập nhật hóa đơn thành công')
            }
            await $.ajax({
                url: '{{ route('bill.save') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: iId.val(),
                    name: iName.val(),
                    price: iPrice.val(),
                    pay_at: iPayAt.val(),
                },
            })
            refreshData()
        })

        $(document).on('click', '.btn-delete', async function () {
            const btnConfirm = await confirmDelete(`{{ route('bill.destroy') }}?id=${$(this).data('id')}`)
            console.log(btnConfirm)

            btnConfirm.on('click', function () {
                refreshData()
            })
        })

        function refreshData()
        {
            $.ajax('{{ route('bill.list') }}').then(function (bills) {
                const ul = $('ul')
                ul.empty()
                bills.forEach(function (bill) {
                    ul.append(`
                        <li>
                            <a href="#" class="modal-edit_bill item" data-bill='${JSON.stringify(bill)}'>
                                <div>${bill.name}</div>
                                <span class="text-secondary">${bill.formattedPrice}</span>
                                <footer>${bill.payDateLeftTag}</footer>
                            </a>
                            <button data-id="${bill.id}" type="button" class="btn-delete btn btn-icon btn-outline-danger me-1">
                                <ion-icon name="trash-outline" role="img" class="md hydrated" aria-label="trash outline"></ion-icon>
                            </button>
                        </li>
                    `)
                })
            })
        }

        function resetForm()
        {
            iId.val('')
            iName.val('')
            iPrice.val('')
            iPayAt.val('')
        }
    </script>
@endscript
