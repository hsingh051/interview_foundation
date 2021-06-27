@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(\Auth::user()->github_token)
                        <github-repos-button-list token="{{\Crypt::decryptString(\Auth::user()->github_token)}}" endpoint="{{route('user.repositories')}}" delete-endpoint="{{route('updateGithubToken')}}"></github-repos-button-list>
                    @else
                        <github-token-form endpoint="{{route('updateGithubToken')}}"></github-token-form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
