@extends('layouts.app')

@section('title', 'Prices')

@section('content')


<div class="container-fluid page-body-wrapper">

    @include("admin.elements.sidebar")

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h4 class="card_title">Latest Price (Class A)</h4>
                                </div>

                                <div class="col-lg-2 text-md-right">
                                    <a class="btn btn-sm btn-success text-white" href="{{ route('prices.create', ['classType' => 1]) }}"> Add New Price</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-2">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Last Dealing Date</th>
                                            <th>Cumulative Return (USD)</th>
                                            <th>Quarterly Return (%)</th>
                                            <th>Latest Cumulative Return (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if (!empty($class_a_price))
                                                
                                                <td class="border-0"><i class="fa fa-calendar-alt"></i> {{ $class_a_price->dealing_date }} </td>
                                                <td class="border-0"><i class="fa fa-dollar-sign"></i> {{ $class_a_price->latest_price }}</td>
                                                <td class="border-0"></i> {{ $class_a_price->quarterly_return }} <i class="fa fa-percentage"></td>
                                                
                                                <td class="border-0"> {{ $class_a_price->ytd_return }} <i class="fa fa-percentage"></i></td>
                                            @else

                                                <td>No Records Found!</td>

                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-10">
                                    <h4 class="card_title">Price Table (Class A)</h4>
                                </div>
                            </div>

                            <div class="table-responsive mt-2">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Last Dealing Date</th>
                                            <th>Cumulative Return (USD)</th>
                                            <th>Quarterly Return (%)</th>
                                            <th>Latest Cumulative Return (%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @if ($class_a_priceHistorys->count() > 0)
                                            
                                        @foreach ($class_a_priceHistorys as $key => $price)
                                        <tr>

                                            <td class="border-0"><i class="fa fa-calendar-alt"></i> {{ $price->dealing_date }} </td>
                                            <td class="border-0"><i class="fa fa-dollar-sign"></i> {{ $price->latest_price }}</td>
                                            <td class="border-0"></i> {{ $price->quarterly_return }} <i class="fa fa-percentage"></td>
                                                
                                            <td class="border-0"> {{ $price->ytd_return }} <i class="fa fa-percentage"></i></td>

                                            <td class="border-0">
                                                <form action="{{ route('prices.destroy',$price->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-soft-primary" href="{{ route('EditPrice', ['PriceId' => $price->id, 'classType' => 1]) }}">Edit</a>
                                                </form>
                                            </td>
                                        </tr>

                                        @endforeach

                                    @else

                                      <tr><td colspan=6 align="center">No Records Available..</td></tr>
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                            
                            <br>
                            {!! $class_a_priceHistorys->links('pagination::bootstrap-4') !!} 
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 card-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h4 class="card_title">Latest Price (Class B)</h4>
                                </div>

                                <div class="col-lg-2 text-md-right">
                                    <a class="btn btn-sm btn-success text-white" href="{{ route('prices.create', ['classType' => 2]) }}"> Add New Price</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-2">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Last Dealing Date</th>
                                            <th>Cumulative Return (USD)</th>
                                            <th>Monthly Return (%)</th>
                                            <th>Latest Cumulative Return (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if (!empty($class_b_price))
                                                <td class="border-0"><i class="fa fa-calendar-alt"></i> {{ $class_b_price->dealing_date }} </td>
                                                <td class="border-0"><i class="fa fa-dollar-sign"></i> {{ $class_b_price->latest_price }}</td>
                                                <td class="border-0"></i> {{ $class_b_price->quarterly_return }} <i class="fa fa-percentage"></td>
                                                
                                                <td class="border-0"> {{ $class_b_price->ytd_return }} <i class="fa fa-percentage"></i></td>
                                            @else

                                                <td>No Records Found!</td>

                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-10">
                                    <h4 class="card_title">Price Table (Class B)</h4>
                                </div>
                            </div>

                            <div class="table-responsive mt-2">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Last Dealing Date</th>
                                            <th>Cumulative Return (USD)</th>
                                            <th>Monthly Return (%)</th>
                                            <th>Latest Cumulative Return (%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @if ($class_b_priceHistorys->count() > 0)
                                            
                                        @foreach ($class_b_priceHistorys as $key => $price)
                                        <tr>
                                            <td class="border-0"><i class="fa fa-calendar-alt"></i> {{ $price->dealing_date }} </td>
                                            <td class="border-0"><i class="fa fa-dollar-sign"></i> {{ $price->latest_price }}</td>
                                            <td class="border-0"></i> {{ $price->quarterly_return }} <i class="fa fa-percentage"></td>
                                                
                                            <td class="border-0"> {{ $price->ytd_return }} <i class="fa fa-percentage"></i></td>

                                            <td class="border-0">
                                                <form action="{{ route('prices.destroy',$price->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-soft-primary" href="{{ route('EditPrice', ['PriceId' => $price->id, 'classType' => 2]) }}">Edit</a>
                                                </form>
                                            </td>
                                        </tr>

                                        @endforeach

                                    @else

                                      <tr><td colspan=6 align="center">No Records Available..</td></tr>
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                            
                            <br>
                            {!! $class_b_priceHistorys->links('pagination::bootstrap-4') !!} 
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @include('admin.elements.footer')
    </div>
</div>
   
@endsection