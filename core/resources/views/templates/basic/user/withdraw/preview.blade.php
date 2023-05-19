@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card custom--card">
                    <div class="card-body">
                        <form action="{{ route('user.withdraw.submit') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-2 text-center bg--light text--info rounded p-3">
                                @php
                                    echo $withdraw->method->description;
                                @endphp
                            </div>
                            <x-viser-form identifier="id" identifierValue="{{ $withdraw->method->form->id }}" />
                            @if (auth()->user()->ts)
                                <div class="form-group">
                                    <label>@lang('Google Authenticator Code')</label>
                                    <input type="text" name="authenticator_code" class="form--control" required>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-md btn--base w-100">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        "use strict";
        (function($) {
            $('label').removeClass('form-label fw-bold');
        })(jQuery);
    </script>
@endpush
