<?php $color = array('text-green', 'text-aqua', 'text-yellow','text-primary','text-purple','text-indigo'); ?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ url('/manager/home') }}"><i class="fa fa-dashboard <?php echo $color[array_rand($color,1)] ?>"></i> <span>Dashboard</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book <?php echo $color[array_rand($color,1)] ?>"></i>
                    <span>Master</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ url('/manager/customers') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Customers</span></a></li>
                    <li><a href="{{ url('/manager/vehicles') }}"><i class="fa fa-truck <?php echo $color[array_rand($color,1)] ?>"></i> <span>Vehicles</span></a></li>
                    <li><a href="{{ url('/manager/accounts') }}"><i class="fa fa-university <?php echo $color[array_rand($color,1)] ?>"></i> <span>Accounts</span></a></li>
                    <li><a href="{{ url('/manager/expense-types') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Expense Type</span></a></li>
                    <li><a href="{{ url('/manager/rto-masters') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>RTO Master</span></a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i>
                    <span>Trip</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ url('/manager/entry/memo') }}"><i class="fa fa-sticky-note-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>Memo</span></a></li>
                    <li><a href="{{ url('/manager/trip/add') }}"><i class="fa fa-truck <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Trip</span></a></li>
                    <li><a href="{{ url('/manager/entry/add') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Entry</span></a></li>
                    <li><a href="{{ url('/manager/expense/add') }}"><i class="fa fa-pie-chart <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Expense</span></a></li>
                    <li><a href="{{ url('/manager/halt/add') }}"><i class="fa fa-shield <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Halt</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i>
                    <span>Income</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ url('/manager/income/add') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Income</span></a></li>
                    <li><a href="{{ url('/manager/incomes') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>View Income</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i>
                    <span>Extra Income</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ url('/manager/extra-income/add') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Extra Income</span></a></li>
                    <li><a href="{{ url('/manager/extra-incomes') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>View Extra Income</span></a></li>
                </ul>
            </li>

            <li><a href="{{ url('/manager/expense-vehicle-list') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>View Expense</span></a></li>

            <li><a href="{{ route('manager.ViewVehicleList') }}"><i class="fa fa-shopping-cart <?php echo $color[array_rand($color,1)] ?>"></i> <span>View Trip Sheet</span></a></li>

        </ul>
    </section>
</aside>