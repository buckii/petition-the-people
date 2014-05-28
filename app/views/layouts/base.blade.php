<!DOCTYPE html>
<!--[if IE 8]><html class="no-js ie8" lang="{{{ Config::get('app.locale') }}}"><![endif]-->
<!--[if (gte IE 9) | !(IE)]><!--><html class="no-js" lang="{{{ Config::get('app.locale') }}}"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
@section( 'document-title' )
<title>@yield( 'title' ) . ' | ' . trans( 'global.app_name' )</title>
@show
<link href="{{{ asset( 'css/app.css' ) }}}" type="text/css" rel="stylesheet" media="all" />
<script src="{{{ asset( 'js/modernizr.min.js' ) }}}"></script>
<link href="{{{ asset( 'favicon.ico' ) }}}" rel="shortcut icon" />
<meta name="apple-mobile-web-app-title" content="{{{ trans( 'global.ios_app_title' ) }}}" />
<link href="{{{ asset( 'img/apple-touch-icon.png' ) }}}" rel="apple-touch-icon" />
<!-- {{ trans( 'global.github_notice' ) }} -->
</head>
<body>

@if ( Config::get( 'wethepeople.google_analytics_profile_id' ) )
  <!-- Google Universal Analytics -->
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', '{{{ Config::get( "wethepeople.google_analytics_profile_id" ) }}}', '{{{ parse_url( Config::get( "app.url", $_SERVER["HTTP_HOST"] ), PHP_URL_HOST ) }}}');
    ga('require', 'displayfeatures');
    ga('send', 'pageview');
  </script>
@endif

  <div id="wrapper">
    @include( 'layouts.header' )

    <div id="content" role="main">
      @include( 'messages.flash' )
      @yield( 'body' )
    </div><!-- #content -->
  </div><!-- #wrapper -->

  @include( 'layouts.footer' )

  <script>
    /* <![CDATA[ */
    var app = {{ WTPHelper::getScriptLocalizationObject() }}
    /* ]]> */
  </script>
  <script src="{{{ asset( 'js/application.js' ) }}}"></script>
</body>
</html>