 {{-- group3 --}}
 @foreach ($item_group_main3 as $key => $item_mian) 
 @php
     $row_group = 0;
     $check_group = 0;
     $check_weight = 0;
 if ($group_row_span3[$key]->count_row == 0){
     $span = 5;
 }
 else{ $span = 3; }

 // นน.รายวัน น้ำหนักdefualt 0 
 for($i = 0; $i < count($shop_list); $i++){
     $check_exist_data[$i] = 0;
 }
 $sum = 0;
 $weight_balance = 0;
 $sum_weight_balance = 0;
 $check_fill_exist = 0;
 $check_fill_exist2 = 0;
 $check_fill_exist2_data= 0;
 @endphp

 {{-- นน.รายวัน เก็บค่าแทน 0 --}}
 @foreach ($weight_daily as $weight_)
 @if ($weight_->item_code == $item_mian->item_code)
         @foreach ($shop_list as $key_ => $shop_)
             @if ($weight_->marker == $shop_->marker)
                 @php
                     $check_exist_data[$key_] = $weight_->weight_number;
                     $sum = $sum + $check_exist_data[$key_];
                 @endphp
             @endif
         @endforeach
     @endif 
 @endforeach
     
 <tr>
     <td style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ $item_mian->item_code }}</td>
     <td style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ $item_mian->item_name }}</td>
     <td style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ $item_mian->yield_main }}</td>
     <td style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ $item_mian->yield_main*$sum_number_of_pig }} </td>
     <td style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ ($item_mian->yield_per_one == null ? '' : number_format( $item_mian->yield_main/$item_mian->yield_per_one , 2, '.', '') ) }}</td>

     {{-- ไม่มีในorderพิเศษ --}}
     @if ($check_weight == 0)
             @if ($check_fill_exist2 == 0)
        <td style="padding: 0px; height: 20px; background-color:#9fff9f;" class="text-center" rowspan="3" > {{ $item_mian->yield_main == null ? $sum_number_of_pig : $item_mian->yield_main*$sum_number_of_pig }}</td>
             @php
                 $weight_balance = ( $item_mian->yield_main == null ? $sum_number_of_pig : $item_mian->yield_main*$sum_number_of_pig );
             @endphp
             @endif
         <td style="padding: 0px; height: 20px;" class="text-center" rowspan="3">{{ ($item_mian->yield_per_one == null ? '' : $item_mian->yield_main*$sum_number_of_pig / number_format( $item_mian->yield_main/$item_mian->yield_per_one , 2, '.', '') ) }}</td>
     @endif
     
     <td style="padding: 0px; height: 20px;" class="text-center" rowspan="3" colspan="{{ count($shop_list) }}"></td>
 
     <td style="padding: 0px; height: 20px;" class="text-center" colspan="{{ count($shop_list)+2 }}" hidden></td>

    
 </tr>


 

    @foreach ($shop_request_list as $shop_request_list_group)
        @php
            for ($ar=0; $ar < count($shop_list) ; $ar++) { 
                foreach ($shop_request_data as $key_code => $request_data){
                        $shoparray[$shop_request_list_group->order_special_id][$ar] = 0;
                }
                
            }
            foreach ($shop_list as $key_shop => $shop){
                foreach ($shop_request_data as $key_code => $request_data){
                    if ($shop->shop_code == $request_data->shop_code && $shop_request_list_group->order_special_id == $request_data->order_special_id){
                        $shoparray[$shop_request_list_group->order_special_id][$key_shop] = $request_data->number_of_item;
                    }
                }
            }
        @endphp

        @if ($shop_request_list_group->group_main == $item_mian->id)

        <tr>
            @php $sum_unit_g3 = 0;@endphp
            @foreach ($shop_list as $ar =>  $shop)
                <td style="padding: 0px; height: 20px;background-color:#ffa6ff;" class="text-center">
                   {{ number_format( ($shoparray[$shop_request_list_group->order_special_id][$ar]) / $shop_request_list_group->yield_per_one ,1,'.','') }}

                   <input type="text" name="number_item[{{ $shop->shop_code }}][{{ $item_mian->item_code2 }}]"
                   value="{{ number_format( ($shoparray[$shop_request_list_group->order_special_id][$ar]) / $shop_request_list_group->yield_per_one ,1,'.','') }}" hidden/>
                </td>
                @php
                    $sum_unit_g3 = $sum_unit_g3  + number_format( ($shoparray[$shop_request_list_group->order_special_id][$ar]) / $shop_request_list_group->yield_per_one ,2,'.','');
                @endphp
            @endforeach
            <td style="padding: 0px; height: 20px;background-color:#ffa6ff;" class="text-center" >{{ $sum_unit_g3 }} </td>
            <td style="padding: 0px; height: 20px;background-color:#ffa6ff;" class="text-center" > จำนวนถุง </td>
        </tr>

        <tr>
            @php $sum_req_g3 = 0;@endphp
            @for ($i = 0; $i < count($shop_list); $i++)
                <td style="padding: 0px; height: 20px;" class="text-center"> {{ $shoparray[$shop_request_list_group->order_special_id][$i] }}</td>
                @php $sum_req_g3 = $sum_req_g3 + $shoparray[$shop_request_list_group->order_special_id][$i] ;@endphp
            @endfor
            <td style="padding: 0px; height: 20px;" class="text-center" colspan="2"> {{ $sum_req_g3 }}</td>
        </tr>
        @endif
    @endforeach

 {{-- <tr>
    @foreach ($shop_list as $ar =>  $shop)
        <td style="padding: 0px; height: 20px;background-color:#ffff00;" class="text-center">
            0
        </td>
    @endforeach

    <td style="padding: 0px; height: 20px;background-color:#ffff00;" class="text-center" colspan="2"> จำนวนถุง </td>
 </tr> --}}

