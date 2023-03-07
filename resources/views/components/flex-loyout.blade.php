@extends('template')

@section('title', 'Flex')

@section('content')

    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <button class="btn btn-primary me-2">Tambah</button>
            <button class="btn btn-primary me-2">Import</button>
            <button class="btn btn-primary">Export</button>
        </div>
        <div>
            <input type="text" class="form-control mt-3" placeholder="Cari...">
        </div>
        <div>
            <select class="form-select mt-3">
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
            </select>
        </div>
    </div>

@endsection
