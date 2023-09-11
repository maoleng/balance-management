@php use App\Enums\ReasonLabel; @endphp
@extends('theme.master')

@section('title')
    Financial Management > Category
@endsection

@section('body')
    <div class="body d-flex py-3">
        <div class="container-xxl">
            {!! showMessage() !!}
            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0 align-items-center flex-wrap">
                <button type="button" class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addCoinModal">Create Category</button>
                <div class="modal fade modal-sm" id="addCoinModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="{{ route('financial-management.category.store') }}" method="post" class="modal-content">
                            @include('category.form')
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="p2pone" class="priceTable table table-hover custom-table table-bordered align-middle mb-0" style="width:100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Label</th>
                        <th>Money</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $category->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {!! ReasonLabel::getBadge($category->label) !!}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="font-weight-bold text-secondary">
                                        {!! formatVND($category->money) !!}
                                    </span>
                                </div>
                            </td>
                            <td class="dt-body-right sorting_1">
                                <div class="btn-group" role="group">
                                    <button data-bs-toggle="modal" data-bs-target="#m-{{ $category->id ?? null }}" type="button" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i>
                                    </button>
                                    <form action="{{ route('financial-management.category.destroy', ['category' => $category]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($categories as $category)
        <div class="modal fade modal-sm" id="m-{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('financial-management.category.update', ['category' => $category]) }}" method="post" class="modal-content">
                    @method('PUT')
                    @include('category.form')
                </form>
            </div>
        </div>
    @endforeach

@endsection

@section('script')
    <script src="{{ asset('assets/js/template.js') }}"></script>

    <script>
        $('.sl-label').on('click', function () {
            const id = $(this).data('id')
            $(`#i-${id}-label`).val($(this).data('label'))
            $('.btn-label').text($(this).text())
        })


    </script>
@endsection
