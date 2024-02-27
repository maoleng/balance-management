@php use Illuminate\Support\Facades\Route; @endphp
<div class="sidebar py-2 py-md-2 me-0 border-end">
    <div class="d-flex flex-column h-100">
        <!-- Logo -->
        <a href="/" class="mb-0 brand-icon">
        <span class="logo-icon">
        <i class="fa fa-gg-circle fs-3"></i>
        </span>
            <span class="logo-text">Balance Management</span>
        </a>
        <!-- Menu: main ul -->
        <ul class="menu-list flex-grow-1 mt-4 px-1">
            <li>
                <a class="m-link {{ Route::is('index') ? 'active' : '' }}" href="{{ route('index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" width="24px" height="24px" viewBox="0 0 38 38">
                        <path xmlns="http://www.w3.org/2000/svg"  d="M34,18.756V34H22v-8h-6v8h-4V14.31l7-3.89L34,18.756z M34,16.472V6h-6v7.139L34,16.472z" style="fill:var(--primary-color);" data-st="fill:var(--chart-color4);"></path>
                        <path xmlns="http://www.w3.org/2000/svg" class="st0" d="M34,14.19V6h-6v2h4v5.08L19,5.86L0.51,16.13l0.98,1.74L19,8.14l17.51,9.73l0.98-1.74L34,14.19z M32,32h-8v-8H14  v8H6V17.653l-2,1.111V34h12v-8h6v8h12V18.764l-2-1.111V32z"></path>
                    </svg>
                    <div>
                        <h6 class="mb-0">Dashboard</h6>
                        <small class="text-muted">Analytics Report</small>
                    </div>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link {{ Route::is('financial-management.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#menu-Authentication" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24px" height="20px" viewBox="0 0 32 32">
                        <path d="M2,0v32h28V0H2z M28,30H4V2h24V30z" style="fill:var(--primary-color);"></path>
                        <path d="M19,8V4H6v10h20V8H19z M8,6h9v2H8V6z M24,12H8v-2h16V12z" style="fill:var(--svg-color);"></path>
                        <path d="M19,20v-4H6v10h20v-6H19z M8,18h9v2H8V18z M24,24H8v-2h16V24z" style="fill:var(--svg-color);"></path>
                    </svg>
                    <div>
                        <h6 class="mb-0">Finance</h6>
                        <small class="text-muted">Finance Management</small>
                    </div>
                    <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                </a>
                <ul class="sub-menu collapse {{ Route::is('financial-management.*') ? 'show' : '' }}" id="menu-Authentication">
                    <li><a class="ms-link {{ Route::is('financial-management.category.*') ? 'active' : '' }}" href="{{ route('financial-management.category.index') }}"><span>Category</span></a></li>
                    <li><a class="ms-link {{ Route::is('financial-management.reason.*') ? 'active' : '' }}" href="{{ route('financial-management.reason.index') }}"><span>Reason</span></a></li>
                </ul>
            </li>
            <li class="collapsed">
                <a class="m-link {{ Route::is('statistic.*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#menu-Statistic" href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <div>
                        <h6 class="mb-0">Statistic</h6>
                        <small class="text-muted">Statistic System</small>
                    </div>
                    <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                </a>
                <ul class="sub-menu collapse {{ Route::is('statistic.*') ? 'show' : '' }}" id="menu-Statistic">
                    <li><a class="ms-link {{ Route::is('statistic.expense') ? 'active' : '' }}" href="{{ route('statistic.expense') }}"><span>Expense</span></a></li>
                </ul>
                <ul class="sub-menu collapse {{ Route::is('statistic.*') ? 'show' : '' }}" id="menu-Statistic">
                    <li><a class="ms-link {{ Route::is('statistic.income') ? 'active' : '' }}" href="{{ route('statistic.income') }}"><span>Income</span></a></li>
                </ul>
            </li>
        </ul>
        <!-- Menu: menu collepce btn -->
        <button type="button" class="btn btn-link sidebar-mini-btn text-muted">
            <span><i class="icofont-bubble-right"></i></span>
        </button>
    </div>
</div>
