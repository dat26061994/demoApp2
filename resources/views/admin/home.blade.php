@extends('layouts.admin')
@section('content')
    <div class="">
        <div class="row container">
            <div class="col-md-3 col-left">
                <div>
                    <center><h2>Dashboard</h2></center>
                </div>
            </div>
            <div class="col-md-9">
                <center><h2>Member List</h2></center>
                <div class="row">
                    <div class="col-md-9">
                        <div class="col-xs-4">
                            <label for="search">Members Per Page:</label>
                            <input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div id="imaginary_container">
                            <div class="input-group stylish-input-group">
                                <input ng-model="searchData" type="text" class="form-control" placeholder="Search">
                    <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <th ng-click="sortData('id')">
                        <div ng-class="getSortClass('id')"></div>
                        #
                    </th>
                    <th>Avatar</th>
                    <th ng-click="sortData('name')">
                        <div ng-class="getSortClass('name')">Name
                    </th>
                    <th ng-click="sortData('age')">
                        <div ng-class="getSortClass('age')">Age
                    </th>
                    <th ng-click="sortData('address')">
                        <div ng-class="getSortClass('address')">Address
                    </th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    <tr dir-paginate="mem in members | orderBy: sortColumn:reverse | filter:searchData | itemsPerPage: pageSize">
                        <td>@{{ $index + 1 }}</td>
                        <td>
                            @if('mem.avatar' == '')
                                <img src="{{ asset('public/upload/') }}" alt="">
                            @else
                                <img style="height: 50px; width: 50px" src="{{ asset('public/upload/default_avatar.png') }}" alt="">
                            @endif
                        </td>
                        <td>@{{ mem.name }}</td>
                        <td>@{{ mem.age }}</td>
                        <td>@{{ mem.address }}</td>
                        <td style="text-align: center;">
                            <button data-toggle="modal" title="Add" type="button"
                                    class="btn btn-primary" ng-click="modal('add')"><i
                                        class="glyphicon glyphicon-pencil"></i></button>
                            <button type="button" class="btn btn-warning" ng-click="modal('edit',mem.id)"><i
                                        class="glyphicon glyphicon-wrench"></i>
                            </button>
                            <button type="button" class="btn btn-danger" ng-click="comfirmDelete(mem.id)"><i
                                        class="glyphicon glyphicon-remove"></i>
                            </button>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <dir-pagination-controls></dir-pagination-controls>


            </div>
            {{--Modal--}}
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">
                                <center>@{{ frmTitle }}</center>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form name="memberForm" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="avatar" class="control-label">Avatar:</label>
                                    <input file type="file" name="file" ng-model="member.file">
                                </div>
                                <div class="form-group">
                                    <label for="name" class="control-label">Name:</label>
                                    <input type="text" class="form-control" name="name" ng-model="member.name" ng-maxlength="8" ng-required="true" ng-pattern="/^[a-zA-Z\s]*$/">
                                    <p class="alert alert-danger" ng-show="memberForm.name.$error.required && !memberForm.name.$pristine" class="help-block">Member name is required.</p>
                                    <p class="alert alert-danger" ng-show="memberForm.name.$error.pattern && !memberForm.name.$pristine" class="help-block">Single word only!.</p>
                                    <p class="alert alert-danger" ng-show="memberForm.name.$error.maxlength && !memberForm.name.$pristine" class="help-block">Member name is max 100 character.</p>
                                </div>
                                <div class="form-group">
                                    <label for="age" class="control-label">Age:</label>
                                    <input type="text" ng-pattern="/^[0-9]*$/" class="form-control" name="age" ng-model="member.age" ng-maxlength="2" ng-required="true" style="width: 15%;">
                                    <p class="alert alert-danger" ng-show="memberForm.age.$error.pattern && !memberForm.age.$pristine" class="help-block">Member age is must numberic.</p>
                                    <p class="alert alert-danger" ng-show="memberForm.age.$error.required && !memberForm.age.$pristine" class="help-block">Member age is required.</p>
                                    <p class="alert alert-danger" ng-show="memberForm.age.$error.maxlength && !memberForm.age.$pristine" class="help-block">Member age is max 2 digits.</p>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="control-label" >Address:</label>
                                    <textarea name="address" class="form-control" ng-model="member.address" ng-maxlength="300" ng-required="true"></textarea>
                                    <p class="alert alert-danger" ng-show="memberForm.address.$error.required && !memberForm.address.$pristine" class="help-block">Member address is required.</p>
                                    <p class="alert alert-danger" ng-show="memberForm.address.$error.pattern && !memberForm.address.$pristine" class="help-block">Single word only!.</p>
                                    <p class="alert alert-danger" ng-show="memberForm.address.$error.maxlength && !memberForm.address.$pristine" class="help-block">Member address is max 300 character.</p>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" ng-click="save(state,id)">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
