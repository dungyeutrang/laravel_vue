@extends('adminlte::layouts.app')
@section('htmlheader_title')
    ListCategory
@endsection

@section('contentheader_title')
    List Category
@endsection

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <example :data="listData"></example>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/admin/category/index.js')}}"></script>
    @parent
@endsection