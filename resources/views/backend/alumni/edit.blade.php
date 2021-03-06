@extends('backend/templates/index')
@section('js')
<script src='{{asset('assets/js/controller/admin-alumni.js')}}'></script>
@stop
@section('content')
<div class="main-content" ng-controller="alumniedit">
    <div class="container">
        <!-- start: PAGE HEADER -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-header">
                    <h1>{{$title}}</h1>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="tabbable">
                    <ul class="nav nav-tabs tab-bricky" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#panel_tab2_example1">
                                <i class="green fa fa-home"></i> {{$title}}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="panel_tab2_example1" class="tab-pane active">
                                                  <alert ng-repeat="alert in alerts" type="<%alert.type%>" close="closeAlert($index)"><% alert.msg %></alert>
                              <form class="form-horizontal" role="form" name="agendaForm" ng-submit="submit({{$data->id}})"" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-field-1"> Nama Lengkap</label>
                                    <div class="col-sm-9">
                                        <input type='text' class='col-sm-10 form-control' name='nama' ng-model='data.nama'/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-field-1"> Tempat Lahir</label>
                                    <div class="col-sm-9">
                                        <input type='text' class='col-sm-10 form-control' name='tempat_lahir' ng-model='data.tempat_lahir'/>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-field-1"> Tanggal Lahir</label>
                                    <div class="col-sm-9">
                                        <input id='datepicker'  type='text' class='col-sm-10 form-control' name='tanggal_lahir' ng-model='data.tanggal_lahir'/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-field-1"> Agama </label>
                                    <div class="col-sm-9">
                                        <select name="data.id" class="form-control" ng-model="data.agama" required>
                                            <option value="">Pilih Agama</option>
                                            <option ng-repeat="unit in agama" value="<% unit.id %>"><% unit.label %></option>
                                        </select>
                                    </div>
                                </div>                      
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-field-1"> Alamat </label>
                                    <div class="col-sm-9">
                                        <input type='text' class='col-sm-10 form-control' name='alamat' ng-model='data.alamat'/>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-field-1"> Pekerjaan </label>
                                    <div class="col-sm-9">
                                        <input type='text' class='col-sm-10 form-control' name='pekerjaan' ng-model='data.pekerjaan'/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-field-1"> Status </label>
                                    <div class="col-sm-9">
                                        <select name="data.id" class="form-control" ng-model="data.status" required>
                                            <option value="">Pilih Status</option>
                                            <option ng-repeat="unit in status" value="<% unit.id %>"><% unit.label %></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-field-1"> Nomor Kontak </label>
                                    <div class="col-sm-9">
                                        <input type='text' class='col-sm-10 form-control' name='kontak_alumni' ng-model='data.kontak_alumni'/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-field-1"></label>
                                    <div class="col-sm-9">
                                        
                                        <button class="btn btn-success" type="submit">
                                            Save
                                        </button>
                                        <a href='{{url('admin/angkatan/'.$data['id_angkatan'].'/alumni')}}' class="btn btn-blue">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop