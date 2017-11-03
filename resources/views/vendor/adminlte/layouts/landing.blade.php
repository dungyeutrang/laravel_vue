<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Adminlte-laravel - {{ trans('adminlte_lang::message.landingdescription') }} ">
        <meta name="author" content="Sergi Tur Badenas - acacha.org">

        <meta property="og:title" content="Adminlte-laravel" />
        <meta property="og:type" content="website" />
        <meta property="og:description" content="Adminlte-laravel - {{ trans('adminlte_lang::message.landingdescription') }}" />
        <meta property="og:url" content="http://demo.adminlte.acacha.org/" />
        <meta property="og:image" content="http://demo.adminlte.acacha.org/img/AcachaAdminLTE.png" />
        <meta property="og:image" content="http://demo.adminlte.acacha.org/img/AcachaAdminLTE600x600.png" />
        <meta property="og:image" content="http://demo.adminlte.acacha.org/img/AcachaAdminLTE600x314.png" />
        <meta property="og:sitename" content="demo.adminlte.acacha.org" />
        <meta property="og:url" content="http://demo.adminlte.acacha.org" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@acachawiki" />
        <meta name="twitter:creator" content="@acacha1" />

        <title>{{ trans('adminlte_lang::message.landingdescriptionpratt') }}</title>

        <!-- Custom styles for this template -->
        <link href="{{ asset('/css/all-landing.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">

        <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

    </head>

    <body data-spy="scroll" data-target="#navigation" data-offset="50">

        <div id="app">
            <!-- Fixed navbar -->
            <div id="navigation" class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><b>Mytube</b></a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#home" class="smoothScroll">{{ trans('adminlte_lang::message.home') }}</a></li>
                            <li><a href="#desc" class="smoothScroll">{{ trans('adminlte_lang::message.product') }}</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                            <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                            @else
                            <li><a href="/home">{{ Auth::user()->name }}</a></li>
                            @endif
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>


            <section id="desc" name="desc">
                <!-- FEATURES WRAP -->
                <div id="features">
                    <div class="container">
                        <div class="row">
                            <h1 class="centered">{{ trans('adminlte_lang::message.product') }}</h1>
                            @foreach($products as $product)
                            <div class="col-sm-4 col-lg-3 col-xs-12 col-md-3 product">
                                <div class=" product-detail">
                                    <div class="avatar-product">
                                        <img  onerror="this.src ='{{asset('/upload/no_image.jpg')}}'" src="{{asset($product->avatar)}}" class="img img-responsive img-product" />
                                    </div>
                                    <div class='description'>
                                        <div class='product-name  text-center'><b>{{$product->name}}</b></div>
                                        <div class='text-center cart_and_rating'>
                                            <div>
                                                <div  class="text-danger product-price">{{number_format($product->price,'0','.',',')}}.đ</div>
                                                <div  class="text-danger add_to_cart"><a class='btn btn-sm btn-warning'>Add to cart</a></div>
                                            </div>
                                            <div>
                                                <div class='product-like pull-left'>
                                                    <span><i class='fa fa-heart'></i> {{$product->num_like}}</span>
                                                </div>
                                                <div class='product-rating pull-right'>
                                                    <span class='span-rating'>
                                                        <i rating ='1' class="fa fa-star rated icon-rating rated" aria-hidden="true"></i>
                                                        <i rating ='2' class="fa fa-star icon-rating rated" aria-hidden="true"></i>
                                                        <i rating ='3' class="fa fa-star-half-o icon-rating rated" aria-hidden="true"></i>
                                                        <i rating ='4' class="fa fa-star-o icon-rating" aria-hidden="true"></i>
                                                        <i rating ='5' class="fa fa-star-o icon-rating" aria-hidden="true"></i>
                                                    </span> 
                                                    <span>(100)</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div><!--/ .container -->
                </div><!--/ #features -->
            </section>

            <section id="showcase" name="showcase">
                <div id="showcase">
                    <div class="container">
                        <div class="row">
                            <h1 class="centered">{{ trans('adminlte_lang::message.recommend') }}</h1>
                        </div>
                        <br>
                        <br>
                        <br>
                    </div><!-- /container -->
                </div>
            </section>

            <footer>
                <div id="c">
                    <div class="container">
                        <p>
                            <strong>Copyright &copy; 2017 dungpv
                                <br/>                   
                        </p>

                    </div>
                </div>
            </footer>

        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="{{ asset('/js/app-landing.js') }}"></script>
        <script>
            $(function(){
                $('.carousel').carousel({
                   interval: 3500
               })
               
                $('.icon-rating').mouseover(function(){
                   $(this).attr('last_class',$(this).attr('class'));
                   $(this).attr('class','fa fa-star icon-rating');
                   $(this).css("color",'orange');
                   $(this).prevAll().each(function(index,e){
                        $(e).attr('last_class',$(e).attr('class'));
                        $(e).attr('class','fa fa-star icon-rating');
                        $(e).css("color",'orange');
                   });
                   
                   $(this).nextAll().each(function(index,e){
                        $(e).attr('last_class',$(e).attr('class'));
                        $(e).attr('class','fa fa-star-o icon-rating');
                        $(e).css("color",'');
                   });
                })
                
                
                $('.icon-rating').mouseleave(function(){
                    
                     $(this).siblings().each(function(index,e){
                         var lastClass = $(this).attr('last_class');
                        $(e).attr('class',lastClass);   
                        $(e).attr('class',lastClass);                    
                        if(!$(e).hasClass('rated')){
                            $(e).css("color",'');                        
                        }
                   });
                    
                    var lastClass = $(this).attr('last_class');
                    $(this).attr('class',lastClass);                    
                    if(!$(this).hasClass('rated')){
                        $(this).css("color",'');                        
                    }
                })
            })
           
        </script>
    </body>
</html>
