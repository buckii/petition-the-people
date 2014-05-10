@extends( 'layouts.base' )

@section( 'title', trans( 'user.create_title' ) )

@section( 'body' )

  {{ Form::open( [ 'action' => 'UserController@store' ] ) }}

    <h1>{{ trans( 'user.create_heading' ) }}</h1>
    @include( 'messages.errors' )

    <ul class="form-list">
      <li>
        {{ Form::label( 'username', trans( 'user.field_username' ), [ 'class' => 'required' ] ) }}
        {{ Form::text( 'username' ) }}
      </li>
      <li>
        {{ Form::label( 'email', trans( 'user.field_email' ), [ 'class' => 'required' ] ) }}
        {{ Form::email( 'email' ) }}
      </li>
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
      {{ Form::submit( trans( 'user.action_register_submit' ) ) }}
    </p>
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

  {{ Form::close() }}

@stop