@section('header')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Giao dịch</div>
    </div>
@endsection
<div id="appCapsule">
    <div class="section mt-2">
        <a wire:navigate href="{{ route('transaction.cash') }}" class="card bg-dark text-white">
            <img src="https://accgroup.vn/wp-content/uploads/2022/09/Tien-mat-la-gi-cap-nhat-2022.jpg" class="card-img overlay-img" alt="image">
            <div class="card-img-overlay">
                <h2 class="card-title">Tiền mặt</h2>
            </div>
        </a>
    </div>
    <div class="section mt-2">
        <div class="card bg-dark text-white">
            <img src="https://img.vietnamfinance.vn/webp-jpg/600x391/upload/news/thanhhang/2018/10/1/vnf-tien-mat-la-gi.webp" class="card-img overlay-img" alt="image">
            <div class="card-img-overlay">
                <h2 class="card-title">Tiền tiết kiệm</h2>
            </div>
        </div>
    </div>
    <div class="section mt-2 mb-2">
        <div class="card bg-dark text-white">
            <img src="https://image.luatvietnam.vn/uploaded/twebp/images/original/2023/08/09/tien-dien-tu-la-tien-duoc-ma-hoa_0908151554.jpg" class="card-img overlay-img" alt="image">
            <div class="card-img-overlay">
                <h2 class="card-title">Tiền điện tử</h2>
            </div>
        </div>
    </div>
</div>
