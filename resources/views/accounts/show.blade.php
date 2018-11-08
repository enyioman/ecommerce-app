@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">
            Account: {{ $account->id }}
            <small>
       
                @if($account->applied_for_payout == 1)
                Payout req uest pending

                @endif
          
            </small>
        </h1>

        <h1 class="pull-right">
            @if(Auth::user()->id == $account->user_id && $account->applied_for_payout != 1)
                {!! Form::open(['route' => ['accounts.apply_for_payout'], 'method' => 'post', 'class'=>"pull-left"]) !!}
                
                <input type="hidden" value="{{ $account->id }}" name="apply_for_payout" />
                {!! Form::button('<i class="fa fa-credit-card"></i> Apply for payout', ['type' => 'submit', 'class' => 'btn btn-primary', 'onclick' => "return confirm('Are you sure you wish to apply for payout?')"]) !!}
                
                {!! Form::close() !!}
            @endif

            @if(Auth::user()->role_id < 3 && $account->paid != 1)
                {!! Form::open(['route' => ['accounts.confirm_payment'], 'method' => 'post', 'class'=>"pull-left", 'style'=>'margin-left:']) !!}
                
                <input type="hidden" value="{{ $account->id }}" name="confirm_payment" />
                {!! Form::button('<i class="fa fa-credit-card"></i> Approve Payout', ['type' => 'submit', 'class' => 'btn btn-success', 'onclick' => "return confirm('Are you sure you wish to confirm payout?')"]) !!}
                
                {!! Form::close() !!}
            @endif
        </h1>

                
    </section>
    <div class="content">
    <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('accounts.show_fields')
                    <a href="{!! route('accounts.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
