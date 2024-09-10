
@extends('template.index')
@section('container')
<div class="d-flex justify-content-center align-items-center full-height">
    
    <div class="card" style="width: 25rem;">
        
        <div class="card-header"><h5 class="card-title text-center">Login</h5></div>
        <div class="card-body">
            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
            @endif

            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
            @endif
            <form action="/authenticate" method="post" class="user">
                @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            
            <div class="d-flex">
                <button class="btn btn-primary btn-sm flex-fill" type="submit">Login</button>                
            </div>
            <div class="text-center mt-3">Belum punya akun ? <a href="/register">Daftar disini</a></div>
        </form>
        </div>
    </div>
</div>

@endsection()