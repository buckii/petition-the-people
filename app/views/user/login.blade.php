@extends( 'layouts.base' )

@section( 'title', trans( 'user.login_title' ) )

@section( 'body' )

  <section class="page-header">
    <h1>{{ trans( 'user.login_heading' ) }}</h1>
  </section>

  <div class="primary">
    {{ Form::open( [ 'action' => 'UserController@login' ] ) }}

      @include( 'messages.errors' )

      <ul class="form-list">
        <li>
          {{ Form::label( 'username', trans( 'user.field_username' ), [ 'class' => 'required' ] ) }}
          {{ Form::text( 'username' ) }}
        </li>
        <li>
          {{ Form:: label( 'password', trans( 'user.field_password' ), [ 'class' => 'required' ] ) }}
          {{ Form::password( 'password' ) }}
          <p>{{ link_to_action( 'UserController@forgotPassword', trans( 'user.action_forgot_password' ), null, [ 'class' => 'forgot-password' ] ) }}</p>
        </li>
        <li>
          <label for="remember">{{ Form::checkbox( 'remember' ) }} {{ trans( 'user.login_remember_me' ) }}</label>
        </li>
      </ul>
      <p class="form-submit">
        {{ Form::submit( trans( 'user.action_login_submit' ) ) }}
      </p>
      <input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />

    {{ Form::close() }}
  </div>

  <div class="secondary">
    <p>{{ trans( 'user.login_create_account', [ 'registration_url' => action( 'UserController@create' ) ] ) }}</p>
  </div>

@stop