@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center"> 

        <nav aria-label="breadcrumb" class="">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="text-dark">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Upload Assets</li>
            </ol>
        </nav>

        <div class="col-md-6" style="box-shadow: 0 5px 10px rgba(0, 0, 0, .2); border-radius: 20px 0 20px 0; padding: 24px; background: #fff">
            <h4>Upload Assets to the System..</h4>
            <hr />

            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <h4 class="alert-heading">Success!</h4>
                <p>Assets have been uploaded successfully.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('arfform.upload') }}" method="POST" class="row g-3 mt-4">
                @csrf
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Paste Asset Codes</label>
                    <textarea required rows="4" name="asset_codes" class="form-control" id="asset_codes"></textarea>
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Asset Type</label>
                    <select class="form-control" name="asset_type" id="asset_type" required onchange="loadBrands(this)">
                        <option value="">Select</option>
                        <option value="Laptop">Laptop</option>
                        <option value="Desktop">Desktop</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Mobile">Mobile</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Sim">Sim</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Asset Brand</label>
                    <select required name="asset_brand" class="form-select" id="asset_brand"></select>
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Company</label>
                    <select required name="company" class="form-select" id="company" required>
                        <option value="">Select</option>
                        <option value="AZIZI Developments">AZIZI Developments</option>
                        <option value="Gardinia">Gardinia</option>
                        <option value="Freesia">Freesia</option>
                        <option value="Royal Infra">Royal Infra</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-secondary mx-1" onclick="window.location.href = '/'">Cancel</button>
                    <button type="submit" class="btn bg-purple text-white">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let lis = Array.from(document.getElementsByClassName('drawer-li '));

    lis.forEach(li => li.classList.remove('active'));

    document.getElementById('sideDrawerListItem3').classList.add('active');
</script>
@endsection