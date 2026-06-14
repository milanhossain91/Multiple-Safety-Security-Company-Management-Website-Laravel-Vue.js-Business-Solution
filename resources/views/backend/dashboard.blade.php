                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Teachers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">@isset($totalProducts) {{ $totalProducts }} @else 0 @endisset</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Notice</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">@isset($totalcats) {{ $totalcats }} @else 0 @endisset</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Photo </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">@isset($totaltags) {{ $totaltags }} @else 0 @endisset</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-12 col-md-12 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <h1 class="h3 mb-2 text-gray-800">Last Week Notice</h1><hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th style="text-align: center;">Title</th>
                                                    <th style="text-align: center;">Date</th>
                                                    
                                                    <th style="text-align: center;">Post Photo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $i = 0 @endphp
                                            @isset($lastWeekPosts)
                                                @foreach ($lastWeekPosts as $product)
                                                    @php $i++ @endphp
                                                    <tr>
                                                        <td width="10%">{{ $i }}</td>
                                                        <td width="40%" style="text-align: center;">{{ $product->title }}</td>
                                                        <td width="25%" style="text-align: center;">
                                                            @isset($product->created_at)
                                                                {{ \Carbon\Carbon::parse($product->created_at)->format('D, M-Y') }}
                                                            @else
                                                                Date not available
                                                            @endisset
                                                        </td>
                                                        <td width="25%" style="text-align: center;">
                                                            @isset($product->photo_path)
                                                                <img src="{{ asset('/image/product/photo/'.$product->photo_path) }}" height="100px" width="100px">
                                                            @else
                                                                No Image
                                                            @endisset
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">No posts found.</td>
                                                </tr>
                                            @endisset
                                            </tbody>
                                        </table>                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        
                    </div>