{{--  
    @foreach ($shop_request_list as $shop_request_list_group)
        @php
            for ($ar=0; $ar < count($shop_list) ; $ar++) { 
                foreach ($shop_request_data as $key_code => $request_data){
                        $shoparray[$shop_request_list_group->order_special_id][$ar] = 0;
                }
                
            }
            foreach ($shop_list as $key_shop => $shop){
                foreach ($shop_request_data as $key_code => $request_data){
                    if ($shop->shop_code == $request_data->shop_code && $shop_request_list_group->order_special_id == $request_data->order_special_id){
                        $shoparray[$shop_request_list_group->order_special_id][$key_shop] = $request_data->number_of_item;
                    }
                }
            }
        @endphp

        @if ($shop_request_list_group->group_main == $item_mian->id)
        <tr>
            <td style="padding: 0px; height: 20px;background-color:#ffe8e8;" class="text-center" rowspan="2">{{ $shop_request_list_group->main_name.' '.$shop_request_list_group->description_item }}</td>
            @foreach ($shop_list as $ikey => $shop)
                <td style="padding: 0px; height: 20px; background-color:#ffff00;" class="text-center" >
                    {{ number_format( ($shop_request_list_group->yield_per_one == null ? 0 : $shoparray[$shop_request_list_group->order_special_id][$ikey]/$shop_request_list_group->yield_per_one),1,'.', '' ) }}</td>
            @endforeach 

            @if ($row_group == 0)
                @foreach ($shop_list as $ar =>  $shop)
                    <td style="padding: 0px; height: 20px;background-color:#ffff00;" class="text-center">
                        {{ ($item_mian->yield_per_one == null || $shop_request_list_group->yield_per_one == null ? 0 : number_format( ($shop_weight_group[$ar]/( $item_mian->yield_main/$item_mian->yield_per_one)-$array1[$item_mian->id][$ar] )/$shop_request_list_group->yield_per_one, 1, '.', '')  ) }}
                    </td>
                @endforeach
                <td style="padding: 0px; height: 20px;background-color:#ffff00;" class="text-center" colspan="2"> จำนวนถุง </td>
                @php $row_group++; @endphp
            @endif
        </tr>

        <tr>
        
            @php $code1075 = 0; @endphp
            @for ($i = 0; $i < count($shop_list); $i++)
                <td style="padding: 0px; height: 20px;" class="text-center"> {{ $shoparray[$shop_request_list_group->order_special_id][$i] }}</td>
                @php
                    if ( $shop_request_list_group->item_code2 == 1075){
                        $code1075 = $code1075 + $shoparray[$shop_request_list_group->order_special_id][$i];
                    }
                @endphp
            @endfor
                @php
                    if ( $shop_request_list_group->item_code2 == 1075){
                        echo '<td style="padding: 0px; height: 20px;" class="text-center" colspan="'.(count($shop_list)) .'"></td>
                        <td style="padding: 0px; height: 20px; background-color:#ff7979; " class="text-center">'.$code1075.'</td>
                        <td style="padding: 0px; height: 20px; background-color:#ff7979; " class="text-center">'.$code1075 * number_format( $item_mian->yield_main/$item_mian->yield_per_one , 2, '.', '').'</td>';
                    }else{
                        echo '<td style="padding: 0px; height: 20px;" class="text-center" colspan="'.(count($shop_list)+2) .'"></td>';
                    }
                @endphp
        </tr>
        @endif
    @endforeach --}}

@endforeach
{{-- group1 --}}