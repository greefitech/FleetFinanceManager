<?php $color = array('text-green', 'text-aqua', 'text-yellow','text-primary','text-purple','text-indigo'); ?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ url('/client/home') }}"><i class="fa fa-dashboard <?php echo $color[array_rand($color,1)] ?>"></i> <span>Dashboard</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i>
                    <span>Master</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="{{ url('/client/customers') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Customers</span></a></li>
                    <li><a href="{{ url('/client/vehicles') }}"><i class="fa fa-truck <?php echo $color[array_rand($color,1)] ?>"></i> <span>Vehicles</span></a></li>
                    <li><a href="{{ url('/client/staffs') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Staffs</span></a></li>
                    <li><a href="{{ url('/client/accounts') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Accounts</span></a></li>
                    <li><a href="{{ url('/client/expense-types') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Expense Type</span></a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>