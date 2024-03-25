@extends('layouts.app_new')
@section('content')

    {{-- invoice pdf --}}
    <div class="row" hidden>
        <div class="col-lg-12">
            <div class="card px-2">
                <div class="card-body">
                    <div class="container-fluid">
            @foreach ($invoice_info as $invoice)
                      <h3 class="text-right my-5">Invoice  {{ $invoice->invoice_id }}</h3>
                      <hr>
                    </div>
                    <div class="container-fluid d-flex justify-content-between">
                      <div class="col-lg-3 ps-0">
                        <p class="mt-5 mb-2"><b>NRF Admin</b></p>
                        <p>104,<br>Minare SK,<br>Canada, K1A 0G9.</p>
                      </div>
                      <div class="col-lg-3 pe-0">
                        <p class="mt-5 mb-2 text-right"><b>Invoice to</b></p>
                        <p class="text-right">
                            {{ $invoice->deli_info->recipient_name }} ,<br>
                            {{ $invoice->deli_info->recipient_phone }} ,<br>
                            {{ $invoice->deli_info->delivery_address }}
                        </p>
                      </div>
                    </div>
                    <div class="container-fluid d-flex justify-content-between">
                      <div class="col-lg-3 ps-0">
                        <p class="mb-0 mt-5">Invoice Date :
                            {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $invoice->created_at)->format('d-m-Y')}}
                            {{-- {{ date('Y-m-d\TH:i', strtotime($order_info->order_date)) }}</p> --}}
                        {{-- <p>Due Date : 25th Jan 2017</p> --}}
                      </div>
                    </div>
                @endforeach
                    <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                      <div class="table-responsive w-100">
                          <table class="table">
                            <thead>
                              <tr class="bg-dark text-white">
                                  <th>#</th>
                                  <th>Description</th>
                                  <th>Size</th>
                                  <th class="text-right">Quantity</th>
                                  <th class="text-right">Price</th>
                                  {{-- <th class="text-right">Discount (%)</th> --}}
                                  <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($invoice_detail as $prd)
                                    <tr class="text-right">
                                        <td class="text-left">{{$i++}}</td>
                                            <td class="text-left">{{ $prd->product_name }}</td>
                                            <td>{{ $prd->size }}</td>
                                            <td> x 1</td>
                                            <td>{{ number_format($prd->price, 0, ',') }}</td>
                                            <td>{{ number_format($prd->price, 0, ',') }} MMK</td>
                                        </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="container-fluid mt-5 w-100">
                      <p class="text-right mb-2">Sub - Total amount: {{ number_format($total_price, 0, ',') }}</p>
                      {{-- <p class="text-right">vat (10%) : $138</p> --}}
                      <h4 class="text-right mb-5 text-dark">Total : {{ number_format($total_price, 0, ',') }} (MMK)</h4>
                      <hr class="text-dark" style="width: 100%">
                    </div>
                    <div class="container-fluid w-100">
                        {{-- <a id="invoicePdfBtn" class="btn btn-warning btn-sm float-right mt-4 ms-2"><i class="ti-printer me-1"></i>Export PDF</a> --}}
                      {{-- <a id="printThis" class="btn btn-primary btn-sm float-right mt-4 ms-2"><i class="ti-printer me-1"></i>Print</a> --}}
                      <a href="{{ url('/account') }}" class="btn btn-secondary btn-sm float-right mt-4 ms-2"><i class="ti-back-right me-1"></i>Back</a>
                      {{-- <a href="#" class="btn btn-success float-right mt-4"><i class="ti-export me-1"></i>Send Invoice</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top:200px">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 mx-auto">
                <div class="card">
                    <div class="card-body" style="text-align: center">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <span><i class="fa fa-download text-dark" style="font-size:30px"></i></span>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <a id="invoicePdfBtn" class="btn btn-primary btn-sm "><h3 class="text-dark">Download Here</h3></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($invoice_info as $invoice)
    <div id="printInvoice" hidden>
        <span id="invoicePdf" style="color:#000;">
            <div class="align-middle" style="height: 130px;background:#0001E6">
                {{-- <h3 class="text-right my-5" style="margin-left: 10px">Invoice  {{ $invoice_info->id }}</h3><hr style="width: 100%"> --}}
                <h3 class="text-center align-middle" style="margin-left: 10px"><img src="{{ asset('assets/img/NRF/black-NRF.png') }}" class="align-middle mt-4" alt="photo" width="200px"></h3>
            </div>
            <div>
                <h3 class="text-uppercase text-center mt-2" style="font-weight:bold;color:#0001E6">Sales Receipt</h3>
            </div>
            <div>
                <hr style="width:1000px">
            </div>
            <div style="display: flex; font-size: 13px; align-items: end;">
                <div style="width: 50%; margin-left: 10px; margin-top:0px">
                    <p class="mt-0 mb-2"><b></b></p>
                    <p class="text-dark">
                        Receipt No.    : {{ $invoice->invoice->id }}<br>
                        Receipt Date : {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $invoice->invoice->created_at)->format('d-m-Y')}}<br>
                        Reference      : {{$invoice->invoice->payment_method}}
                    </p>
                </div>
                <div style="width: 50%; font-size:13px; text-align: right; line-height: 6px; margin-right: 10px;">
                    <p class="mt-0 mb-2 text-right"><b>Customer Info</b></p>
                    <p class="text-right">
                        <p class="text-dark">{{ $invoice->deli_info->recipient_name }}</p>
                        <p class="text-dark">{{ $invoice->deli_info->recipient_phone }}</p>
                        <p class="text-dark">{{ $invoice->deli_info->delivery_address }}</p>
                    </p>
                </div>
            </div>
            <div>
                <p style="margin-left: 10px;">
                    <hr>
                </p>
            </div>
            <div style="margin-right: 10px; margin-top: 60px">
                <table style="border-top: 1px solid black; border-bottom: 1px solid black; width: 100%; border-collapse:collapse; margin-left: 10px; margin-right: 10px; margin-top:10px">
                    <thead>
                        <tr>
                            <th style="border-bottom: 1px solid black; text-align: center;">#</th>
                            <th style="border-bottom: 1px solid black; text-align: center;">Description</th>
                            <th style="border-bottom: 1px solid black; text-align: center;">Size</th>
                            <th style="border-bottom: 1px solid black; text-align: center;">Quantity</th>
                            <th style="border-bottom: 1px solid black; text-align: center;">Price</th>
                            <th style="border-bottom: 1px solid black; text-align: center;">Total</th>
                          </tr>
                      </thead>
                      <tbody>
                            @php $i = 1; @endphp
                            @foreach ($invoice_detail as $prd)
                                <tr>
                                    <td style="text-align: center;">{{ $i++ }}</td>
                                    <td style="text-align: center;">{{ $prd->product_name }}</td>
                                    <td style="text-align: center;">{{ $prd->size }}</td>
                                    <td style="text-align: center;"> x 1</td>
                                    <td style="text-align: center;">{{ number_format($prd->price, 0, ',') }}</td>
                                    <td style="text-align: center;">{{ number_format($prd->price, 0, ',') }} MMK</td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                    <div style="width: 100%; font-size:13px; text-align: right;">
                        <p class="text-right mb-2" style="margin-right:10px;">Sub - Total amount: {{ number_format($total_price, 0, ',') }}</p>
                        
                        <h4 class="text-right mb-5" style="margin-right:10px;">Total : {{ number_format($total_price, 0, ',') }} (MMK)</h4>
                    </div>
                    <div>
                        <footer>
                            <p class="text-center" style="color:#0001E6">Thank you for your purchase!</p>
                            <p class="text-center" style="color:#0001E6">For more information and inquiries please contact noreplacementsfound.online@gmail.com</p>
                        </footer>
                    </div>
                </span>
            </div>
            @endforeach


    <script>
        var invoicePdfBtn = document.getElementById('invoicePdfBtn');
        var invoicePdf = document.getElementById('invoicePdf');

        //invoiceToPdf
        invoicePdfBtn.addEventListener("click", function () {
            html2pdf(invoicePdf);
        });
    </script>

@endsection
