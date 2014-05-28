@extends( 'layouts.base' )

@section( 'title', trans( 'user.reset_password_title' ) )

@section( 'body' )

  <section class="page-header">
    <h1>{{ trans( 'user.reset_password_heading' ) }}</h1>
  </section>

  <div class="primary">
    {{ Form::open( [ 'action' => 'UserController@doResetPassword' ] ) }}

      @include( 'messages.errors' )

      <ul class="form-list">
        <li>
          {{ Form:: label( 'password', trans( 'user.field_password' ), [ 'class' => 'required' ] ) }}
          {{ Form::password( 'password' ) }}
        </li>
        <li>
          {{ Form:: label( 'password_confirmation', trans( 'user.field_password_confirmation' ), [ 'class' => 'required' ] ) }}
          {{ Form::password( 'password_confirmation' ) }}
        </li>
      </ul>
      <p class="form-submit">
        {{ Form::submit( trans( 'user.action_reset_password_submit' ) ) }}
      </p>
      <input type="hidden" name="token" value="{{{ $token }}}" />
      <input type="hidden" name="_token" value="{{{ Session::getToken() }}}" />

    {{ Form::close() }}
  </div>

  <div class="secondary">
    <p>{{ trans( 'user.reset_password_body' ) }}</p>
  </div>

@stop