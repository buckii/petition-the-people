@extends( 'layouts.base' )

@section( 'title', trans( 'user.forgot_password_title' ) )

@section( 'body' )

  @if ( $email_sent )

    <section class="page-header">
      <h1>{{ trans( 'user.forgot_password_sent_heading' ) }}</h1>
    </section>

    <div class="primary">
      <p>{{ trans( 'user.forgot_password_sent_body', [ 'email' => $email ] ) }}</p>
    </div>

  @else

    <section class="page-header">
      <h1>{{ trans( 'user.forgot_password_heading' ) }}</h1>
    </section>

    <div class="primary">
      {{ Form::open( [ 'action' => 'UserController@doForgotPassword' ] ) }}

        @include( 'messages.errors' )

        <ul class="form-list">
          <li>
            {{ Form:: label( 'email', trans( 'user.field_email' ), [ 'class' => 'required' ] ) }}
            {{ Form::email( 'email' ) }}
          </li>
        </ul>
        <p class="form-submit">
          {{ Form::submit( trans( 'user.action_forgot_password_submit' ) ) }}
        </p>
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />

      {{ Form::close() }}
    </div>

    <div class="secondary">
      <p>{{ trans( 'user.forgot_password_body' ) }}</p>
    </div>

  @endif

@stop