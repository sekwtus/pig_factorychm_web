@extends('layouts.master')
@section('style')

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

<style>
    body{
        zoom:0.8;
    }
</style>
@endsection

@section('main')

   @php
       echo $date
   @endphp
<div class="row">


        <div class="table-responsive" >

          <table class="table table-bordered" cellspacing="0" border="0">
            <colgroup width="211"></colgroup>
            <colgroup width="249"></colgroup>
            <colgroup width="169"></colgroup>
            <colgroup width="138"></colgroup>
            <colgroup width="169"></colgroup>
            <colgroup span="8" width="193"></colgroup>
            <colgroup width="189"></colgroup>
            <tbody><tr>
              <td colspan="14" height="53" align="center" valign="middle"><b><font face="Cordia New" size="6" color="#000000">บริษัท เชียงใหม่กิจมงคล จำกัด</font></b></td>
              </tr>
            <tr>
              <td colspan="14" height="53" align="center" valign="middle"><b><font face="Cordia New" size="6" color="#000000">แผนกผลิต High Risk</font></b></td>
              </tr>
            <tr>
              <td colspan="14" height="53" align="center" valign="middle"><b><font face="Cordia New" size="6" color="#000000">ความเคลื่อนไหวห้องOver night ประจำวันที่ 24/06/2563</font></b></td>
              </tr>
            <tr>
              <td height="27" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="2" height="80" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">ขั้นตอนทำงาน</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">หมายเลขใบงาน/Bill</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">รายการสินค้า</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">ที่จัดเก็บ</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">หน่วยนับ</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="2" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">ยกมา</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="2" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">เข้า</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="2" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">ออก</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="2" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">ผลต่าง</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">หมายเหตุ</font></b></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">จำนวน</font></b></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">น้ำหนัก(Kg.)</font></b></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">จำนวน</font></b></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">น้ำหนัก(Kg.)</font></b></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">จำนวน</font></b></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">น้ำหนัก(Kg.)</font></b></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">จำนวน</font></b></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FFB9B9"><b><font size="4">น้ำหนัก(Kg.)</font></b></td>
              </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="5" height="202" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">หมูสาขา</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7" sdval="151" sdnum="1033;"><font size="4">151</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#DEEBF7" sdval="15264.8916491228" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 15,264.89 </font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">7144/357166</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">ซาก</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">ov.</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">ตัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#DEEBF7" sdval="155" sdnum="1033;"><font size="4">155</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#DEEBF7" sdval="12224.25" sdnum="1033;0;0.00"><font size="4">12224.25</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="bottom"><font size="4" color="#000000"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">7118/355887</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">หัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">ov.</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">หัว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7" sdnum="1033;0;0.00"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#DEEBF7" sdval="913.16" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 913.16 </font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              </tr>
            <tr>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">7143/357127</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">ซาก</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">ตัดแต่ง</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">ตัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#DEEBF7" sdval="150" sdnum="1033;"><font size="4">150</font></td>
              <td style="border-top: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#DEEBF7" sdval="12573.4" sdnum="1033;0;0.00"><font size="4">12573.40</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">หัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">ตัดแต่ง</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4">หัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#DEEBF7" sdval="918.580915789474" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 918.58 </font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#DEEBF7"><b><font size="4"><br></font></b></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#DEEBF7" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"><br></font></b></td>
              </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000" colspan="2" rowspan="2" height="80" align="center" valign="middle" bgcolor="#9DC3E6"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000" colspan="3" rowspan="2" align="center" valign="middle" bgcolor="#9DC3E6"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#9DC3E6" sdval="151" sdnum="1033;"><b><font size="4">151</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#9DC3E6" sdval="15264.8916491228" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> 15,264.89 </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#9DC3E6" sdval="155" sdnum="1033;"><b><font size="4">155</font></b></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#9DC3E6" sdval="13137.41" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> 13,137.41 </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#9DC3E6" sdval="150" sdnum="1033;"><b><font size="4">150</font></b></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#9DC3E6" sdval="13491.9809157895" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> 13,491.98 </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#9DC3E6" sdval="156" sdnum="1033;"><b><font size="4">156</font></b></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#9DC3E6" sdval="14910.3207333333" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> 14,910.32 </font></b></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="2" align="center" valign="middle" bgcolor="#9DC3E6" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><b><font size="4"><br></font></b></td>
            </tr>
            <tr>
              </tr>
            <tr>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="8" height="320" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">หมูลูกค้า เจ๊ก</font></td>
              <td style="border-bottom: 1px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">7144/357167</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">ซาก</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">ov.</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">ตัว</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#FBE5D6" sdval="3" sdnum="1033;"><font size="4">3</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#FBE5D6" sdval="244.3" sdnum="1033;0;0.00"><font size="4">244.30</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4" color="#4472C4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4" color="#4472C4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="3" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">7118/355888</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">หัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">หัว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#FBE5D6" sdval="17.48" sdnum="1033;0;0.00"><font size="4">17.48</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4" color="#4472C4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">เครื่องในขาว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">พวง</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#FBE5D6" sdval="15.6" sdnum="1033;0;0.00"><font size="4">15.60</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4" color="#4472C4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">เครื่องในแดง</font></td>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">พวง</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#FBE5D6" sdval="10.71" sdnum="1033;0;0.00"><font size="4">10.71</font></td>
              <td style="border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4" color="#4472C4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">7143/357130</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">ซาก</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">ตัว</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4" color="#4472C4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6" sdnum="1033;0;0.00"><font size="4" color="#4472C4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#FBE5D6" sdval="3" sdnum="1033;"><font size="4">3</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#FBE5D6" sdval="244.3" sdnum="1033;0;0.00"><font size="4">244.30</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">หัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">หัว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4" color="#4472C4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#FBE5D6" sdval="17.48" sdnum="1033;0;0.00"><font size="4">17.48</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">เครื่องในขาว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">พวง</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4" color="#4472C4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#FBE5D6" sdval="15.6" sdnum="1033;0;0.00"><font size="4">15.60</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">เครื่องในแดง</font></td>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4">พวง</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4" color="#4472C4"><br></font></td>
              <td style="border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#FBE5D6" sdval="10.71" sdnum="1033;0;0.00"><font size="4">10.71</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#FBE5D6"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000" height="40" align="left" valign="middle" bgcolor="#F4B183"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000" align="left" valign="middle" bgcolor="#F4B183"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="center" valign="middle" bgcolor="#F4B183"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F4B183"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F4B183" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F4B183" sdval="3" sdnum="1033;"><b><font size="4">3</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F4B183" sdval="288.09" sdnum="1033;0;0.00"><b><font size="4">288.09</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F4B183" sdval="3" sdnum="1033;"><b><font size="4">3</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F4B183" sdval="288.09" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> 288.09 </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F4B183" sdval="0" sdnum="1033;"><b><font size="4">0</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F4B183" sdval="0" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> -   </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F4B183"><b><font size="4"><br></font></b></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="8" height="320" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">หมูลูกค้า เคี้ยง</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">7144/357167</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">ซาก</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">ov.</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">ตัว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#E2F0D9" sdval="3" sdnum="1033;"><font size="4">3</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#E2F0D9" sdval="250.75" sdnum="1033;0;0.00"><font size="4">250.75</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="3" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">7118/355888</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">หัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">หัว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#E2F0D9" sdval="17.62" sdnum="1033;0;0.00"><font size="4">17.62</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">เครื่องในขาว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">พวง</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#E2F0D9" sdval="16.99" sdnum="1033;0;0.00"><font size="4">16.99</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">เครื่องในแดง</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">พวง</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#E2F0D9" sdval="10.46" sdnum="1033;0;0.00"><font size="4">10.46</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">7143/357130</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">ซาก</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">ตัว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#E2F0D9" sdval="3" sdnum="1033;"><font size="4">3</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#E2F0D9" sdval="250.75" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 250.75 </font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">หัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">หัว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#E2F0D9" sdval="17.62" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 17.62 </font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">เครื่องในขาว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">พวง</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#E2F0D9" sdval="16.99" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 16.99 </font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">เครื่องในแดง</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4">พวง</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#E2F0D9" sdval="10.46" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 10.46 </font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#E2F0D9"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000" height="40" align="left" valign="middle" bgcolor="#A9D18E"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000" align="center" valign="middle" bgcolor="#A9D18E"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="center" valign="middle" bgcolor="#A9D18E"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#A9D18E"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#A9D18E" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"><br></font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#A9D18E" sdval="3" sdnum="1033;"><b><font size="4">3</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#A9D18E" sdval="295.82" sdnum="1033;"><b><font size="4">295.82</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#A9D18E" sdval="3" sdnum="1033;"><b><font size="4">3</font></b></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#A9D18E" sdval="295.82" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> 295.82 </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#A9D18E" sdval="0" sdnum="1033;"><b><font size="4">0</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#A9D18E" sdval="0" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> -   </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#A9D18E"><b><font size="4"><br></font></b></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="8" height="320" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หมูลูกค้า ดอน</font></td>
              <td style="border-top: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">7144/357167</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ซาก</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ov.</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ตัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5" sdval="2" sdnum="1033;"><font size="4">2</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="162.2" sdnum="1033;0;0.00"><font size="4">162.20</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="3" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">7118/355888</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="12.23" sdnum="1033;0;0.00"><font size="4">12.23</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในขาว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="11.28" sdnum="1033;"><font size="4">11.28</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในแดง</font></td>
              <td style="border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="7.61" sdnum="1033;0;0.00"><font size="4">7.61</font></td>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">7143/357130</font></td>
              <td style="border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ซาก</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ตัว</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5" sdval="2" sdnum="1033;"><font size="4">2</font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="162.2" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 162.20 </font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="12.23" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 12.23 </font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในขาว</font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="11.28" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 11.28 </font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในแดง</font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="7.61" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 7.61 </font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="2" height="40" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#C997A2" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="2" sdnum="1033;"><b><font size="4">2</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#C997A2" sdval="193.32" sdnum="1033;"><b><font size="4">193.32</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="2" sdnum="1033;"><b><font size="4">2</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#C997A2" sdval="193.32" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> 193.32 </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="0" sdnum="1033;"><b><font size="4">0</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="0" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> -   </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="8" height="320" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หมูลูกค้า ไก่</font></td>
              <td style="border-top: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">7144/357167</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ซาก</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ov.</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ตัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5" sdval="1" sdnum="1033;"><font size="4">1</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="71.15" sdnum="1033;0;0.00"><font size="4">71.15</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="3" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">7118/355888</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="5.75" sdnum="1033;0;0.00"><font size="4">5.75</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในขาว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="6.49" sdnum="1033;0;0.00"><font size="4">6.49</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในแดง</font></td>
              <td style="border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="3.02" sdnum="1033;0;0.00"><font size="4">3.02</font></td>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">7143/357130</font></td>
              <td style="border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ซาก</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ตัว</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5" sdval="1" sdnum="1033;"><font size="4">1</font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="71.15" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 71.15 </font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="5.75" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 5.75 </font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในขาว</font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="6.49" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 6.49 </font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในแดง</font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="3.02" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 3.02 </font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="2" height="40" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#C997A2" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="1" sdnum="1033;"><b><font size="4">1</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#C997A2" sdval="86.41" sdnum="1033;"><b><font size="4">86.41</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="1" sdnum="1033;"><b><font size="4">1</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#C997A2" sdval="86.41" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> 86.41 </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="0" sdnum="1033;"><b><font size="4">0</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="0" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> -   </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="8" height="320" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หมูลูกค้า กอล์ฟ</font></td>
              <td style="border-top: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">7144/357167</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ซาก</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ov.</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ตัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5" sdval="1" sdnum="1033;"><font size="4">1</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="81.95" sdnum="1033;0;0.00"><font size="4">81.95</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="3" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">7118/355888</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="5.73" sdnum="1033;0;0.00"><font size="4">5.73</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในขาว</font></td>
              <td style="border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="5.49" sdnum="1033;0;0.00"><font size="4">5.49</font></td>
              <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในแดง</font></td>
              <td style="border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="2.86" sdnum="1033;0;0.00"><font size="4">2.86</font></td>
              <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">7143/357130</font></td>
              <td style="border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ซาก</font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">ตัว</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" rowspan="4" align="center" valign="middle" bgcolor="#F1CBB5" sdval="1" sdnum="1033;"><font size="4">1</font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="81.95" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 81.95 </font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">หัว</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="5.73" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 5.73 </font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในขาว</font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="5.49" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 5.49 </font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">เครื่องในแดง</font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4">พวง</font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-bottom: 1px solid #000000" align="right" valign="middle" bgcolor="#F1CBB5" sdval="2.86" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"> 2.86 </font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5" sdnum="1033;0;_-* #,##0.000000_-;-* #,##0.000000_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#F1CBB5"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="2" height="40" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan="3" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="left" valign="middle" bgcolor="#C997A2" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><font size="4"><br></font></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="1" sdnum="1033;"><b><font size="4">1</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#C997A2" sdval="96.03" sdnum="1033;"><b><font size="4">96.03</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="1" sdnum="1033;"><b><font size="4">1</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="right" valign="middle" bgcolor="#C997A2" sdval="96.03" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> 96.03 </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="0" sdnum="1033;"><b><font size="4">0</font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2" sdval="0" sdnum="1033;0;_-* #,##0.00_-;-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"><b><font size="4"> -   </font></b></td>
              <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign="middle" bgcolor="#C997A2"><font size="4"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><b><font face="Cordia New" size="5" color="#000000"><br></font></b></td>
              <td style="border-bottom: 1px solid #000000" align="center" valign="middle"><font face="Cordia New" size="5" color="#000000"><br></font></td>
              <td style="border-bottom: 1px solid #000000" align="center" valign="middle"><font face="Cordia New" size="5" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td style="border-top: 1px solid #000000" colspan="2" align="center" valign="middle" sdnum="1033;1033;M/D/YYYY"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
            <tr>
              <td height="40" align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="left" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
              <td align="center" valign="middle"><font size="4" color="#000000"><br></font></td>
            </tr>
          </tbody></table>
        </div>
       
 
</div>



@endsection
@section('script')
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

<script>
    function deleteRecord(order_number){
        if(confirm('ต้องการลบ : '+order_number+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_importCompare') }}',
                data: {order_number:order_number},
                success: function (msg) {
                    alert(msg);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        }
    }
</script>
<script>
        var table = $('#tbl-1').DataTable({
            lengthMenu: [[-1], ["All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            "ordering": false,
            // rowReorder: true,
            dom: 'Brt',
            // "order": [[ 1, "desc" ]],
            buttons: [
                'excel','copy','print'
                //  'pdf', 'print'
            ],
            // processing: true,
            // serverSide: true,
        });
        // table.on( 'order.dt search.dt', function () {
        //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        //         cell.innerHTML = i+1;
        //     } );
        // } ).draw();
</script>

@endsection