<?php $color = array('text-green', 'text-aqua', 'text-yellow','text-primary','text-purple','text-indigo'); ?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="{{ url('/admin/home') }}"><i class="fa fa-dashboard <?php echo $color[array_rand($color,1)] ?>"></i> <span>Dashboard</span></a></li>
            <li><a href="{{ url('/admin/ClientList') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Client List</span></a></li>
            <li><a href="{{ url('/admin/VehicleCredit') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Vehicle Credit</span></a></li>
            <li><a href="{{ url('/admin/Vehicle-Credit-Payment/View') }}"><i class="fa fa-user <?php echo $color[array_rand($color,1)] ?>"></i> <span>Vehicle Credit Payment</span></a></li>
            @if(auth()->user()->id == 1)
                <li><a href="{{ url('/admin/vehicleType') }}"><i class="fa fa-car <?php echo $color[array_rand($color,1)] ?>"></i> <span>Vehicle Type</span></a></li>
                <li><a href="{{ url('/admin/expenseType') }}"><i class="fa fa-money <?php echo $color[array_rand($color,1)] ?>"></i> <span>Expense Type</span></a></li>
                <li><a href="{{ url('/admin/documentType') }}"><i class="fa fa-file <?php echo $color[array_rand($color,1)] ?>"></i> <span>Document Type</span></a></li>
                <li><a href="{{ url('/admin/Viewadminaccount') }}"><i class="fa fa-user-plus  <?php echo $color[array_rand($color,1)] ?>" aria-hidden="true"></i> <span>Add Admin</span></a></li>
            @endif

        </ul>
    </section>
</aside>