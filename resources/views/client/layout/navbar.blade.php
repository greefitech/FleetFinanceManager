<?php $color = array('text-green', 'text-aqua', 'text-yellow','text-primary','text-purple','text-indigo'); ?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ url('/client/home') }}"><i class="fa fa-dashboard <?php echo $color[array_rand($color,1)] ?>"></i> <span>Dashboard</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book <?php echo $color[array_rand($color,1)] ?>"></i>
                    <span>Master</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ url('/client/customers') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Customers</span></a></li>
                    <li><a href="{{ url('/client/vehicles') }}"><i class="fa fa-truck <?php echo $color[array_rand($color,1)] ?>"></i> <span>Vehicles</span></a></li>
                    <li><a href="{{ url('/client/staffs') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Staffs</span></a></li>
                    <li><a href="{{ url('/client/accounts') }}"><i class="fa fa-university <?php echo $color[array_rand($color,1)] ?>"></i> <span>Accounts</span></a></li>
                    <li><a href="{{ url('/client/expense-types') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Expense Type</span></a></li>
                    <li><a href="{{ url('/client/rto-masters') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>RTO Master</span></a></li>
                    <li><a href="{{ url('/client/master/tyres') }}"><i class="fa fa-cog <?php echo $color[array_rand($color,1)] ?>"></i> <span>Tyre</span></a></li>
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
                    <li><a href="{{ url('/client/entry/memo') }}"><i class="fa fa-sticky-note-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>Memo</span></a></li>
                    <li><a href="{{ url('/client/trip/add') }}"><i class="fa fa-truck <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Trip</span></a></li>
                    <li><a href="{{ url('/client/entry/add') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Entry</span></a></li>
                    <li><a href="{{ url('/client/expense/add') }}"><i class="fa fa-pie-chart <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Expense</span></a></li>
                    <li><a href="{{ url('/client/halt/add') }}"><i class="fa fa-shield <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Halt</span></a></li>
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
                    <li><a href="{{ url('/client/income/add') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Income</span></a></li>
                    <li><a href="{{ url('/client/incomes') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>View Income</span></a></li>
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
                    <li><a href="{{ url('/client/extra-income/add') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>Add Extra Income</span></a></li>
                    <li><a href="{{ url('/client/extra-incomes') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>View Extra Income</span></a></li>
                </ul>
            </li>

            <li><a href="{{ url('/client/expense-vehicle-list') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>View Expense</span></a></li>

            <li><a href="{{ route('client.ViewVehicleList') }}"><i class="fa fa-shopping-cart <?php echo $color[array_rand($color,1)] ?>"></i> <span>View Trip Sheet</span></a></li>

            <li><a href="{{ url('/client/tyre/vehicle-list') }}"><i class="fa fa-cog <?php echo $color[array_rand($color,1)] ?>"></i> <span>Assign Tyre</span></a></li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-pdf-o <?php echo $color[array_rand($color,1)] ?>"></i>
                    <span>Report</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ url('/client/report/expense-report') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Expense Report</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cog <?php echo $color[array_rand($color,1)] ?>"></i>
                    <span>Setting</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ url('client/managers') }}"><i class="fa fa-circle-o <?php echo $color[array_rand($color,1)] ?>"></i> <span>Manager</span></a></li>
                </ul>
            </li>


        </ul>
    </section>
</aside>