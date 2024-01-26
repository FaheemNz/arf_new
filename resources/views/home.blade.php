@extends('layouts.app')

@section('content')

<style>
    :root {
        --red: hsl(0, 78%, 62%);
        --cyan: hsl(180, 62%, 55%);
        --orange: hsl(34, 97%, 64%);
        --blue: hsl(212, 86%, 64%);
        --varyDarkBlue: hsl(234, 12%, 34%);
        --grayishBlue: hsl(229, 6%, 66%);
        --veryLightGray: hsl(0, 0%, 98%);
        --weight1: 200;
        --weight2: 400;
        --weight3: 600;
    }

    body {
        font-size: 15px;
        font-family: 'Poppins', sans-serif;
        background-color: var(--veryLightGray);
    }

    .attribution {
        font-size: 11px;
        text-align: center;
    }

    .attribution a {
        color: hsl(228, 45%, 44%);
    }

    h1:first-of-type {
        font-weight: var(--weight1);
        color: var(--varyDarkBlue);

    }

    h1:last-of-type {
        color: var(--varyDarkBlue);
    }

    @media (max-width: 400px) {
        h1 {
            font-size: 1.5rem;
        }
    }

    .header {
        text-align: center;
        line-height: 0.8;
        margin-bottom: 50px;
        margin-top: 100px;
    }

    .header p {
        margin: 0 auto;
        line-height: 2;
        color: var(--grayishBlue);
    }


    .box p {
        color: var(--grayishBlue);
    }

    .box {
        border-radius: 5px;
        box-shadow: 0px 30px 40px -20px var(--grayishBlue);
        padding: 30px;
        margin: 20px;
    }

    img {
        float: right;
    }

    @media (max-width: 450px) {
        .box {
            height: 200px;
        }
    }

    @media (max-width: 950px) and (min-width: 450px) {
        .box {
            text-align: center;
            height: 180px;
        }
    }

    .cyan {
        border-top: 3px solid var(--cyan);
    }

    .red {
        border-top: 3px solid var(--red);
    }

    .blue {
        border-top: 3px solid var(--blue);
    }

    .orange {
        border-top: 3px solid var(--orange);
    }

    h2 {
        color: var(--varyDarkBlue);
        font-weight: var(--weight3);
    }


    @media (min-width: 950px) {
        .row1-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .row2-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box-down {
            position: relative;
            top: 150px;
        }

        .box {
            width: 20%;

        }

        .header p {
            width: 30%;
        }

    }
</style>

<div class="container">
    <div class="alert d-none alert-success alert-dismissable" id="alert_import" role="alert" style="width: 300px; position: fixed; top: 70px; right: 12px">
        <h4 class="alert-heading"><i class="fa fa-check"></i> Assets Refreshed</h4>
        <div>Assets have been refresh successfully.</div>
    </div>
    <div class="row1-container text-center">
        <div class="box red box-down">
            <h2>Offboarding / Update</h2>
            <div><input type="text" id="emp_id" placeholder="Enter Emp ID" class="form-control"></div>
            <div class="mt-2">
                <select onchange="preSelectOfficeLocation(this.value)" name="action" id="action" class="form-select form-select-sm" aria-label="Default" required>
                    <option value="">Select Action</option>
                    <option value="Asset_Update">Asset Update</option>
                    <option value="Offboarding">Offboarding</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary btn-sm mt-3" onclick="openUpdateOrOffboardingForm()">Go</a>
        </div>

        <div class="box cyan">
            <h2>ARF Form</h2>
            <p>Create a new ARF Form</p>
            <a href="/arf-new" class="btn btn-primary">New Form</a>
        </div>

        <div class="box red box-down">
            <h2>Admin Panel</h2>
            <p><a href="/admin" target="_blank">Admin Panel</a></p>
            <img src="https://assets.codepen.io/2301174/icon-karma.svg" alt="">
        </div>
    </div>
    <div class="row2-container">
        <div class="box orange text-center">
            <h2>Upload</h2>
            <p><a href="/upload-assets" target="_blank">Upload Assets </a></p>
            <div class="d-flex align-items-center justify-content-center">
                <button type="button" class="btn btn-success btn-sm mt-3" id="btnAsset" onclick="refreshAssets()">Refresh Assets</button>
                <div class="spinner-border text-primary mx-3 d-none" role="status" id="assetLoader">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openUpdateOrOffboardingForm(){
        let action = document.getElementById('action'),
            empId = document.getElementById('emp_id');

        if(!empId.value){
            alert("Please enter Employee ID.");
            
            return;
        }

        if(action.value == "Asset_Update"){
            window.open("/arf-edit/" + empId.value, "_blank");
        } else if(action.value == "Offboarding"){
            window.open("/arf-offboarding/" + empId.value, "_blank");
        }
    }

    function refreshAssets(){
        let btnImport = $('#btnAsset'),
            loader = $('#assetLoader'),
            alertBox = $('#alert_import');

        btnImport.addClass('d-none');
        loader.removeClass('d-none');

        $.ajax({
            url: "/refresh-assets",
            method: "GET",
            data: {
                fetch: true
            },
            success: function(response){
                if(response.success == true){
                    alertBox.removeClass('d-none');

                    let theId = setTimeout(() => {
                        alertBox.addClass('d-none');

                        clearTimeout(theId);
                    }, 2000);
                } else {
                    alert("Some Error Occured while refreshing Assets. Please try again later");
                    
                    alertBox.addClass('d-none');
                }

                btnImport.attr('disabled', false);
                btnImport.removeClass('d-none');
                loader.addClass('d-none');
            },
            error: function(error){
                console.log(error);

                alert("Some Error Occured while refreshing Assets. Please try again later");

                btnImport.attr('disabled', false);

                alertBox.addClass('d-none');
                btnImport.removeClass('d-none');
                loader.addClass('d-none');
            }
        });
    }
</script>
@endsection