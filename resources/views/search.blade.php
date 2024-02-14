@extends('layouts.app')

@section('content')

<style>
    .height {
        height: 100vh;
    }

    .form {
        position: relative;
    }

    .form .fa-search {
        position: absolute;
        top: 20px;
        left: 20px;
        color: #9ca3af;
    }

    .form span {
        position: absolute;
        right: 17px;
        top: 13px;
        padding: 2px;
        border-left: 1px solid #d1d5db;
    }

    .left-pan {
        padding-left: 7px;
    }

    .left-pan i {
        padding-left: 10px;
    }

    .form-input {
        height: 55px;
        text-indent: 33px;
        border-radius: 10px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('arfform.search') }}" method="GET">
                <div class="form">
                    <i class="fa fa-search"></i>
                    <input required type="text" value="{{ $search_main }}" name="search_main" class="form-control form-input" placeholder="Enter Employee ID / Name">
                    
                </div>

                <div class="text-end mt-3">
                    <button type="button" onclick="window.location.href = '/search'" class="btn">Refresh</button>
                    <button type="submit" class="btn bg-purple text-white">Search</button>
                </div>
            </form>

            <div id="search-results" class="mt-5">
                <?php $counter = 1; ?>
                
                @if( isset($results) && count($results) > 0 )
                @foreach($results as $result)
                <div><strong>- {{ $counter }}</strong></div>
                <div class="card">
                    <div class="card-header">{{ $result->name }}</div>
                    <div class="card-body">
                        <div class="mb-3">
                            The User <strong><u>"{{ $result->name }} ({{ $result->emp_id }})"</u></strong> is using following items:
                        </div>

                        <table class="table table-primary table-responsive table-bordered table-sm">
                            <thead>
                                <th>Laptop</th>
                                <th>Desktop</th>
                                <th>Monitor</th>
                                <th>Sim</th>
                                <th>Tablet</th>
                                <th>Mobile</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ count($result->laptops) }}</td>
                                    <td>{{ count($result->desktops) }}</td>
                                    <td>{{ count($result->monitors) }}</td>
                                    <td>{{ count($result->sims) }}</td>
                                    <td>{{ count($result->tablets) }}</td>
                                    <td>{{ count($result->mobiles) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        @if( count($result->laptops) > 0 )
                        <h5 class="search-heading-md">Laptops</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->laptops as $result_laptop )
                                <tr>
                                    <td>{{ $result_laptop->asset_code }}</td>
                                    <td>{{ $result_laptop->asset_brand }}</td>
                                    <td>{{ $result_laptop->created_at }}</td>
                                    <td>{{ $result_laptop->remarks }}</td>
                                    <td>{{ $result_laptop->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Laptops</td>
                                </tr>
                                @endforelse 
                            </tbody>
                        </table>
                        @endif
                        
                        @if( count($result->desktops) > 0 )
                        <h5 class="search-heading-md">Desktops</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->desktops as $result_desktop )
                                <tr>
                                    <td>{{ $result_desktop->asset_code }}</td>
                                    <td>{{ $result_desktop->asset_brand }}</td>
                                    <td>{{ $result_desktop->created_at }}</td>
                                    <td>{{ $result_desktop->remarks }}</td>
                                    <td>{{ $result_desktop->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Desktops</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @endif
                        
                        @if( count($result->monitors) > 0 )
                        <h5 class="search-heading-md">Monitors</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->monitors as $result_monitor )
                                <tr>
                                    <td>{{ $result_monitor->asset_code }}</td>
                                    <td>{{ $result_monitor->asset_brand }}</td>
                                    <td>{{ $result_monitor->created_at }}</td>
                                    <td>{{ $result_monitor->remarks }}</td>
                                    <td>{{ $result_monitor->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Monitors</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @endif
                        
                        @if( count($result->tablets) > 0 )
                        <h5 class="search-heading-md">Tablets</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->tablets as $result_tablet )
                                <tr>
                                    <td>{{ $result_tablet->asset_code }}</td>
                                    <td>{{ $result_tablet->asset_brand }}</td>
                                    <td>{{ $result_tablet->created_at }}</td>
                                    <td>{{ $result_tablet->remarks }}</td>
                                    <td>{{ $result_tablet->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Tablets</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @endif
                        
                        @if( count($result->sims) > 0 )
                        <h5 class="search-heading-md">Sims</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->sims as $result_sim )
                                <tr>
                                    <td>{{ $result_sim->asset_code }}</td>
                                    <td>{{ $result_sim->asset_brand }}</td>
                                    <td>{{ $result_sim->created_at }}</td>
                                    <td>{{ $result_sim->remarks }}</td>
                                    <td>{{ $result_sim->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Sim</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @endif
                        
                        @if( count($result->mobiles) > 0 )
                        <h5 class="search-heading-md">Mobile</h5>
                        <table class="table table-success table-responsive table-bordered table-sm">
                            <thead>
                                <th>Asset Code</th>
                                <th>Asset Brand</th>
                                <th>Date Issued</th>
                                <th>Remarks</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @forelse( $result->mobiles as $result_mobile )
                                <tr>
                                    <td>{{ $result_mobile->asset_code }}</td>
                                    <td>{{ $result_mobile->asset_brand }}</td>
                                    <td>{{ $result_mobile->created_at }}</td>
                                    <td>{{ $result_mobile->remarks }}</td>
                                    <td>{{ $result_mobile->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">No Mobiles</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
                <br />
                <br />
                <?php $counter++; ?>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    let lis = Array.from(document.getElementsByClassName('drawer-li '));

    lis.forEach(li => li.classList.remove('active'));

    document.getElementById('sideDrawerListItem4').classList.add('active');
</script>
@endsection