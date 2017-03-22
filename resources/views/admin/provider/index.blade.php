@extends('adminlte::layouts.app')
@section('htmlheader_title')
    List Provider
@endsection

@section('contentheader_title')
    List Provider
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
    @parent
    <script src="{{asset('js/admin/provider/index.js')}}"></script>
@endsection