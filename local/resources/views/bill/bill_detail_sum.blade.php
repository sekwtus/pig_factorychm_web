@extends('layouts.master')
@section('style')
<style>
    table {
        border-collapse: collapse;
    }

    table, th {
    border: 1px solid black;
    }

    th {
        height: 30px;
        font-weight: bold;
    }
    td {
        /* border-left: 0px solid black; */
        border: 0px solid black;
    }

</style>
@endsection
@section('main')
<div class="row ">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 pr-md-0 text-center"><b>ใบแจ้งหนี้</b></div>
                    <br><br>
                </div>
                <div class="row">
                    <div class="col-md-9 pr-md-0">
                        <div class="row">
                            <div class="col-md-2 pr-md-0">รหัสลูกค้า</div><div class="col-md-2 pr-md-0 text-left">{{$detail_ivs[0]->customer_id}}</div>
                            <div class="col-md-1 pr-md-0">ชื่อ</div><div class="col-md-7 pr-md-0 text-left">{{$detail_ivs[0]->customer_name}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pr-md-0">ขอเรียนว่าท่านได้ซื้อสินค้า ไปตามรายการต่อไปนี้</div>
                        </div>
                    </div>
                    <div class="col-md-3 pr-md-0">
                        <div class="row">
                            <div class="col-md-2 pr-md-0 text-left">วันที่</div>
                            <div class="col-md-10 pr-md-0 text-right">{{$detail_ivs[0]->date }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-md-0">เลขที่ใบแจ้งหนี้</div>
                            <div class="col-md-8 pr-md-0 text-right">{{$detail_ivs[0]->ivs_id}}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pr-md-0">
                        <table class="" width="100%" id="orderTable">
                            <thead class="text-center">
                                <tr>
                                    <th style="padding: 0px; font-size: 0.7rem;">เลขที่บิล</th>
                                    <th style="padding: 0px; font-size: 0.7rem;">วันที่</th>
                                    <th style="padding: 0px; font-size: 0.7rem;">กำหนดชำระ</th>
                                    <th style="padding: 0px; font-size: 0.7rem;">จำนวนเงิน</th>
                                    <th style="padding: 0px; font-size: 0.7rem;">คืนสินค้า</th>
                                    <th style="padding: 0px; font-size: 0.7rem;">ค้างชำระ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sub_total = 0;
                                    $return_product = 0;
                                    $overdue = 0;
                                @endphp
                                @foreach ($ivs_list as $ivs_lise_out)
                                    <tr>
                                        <td class="text-center">{{$ivs_lise_out->ivm_id}}</td>
                                        <td class="text-center">{{$ivs_lise_out->date_bill}}</td>
                                        <td class="text-center">{{$ivs_lise_out->date_payment}}</td>
                                        <td class="text-center">{{$ivs_lise_out->sub_total}}</td>
                                        <td class="text-center">{{$ivs_lise_out->return_product}}</td>
                                        <td class="text-center">{{$ivs_lise_out->overdue}}</td>
                                    </tr>
                                    @php
                                        $sub_total = $sub_total+$ivs_lise_out->sub_total;
                                        $return_product = $return_product+$ivs_lise_out->return_product;
                                        $overdue = $overdue+$ivs_lise_out->overdue;
                                    @endphp
                                @endforeach
                                    <tr style="border: 1px solid black">
                                        <td class="text-center">รวม &nbsp;&nbsp;&nbsp;&nbsp;{{ count($ivs_list) }}&nbsp;ใบ</td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center">{{$sub_total}}</td>
                                        <td class="text-center">{{$return_product}}</td>
                                        <td class="text-center">{{$overdue}}</td>
                                    </tr>
                            </tbody>
                        </table>
                        <div id="thai">
                            
                        </div>
                        <input id="total" type="text" value="{{$sub_total}}" hidden>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 pr-md-0 text-left" style="height: 200px;">
                        <div style="position:absolute; bottom:0;">หมายเหตุ กำหนดชำระเงินในวันที่</div>
                    </div>
                    <div class="col-md-6 pr-md-0 text-center">
                        <div class="row" style="height: 150px;">
                            <div  style="position:absolute; bottom:150px;">ขอแสดงความนับถือ</div>
                        </div>
                        <div class="row" style="height: 150px;">
                            <div  style="position:absolute; bottom:0;">เจ้าหน้าที่บัญชีและการเงิน</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('/js/thaibath.js') }}" type="text/javascript" charset="utf-8"></script>
<script>
    $(document).ready(function(){
        add();
    });

    function add(){
    var thaibath = ArabicNumberToText($('#total').val());
    $('#thai').append('('+thaibath+')');
}
</script>
@endsection


