
@extends('template.index')
@section('container')
<div class="d-flex justify-content-center align-items-center full-height">
    <div class="card" style="width: 25rem;">
        <div class="card-header"><h5 class="card-title text-center">Register</h5></div>
        <form method="POST" action="/register">
            @csrf
        <div class="card-body">
            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Tulis namanya disini" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"  placeholder="Tulis emailnya disini" value="{{ old('email') }}"  required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Tulis passwordnya disini, Hati-hati yah ;)" required>
            </div>
            
            <div class="d-flex">
                <button class="btn btn-primary btn-sm flex-fill" type="submit">Register</button>
                <br>
                
            </div>
        </form>
            <div class="text-center mt-3">Sudah punya akun ? <a href="/login">Login disini</a></div>
            
        </div>
    </div>
</div>

@endsection()