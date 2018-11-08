<div class="col-sm-6">
<!-- Product Name Field -->
<div class="form-group">
    {!! Form::label('product_name', 'Product Name:') !!}
    <h4 >{!! $qrcode->product_name !!}
    <br>
    @if(isset($qrcode->company_name))
        <small>By {!! $qrcode->company_name !!}</small>
    @endif
    </h4>
</div>

<!-- Amount Field -->
<div class="form-group">
    <h4>Amount: ${!! $qrcode->amount !!}</h4>
</div>

<!-- Company Url Field -->
<div class="form-group">
    {!! Form::label('product_url', 'Product Url:') !!}
    <p>
        <a href="{!! $qrcode->product_url !!}" target="_blank">
        {!! $qrcode->product_url !!}
        </a>
    </p>
</div>

@if(!Auth::guest() && ($qrcode->user_id == Auth::user()->id || Auth::user()-role_id < 3))
<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User:') !!}
    <p>{!! $qrcode->user['email'] !!}</p>
</div>

<!-- Website Field -->
<div class="form-group">
    {!! Form::label('website', 'Website:') !!}
    <p>
    <a href="{!! $qrcode->website !!}" target="_blank">
    {!! $qrcode->website !!}
    </a>
    </p>
</div>

<!-- Company Name Field -->
<div class="form-group">
    {!! Form::label('company_name', 'Company Name:') !!}
    <p>{!! $qrcode->company_name !!}</p>
</div>

<!-- Callback Url Field -->
<div class="form-group">
    {!! Form::label('callback_url', 'Callback Url:') !!}
    <p>
        <a href="{!! $qrcode->callback_url !!}" target="_blank">
        {!! $qrcode->callback_url !!}
        </a>
    </p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    @if($qrcode->status == 1)
        <p>Active</p>
    @else
        <p>Inactive</p>
    @endif    
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $qrcode->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $qrcode->updated_at !!}</p>
</div>
@endif
</div>


<div class="col-sm-6">
    <!-- Qrcode Path Field -->
<div class="form-group">
    {!! Form::label('qrcode_path', 'Scan QRCode and Pay With Our App:') !!}
    <br>
    <img src="{{ asset($qrcode->qrcode_path) }}">

    <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px;">
          <div class="col-md-8 col-md-offset-2">
            <p>
                <div>
                    Lagos Eyo Print Tee Shirt
                    ₦ 2,950
                </div>
            </p>
            <input type="hidden" name="email" value="enyiomanwadibia@gmail.com"> {{-- required --}}
            <input type="hidden" name="orderID" value="{{ $qrcode->id }}">
            <input type="hidden" name="amount" value="{{ $qrcode->amount}}"> {{-- required in kobo --}}
            <input type="hidden" name="quantity" value="1">
            @if(!Auth::guest())
            <input type="hidden" name="metadata" value="{{ json_encode($array = ['buyer_user_id' => Auth::user()->id,]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
            @endif
            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
            <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}"> {{-- required --}}
            {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

             <input type="hidden" name="_token" value="{{ csrf_token() }}"> {{-- employ this in place of csrf_field only in laravel 5.0 --}}


            <p>
              <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
              <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
              </button>
            </p>
          </div>
        </div>
</form>
</div>

</div>

@if(!Auth::guest() && ($qrcode->user_id == Auth::user()->id || Auth::user()-role_id < 3))
<div class="col-xs-12">
<h3 class="text-center">Transaction done on this QRCode</h3>
@include('transactions.table')

</div>
@endif 