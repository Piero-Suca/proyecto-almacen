<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-30">
                <div class="small-box bg-danger" style="height: 100px;"> 
                    <div class="inner text-center">
                        <p class="font-weight-bold mb-0"><h2>Salida</h2></p>
                        
                    </div>
                <div class="icon">
                    <i class="fas fa-fw fa-arrow-left"></i>
                </div>
                <a href="{{ route('admin.salida.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-30">
                <div class="small-box bg-info" style="height: 100px;">
                    <div class="inner text-center">
                        <p class="font-weight-bold mb-0"><h2>Inventario</h2></p> <!-- Negrita y sin margen inferior -->
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-toolbox"></i>
                    </div>
                    <a href="{{ route('admin.articulo.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $combo }}</h3>
                        <p>Combo</p>
                    </div>
                <div class="icon">
                    <i class="fas fa-fw fa-users" ></i>
                </div>
                <a href="{{ route('admin.articulo.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $segadera }}<!--<sup style="font-size: 20px">%</sup--></h3> 
                        <p>Segadera</p>
                    </div>
                <div class="icon">
                    <i class="fas fa-fw fa-arrow-left"></i>
                </div>
                <a href="{{ route('admin.articulo.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pala }}</h3>
                    <p>Pala</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-arrow-right"></i>
                </div>
                <a href="{{ route('admin.articulo.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $tijeradepodar }}</h3>
                    <p>Tijera de Podar Grande</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-arrow-right"></i>
                </div>
                <a href="{{ route('admin.articulo.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $machete }}</h3>
                    <p>Machete</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-arrow-right"></i>
                </div>
                <a href="{{ route('admin.articulo.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $rastrillo }}</h3>
                    <p>Rastrillo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-arrow-right"></i>
                </div>
                <a href="{{ route('admin.articulo.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $extintor }}</h3>
                    <p>Extintor</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-arrow-right"></i>
                </div>
                <a href="{{ route('admin.articulo.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$picos}}</h3>
                    <p>Picos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-toolbox"></i>
                </div>
                <a href="{{ route('admin.articulo.index') }}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- -----------------GRÁFICO LÍNEAL Y CIRCULAR----------------- -->


    {{-- <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Gráficos
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#sales-chart" data-toggle="tab">Donut</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#revenue-chart" data-toggle="tab">Area</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane" id="revenue-chart" style="position: relative; height: 300px;">
                        <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                    </div>
                    <div class="chart tab-pane active" id="sales-chart" style="position: relative; height: 300px;">
                        <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>   --}}  
</div>
