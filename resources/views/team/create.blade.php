@extends('adminlte::page')


@section('title', 'Administrador')


@section('template_title')
    {{ __('Create') }} Equipo
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Team</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('teams.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('team.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
