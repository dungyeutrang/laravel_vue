@extends('adminlte::layouts.app')
@section('htmlheader_title')
    ListCategory
@endsection

@section('contentheader_title')
    @if($id)
        Update Category
    @else
        Create Category
    @endif
@endsection

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <example id="{{$id}}"></example>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{asset('js/admin/category/edit.js')}}"></script>
@endsection