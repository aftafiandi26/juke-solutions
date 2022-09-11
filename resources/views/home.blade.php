@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Employes</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('home') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-1">
                                        <label for="filter">Filter</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="filter" placeholder="name" name="filterName">
                                    </div>
                                    <div class="col">
                                        <select name="filterPosition" id="filter" class="form-control">
                                            <option value="">-select-</option>
                                            <option value="manager">Manager</option>
                                            <option value="supervisor">Supervisor</option>
                                            <option value="staff">Staff</option>
                                            <option value="etc">Etc</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        <a href="{{ route('home') }}" type="submit" class="btn btn-sm btn-secondary"><i class="fa-solid fa-power-off"></i></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col">

                            <button type="button" class="btn btn-sm btn-primary float-end mb-2" data-bs-toggle="modal" data-bs-target="#addEmployes">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-condensed table-borderd">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>DoB</th>
                                    <th>Address</th>
                                    <th>Current Position</th>
                                    <th>KTP File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employes as $key => $employe)
                                <tr>
                                    <td>{{ $employes->firstItem() + $key }}</td>
                                    <td>{{ $employe->first_name }} {{ $employe->last_name }}</td>
                                    <td>{{ $employe->phone }}</td>
                                    <td>{{ date('d-m-Y', strtotime($employe->bod)) }}</td>
                                    <td>{{ $employe->address }}</td>
                                    <td>{{ $employe->position }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal" data-bs-role="{{ route('home.view', $employe->id) }}" id="viewModalButton"><i class="fa-solid fa-address-card"></i></button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" id="editModalButton" data-bs-role="{{ route('home.edit', $employe->id) }}"><i class="fa-solid fa-pencil"></i></button>

                                        <button type="button" class="btn btn-sm btn-danger" data-bs-role="{{ route('employes.destroy', $employe->id) }}" id="delete"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>

                                <div class="hidden">
                                    <form action="{{ route('employes.update', $employe->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')

                                    </form>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $employes->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<form action="{{ route('employes.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal modal-lg fade" id="addEmployes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addEmployesLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployesLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3 row">
                        <label for="firstName" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="firstName" name="firstName">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="lastName" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="lastName" name="lastName">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="position" class="col-sm-2 col-form-label">Position</label>
                        <div class="col-sm-10">
                            <select name="position" id="position" class="form-control">
                                <option value="">-select position-</option>
                                <option value="manager">Manager</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="staff">Staff</option>
                                <option value="etc">Etc</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="datepicker" class="col-sm-2 col-form-label">Date of Birth</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="datepicker" name="datepicker">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="provinsi" class="col-sm-2 col-form-label">Province</label>
                        <div class="col-sm-10">
                            <select name="provinsi" id="provinsi" class="form-control">
                                <option value="">-select province-</option>
                                @foreach ($provinces as $province)
                                <option value="{{ $province['id'] }}">{{ $province['nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="city" class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-10">
                            <select name="city" id="city" class="form-control">
                                <option value="">-select city-</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <textarea name="address" id="address" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="code_pos" class="col-sm-2 col-form-label">Code Pos</label>
                        <div class="col-sm-10">
                            <input type="text" name="code_pos" id="code_pos" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="bank_position" class="col-sm-2 col-form-label">Rekening Bank Position</label>
                        <div class="col-sm-10">
                            <select name="bank_position" id="bank_position" class="form-control">
                                <option value="">-select Bank-</option>
                                <option value="bca">BCA</option>
                                <option value="cimb">CIMB Niaga</option>
                                <option value="mandiri">Mandiri</option>
                                <option value="bni">BNI</option>
                                <option value="bri">BRI</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="account" class="col-sm-2 col-form-label">Bank Account</label>
                        <div class="col-sm-10">
                            <input type="text" name="account" id="account" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="ktp" class="col-sm-2 col-form-label">No KTP</label>
                        <div class="col-sm-10">
                            <input type="text" name="ktp" id="ktp" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="photo_ktp" class="col-sm-2 col-form-label">Attach KTP</label>
                        <div class="col-sm-10">
                            <input type="file" name="photo_ktp" id="photo_ktp" class="form-control">
                        </div>
                    </div>


                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal View -->
<div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content-view">

        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content-edit">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployesLabel">Update Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-edit">

            </div>
        </div>
    </div>
</div>

<!-- form delete -->
<form action="" method="post" id="deleteForm">
    @csrf
    @method("DELETE")
    <input type="submit" value="Hapus" style="display: none">
</form>


@endsection

@push('style')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


<script>
    $("#datepicker").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: "dd/mm/yy",
    });

    $('select#provinsi').on('change', function(e) {
        e.preventDefault();
        const id = $(this).val();
        const url = "http://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=" + id;
        $('select#city').html('');

        $.ajax({
            url: url,
            success: function(a) {
                const result = a.kota_kabupaten;
                $.each(result, function(nama, data) {
                    $('select#city').append(`<option value="` + data.nama + `">` +
                        data.nama + `</option>`);
                });
            }
        });
    });

    $('button#viewModalButton').on('click', function(e) {
        const url = $(this).attr('data-bs-role');

        $.ajax({
            url: url,
            success: function(a) {
                $("#modal-content-view").html(a);
            }
        });
    });

    function jalankan() {
        $('select#cityEdit').html('');
        const id = $('select#provinsiEdit').val();
        console.log(id);
        const url = "http://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=" + id;

        $.ajax({
            url: url,
            success: function(a) {
                const result = a.kota_kabupaten;
                $.each(result, function(nama, data) {
                    $('select#cityEdit').append(`<option value="` + data.nama + `">` +
                        data.nama + `</option>`);
                });
            }
        });
    }

    $('button#editModalButton').on('click', function(e) {
        const url = $(this).attr('data-bs-role');

        $.ajax({
            url: url,
            success: function(a) {

                const provinsi = 'http://dev.farizdotid.com/api/daerahindonesia/provinsi';
                const idProvinsi = a.data.province_id;
                $.ajax({
                    url: provinsi,
                    dataType: 'json',
                    success: function(x) {
                        const result = x.provinsi;
                        $.each(result, function(nama, data) {
                            let lock;
                            switch (idProvinsi) {
                                case data.id:
                                    lock = "selected";
                                    break;

                                default:
                                    lock = null;
                                    break;
                            }
                            $('select#provinsiEdit').append(`<option ` + lock + ` value="` + data.id + `">` + data.nama + `</option>`);
                        });
                    }
                });

                let positionManager;
                let positionSupervisor;
                let positionStaff;
                let positionEtc;

                if (a.data.position === "manager") {
                    positionManager = "selected";
                }
                if (a.data.position === "supervisor") {
                    positionSupervisor = "selected";
                }
                if (a.data.position === "staff") {
                    positionStaff = "selected";
                }
                if (a.data.position === "etc") {
                    positionEtc = "selected";
                }

                let bankPositionCIMB;
                let bankPositionBCA;
                let bankPositionBRI;
                let bankPositionBNI;
                let bankPositionMANDIRI;

                if (a.data.rek_bank_position === "cimb") {
                    bankPositionCIMB = "selected";
                }

                if (a.data.rek_bank_position === "bca") {
                    bankPositionBCA = "selected";
                }

                if (a.data.rek_bank_position === "bni") {
                    bankPositionBNI = "selected";
                }
                if (a.data.rek_bank_position === "mandiri") {
                    bankPositionMANDIRI = "selected";
                }
                if (a.data.rek_bank_position === "bri") {
                    bankPositionBRI = "selected";
                }

                $('#modal-body-edit').html(`
                <form action="` + a.url + `" method="post" enctype="multipart/form-data" id="form-edit">        
                @csrf
                @method('put')

                <div class="mb-3 row">
                    <label for="firstNameEdit" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="firstNameEdit" name="firstName" value="` + a.data.first_name + `">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="lastName" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="lastName" name="lastName" value=` + a.data.last_name + `>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" value="` + a.data.email + `">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="phone" name="phone" value="` + a.data.phone + `">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="position" class="col-sm-2 col-form-label">Position</label>
                    <div class="col-sm-10">
                        <select name="position" id="position" class="form-control">
                            <option value="">-select position-</option>
                            <option value="manager" ` + positionManager + `>Manager</option>
                            <option value="supervisor" ` + positionSupervisor + `>Supervisor</option>
                            <option value="staff" ` + positionStaff + `>Staff</option>
                            <option value="etc" ` + positionEtc + `>Etc</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="datepickerEdit" class="col-sm-2 col-form-label">Date of Birth</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="datepickerEdit" name="datepicker" value="` + a.data.bod + `">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="provinsiEdit" class="col-sm-2 col-form-label">Province</label>
                    <div class="col-sm-10">
                        <select name="provinsi" id="provinsiEdit" class="form-control" onchange="jalankan()">
                            <option value="">-select city-</option>                                         
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="cityEdit" class="col-sm-2 col-form-label">City</label>
                    <div class="col-sm-10">
                        <select name="city" id="cityEdit" class="form-control">
                            <option value="` + a.data.city + `">` + a.data.city + `</option>                            
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <textarea name="address" id="address" cols="30" rows="10" class="form-control">` + a.data.address + `</textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="code_pos" class="col-sm-2 col-form-label">Code Pos</label>
                    <div class="col-sm-10">
                        <input type="text" name="code_pos" id="code_pos" class="form-control" value="` + a.data.code_pos + `">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="bank_position" class="col-sm-2 col-form-label">Rekening Bank Position</label>
                    <div class="col-sm-10">
                        <select name="bank_position" id="bank_position" class="form-control">
                            <option value="">-select Bank-</option>  
                            <option value="bca" ` + bankPositionBCA + `>BCA</option>
                            <option value="cimb" ` + bankPositionCIMB + `>CIMB Niaga</option>
                            <option value="mandiri" ` + bankPositionMANDIRI + `>Mandiri</option>
                            <option value="bni" ` + bankPositionBNI + `>BNI</option>
                            <option value="bri" ` + bankPositionBRI + `>BRI</option>                        
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="account" class="col-sm-2 col-form-label">Bank Account</label>
                    <div class="col-sm-10">
                        <input type="text" name="account" id="account" class="form-control" value="` + a.data.rek_bank + `">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="ktp" class="col-sm-2 col-form-label">No KTP</label>
                    <div class="col-sm-10">
                        <input type="text" name="ktp" id="ktp" class="form-control" value="` + a.data.ktp + `">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="photo_ktp" class="col-sm-2 col-form-label">Attach KTP</label>
                    <div class="col-sm-10">
                        <input type="file" name="photo_ktp" id="photo_ktp" class="form-control">
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
                </form>
                `);
            }
        });
    });

    $('button#delete').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('data-bs-role');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-sm btn-success',
                cancelButton: 'btn btn-sm btn-danger'
            },
            buttonsStyling: false
        });

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Anda tidak akan dapat mengembalikannya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus ini!',
            cancelButtonText: 'Tidak, Batalkan!',
        }).then((result) => {
            if (result.value) {
                document.getElementById('deleteForm').action = href;
                document.getElementById('deleteForm').submit();

                swalWithBootstrapButtons.fire(
                    'Terhapus!',
                    'Data berhasil dihapus dari sistem.',
                    'success'
                )
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Dibatalkan',
                    'Data berhasil diamakan :)',
                    'error'
                )
            }
        });
    });
</script>
@endpush

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>


<!-- <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/fontawesome.css') }}"> -->
<link rel="stylesheet" href="{{ asset('assets/fontawesome/css/solid.css') }}">
<script src="{{ asset('assets/fontawesome/js/fontawesome.js') }}"></script>
<script src="{{ asset('assets/fontawesome/js/solid.js') }}"></script>
@endpush