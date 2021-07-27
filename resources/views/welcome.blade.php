@extends('layouts.dashboard')

@section('main')
<div class="col-12">
    <div class="d-flex align-items-center justify-content-between pb-3">
        <h1 class="m-0">Inicio</h1>
        <button type="button" class="btn btn-primary sd-sm" title="Añadir"><span class="pr-2"><i class="fas fa-plus"></i></span>Añadir</button>
    </div>
</div>
<div class="col-12">
    <div class="card bg-white mb-3 sd-sm">
        <div class="card-body">
            <form action="" method="get" class="form-inline mb-4">
                <div class="form-group m-0 mr-1">
                    <label for="search" class="sr-only">Search</label>
                    <input type="text" class="form-control" id="search" placeholder="Buscar...">
                </div>
                <button type="submit" class="btn btn-light" title="Buscar">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="border-0">#</th>
                        <th scope="col" class="border-0">First</th>
                        <th scope="col" class="border-0">Last</th>
                        <th scope="col" class="border-0">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-12">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
@endsection