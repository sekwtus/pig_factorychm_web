 {{-- group3 --}}
 @foreach ($item_group_main4 as $key => $item_mian) 

 <tr>
     <td style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ $item_mian->item_code }}</td>
     <td style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ $item_mian->item_name }}</td>
     <td hidden style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ $item_mian->yield_main }}</td>
     <td hidden style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ $item_mian->yield_main*$sum_number_of_pig }} </td>
     <td hidden style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ ($item_mian->yield_per_one == null ? '' : number_format( $item_mian->yield_main/$item_mian->yield_per_one , 2, '.', '') ) }}</td>

     {{-- ไม่มีในorderพิเศษ --}}
    <td hidden style="padding: 0px; height: 20px; background-color:#c0c0c0;" class="text-center" rowspan="3" ></td>
    <td hidden style="padding: 0px; height: 20px; " class="text-center" rowspan="3" ></td>
    <td style="padding: 0px; height: 20px;" class="text-center" rowspan="3" colspan="{{ count($shop_list) }}"></td>
    <td style="padding: 0px; height: 20px;" class="text-center" colspan="{{ count($shop_list)+2 }}" hidden></td>
 </tr>

        <tr>
            @php $sum_unit_g3 = 0;@endphp
            @foreach ($shop_list as $ar =>  $shop)
                <td style="padding: 0px; height: 20px;background-color:#c0c0c0;" class="text-center">
                
                </td>
            @endforeach
            <td style="padding: 0px; height: 20px;background-color:#c0c0c0;" class="text-center" ></td>
            <td style="padding: 0px; height: 20px;background-color:#c0c0c0;" class="text-center" ></td>
        </tr>

        <tr>
            @php $sum_req_g3 = 0; @endphp

            @if ( !empty($data_group4) )

                @foreach ($data_group4 as $data_4)
                    @if ($data_4->item_code2 == $item_mian->item_code2)

                        @for ($i = 0; $i < count($shop_list); $i++)  @php $mk_code = $shop_list[$i]->shop_code; @endphp
                            <td style="padding: 0px; height: 20px;" class="text-center"> {{ $data_4->$mk_code }}
                            </td>  @php $sum_req_g3 = $sum_req_g3 + $data_4->$mk_code ;@endphp
                        @endfor
                        <td style="padding: 0px; height: 20px;" class="text-center" colspan="2"> {{ $sum_req_g3 }} {{ $item_mian->unit }} </td>
                    
                    @endif
                @endforeach

            @else

                @for ($i = 0; $i < count($shop_list); $i++)  @php $mk_code = $shop_list[$i]->shop_code; @endphp
                    <td style="padding: 0px; height: 20px;" class="text-center">0
                    </td>  @php $sum_req_g3 = $sum_req_g3 + 0 ;@endphp
                @endfor
                <td style="padding: 0px; height: 20px;" class="text-center" colspan="2"> {{ $sum_req_g3 }} {{ $item_mian->unit }} </td>
            
            @endif
    

        </tr>
@endforeach