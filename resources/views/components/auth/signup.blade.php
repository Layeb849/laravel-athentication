@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <form>
                        <div class="mb-lg-3">
                            <label for="">Name</label>
                            <input type="text" id="name" class="form-control form-control-sm">
                        </div>
                        <div class="mb-lg-3">
                            <label for="">Email</label>
                            <input type="email" id="email" class="form-control form-control-sm">
                        </div>
                        <div class="mb-lg-3">
                            <label for="">Password</label>
                            <input type="password" id="password" class="form-control form-control-sm">
                        </div>
                        <button class="btn btn-success btn-sm px-3 py-2">Sign-up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
