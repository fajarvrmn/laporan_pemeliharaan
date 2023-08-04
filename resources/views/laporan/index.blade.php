@extends('layouts.app')
 
@section('content')
<style>
    .label-padding{
        font-size: 100%;
        padding-top: 2%;
    }
</style>
<div class="container-fluid">
    
    <div>
        <hr>
    </div>
    <div class="row mb-3">
        <div class="col-10">
            <h4>Data Laporan Pemeliharaan</h4>
        </div>
        <div class="col-2">
            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNew"> Tambah Laporan</a>
        </div>
        <div class="col-12">
            <hr>
        </div>
        <form id="form_filter">
            <div class="row">
                <div class="col-3">
                    <select name="id_peralatan" class="form-control form-control-sm filter_datatable_search">
                        <option value="" disabled selected>Pilih Peralatan</option>
                        @foreach(getPeralatan() as $peralatan)
                            <option value="{{ $peralatan->id_alat }}">{{ $peralatan->nama_bay }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="id_gardu_induk" class="form-control form-control-sm filter_datatable_search">
                        <option value="" disabled selected>Pilih Gardu Induk</option>
                        @foreach(getGarduInduk() as $gardu)
                            <option value="{{ $gardu->id }}">{{ $gardu->nama_gardu }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="nip" class="form-control form-control-sm filter_datatable_search">
                        <option value="" disabled selected>Pilih Nama</option>
                        @foreach(getAllUsers() as $users)
                            <option value="{{ $users->nip }}">{{ $users->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="status" class="form-control form-control-sm filter_datatable_search">
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="0">Diterima</option>
                        <option value="1">Ditolak</option>
                    </select>
                </div>
                <br><br>
                <div class="col-3">
                    <input type="text" placeholder="Tanggal Dari" name="tgl_pelaksanaan_dari" class="form-control form-control-sm filter_datatable_search datepicker" value="">
                </div>
                <div class="col-3">
                    <input type="text" placeholder="Tanggal Sampai" name="tgl_pelaksanaan_sampai" class="form-control form-control-sm filter_datatable_search datepicker" value="">
                </div>
                <div class="col-6">
                     <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                    <button id="clearFilter" type="button" class="btn btn-warning btn-sm text-white">Clear</button> 
                    <!-- <a class="btn btn-danger btn-sm text-white" href="laporan/pdf/0" id="export-pdf"> Export PDF</a> -->
                    <a class="btn btn-success btn-sm" href="laporan/excel/0" id="export-excel"> Export Excel</a>


                </div>
                <div class="col-12">
                    <hr>
                </div>
                
            </div>  
        </form>
        
    </div>
    <!-- <br><br> -->
    <!-- <div class="table-responsive"> -->

        <table class="table table-bordered data-table">
            <thead align="center">
                <tr>
                    <th>No</th>
                    <th>Status Laporan</th>
                    <th>Alasan Penolakan</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Gardu Induk</th>
                    <th>Bay</th>
                    <th>Rel</th>
                    <th>Pengawas Pekerjaan</th>
                    <th>Pelaksana Uji</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    <!-- </div> -->
    
</div>
     
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body" style="font-size: small;">
                
                <form id="formCRUD" name="formCRUD" class="form-horizontal">
                   
                    <input type="hidden" name="id" id="id">

                    <div class="row">

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Tanggal Pelaksanaan</label>
                                </div>
                                <div class="col-9">
                                    <div class="input-group">
                                        <input type="text" name="tgl_pelaksanaan" id="tgl_pelaksanaan" class="form-control form-control-sm datepicker" aria-label="">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Tahanan Kontak</label>
                                </div>
                                <div class="col-9 row">
                                    <label for="" class="col-1 label-padding">R</label>
                                    <input type="text" name="hasil_pengujian_tahanan_kontak[]" id="hasil_pengujian_tahanan_kontak_1" class="form-control form-control-sm col-3 text-center">
                                    <label for="" class="col-1 label-padding">S</label>
                                    <input type="text" name="hasil_pengujian_tahanan_kontak[]" id="hasil_pengujian_tahanan_kontak_2" class="form-control form-control-sm col-3 text-center">
                                    <label for="" class="col-1 label-padding">T</label>
                                    <input type="text" name="hasil_pengujian_tahanan_kontak[]" id="hasil_pengujian_tahanan_kontak_3" class="form-control form-control-sm col-3 text-center">
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Gardu Induk</label>
                                </div>
                                <div class="col-9">
                                    <select id="id_gardu_induk" name="id_gardu_induk" class="form-control form-control-sm">
                                        <option value="" disabled selected>Pilih</option>
                                        @foreach(getGarduInduk() as $gardu)
                                            <option value="{{ $gardu->id }}">{{ $gardu->nama_gardu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Tahanan Isolasi</label>
                                </div>
                                <div class="col-9 row">
                                    <label for="" class="col-1 label-padding">R</label>
                                    <input type="text" name="hasil_pengujian_tahanan_isolasi[]" id="hasil_pengujian_tahanan_isolasi_1" class="form-control form-control-sm col-3 text-center">
                                    <label for="" class="col-1 label-padding">S</label>
                                    <input type="text" name="hasil_pengujian_tahanan_isolasi[]" id="hasil_pengujian_tahanan_isolasi_2" class="form-control form-control-sm col-3 text-center">
                                    <label for="" class="col-1 label-padding">T</label>
                                    <input type="text" name="hasil_pengujian_tahanan_isolasi[]" id="hasil_pengujian_tahanan_isolasi_3" class="form-control form-control-sm col-3 text-center">
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Nama Bay</label>
                                </div>
                                <div class="col-9">
                                    <select id="id_peralatan" name="id_peralatan" class="form-control form-control-sm" required>
                                        <option value="" disabled selected>Pilih</option>
                                        @foreach(getPeralatan() as $peralatan)
                                            <option value="{{ $peralatan->id_alat }}">{{ $peralatan->nama_bay }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Arus Motor</label>
                                </div>
                                <div class="col-9 row">
                                    <input type="number" class="form-control col-12 form-control-sm" name="arus_motor" id="arus_motor">
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Rel</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control form-control-sm" name="rel" id="rel">
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Waktu</label>
                                </div>
                                <div class="col-9 row">
                                    <label for="waktu_open" class="col-2 label-padding">Open</label>
                                    <input type="time" name="waktu_open" id="waktu_open" step="1" class="form-control col-4 form-control-sm text-center">
                                    <label for="waktu_close" class="col-2 label-padding">Close</label>
                                    <input type="time" name="waktu_close" id="waktu_close" step="1" class="form-control col-4 form-control-sm text-center">
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Merk</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" id="merk_name" class="form-control form-control-sm" readonly>
                                    <input type="hidden" id="merk" name="merk" class="form-control form-control-sm">
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Pengawas Pekerjaan</label>
                                </div>
                                <div class="col-9 row">
                                    <select id="pengawas_pekerjaan" name="pengawas_pekerjaan" class="form-control col-12 form-control-sm" required>
                                        <option value="" disabled selected>Pilih</option>
                                        @foreach(getAllUsers() as $user)
                                            <option value="{{ $user->nip }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- <input type="hidden" name="id_peralatan" id="id_peralatan"> -->
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="type" class="control-label label-padding">Type</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" id="type_name" class="form-control form-control-sm" readonly>
                                    <input type="hidden" id="type" name="type" class="form-control form-control-sm">
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Pelaksana Uji</label>
                                </div>
                                <div class="col-9 row">
                                    <select id="pelaksana_uji" name="pelaksana_uji" class="form-control col-12 form-control-sm" required>
                                        <option value="" disabled selected>Pilih</option>
                                        @foreach(getAllUsers() as $user)
                                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- <input type="hidden" name="id_peralatan" id="id_peralatan"> -->
                                </div>
                            </div>

                        </div>


                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Kapasitas</label>
                                </div>
                                <div class="col-9">
                                    <input type="number" name="kapasitas" id="kapasitas" class="form-control form-control-sm">
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Kondisi Visual</label>
                                </div>
                                <div class="col-9 row">
                                    <input type="text" name="kondisi_visual" id="kondisi_visual" class="form-control col-12 form-control-sm">
                                </div>
                            </div>

                        </div>


                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Dokumentasi</label>
                                </div>
                                <div class="col-9">
                                    <input type="file" name="dokumentasi" id="dokumentasi" class="form-control form-control-sm">
                                </div>
                            </div>

                        </div>
                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Status Pekerjaan</label>
                                </div>
                                <div class="col-9 row">
                                    <select id="status_laporan" name="status_laporan" class="form-control col-12 form-control-sm" required>
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Selesai">Belum Selesai</option>
                                       
                                    </select>
                                    <!-- <input type="hidden" name="id_peralatan" id="id_peralatan"> -->
                                </div>
                            </div>

                        </div>

                       <div class="col-6">

                            <div class="form-group row">
                                <div class="col-3 text-left">
                                    <label for="name" class="control-label label-padding">Keterangan</label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="col-9 row">
                                    <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control col-12 form-control-sm"></textarea>
                                </div>
                            </div>

                        </div>

                   </div>
                   
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary" id="saveBtn" value="create"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!--  -->
<!-- Preview Modal -->
<!--  -->
<div class="modal fade" id="ajaxModelPreview" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="min-width:70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading_preview"></h5>
            </div>
            <div class="modal-body" style="font-size: small;">
                <form id="formPreview" name="formPreview" class="form-horizontal">
                    
                   <input type="hidden" name="id_preview" id="id_preview">
                   <input type="hidden" name="id_status_pekerjaan_preview" id="id_status_pekerjaan_preview">
                   <input type="hidden" name="status_preview" id="status_preview">

                   <div class="row">

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Tanggal Pelaksanaan</label>
                                </div>
                                <div class="col-10">
                                    <div class="input-group">
                                        <p id="tgl_pelaksanaan_preview" class="label-padding">: </p>
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Tahanan Kontak</label>
                                </div>
                                <div class="col-10 row">
                                    <label for="" class="col-1 label-padding">R</label>
                                    <p id="hasil_pengujian_tahanan_kontak_1_preview" class="col-3 label-padding" style="font-size:89%!important;">: </p>
                                    <label for="" class="col-1 label-padding">S</label>
                                    <p id="hasil_pengujian_tahanan_kontak_2_preview" class="col-3 label-padding" style="font-size:89%!important;">: </p>
                                    <label for="" class="col-1 label-padding">T</label>
                                    <p id="hasil_pengujian_tahanan_kontak_3_preview" class="col-3 label-padding" style="font-size:89%!important;">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Gardu Induk</label>
                                </div>
                                <div class="col-10">
                                    <p id="id_gardu_induk_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Tahanan Isolasi</label>
                                </div>
                                <div class="col-10 row">
                                    <label for="" class="col-1 label-padding">R</label>
                                    <p id="hasil_pengujian_tahanan_isolasi_1_preview" class="col-3 label-padding" style="font-size:89%!important;">: </p>
                                    <label for="" class="col-1 label-padding">S</label>
                                    <p id="hasil_pengujian_tahanan_isolasi_2_preview" class="col-3 label-padding" style="font-size:89%!important;">: </p>
                                    <label for="" class="col-1 label-padding">T</label>
                                    <p id="hasil_pengujian_tahanan_isolasi_3_preview" class="col-3 label-padding" style="font-size:89%!important;">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Nama Bay</label>
                                </div>
                                <div class="col-10">
                                    <p id="id_peralatan_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Arus Motor</label>
                                </div>
                                <div class="col-10 row">
                                    <!-- <input type="number" class="form-control col-12 form-control-sm" name="arus_motor" id="arus_motor"> -->
                                    <p id="arus_motor_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Rel</label>
                                </div>
                                <div class="col-10">
                                    <!-- <input type="text" class="form-control form-control-sm" name="rel" id="rel"> -->
                                    <p id="rel_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Waktu</label>
                                </div>
                                <div class="col-10 row">
                                    <label for="" class="col-2 label-padding">Open</label>
                                    <!-- <input type="number" name="waktu_open" id="waktu_open" class="form-control col-4 form-control-sm text-center"> -->
                                    <p id="waktu_open_preview" class="col-4 label-padding">: </p>
                                    <label for="" class="col-2 label-padding">Close</label>
                                    <!-- <input type="number" name="waktu_close" id="waktu_close" class="form-control col-4 form-control-sm text-center"> -->
                                    <p id="waktu_close_preview" class="col-4 label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="nama_merk_preview" class="control-label label-padding">Merk</label>
                                </div>
                                <div class="col-10">
                                    <p id="nama_merk_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Pengawas Pekerjaan</label>
                                </div>
                                <div class="col-10 row">
                                    <p id="user_name_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="nama_type_preview" class="control-label label-padding">Type</label>
                                </div>
                                <div class="col-10">
                                    <p id="nama_type_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Pelaksana Uji</label>
                                </div>
                                <div class="col-10 row">
                                    <p id="pelaksana_uji_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Kapasitas</label>
                                </div>
                                <div class="col-10">
                                    <p id="kapasitas_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Kondisi Visual</label>
                                </div>
                                <div class="col-10 row">
                                    <!-- <input type="number" name="kondisi_visual" id="kondisi_visual" class="form-control col-12 form-control-sm"> -->
                                    <p id="kondisi_visual_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Dokumentasi</label>
                                </div>
                                <div class="col-10">
                                    <!-- <input type="number" name="dokumentasi" id="dokumentasi" class="form-control form-control-sm"> -->
                                    <p id="dokumentasi_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Status Pekerjaan</label>
                                </div>
                                <div class="col-10 row">
                                    <!-- <input type="number" name="kondisi_visual" id="kondisi_visual" class="form-control col-12 form-control-sm"> -->
                                    <p id="status_laporan_preview" class="label-padding">: </p>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group row">
                                <div class="col-2 text-left">
                                    <label for="name" class="control-label label-padding">Keterangan</label>
                                </div>
                                <div class="col-10 row">
                                    <textarea id="keterangan_preview" cols="30" rows="3" class="form-control col-12 form-control-sm" readonly></textarea>
                                </div>
                            </div>

                        </div>

                   </div>

                   <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-12">
                       <h5 align="center">Status Persetujuan</h5>
                    </div>

                   <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-12">
                        <input type="hidden" id="id_prev">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Admin</td>
                                    <td>
                                        <button type="button" class="btn btn-success" id="admin-belum-kirim">
                                            <i class="fa fa-envelope"></i> Kirim
                                        </button>
                                        <button type="button" class="btn btn-success d-none" id="admin-sudah-kirim">
                                            <i class="fa fa-check"> Disetujui</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Supervisor</td>
                                    <td>
                                        <button type="button" class="btn btn-success d-none spv-approval" id="spv_setuju">
                                            <i class="fa fa-check"></i> Setuju
                                        </button>
                                        <button type="button" class="btn btn-danger d-none spv-approval" id="spv_tolak">
                                            <i class="fa fa-times"></i> Tolak
                                        </button>
                                        <button type="button" class="btn btn-success d-none" id="spv-sudah-kirim">
                                            <i class="fa fa-check"> Disetujui</i>
                                        </button>
                                        <button type="button" class="btn btn-danger d-none" id="spv-tolak-kirim">
                                            <i class="fa fa-times"> Ditolak</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Manager</td>
                                    <td>
                                        <button type="button" class="btn btn-success d-none manager-approval" id="manager_setuju">
                                            <i class="fa fa-check"></i> Setuju
                                        </button>
                                        <button type="button" class="btn btn-danger d-none manager-approval" id="manager_tolak">
                                            <i class="fa fa-times"></i> Tolak
                                        </button>
                                        <button type="button" class="btn btn-success d-none" id="manager-sudah-kirim">
                                            <i class="fa fa-check"> Disetujui</i>
                                        </button>
                                        <button type="button" class="btn btn-danger d-none" id="manager-tolak-kirim">
                                            <i class="fa fa-times"> Ditolak</i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">
                        <hr>
                    </div>
                   
                    <div class="col-sm-offset-2 col-sm-10">
                     <!-- <button type="submit" class="btn btn-primary" id="previewBtn">Simpan</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="ajaxModelTolak" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id=""></h4>
            </div>
            <div class="modal-body text-center">
                <form id="formTolak" name="formTolak" class="form-horizontal">

                    <div class="col-12">
                        <h5>Tolak Laporan Ini ?</h5>
                    </div>

                    <div class="form-group col-12">
                        <label for="keterangan" class="col-sm-12 control-label">Alasan Penolakan</label>
                        <div class="col-sm-12">
                            <textarea name="alasan_ditolaknya" id="alasan_ditolaknya" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger" id="tolakBtn">Tolak</button>
                    </div> -->

                </form>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger" id="tolakBtn"><i class="fa fa-ban"></i> Tolak</button>
            </div>
        </div>
    </div>
</div>


      
</body>

<script type="text/javascript">

    document.getElementById('waktu_open').addEventListener('change', function() {
      var waktu_open = this.value;
      var parts = waktu_open.split(':');
      if (parts.length === 3) {
        // Jika input mengandung detik
        var hours = parseInt(parts[0]);
        var minutes = parseInt(parts[1]);
        var seconds = parseInt(parts[2]);
        var totalSeconds = hours * 3600 + minutes * 60 + seconds;

        // Mengatur format detik pada input
        var formattedSeconds = seconds < 10 ? '0' + seconds : seconds;
        var formattedHours = hours < 10 ? '0' + hours : hours;
        this.value = formattedHours + ':' + minutes + ':' + formattedSeconds;
      } else {
        // Jika input tidak mengandung detik, tambahkan detik 00
        this.value += ':00';
      }
    });
    
    document.getElementById('waktu_close').addEventListener('change', function() {
      var waktu_close = this.value;
      var parts = waktu_close.split(':');
      if (parts.length === 3) {
        // Jika input mengandung detik
        var hours = parseInt(parts[0]);
        // console.log(parts[0], parts[0].length, hours);
        var minutes = parseInt(parts[1]);
        var seconds = parseInt(parts[2]);
        var totalSeconds = hours * 3600 + minutes * 60 + seconds;

        // Mengatur format detik pada input
        var formattedSeconds = seconds < 10 ? '0' + seconds : seconds;
        var formattedHours = hours < 10 ? '0' + hours : hours;
        this.value = formattedHours + ':' + minutes + ':' + formattedSeconds;
      } else {
        // Jika input tidak mengandung detik, tambahkan detik 00
        this.value += ':00';
      }
    });

  $(function () {
    /*------------------------------------------
     --------------------------------------------
     Pass Header Token
     --------------------------------------------
     --------------------------------------------*/ 
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
      
    /*------------------------------------------
    --------------------------------------------
    Render DataTable
    --------------------------------------------
    --------------------------------------------*/

    // var a = $('form#form_filter').serializeArray();
    // console.log(a);

    var table = $('.data-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bFilter: false,
        ajax: {
            url: "{{ route('laporan.index') }}",
            data: function ( d ) {
                // return $.extend( {}, d, {
                // "search_keywords": $("#searchInput").val().toLowerCase(),
                // "filter_option": $("#sortBy").val().toLowerCase()
                    d.form_search = $('form#form_filter').serializeArray();
                // });
            }
        },
        // ajax: "{{ route('laporan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'status_text', name: 'status_text'},
            {data: 'alasan_ditolak', name: 'alasan_ditolak'},
            {data: 'tgl_pelaksanaan', name: 'tgl_pelaksanaan'},
            {data: 'nama_gardu', name: 'nama_gardu'},
            {data: 'nama_bay', name: 'nama_bay'},
            {data: 'rel', name: 'rel'},
            {data: 'user_name', name: 'user_name'},
            {data: 'pelaksana_uji', name: 'pelaksana_uji'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    new $.fn.dataTable.FixedHeader( table );

    $('#id_peralatan').change(function(){
        // console.log($(this).val());
        var id_alat = $(this).val();

        $.get('laporan/peralatan/'+id_alat,  // url
        function (data, textStatus, jqXHR) {  // success callback
            // console.log(data);
            $.each(data[0], function(k, v) {
                console.log(k, v);
                if(k == 'id_type'){
                    $('#type').val(v);
                }else if(k == 'id_merk'){
                    $('#merk').val(v);
                }else if(k == 'nama_merk'){
                    $('#merk_name').val(v);
                }else if(k == 'nama_type'){
                    $('#type_name').val(v);
                }
            });

        });
    })

    $('form#form_filter').submit(function(){
        // var data = table.$('form#form_filter').serialize();
        var sa = $('form#form_filter').serialize();
        $('#export-pdf').attr('href', 'laporan/pdf/1?'+sa);
        $('#export-excel').attr('href', 'laporan/excel/1?'+sa);
        // console.log(sa);
        // return false;
        table.draw();
        return false;
    });

    $('#clearFilter').click(function(){
        $('form#form_filter')[0].reset();
        $('#export-pdf').attr('href', 'laporan/pdf/0');
        $('#export-excel').attr('href', 'laporan/excel/0');
        table.draw();
    })

    $('body').on('click', '.preview', function () {

        var id = $(this).data('id');
        var id_peralatan = $(this).data('idperalatan');
        var nip = $(this).data('idnip');
        var id_status_pekerjaan = $(this).data('idstatus');
        // var status = $('#status_preview').val();
        // alert(status);

        // console.log(param);
        $.ajax({
            type: 'GET',
            url: '{{ route("laporan.index") }}/'+id+'/edit',
            data: {
                id: id,
                // id_peralatan : id_peralatan,
                // nip : nip,
                // id_status_pekerjaan: id_status_pekerjaan
            },
            success: function(data){
                
                var status = data[0].status;
                
                // console.log(status);

                $.each(data[0], function(k, v) {
                    console.log(k, v);
                    // $('th.'+k+"_preview").text(v);
                    if(k !== 'dokumentasi'){
                        $('p.'+k+"_preview").text(': '+v);
                        $('p#'+k+"_preview").text(': '+v);
                        $('input#'+k+"_preview").val(v);
                        $('textarea#'+k+"_preview").val(v);
                    }else{
                        $('#'+k+'_preview').html('<img src="{{ URL::asset("uploads") }}/images/'+v+'" style="width: 100%;height: 10rem;" alt="No Image Set"></img>');
                    }
                    
                });

                var tahanan_kontak = data[0].hasil_pengujian_tahanan_kontak.split(',');
                var tahanan_isolasi = data[0].hasil_pengujian_tahanan_isolasi.split(',');

                // console.log(tahanan_kontak);

                var i = 1;
                for (let index = 0; index < tahanan_kontak.length; index++) {
                    $('#hasil_pengujian_tahanan_kontak_'+i+'_preview').html(': '+tahanan_kontak[index]+' &#181;Ohm');
                    i++;
                }

                var i = 1;
                for (let index = 0; index < tahanan_isolasi.length; index++) {
                    // const element = array[index];
                    $('#hasil_pengujian_tahanan_isolasi_'+i+'_preview').html(': '+tahanan_isolasi[index]+' MOhm');
                    i++;
                }

                if(data[0].id_status_pekerjaan == '1' && status == '0'){

                    if(role == '1'){
                        $('#admin-belum-kirim').removeClass('d-none');
                        $('#admin-sudah-kirim').addClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }else{
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').addClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }

                }else if(data[0].id_status_pekerjaan == '2' && status == '0'){

                    if(role == '2'){
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').removeClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }else{
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }

                }else if(data[0].id_status_pekerjaan == '2' && status == '1'){

                    if(role == '2'){
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').removeClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }else{
                        $('#admin-belum-kirim').removeClass('d-none');
                        $('#admin-sudah-kirim').addClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').removeClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }

                }else if(data[0].id_status_pekerjaan == '3' && status == '0'){

                    if(role == '3'){
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').removeClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').removeClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }else{
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').removeClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }
                }else if(data[0].id_status_pekerjaan == '3' && status == '1'){

                    if(role == '3'){
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').removeClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').removeClass('d-none');
                    }else{
                        $('#admin-belum-kirim').removeClass('d-none');
                        $('#admin-sudah-kirim').addClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').removeClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').removeClass('d-none');
                    }
                }else if(data[0].id_status_pekerjaan == '4' && status == '0'){
                    $('#admin-belum-kirim').addClass('d-none');
                    $('#admin-sudah-kirim').removeClass('d-none');
                    $('.spv-approval').addClass('d-none');
                    $('#spv-sudah-kirim').removeClass('d-none');
                    $('#spv-tolak-kirim').addClass('d-none');
                    $('.manager-approval').addClass('d-none');
                    $('#manager-sudah-kirim').removeClass('d-none');
                    $('#manager-tolak-kirim').addClass('d-none');
                }

                $('#modelHeading_preview').html("Detail Laporan");
                $('#previewBtn').val("preview");
                $('#ajaxModelPreview').modal('show');

            },
            error: function(xhr){
                console.log(xhr.responseText);
            }
        });
    });

    $('#admin-belum-kirim').click(function(){
        var id = $('#id_preview').val();
        // var id_peralatan = $("#id_peralatan_preview").val();
        // var nip = $("#nip_preview").val();
        $.ajax({
            data: {id: id, id_status_pekerjaan: 2, status: 0, alasan_ditolak: null},
            url: "{{ route('laporan.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
        
                $('#formPreview').trigger("reset");
                $('#ajaxModelPreview').modal('hide');
                table.draw();
            
            },
            error: function (data) {
                console.log('Error:', data);
                // $('#saveBtn').html('Simpan');
            }
        });
    });

    $('#spv_setuju').click(function(){
        var id = $('#id_preview').val();
        // var id_peralatan = $("#id_peralatan_preview").val();
        // var nip = $("#nip_preview").val();
        $.ajax({
            data: {id: id, id_status_pekerjaan: 3, status: 0},
            url: "{{ route('laporan.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
        
                $('#formPreview').trigger("reset");
                $('#ajaxModelPreview').modal('hide');
                table.draw();
            
            },
            error: function (data) {
                console.log('Error:', data);
                // $('#saveBtn').html('Simpan');
            }
        });
    });

    $('#manager_setuju').click(function(){
        var id = $('#id_preview').val();
        // var id_peralatan = $("#id_peralatan_preview").val();
        // var nip = $("#nip_preview").val();
        $.ajax({
            data: {id: id, id_status_pekerjaan: 4, status: 0},
            url: "{{ route('laporan.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
        
                $('#formPreview').trigger("reset");
                $('#ajaxModelPreview').modal('hide');
                table.draw();
            
            },
            error: function (data) {
                console.log('Error:', data);
                // $('#saveBtn').html('Simpan');
            }
        });
    });

    $('#spv_tolak, #manager_tolak').click(function(){
        $('#ajaxModelTolak').modal('show');
    });

    $('#tolakBtn').click(function(){

        var id = $('#id_preview').val();
        // var id_peralatan = $("#id_peralatan_preview").val();
        // var nip = $("#nip_preview").val();
        var id_status_pekerjaan = $('#id_status_pekerjaan_preview').val();
        var alasan = $('#alasan_ditolaknya').val();

        $.ajax({
            data: {id: id, id_status_pekerjaan: id_status_pekerjaan, alasan_ditolak: alasan, status: 1},
            url: "{{ route('laporan.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {

                $('#formTolak').trigger("reset");
                $('#ajaxModelTolak').modal('hide');
                $('#formPreview').trigger("reset");
                $('#ajaxModelPreview').modal('hide');
                table.draw();
            
            },
            error: function (data) {
                console.log('Error:', data);
                // $('#saveBtn').html('Simpan');
            }
        });
    })

    $('#createNew').click(function () {
        $('#id_peralatan').val("");
        $('#id_status_pekerjaan').val("");
        $('#saveBtn').val("create");
        $('#id').val('');
        $('#formCRUD').trigger("reset");
        $('#modelHeading').html("Tambah Data");
        $('#ajaxModel').modal('show');
        
        $('#id_peralatan_select').prop('disabled', false);
        $('#nip').prop('readonly', false);
        $('#id_status_pekerjaan_select').prop('disabled', false);
    });

    $('select#id_peralatan_select').change(function(){
        $('#id_peralatan').val($(this).val());
    })

    $('select#id_status_pekerjaan_select').change(function(){
        $('#id_status_pekerjaan').val($(this).val());
    })
      
    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: '{{ route("laporan.index") }}/'+id+'/edit',
            data: {
                id: id,
                // id_peralatan : id_peralatan,
                // nip : nip,
                // id_status_pekerjaan: id_status_pekerjaan
            },
            success: function(data){
                // console.log(data);
                $('#modelHeading').html("Edit Data");
                $('#saveBtn').val("edit");
                $('#ajaxModel').modal('show');

                $.each(data[0], function(k, v) {
                    // console.log(k, v);
                    if(k !== "dokumentasi"){

                        $('input#'+k).val(v);
                        $('textarea#'+k).text(v);
                        $('select#'+k).val(v).trigger('change');

                    }
                    
                });

                var tahanan_kontak = data[0].hasil_pengujian_tahanan_kontak.split(',');
                var tahanan_isolasi = data[0].hasil_pengujian_tahanan_isolasi.split(',');

                var i = 1;
                for (let index = 0; index < tahanan_kontak.length; index++) {
                    // const element = array[index];
                    $('#hasil_pengujian_tahanan_kontak_'+i).val(tahanan_kontak[index]);
                    i++;
                }

                var i = 1;
                for (let index = 0; index < tahanan_isolasi.length; index++) {
                    // const element = array[index];
                    $('#hasil_pengujian_tahanan_isolasi_'+i).val(tahanan_isolasi[index]);
                    i++;
                }

                // if(k == 'hasil_pengujian_tahanan_kontak'){
                    // var str = 
                    // const tKontak = v.split(',');
                    console.log(data[0].hasil_pengujian_tahanan_kontak);
                // }

                // $('#id_peralatan_select').val(data[0].id_peralatan).trigger('change');
                // $('#id_status_pekerjaan_select').val(data[0].id_status_pekerjaan).trigger('change');

                // $('#id_peralatan_select').prop('disabled', true);
                // $('#nip').prop('readonly', true);
                // $('#id_status_pekerjaan_select').prop('disabled', true);

                table.draw();

            },
            error: function(xhr){
                console.log(xhr.responseText);
            }
        });
    });
      
    /*------------------------------------------
    --------------------------------------------
    Create Product Code
    --------------------------------------------
    --------------------------------------------*/
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        var form = $('#formCRUD')[0];
        var dataForm = new FormData(form);
      
        $.ajax({
            data: dataForm,
            enctype: 'multipart/form-data',
            url: "{{ route('laporan.store') }}",
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            //   dataType: 'json',
            success: function (data) {
        
                $('#formCRUD').trigger("reset");
                $('#ajaxModel').modal('hide');
                $('#saveBtn').html('Simpan');
                table.draw();
            
            },
            error: function (data) {
                console.log('Error:', data);
                $('#saveBtn').html('Simpan');
            }
        });
    });
      
    /*------------------------------------------
    --------------------------------------------
    Delete Product Code
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.delete', function () {
     
        // var id = $(this).data("id");
        confirm("Are You sure want to delete !");

        var id = $(this).data('id');
        var id_peralatan = $(this).data('idperalatan');
        var nip = $(this).data('idnip');
        var id_status_pekerjaan = $(this).data('idstatus');
        
        $.ajax({
            type: "DELETE",
            url: "{{ route('laporan.store') }}"+'/'+id,
            data: {
                id: id,
                id_peralatan : id_peralatan,
                nip : nip,
                id_status_pekerjaan: id_status_pekerjaan
            },
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
       
  });
</script>
      
@endsection