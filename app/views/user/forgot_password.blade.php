@extends( 'layouts.base' )

@section( 'title', trans( 'user.forgot_password_title' ) )

@section( 'body' )

  @if ( $email_sent )

    <h1>{{ trans( 'user.forgot_password_sent_heading' ) }}</h1>
    <p>{{ trans( 'user.forgot_password_sent_body', [ 'email' => $email ] ) }}</p>

  @else

    {{ Form::open( [ 'action' => 'UserController@doForgotPassword' ] ) }}

      <h1>{{ trans( 'user.forgot_password_heading' ) }}</h1>
      <p>{{ trans( 'user.forgot_password_body' ) }}</p>
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

  @endif

@stop