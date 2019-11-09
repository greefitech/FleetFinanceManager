@extends('manager.layout.master')

@section('content')
    <div class="box box-info">
      <div class="box-body">
            <div class="col-sm-4">
                <input type="month" class="form-control dashboardDate" id="year" value="{{ date("Y-m") }}" max="{{ date("Y-m") }}">
            </div>
        </div>
    </div>

   
   <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>Out Standing Amount</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Profit</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

      <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Expense</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
    </div>
  
    <div class="box box-info">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <div id="IncomeExpenseChart"></div>
                </div>
            </div>
        </div>
    </div>

@endsection