<?php $color = array( 'text-aqua', 'text-yellow','text-white'); ?>


<aside class="main-sidebar">
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ auth()->user()->profile_image? url(auth()->user()->profile_image):config('mohan.website_logo') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{ auth()->user()->transportName }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>

    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" class="form-control menuFilter" placeholder="Search...">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </form>

    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="@yield('DashboardMenu')"><a href="{{ url('/client/home') }}"><i class="fa fa-dashboard {{ $color[array_rand($color,1)] }}"></i> <span>Dashboard</span></a></li>

            <li class="header">MASTER</li>
            <li class="treeview @yield('MasterMenu')">
                <a href="#" style="text-decoration:none">
                    <i class="fa fa-book {{ $color[array_rand($color,1)] }}"></i>
                    <span>Master</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ action('ClientController\CustomerController@index') }}"><i class="fa fa-user {{ $color[array_rand($color,1)] }}"></i> <span>Customers</span></a></li>
                    <li><a href="{{ url('/client/vehicles') }}"><i class="fa fa-truck {{ $color[array_rand($color,1)] }}"></i> <span>Vehicles</span></a></li>
                    <li><a href="{{ action('ClientController\StaffController@index') }}"><i class="fa fa-user {{ $color[array_rand($color,1)] }}"></i> <span>Staffs</span></a></li>
                    <li><a href="{{ url('/client/accounts') }}"><i class="fa fa-university {{ $color[array_rand($color,1)] }}"></i> <span>Accounts</span></a></li>
                    <li><a href="{{ url('/client/expense-types') }}"><i class="fa fa-user {{ $color[array_rand($color,1)] }}"></i> <span>Expense / Income Type</span></a></li>
                    <li><a href="{{ url('/client/rto-masters') }}"><i class="fa fa-user {{ $color[array_rand($color,1)] }}"></i> <span>RTO/PC Master</span></a></li>
                </ul>
            </li>

            <li class="header">ENTRY</li>
            <li class="treeview @yield('EntryMenu')">
                <a href="#">
                    <i class="fa fa-cab {{ $color[array_rand($color,1)] }}"></i>
                    <span>Trip</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/client/entry/memo') }}"><i class="fa fa-sticky-note-o {{ $color[array_rand($color,1)] }}"></i> <span>Memo</span></a></li>
                    <li><a href="{{ url('/client/trip/add') }}"><i class="fa fa-truck {{ $color[array_rand($color,1)] }}"></i> <span>Add Trip</span></a></li>
                    <li><a href="{{ url('/client/entry/add') }}"><i class="fa fa-paper-plane {{ $color[array_rand($color,1)] }}"></i> <span>Add Entry</span></a></li>
                    <li><a href="{{ url('/client/expense/add') }}"><i class="fa fa-pie-chart {{ $color[array_rand($color,1)] }}"></i> <span>Add Expense</span></a></li>
                    <li><a href="{{ url('/client/trip-advance/add') }}"><i class="fa fa-shield {{ $color[array_rand($color,1)] }}"></i> <span>Add Trip Advance</span></a></li>
                    <li><a href="{{ url('/client/halt/add') }}"><i class="fa fa-shield {{ $color[array_rand($color,1)] }}"></i> <span>Add Halt</span></a></li>
                </ul>
            </li>

            <li class="treeview @yield('IncomeMenu')">
                <a href="#">
                    <i class="fa fa-user {{ $color[array_rand($color,1)] }}"></i>
                    <span>Income</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/client/income/add') }}"><i class="fa fa-circle-o {{ $color[array_rand($color,1)] }}"></i> <span>Add Income</span></a></li>
                    <li><a href="{{ url('/client/incomes') }}"><i class="fa fa-circle-o {{ $color[array_rand($color,1)] }}"></i> <span>View Income</span></a></li>
                </ul>
            </li>

            <li class="treeview @yield('ExtraIncomeMenu')">
                <a href="#">
                    <i class="fa fa-ils {{ $color[array_rand($color,1)] }}"></i>
                    <span>Extra Income</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/client/extra-income/add') }}"><i class="fa fa-circle-o {{ $color[array_rand($color,1)] }}"></i> <span>Add Extra Income</span></a></li>
                    <li><a href="{{ url('/client/extra-incomes') }}"><i class="fa fa-circle-o {{ $color[array_rand($color,1)] }}"></i> <span>View Extra Income</span></a></li>
                </ul>
            </li>

            <li class="treeview @yield('NonTripExpenseMenu')">
                <a href="#">
                    <i class="fa fa-gbp {{ $color[array_rand($color,1)] }}"></i>
                    <span>Non Trip Expense</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ action('ClientController\ExpenseController@CreateNonTripExpense') }}"><i class="fa fa-pie-chart {{ $color[array_rand($color,1)] }}"></i> <span>Create Expense</span></a></li>
                     <li><a href="{{ url('/client/expense-vehicle-list') }}"><i class="fa fa-circle-o {{ $color[array_rand($color,1)] }}"></i> <span>View Expense</span></a></li>
                </ul>
            </li>

            <li class="@yield('TripSheetMenu')"><a href="{{ route('client.ViewVehicleList') }}"><i class="fa fa-shopping-cart {{ $color[array_rand($color,1)] }}"></i> <span>View Trip Sheet</span></a></li>

             <li class="@yield('TempMemoSheetMenu')"><a href="{{ action('ClientController\MemoController@ViewTempMemo') }}"><i class="fa fa-sticky-note-o {{ $color[array_rand($color,1)] }}"></i> <span>View Temp Memo Sheet</span></a></li>

             <li class="header">REPORT</li>
            <li class="treeview @yield('ReportMenu')">
                <a href="#">
                    <i class="fa fa-file-pdf-o {{ $color[array_rand($color,1)] }}"></i>
                    <span>Report</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/client/report/expense-report') }}"><i class="fa fa-file-excel-o {{ $color[array_rand($color,1)] }}"></i> <span>Expense Report</span></a></li>
                </ul>
            </li>
            <li class="header">SETTING</li>
            <li class="treeview @yield('SettingMenu')">
                <a href="#">
                    <i class="fa fa-cog {{ $color[array_rand($color,1)] }}"></i>
                    <span>Setting</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('client/managers') }}"><i class="fa fa-circle-o {{ $color[array_rand($color,1)] }}"></i> <span>Manager</span></a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
