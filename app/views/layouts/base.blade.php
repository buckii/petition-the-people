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
<!-- {{ trans( 'global.github_notice' ) }} -->
</head>
<body>
  <div id="wrapper">
    @include( 'layouts.header' )

    <div id="content" role="main">
      <div class="columns">
        @include( 'messages.flash' )
        @yield( 'body' )
      </div>
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