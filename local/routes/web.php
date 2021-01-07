<?php
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

//------------------Theme-----------------------------
Route::get('/', 'HomeController@index')->middleware('auth');
Route::get('/logout', function () {
//backpage
    Auth::logout();
    return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    //var_dump(Auth::user());
    //return view('auth.login');
    //return redirect(route('/login'));
    //return view('auth.login');
});

Route::get('/command/{$cc}', function () {
    // Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/login', 'loginController@index');

Route::get('/setting_customer', 'Auth\Settingcontroller@setting_customer')->middleware('auth');
Route::post('/setting_customer_add', 'Auth\Settingcontroller@setting_customer_add')->middleware('auth');
Route::get('/setting_customer_data', 'Auth\Settingcontroller@setting_customer')->middleware('auth');
Route::get('/setting', 'Auth\Settingcontroller@setting')->middleware('auth');
Route::get('/setting_customer_show/{Customer_ID}', 'Auth\Settingcontroller@setting_customer_show')->middleware('auth');

//------------------Sale-----------------------------
Route::get('/index_sale', 'SaleController@index_sale')->middleware('auth');

Route::get('/salepig', 'SaleController@salepig')->middleware('auth');
Route::get('/salepig/add', 'SaleController@show_addsalepig')->middleware('auth');
Route::post('/salepig_add', 'SaleController@salepig_add')->middleware('auth');
Route::get('/salepig/edit/{sale_no}', 'SaleController@show_editsalepig')->middleware('auth');
Route::post('/salepig_edit', 'SaleController@salepig_edit')->middleware('auth');
Route::get('/salepig/view/{salepig_no}', 'SaleController@salepig_view')->middleware('auth');
Route::post('/salepig/delete/{id}', 'SaleController@salepig_del')->middleware('auth');
Route::get('/salepig/deleteDetail/', 'SaleController@deleteDetail')->middleware('auth');
Route::get('/salepig/report/', 'SaleController@salepig_report')->middleware('auth');

Route::get('/saleslice', 'SaleController@saleslice')->middleware('auth');
Route::get('/saleslice/add', 'SaleController@show_addsaleslice')->middleware('auth');
Route::post('/saleslice_add', 'SaleController@saleslice_add')->middleware('auth');
Route::get('/saleslice/edit/{sale_no}', 'SaleController@show_editsaleslice')->middleware('auth');
Route::post('/saleslice_edit', 'SaleController@saleslice_edit')->middleware('auth');
Route::get('/saleslice/view/{saleslice_no}', 'SaleController@saleslice_view')->middleware('auth');
Route::post('/saleslice/delete/{id}', 'SaleController@saleslice_del')->middleware('auth');
Route::get('/saleslice/deleteDetail/', 'SaleController@deleteDetail1')->middleware('auth');

Route::get('/truck', 'SaleController@truck')->middleware('auth');
Route::get('/truck/add', 'SaleController@show_addtruck')->middleware('auth');
Route::post('/truck_add', 'SaleController@truck_add')->middleware('auth');
Route::get('/truck/edit/{get_no}', 'SaleController@show_edittruck')->middleware('auth');
Route::post('/truck_edit', 'SaleController@truck_edit')->middleware('auth');
Route::post('/truck/delete/{id}', 'SaleController@truck_del')->middleware('auth');

//------------------product-----------------------------
Route::get('/index_product', 'ProductController@index_product')->middleware('auth');
Route::get('/product', 'ProductController@product')->middleware('auth');
Route::get('/product_add_main', 'ProductController@product_add_main')->middleware('auth');
Route::post('/product_add', 'ProductController@product_add')->middleware('auth');
Route::get('/product_view_order/{product_no}', 'ProductController@product_view_order')->middleware('auth');
Route::post('/product/delete/{product_no}', 'ProductController@product_del')->middleware('auth');
Route::get('/product/edit/{product_no}', 'ProductController@show_product_edit')->middleware('auth');
Route::post('/product_edit', 'ProductController@product_edit')->middleware('auth');
Route::get('/product/deleteDetail/', 'ProductController@deleteDetail')->middleware('auth')->middleware('auth');
Route::get('/product/report', 'ProductController@product_report')->middleware('auth');

///--------------sale-----------------------------
Route::get('/bill', 'Billcontroller@getbill')->middleware('auth');
Route::get('/bill-add', 'Billcontroller@addbill');
Route::post('/bill/insertbill', 'Billcontroller@insertbill')->middleware('auth');
Route::post('/bill/update/{id}', 'Billcontroller@updatebill')->middleware('auth');
Route::post('/bill/delete/{id}', 'Billcontroller@deletebill')->middleware('auth');
Route::get('/bill_iv', 'Billcontroller@bill_iv')->middleware('auth');
Route::get('/bill_ivsum', 'Billcontroller@bill_ivs')->middleware('auth');
Route::post('/create_bill', 'Billcontroller@create_bill')->middleware('auth');
Route::get('/create_bill_order', 'Billcontroller@create_bill_order')->middleware('auth');
Route::post('/create_bill_iv', 'Billcontroller@create_bill_iv')->middleware('auth');
Route::post('/create_bill_sum', 'Billcontroller@create_bill_sum')->middleware('auth');
Route::get('/get_ajax_bill', 'Billcontroller@get_ajax_bill')->middleware('auth');
Route::get('/get_ajax_bill_iv', 'Billcontroller@get_ajax_bill_iv')->middleware('auth');
Route::get('/get_ajax_bill_sum', 'Billcontroller@get_ajax_bill_sum')->middleware('auth');
Route::get('/bill_detail/{id}/{bill}', 'Billcontroller@bill_detail')->middleware('auth');
Route::get('/bill_detail_rvm/{id}', 'Billcontroller@bill_detail_rvm')->middleware('auth');
Route::get('/bill_detail_p/{id}/{bill}', 'Billcontroller@bill_detail_p')->middleware('auth');
Route::get('/bill_detail_p_order/{id}', 'Billcontroller@bill_detail_p_order')->middleware('auth'); 
Route::get('/bill_detail_p_print/{id}/{bill}', 'Billcontroller@bill_detail_p_print')->middleware('auth');
Route::get('/bill_detail_rc/{id}/{bill}', 'Billcontroller@bill_detail_rc')->middleware('auth');
Route::get('/bill_detail_re/{id}/{bill}', 'Billcontroller@bill_detail_re')->middleware('auth');
Route::get('/bill_detail_s/{id}/{bill}', 'Billcontroller@bill_detail_s')->middleware('auth');
Route::get('/bill_detail_t/{id}/{bill}', 'Billcontroller@bill_detail_t')->middleware('auth');
Route::get('/bill_detail_c/{id}/{bill}', 'Billcontroller@bill_detail_c')->middleware('auth');
Route::get('/bill_detail_sum/{id}', 'Billcontroller@bill_detail_sum')->middleware('auth');
Route::get('/bill_detail_sum_p/{id}', 'Billcontroller@bill_detail_sum_p')->middleware('auth');
Route::get('/bill_rvm', 'Billcontroller@receipt')->middleware('auth');
Route::post('/create_bill_rvm', 'Billcontroller@receipt_create')->middleware('auth');
Route::get('/get_ajax_bill_rvm', 'Billcontroller@receipt_rvm')->middleware('auth');
Route::post('/bill_add_item/{id}', 'Billcontroller@add_detall')->middleware('auth');
Route::get('/get_order_bill', 'Billcontroller@get_order_bill')->middleware('auth');
Route::get('/get_order_bill_iv', 'Billcontroller@get_order_bill_iv')->middleware('auth');
Route::post('/bill_pay', 'Billcontroller@bill_pay')->middleware('auth');
Route::get('/bill_cancel', 'Billcontroller@bill_cancel')->middleware('auth');
Route::get('/receipt_fully', 'Billcontroller@receipt_fully')->middleware('auth');
Route::get('/get_receipt_fully', 'Billcontroller@get_receipt_fully')->middleware('auth');
Route::get('/report_sales', 'Billcontroller@report_sales')->middleware('auth');

//-----------------Stock_take--------------------------
Route::get('/index_stock', 'StockController@index_stock');
Route::get('/stock_live', 'StockController@stock_live')->middleware('auth');
Route::get('/stock_live/add', 'StockController@show_live_add')->middleware('auth');
Route::post('/stock_live_add', 'StockController@live_add')->middleware('auth');
Route::post('/stock_live/delete/{take_live_no}', 'StockController@live_delete')->middleware('auth');
Route::get('/stock_live/edit/{take_live_no}', 'StockController@show_live_edit')->middleware('auth');
Route::post('/stock_live_edit', 'StockController@live_edit')->middleware('auth');

Route::get('/take_slice', 'StockController@take_slice')->middleware('auth');
Route::get('/take_slice/add', 'StockController@show_take_slice_add')->middleware('auth');
Route::post('/take_slice_add', 'StockController@take_slice_add')->middleware('auth');
Route::post('/take_slice/delete/{take_slice_no}', 'StockController@take_slice_delete')->middleware('auth');
Route::get('/take_slice/edit/{take_slice_no}', 'StockController@show_take_slice_edit')->middleware('auth');
Route::post('/take_slice_edit', 'StockController@take_slice_edit')->middleware('auth');

Route::get('/take_entrail', 'StockController@take_entrail')->middleware('auth');
Route::get('/take_entrail/add', 'StockController@show_take_entrail_add')->middleware('auth');
Route::post('/take_entrail_add', 'StockController@take_entrail_add')->middleware('auth');
Route::post('/take_entrail/delete/{take_entrail_no}', 'StockController@take_entrail_delete')->middleware('auth');
Route::get('/take_entrail/edit/{take_entrail_no}', 'StockController@show_take_entrail_edit')->middleware('auth');
Route::post('/take_entrail_edit', 'StockController@take_entrail_edit')->middleware('auth');

Route::get('/take_carcase', 'StockController@take_carcase')->middleware('auth');
Route::get('/take_carcase/add', 'StockController@show_take_carcase_add')->middleware('auth');
Route::post('/take_carcase_add', 'StockController@take_carcase_add')->middleware('auth');
Route::post('/take_carcase/delete/{take_carcase_no}', 'StockController@take_carcase_delete')->middleware('auth');
Route::get('/take_carcase/edit/{take_carcase_no}', 'StockController@show_take_carcase_edit')->middleware('auth');
Route::post('/take_carcase_edit', 'StockController@take_carcase_edit')->middleware('auth');

//-----------------Stock_รับเครื่องใน,รับซาก--------------------------
Route::get('/receipt_entrail', 'StockController@receipt_entrail')->middleware('auth');
Route::get('/receipt_entrail/add', 'StockController@show_receipt_entrail_add')->middleware('auth');
Route::post('/receipt_entrail_add', 'StockController@receipt_entrail_add')->middleware('auth');
Route::post('/receipt_entrail/delete/{receipt_entrail_no}', 'StockController@receipt_entrail_delete')->middleware('auth');
Route::get('/receipt_entrail/edit/{receipt_entrail_no}', 'StockController@show_receipt_entrail_edit')->middleware('auth');
Route::post('/receipt_entrail_edit', 'StockController@receipt_entrail_edit')->middleware('auth');

Route::get('/receipt_carcase', 'StockController@receipt_carcase')->middleware('auth');
Route::get('/receipt_carcase/add', 'StockController@show_receipt_carcase_add')->middleware('auth');
Route::post('/receipt_carcase_add', 'StockController@receipt_carcase_add')->middleware('auth');
Route::post('/receipt_carcase/delete/{receipt_carcase_no}', 'StockController@receipt_carcase_delete')->middleware('auth');
Route::get('/receipt_carcase/edit/{receipt_carcase_no}', 'StockController@show_receipt_carcase_edit')->middleware('auth');
Route::post('/receipt_carcase_edit', 'StockController@receipt_carcase_edit')->middleware('auth');

//-----------------Stock_โหลดเครื่องใน,รับซาก--------------------------
Route::get('/load_entrail', 'StockController@load_entrail')->middleware('auth');
Route::get('/load_entrail/add', 'StockController@show_load_entrail_add')->middleware('auth');
Route::post('/load_entrail_add', 'StockController@load_entrail_add')->middleware('auth');
Route::post('/load_entrail/delete/{load_entrail_no}', 'StockController@load_entrail_delete')->middleware('auth');
Route::get('/load_entrail/edit/{load_entrail_no}', 'StockController@show_load_entrail_edit')->middleware('auth');
Route::post('/load_entrail_edit', 'StockController@load_entrail_edit')->middleware('auth');

Route::get('/load_carcase', 'StockController@load_carcase')->middleware('auth');
Route::get('/load_carcase/add', 'StockController@show_load_carcase_add')->middleware('auth');
Route::post('/load_carcase_add', 'StockController@load_carcase_add')->middleware('auth');
Route::post('/load_carcase/delete/{load_carcase_no}', 'StockController@load_carcase_delete')->middleware('auth');
Route::get('/load_carcase/edit/{load_carcase_no}', 'StockController@show_load_carcase_edit')->middleware('auth');
Route::post('/load_carcase_edit', 'StockController@load_carcase_edit')->middleware('auth');

//------------------Other-------------------------
Route::get('/index_other', 'OtherController@index_other')->middleware('auth');

Route::get('/transfer_products', 'OtherController@transfer')->middleware('auth');
Route::post('/transfer/search', 'OtherController@transfer_search')->middleware('auth');
Route::get('/transfer/add', 'OtherController@show_addtransfer')->middleware('auth');
Route::post('/transfer_add', 'OtherController@transfer_add')->middleware('auth');
Route::get('/transfer/edit/{transfer_no}', 'OtherController@show_edittransfer')->middleware('auth');
Route::post('/transfer_edit', 'OtherController@transfer_edit')->middleware('auth');
Route::get('/transfer/view/{transfer_no}', 'OtherController@transfer_view')->middleware('auth');
Route::post('/transfer/view/{id}/search', 'OtherController@transfer_view_search')->middleware('auth');
Route::post('/transfer/delete/{id}', 'OtherController@transfer_del')->middleware('auth');
Route::get('/transfer/deleteDetail/', 'OtherController@deleteDetail_transfer')->middleware('auth');

Route::get('/take_back', 'OtherController@take_back')->middleware('auth');
Route::post('/take_back/search', 'OtherController@take_back_search')->middleware('auth');
Route::get('/take_back/add', 'OtherController@show_addtakeback')->middleware('auth');
Route::post('/take_back_add', 'OtherController@take_back_add')->middleware('auth');
Route::get('/take_back/edit/{take_no}', 'OtherController@show_edittakeback')->middleware('auth');
Route::post('/take_back_edit', 'OtherController@take_back_edit')->middleware('auth');
Route::get('/take_back/view/{take_no}', 'OtherController@take_back_view')->middleware('auth');
Route::post('/take_back/view/{id}/search', 'OtherController@take_back_view_search')->middleware('auth');
Route::post('/take_back/delete/{id}', 'OtherController@take_back_del')->middleware('auth');
Route::get('/take_back/deleteDetail/', 'OtherController@deleteDetail_take')->middleware('auth');

//------------------------piece----------------------------------------

Route::get('/get_piece', 'PieceController@get_piece')->middleware('auth');
Route::get('/get_piece/add', 'PieceController@show_addget_piece')->middleware('auth');
Route::post('/get_piece_edit', 'PieceController@get_piece_edit')->middleware('auth');
Route::get('/get_piece/view/{piece_no}', 'PieceController@get_piece_view')->middleware('auth');
Route::post('/get_piece/delete/{id}', 'PieceController@get_piece_del')->middleware('auth');
// Route::get('/deleteDetail1', 'PieceController@deleteDetail')->middleware('auth');
Route::get('/get_piece_add', 'PieceController@get_piece_add');

Route::get('/check_piece', 'PieceController@check_piece')->middleware('auth');
Route::get('/check_piece/add', 'PieceController@show_addcheck_piece')->middleware('auth');
Route::post('/check_piece_edit', 'PieceController@check_piece_edit')->middleware('auth');
Route::get('/check_piece/view/{piece_no}', 'PieceController@check_piece_view')->middleware('auth');
Route::post('/check_piece/delete/{id}', 'PieceController@check_piece_del')->middleware('auth');
// Route::get('/deleteDetail1', 'PieceController@deleteDetail')->middleware('auth');
Route::get('/check_piece_add', 'PieceController@check_piece_add');

Route::get('/load_piece', 'PieceController@load_piece')->middleware('auth');
Route::get('/load_piece/add', 'PieceController@show_addload_piece')->middleware('auth');
Route::post('/load_piece_edit', 'PieceController@load_piece_edit')->middleware('auth');
Route::get('/load_piece/view/{piece_no}', 'PieceController@load_piece_view')->middleware('auth');
Route::post('/load_piece/delete/{id}', 'PieceController@load_piece_del')->middleware('auth');
// Route::get('/deleteDetail1', 'PieceController@deleteDetail')->middleware('auth');
Route::get('/load_piece_add', 'PieceController@load_piece_add');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth')->middleware('auth');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth')->middleware('auth');
Route::get('/companyedit', 'companyeditcontroller@getedit');

// //-------------------reportมีชีวิต----------------------
Route::get('/index_report', 'ReportController@index_report');
Route::get('/Report', 'ReportController@getreport');
Route::get('/Report/saleL', 'ReportController@printreprintsaleL');
Route::get('/Report/add', 'ReportController@getaddsaleL');
Route::post('/Report_add', 'ReportController@Report_addBreed');
Route::get('/ReportbillL', 'ReportController@getreportbillL');
Route::get('/ReportbillL/ReportprintbillL', 'ReportController@printreprintbillL');
Route::get('/ReportbillRe', 'ReportController@getreportbillRe');
Route::get('/ReportbillRe/ReportprintbillRe', 'ReportController@printreprintbillRe');
//////สุกรเป็นและบริการ
Route::get('/ReportserviceS', 'ReportController@getReportserviceS');
Route::get('/ReportserviceS/ReportprintserviveLS', 'ReportController@printReportserviceS');
Route::get('/ReportserviceBilling', 'ReportController@getReportserviceBilling');
Route::get('/ReportserviceBilling/ReportprintserviveLBilling', 'ReportController@printReportserviceBilling');
Route::get('/ReportserviceBillRe', 'ReportController@getReportserviceBillRe');
Route::get('/ReportserviceBillRe/ReportprintserviveLBillRe', 'ReportController@printReportserviceBillRe');
////หมุซาก
Route::get('/ReportBillcarcassSent', 'ReportController@getReportBillcarcassSent');
Route::get('/ReportBillcarcassSent/ReportprintBillcarcassSent', 'ReportController@printReportBillcarcassSent');
Route::get('/ReportBillcarcassBilling', 'ReportController@getReportBillcarcassBilling');
Route::get('/ReportBillcarcassBilling/ReportprintBillcarcassBilling', 'ReportController@printReportBillcarcassBilling');
Route::get('/ReportBillcarcassRe', 'ReportController@getReportBillcarcassRe');
Route::get('/ReportBillcarcassRe/ReportprintBillcarcassRe', 'ReportController@printReportBillcarcassRe');

// NEW !!
Route::get('shop/recieve_pig', 'shop@index')->middleware('auth');

Route::get('shop/scale/{id}', 'shop@index_scale')->middleware('auth');

//รับสุกร
Route::get('recieve/truck', 'recieve@index')->middleware('auth');
Route::get('recieve/count_pig', 'recieve@indexPig')->middleware('auth');
Route::get('add_order', 'recieve@add_order')->middleware('auth');
Route::get('data_recieve', 'recieve@data_recieve')->middleware('auth');
// Route::get('webSocket', 'recieve@debug')->middleware('auth');

//ส่งออกสุกร
Route::get('send/sendTruck', 'send@index')->middleware('auth');
Route::get('send/pigCount', 'send@indexPig')->middleware('auth');

Route::get('webSocket', function () {
    return view('index3');
});

// create order
Route::get('order/create', 'order@index')->middleware('auth');

// stock
Route::get('stock/check', 'order@index')->middleware('auth');

//customer
Route::get('customer/get_all', 'customer@index')->middleware('auth');
Route::get('customer/get_all_creditor', 'customer@index_creditor')->middleware('auth');
Route::get('customer/get_ajax', 'customer@ajaxCustomer')->middleware('auth');
Route::get('customer/get_ajax_creditor', 'customer@ajaxCustomer_creditor')->middleware('auth');

Route::get('customer/add', 'customer@indexAdd')->middleware('auth');
Route::get('customer/add_creditor', 'customer@indexAdd_creditor')->middleware('auth');
Route::post('customer/add/save', 'customer@saveRegster')->middleware('auth');
Route::post('customer/add/save_creditor', 'customer@saveRegster_creditor')->middleware('auth');
Route::get('customer/edit/{id}', 'customer@indexEdit')->middleware('auth');
Route::post('customer/edit/save', 'customer@saveEdit')->middleware('auth');

Route::get('customer/add_debtor', 'customer@indexAdd_debtor')->middleware('auth');
Route::get('customer/customer_group', 'customer@customer_group')->middleware('auth');
Route::get('get_standard_group', 'customer@get_standard_group')->middleware('auth');
Route::post('add_standard_group', 'customer@add_standard_group')->middleware('auth');
Route::post('add_standard_weight', 'customer@add_standard_weight')->middleware('auth');
Route::post('edit_standard_weight', 'customer@edit_standard_weight')->middleware('auth');
Route::post('add_type', 'customer@add_type')->middleware('auth');
Route::post('edit_standard_price/{id}', 'customer@edit_standard_price')->middleware('auth');


//setting

Route::get('setting/customer_business', 'setting@getCustomerBusiness')->middleware('auth');
Route::get('setting/customer_business/get_ajax', 'setting@ajaxCustomerBusiness')->middleware('auth');
Route::get('setting/customer_business/save', 'setting@customerBusinessSave')->middleware('auth');
Route::get('setting/part_of_pig', 'setting@getPartPig')->middleware('auth');

Route::get('standard_group_setting', 'setting@standard_group_setting')->middleware('auth');

Route::get('setting_user', 'setting@setting_user')->middleware('auth');
Route::get('/setting/show_users', 'setting@show_users')->middleware('auth');
Route::post('/setting_user/save', 'setting@save_users')->middleware('auth');
Route::post('/setting_user/edit', 'setting@edit_users')->middleware('auth');
Route::get('/setting/get_profile', 'setting@get_profile')->middleware('auth');
Route::post('/setting_user/update_profile', 'setting@update_profile')->middleware('auth');

// !!TEST
Route::get('setting_shop', 'setting@setting_shop')->middleware('auth');
Route::get('/setting/show_shop', 'setting@show_shop')->middleware('auth');
Route::post('/setting_shop/save', 'setting@save_shop')->middleware('auth');
Route::post('/setting_shop/edit', 'setting@edit_shop')->middleware('auth');
Route::post('/setting_shop/delete', 'setting@delete_shop')->middleware('auth');
// !! TEST

Route::get('setting/shop', 'setting@shop_index')->middleware('auth');
Route::post('setting/shop/add', 'setting@shop_add')->middleware('auth');
Route::put('setting/shop/update', 'setting@shop_update')->middleware('auth');
Route::delete('setting/shop/delete', 'setting@shop_delete')->middleware('auth');

Route::get('setting/shop_product/{id}/detail', 'setting@shop_product_index')->middleware('auth');
Route::post('setting/shop_product/add', 'setting@shop_product_add')->middleware('auth');
Route::put('setting/shop_product/update', 'setting@shop_product_update')->middleware('auth');
Route::delete('setting/shop_product/delete', 'setting@shop_product_delete')->middleware('auth');

Route::get('setting/shop_crew/{id}/detail', 'setting@shop_crew_index')->middleware('auth');
Route::post('setting/shop_crew/add', 'setting@shop_crew_add')->middleware('auth');
Route::put('setting/shop_crew/update', 'setting@shop_crew_update')->middleware('auth');
Route::delete('setting/shop_crew/delete', 'setting@shop_crew_delete')->middleware('auth');

Route::get('setting_product', 'setting@setting_product')->middleware('auth');
Route::get('/setting/show_product', 'setting@show_product')->middleware('auth');
Route::post('/setting_product/save', 'setting@save_product')->middleware('auth');
Route::post('/setting_product/edit', 'setting@edit_product')->middleware('auth');
Route::post('/setting_product/delete', 'setting@delete_product')->middleware('auth');

Route::get('setting_promotion', 'setting@setting_promotion')->middleware('auth');
Route::post('setting_promotion/add', 'setting@setting_promotion_add')->middleware('auth');
Route::put('setting_promotion/update', 'setting@setting_promotion_update')->middleware('auth');
Route::delete('setting_promotion/delete', 'setting@setting_promotion_delete')->middleware('auth');

Route::get('setting_receipt', 'setting@setting_receipt')->middleware('auth');
Route::get('setting_receipt_data', 'setting@setting_receipt_data')->middleware('auth');
Route::get('setting/receipt/{id}/detail', 'setting@receipt_detail')->middleware('auth');

//order
Route::get('create_order', 'order@createOrder')->middleware('auth');
Route::get('getMarkerCustomer', 'order@getMarkerCustomer')->middleware('auth');
Route::get('order/get_ajax', 'order@ajaxOrder')->middleware('auth');
Route::get('order/save_plan', 'order@ajaxSavePlan')->middleware('auth');
Route::get('lot/get_ajax', 'order@ajaxLot')->middleware('auth');
Route::get('weighing/get_ajax', 'order@ajaxWeighing')->middleware('auth');
Route::get('start_stop/create_lot', 'order@start_stop_create_lot')->middleware('auth');
Route::get('getCustomer', 'order@getCustomer')->middleware('auth');
Route::get('order/get_ajax/type_branch', 'order@ajaxOrder_type_branch')->middleware('auth');

Route::get('getPlan', 'order@getPlan')->middleware('auth');

Route::get('order/all_plan', 'order@indexPlan')->middleware('auth');
Route::get('order/plan/getajax', 'order@ajaxPlan')->middleware('auth');
Route::get('order/plan_daily/{id}', 'order@plan_daily')->middleware('auth');
Route::get('new_lot/create_lot', 'order@create_lot')->middleware('auth');
Route::get('order/get_ajax/today', 'order@ajaxOrderToday')->middleware('auth');
Route::get('addOrder_to_lot', 'order@addOrder_to_lot')->middleware('auth');
Route::get('order/get_ajax_inLot', 'order@get_ajax_inLot')->middleware('auth');
Route::get('deleteOrder_from_lot', 'order@deleteOrder_from_lot')->middleware('auth');

Route::get('order/number_of_pig', 'order@number_of_pig')->middleware('auth');
Route::post('order/save_pig_number', 'order@save_pig_number')->middleware('auth');

// offal plan
Route::get('offal_order', 'order_offal@index')->middleware('auth');
Route::post('create_order_offal/create_order', 'order_offal@create_order')->middleware('auth');
Route::get('create_order_offal/get_ajax', 'order_offal@ajaxOrder')->middleware('auth');
Route::get('delete_order_offal', 'order_offal@delete_order_offal')->middleware('auth');
Route::post('order_offal/edit', 'order_offal@order_edit')->middleware('auth');

//overnight
Route::get('overnight_order', 'order_overnight@index')->middleware('auth');
Route::get('check_stock_overnight', 'order_overnight@check_stock_overnight')->middleware('auth');
Route::post('create_order_ov/create_order', 'order_overnight@create_order')->middleware('auth');
Route::get('create_order_ov/get_ajax', 'order_overnight@ajaxOrder')->middleware('auth');
Route::get('delete_order_ov', 'order_overnight@delete_order_ov')->middleware('auth');
Route::post('order_ov/edit', 'order_overnight@order_edit')->middleware('auth');

// cutting plan
Route::get('cutting_order', 'order_cutting@index')->middleware('auth');
Route::post('create_order_cutting/create_order', 'order_cutting@create_order')->middleware('auth');
Route::get('create_order_cutting/get_ajax', 'order_cutting@ajaxOrder')->middleware('auth');
Route::get('delete_order_cutting', 'order_cutting@delete_order_cutting')->middleware('auth');
Route::get('order_cutting/get_ajax/today', 'order_cutting@ajaxOrderCuttingToday')->middleware('auth');
Route::get('order_cutting/get_ajax_inLot', 'order_cutting@get_ajax_inLot')->middleware('auth');
Route::post('order_cutting/edit', 'order_cutting@order_edit')->middleware('auth');
Route::get('stock_cl_receive', 'stock@stock_cl_receive')->middleware('auth');

Route::get('order/plan_cutting/{id}', 'order@plan_cutting')->middleware('auth');
Route::get('addOrderCutting_to_lot', 'order_cutting@addOrderCutting_to_lot')->middleware('auth');

// transport plan
Route::get('order/plan_transport', 'order_transport@index')->middleware('auth');
Route::get('order_transport/get_ajax', 'order_transport@ajaxOrder')->middleware('auth');
Route::post('set_order_transport', 'order_transport@set_order_transport')->middleware('auth');
Route::get('create_order_offal/ajaxOrderOffal', 'order_transport@ajaxOrderOffal')->middleware('auth');
Route::get('order_transport/get_ajax_inLot', 'order_transport@get_ajax_inLot')->middleware('auth');
Route::get('order_transport/get_ajax_inLot2', 'order_transport@get_ajax_inLot2')->middleware('auth');
Route::get('order_transport/delete_transportOrder_from_lot', 'order_transport@delete_transportOrder_from_lot')->middleware('auth');
Route::get('order_transport/create_tr', 'order_transport@create_order_transport')->middleware('auth');
Route::post('order_transport/save', 'order_transport@order_transport_save')->middleware('auth');
Route::get('delete_order_tr', 'order_transport@delete_order_tr')->middleware('auth');
Route::post('order/tr_edit', 'order_transport@tr_edit')->middleware('auth');
Route::get('ended_tr_order', 'order_transport@ended_tr_order')->middleware('auth');

Route::post('order/edit', 'order@order_edit')->middleware('auth');
Route::get('delete_order', 'order@delete_order')->middleware('auth');

Route::get('delete_order_bill', 'order@delete_order_bill')->middleware('auth');

Route::get('ajax_type_order', 'order@ajax_type_order')->middleware('auth');

//ชั่งน้ำหนักรวม

Route::get('weighing/general', 'recieve@weighing')->middleware('auth');
Route::get('weighing/sku_weight_data', 'recieve@sku_weight_data')->middleware('auth');
Route::get('factory_weighing_report', 'recieve@weighing_factory')->middleware('auth');
Route::get('weighing/sku_weight_data/factory', 'recieve@sku_weight_data_factory')->middleware('auth');
Route::get('factory_weighing_date_specify', 'recieve@weighing_factory_date_specify')->middleware('auth');
Route::get('/weighing/sku_weight_data/factory/date_specify', 'recieve@sku_weight_data_factory_date_specify')->middleware('auth');
Route::get('factory_weighing_date_specify/log_delete', 'recieve@weighing_factory_date_specify_log_delete')->middleware('auth');
Route::get('/weighing/sku_weight_data/factory/date_specify_delete', 'recieve@sku_weight_data_factory_date_specify_delete')->middleware('auth');

Route::get('/delete_weighing_data', 'recieve@delete_weighing_data')->middleware('auth');
Route::POST('/wg_sku_weigth_add', 'recieve@wg_sku_weigth_add')->middleware('auth');
Route::POST('/wg_sku_weigth_add_multiple', 'recieve@wg_sku_weigth_add_multiple')->middleware('auth');\
Route::POST('/wg_sku_weigth_edit', 'recieve@wg_sku_weigth_edit')->middleware('auth');
Route::get('/get_weighing_data', 'recieve@get_weighing_data')->middleware('auth');

//ชั่งโอน
Route::get('weight/transfer_product', 'recieve@weighingTransfer')->middleware('auth');
Route::get('/weighing/sku_weight_data/transfer', 'recieve@sku_weight_data_transfer')->middleware('auth');

//stock
Route::get('/weight/stock', 'recieve@weighingStock')->middleware('auth');
Route::get('/weighing/stock', 'recieve@weighing_stock')->middleware('auth');

//รับเข้าแผนกย่อย
Route::get('/process/plan_daily', 'production@index')->middleware('auth');
Route::get('/process/in_weighing_order', 'production@inOrder')->middleware('auth');

//แสดงเลขลอต
Route::get('/order/lot', 'order@indexLot')->middleware('auth');

//เปรียบเทียบน้ำหนัก
Route::get('/compare/factory_to_shop/{id}', 'compare@factoryToShopIndex')->middleware('auth');
Route::get('/checkOrderResult/{id}', 'compare@checkOrderResult')->middleware('auth');
Route::get('/selectLot', 'compare@selectLot')->middleware('auth');

//สุปการชั่งแต่ละเลขorder
Route::get('/summary_weighing_receive/{id}', 'summary@summary_weighing_receive')->middleware('auth');
Route::get('/summary_weighing_offal/{id}', 'summary@summary_weighing_offal')->middleware('auth');
Route::get('/summary_weighing_cutting/{id}', 'summary@summary_weighing_cutting')->middleware('auth');
/////////////  เพิ่มหมูกรณีหมูขึ้นชั่งไม่ได้
Route::POST('/wg_sku_weigth_add_multiple', 'summary@wg_sku_weigth_add_multiple')->middleware('auth');

//stock_new


Route::get('/stock_main', 'stock@stock_main')->middleware('auth');
Route::get('/stock_daily_tt/{date}', 'stock@stock_daily_tt')->middleware('auth');
Route::get('/stock_daily_pl/{date}', 'stock@stock_daily_pl')->middleware('auth');
Route::get('/stock_daily_of/{date}', 'stock@stock_daily_of')->middleware('auth');
Route::get('/stock_daily_ov/{date}', 'stock@stock_daily_ov')->middleware('auth');
Route::get('/stock_daily_cl/{date}', 'stock@stock_daily_cl')->middleware('auth');
Route::get('/stock_daily_mr/{date}', 'stock@stock_daily_mr')->middleware('auth');
Route::get('/stock_daily_dc/{date}', 'stock@stock_daily_dc')->middleware('auth');

Route::get('/stock_data_pp2/{id}', 'stock@stock_data_pp2')->middleware('auth');
Route::get('/stock_pp2_send', 'stock@stock_pp2_send')->middleware('auth');
Route::get('/stock_pp2_receive', 'stock@stock_pp2_receive')->middleware('auth');
Route::get('/stock_of_pp2_balance', 'stock@stock_of_pp2_balance')->middleware('auth');
Route::get('/stock_data/edit_row', 'stock@edit_row')->middleware('auth');

Route::get('/stock_data_pp1/{id}', 'stock@stock_data_pp1')->middleware('auth');
Route::get('/get_stock', 'stock@get_stock')->middleware('auth');
Route::get('/get_stock_history', 'stock@get_stock_history')->middleware('auth');
Route::post('/stock_data/add/{id}', 'stock@stock_data_add')->middleware('auth');
Route::post('/stock_data/editr_row/{id}', 'stock@stock_data_edit_row')->middleware('auth');
Route::get('/stock_data/del_row', 'stock@del_row')->middleware('auth');
Route::get('/stock_pp1_receive', 'stock@stock_pp1_receive')->middleware('auth');
Route::get('/stock_pp1_send', 'stock@stock_pp1_send')->middleware('auth');
Route::get('/stock_data/edit_price', 'stock@edit_price')->middleware('auth');
Route::post('/stock_data/pigpen_summary', 'stock@pigpen_summary')->middleware('auth');

// of
Route::get('/stock_data_of_summay', 'stock@stock_data_of_summay')->middleware('auth');

Route::get('/add_pig/{id}', 'stock@show_add_form')->middleware('auth');

Route::post('/stock_data/add_ov/{id}', 'stock@stock_ov_data_add')->middleware('auth');
Route::get('/stock_ov2_receive', 'stock@stock_ov2_receive')->middleware('auth');

Route::get('pig_into_fac/request', 'stock@pig_into_fac')->middleware('auth');
Route::get('checking_recieve_order', 'stock@checking_recieve_order')->middleware('auth');
Route::get('delete_pig_to_fac', 'stock@delete_pig_to_fac')->middleware('auth');
Route::get('stock_main_data', 'stock@stock_main_data')->middleware('auth');

Route::get('/stock_data_ov/{id}', 'stock@stock_data_ov')->middleware('auth');
Route::get('/stock_ov_receive', 'stock@stock_ov_receive')->middleware('auth');
Route::get('/stock_ov_send', 'stock@stock_ov_send')->middleware('auth');
Route::get('/stock_of_ov_balance', 'stock@stock_of_ov_balance')->middleware('auth');
Route::get('/stock_data_ov/report_overnight/{order_number}', 'stock@report_overnight')->middleware('auth');
Route::get('/stock_data_ov2/{id}', 'stock@stock_data_ov2')->middleware('auth');

Route::get('/stock_data_of_cl/{id}', 'stock@stock_data_of_cl')->middleware('auth');
Route::get('/stock_of_red_receive', 'stock@stock_of_red_receive')->middleware('auth');
Route::get('/stock_of_red_balance', 'stock@stock_of_red_balance')->middleware('auth');
Route::get('/stock_of_red_send', 'stock@stock_of_red_send')->middleware('auth');

Route::get('/stock_data_of_entrails/{id}', 'stock@stock_data_of_white')->middleware('auth');
Route::get('/stock_data_of_entrails_item/{id}', 'stock@entrails_item')->middleware('auth');
Route::get('/stock_of_entrails', 'stock@stock_of_entrails')->middleware('auth');
Route::get('/stock_of_entrails_item', 'stock@stock_of_entrails_item')->middleware('auth');
Route::get('/stock_of_white_balance', 'stock@stock_of_white_balance')->middleware('auth');
Route::get('/stock_of_white_send', 'stock@stock_of_white_send')->middleware('auth');

Route::get('/stock/factory_daily_main', 'stock@factory_daily_main')->middleware('auth');
Route::get('/stock/factory_daily/customer/{date}', 'stock@factory_daily_customer')->middleware('auth');
Route::get('/stock/factory_daily/branch/{date}', 'stock@factory_daily_branch')->middleware('auth');
Route::get('/stock/factory_daily_trim/branch/{date}', 'stock@factory_daily_trim_branch')->middleware('auth');
Route::get('/stock_data_of_dc/{id}', 'stock@stock_data_of_dc')->middleware('auth');
Route::get('/stock_of_dc', 'stock@stock_of_dc')->middleware('auth');

Route::get('/order_customer/edit_weight_side', 'stock@edit_weight_side')->middleware('auth');

//export excel
Route::get('export', 'controllerReportShopImport@export')->name('export');

Route::get('importExportView', 'controllerReportShopImport@importExportView');
Route::post('importReportSales', 'controllerReportShopImport@import')->name('import');
Route::get('report_shop_level1/{id}', 'controllerReportShopImport@report_shop_level1');
Route::get('report_shop_level2/{shop}/{date}', 'controllerReportShopImport@report_shop_level2');
Route::get('/delete_import', 'controllerReportShopImport@delete_import')->middleware('auth');

//export excel purchase
Route::get('importShopPurchase', 'controllerReportShopImport@importShopPurchase');
Route::post('importExcelPurchase', 'controllerReportShopImport@importExcelPurchase')->name('import');
Route::get('report_purchase/{id}', 'controllerReportShopImport@report_purchase');
Route::get('delete_report_purchase', 'controllerReportShopImport@delete_report_purchase')->middleware('auth');

//export excel compare
Route::get('importCompare', 'controllerReportShopImport@importCompare');
Route::get('importCompare_daily', 'controllerReportShopImport@importCompare_daily');
Route::post('importExcelCompare', 'controllerReportShopImport@importExcelCompare')->name('import');
Route::get('/checkOrderResultImportcompare/{id}', 'compare@checkOrderResultImportcompare')->middleware('auth');
Route::get('/checkOrderResultImportcompareprint/{id}', 'compare@checkOrderResultImportcompareprint')->middleware('auth');
Route::get('/daily_ResultImportcompare/{date}', 'compare@daily_ResultImportcompare')->middleware('auth');

Route::post('importExcelCompareShop', 'controllerReportShopImport@importExcelCompareShop')->name('import');
Route::get('/delete_importCompare', 'controllerReportShopImport@delete_importCompare')->middleware('auth');
Route::get('/compare/edit_weight_recieve', 'compare@edit_weight_recieve')->middleware('auth');

//ขนส่ง
Route::get('/checking_order', 'transport@checking_order')->middleware('auth');
Route::get('/report_transport/{id}', 'transport@report_transport')->middleware('auth');
Route::post('report_transport/check', 'transport@check_report')->name('import');
Route::get('/report_transport_pdf/pdf_make/{order}', 'reportTransportPDF@create_pdf')->middleware('auth');
Route::get('/report_transport_pdf/pdf_load/{order}', 'reportTransportPDF@create_pdf_load')->middleware('auth');

//แปรสภาพ
Route::get('transform_main', 'transform@transform_main')->name('import');
Route::get('report_transform/{order_number}', 'transform@report_transform')->name('import');

// สั่งorderพิเศษ
Route::get('shop/special_order/{date}', 'shop@special_order')->name('import');
Route::post('/shop/specail_order/request', 'shop@special_order_request')->name('import');

Route::get('factory/receive_sp_order_1/{date}', 'shop@receive_sp_order_1')->name('import');
Route::get('factory/receive_sp_order_1_print/{date}', 'shop@receive_sp_order_1_print')->name('import');
Route::get('factory/receive_sp_order_1_print_all/{date}', 'shop@receive_sp_order_1_print_all')->name('import');
Route::get('checkOrderResultImportcompareprint', 'shop@daily_sales')->name('import');
Route::get('factory/receive_sp_order_2/{date}', 'shop@receive_sp_order_2')->name('import');
Route::get('factory/receive_sp_order_2_print/{date}', 'shop@receive_sp_order_2_print')->name('import');
Route::get('factory/receive_sp_order_2_print_all/{date}', 'shop@receive_sp_order_2_print_all')->name('import');

Route::get('shop/daily_sales_all', 'shop@daily_sales_all')->name('import');
Route::post('shop/receive_sp_order_2_fill/{date}', 'shop@receive_sp_order_2_fill')->name('import');
Route::get('shop/shop_request_all', 'shop@shop_request_all')->name('import');
Route::get('shop/special_order_admin/{date}/{shop_code}', 'shop@special_order_admin')->name('import');

Route::get('/check_sp_order/sale', function () {
    return redirect('shop/daily_sales_all');
});
Route::get('/check_sp_order/factory', function () {
    return redirect('shop/daily_sales_all');
});
Route::get('/check_sp_order/shop', function () {
    return redirect('shop/daily_sales_all');
});

//ใบแกะ ใบคนงาน
Route::get('factory/receive_sp_order_cutting/{date}', 'shop@receive_sp_order_cutting')->name('import');
Route::get('factory/receive_sp_order_cutting_print/{date}', 'shop@receive_sp_order_cutting_print')->name('import');
Route::get('factory/receive_sp_order_employee/{date}', 'shop@receive_sp_order_employee')->name('import');
Route::get('factory/receive_sp_order_employee_print/{date}', 'shop@receive_sp_order_employee_print')->name('import');

// save น้ำหนัก DC สุดท้ายของแต่ละวัน
Route::post('/shop/sp_summary_weight', 'shop@sp_summary_weight')->name('import');

//เฉลี่ยเปอร์เซ้น
Route::get('shop/average_percent/{date}', 'shop@average_percent')->name('import');
Route::post('shop/average_percent_save/', 'shop@average_percent_save')->name('import');

// แปรสภาพ
Route::get('shop_transform_main', 'transform@shop_transform_main')->name('import');
Route::get('transform/transform_compare/{date}/{mk}', 'transform@transform_compare')->name('import');
Route::get('transform/transform_compare_all/{date}', 'transform@transform_compare_all')->name('import');
Route::get('get_data_shop_tranform_main', 'transform@get_data_shop_tranform_main')->name('import');

//สร้างรายการโอนสินค้า
Route::get('/order/product_transfer', 'transfer@product_transfer_index')->middleware('auth');
Route::get('/order/product_transfer_all', 'transfer@product_transfer_index_all')->middleware('auth');

// สร้างรายการแปรสภาพ
Route::get('/order/transfer', 'tranfrom@transfer_index')->middleware('auth');
Route::get('/approve_tranfrom/{id}', 'tranfrom@approve_tranfrom')->middleware('auth');
Route::get('/no_approve_tranfrom/{id}', 'tranfrom@no_approve_tranfrom')->middleware('auth');

// สร้างรายการคืนโรงงาน
Route::get('/order/transfer_to_fac', 'transfer_to_fac@transfer_index')->middleware('auth');
Route::get('create_order_transfer_fac/get_ajax', 'transfer_to_fac@product_transfer_table')->middleware('auth');

// โอนคืนสินค้า
Route::get('create_order_transfer/get_ajax', 'transfer@product_transfer_table')->middleware('auth');
Route::post('create_order_transfer/create_order', 'transfer@create_order')->middleware('auth');
Route::post('create_order_tranfrom/create_order', 'tranfrom@create_order')->middleware('auth');
Route::get('order/create_order_transfer/{id}/edit', 'transfer@order_edit')->middleware('auth');
// Route::get('order/create_order_transfer/{id}/delete','transfer@order_on_delete')->middleware('auth');
Route::put('create_order_transfer/update', 'transfer@order_update')->middleware('auth');
Route::get('create_order_transfer/delete', 'transfer@order_delete')->middleware('auth');
Route::get('create_order_tranfrom/get_ajax', 'tranfrom@product_transfer_table')->middleware('auth');
Route::get('create_order_transfrom/delete', 'tranfrom@order_delete')->middleware('auth');

//ยืนยันรายการโอนสินค้า
Route::post('create_order_transfer/confirm_order', 'transfer@confirm_order')->middleware('auth');

//ยืนยันรายการคือสินค้า
Route::post('create_order_transfer_to_fac/create_order', 'transfer_to_fac@create_order')->middleware('auth');

Route::get('getMarkerCustomerFrom', 'order@getMarkerCustomer_from')->middleware('auth');
Route::get('getMarkerCustomerTo', 'order@getMarkerCustomer_to')->middleware('auth');

//ตรวจสอบรายการโอนสินค้า
Route::get('/order/report_transfer/{order}', 'transfer@report_transfer')->middleware('auth');
Route::get('/order/report_transfer_all/{date}', 'transfer@report_transfer_all')->middleware('auth');
Route::get('/order/report_transfer_all_print/{date}', 'transfer@report_transfer_all_print')->middleware('auth');
Route::get('check_order_transfer/{id}', 'transfer@check_order_transfer')->middleware('auth');
Route::get('/order/report_transfer_print/{order}', 'transfer@report_transfer_print')->middleware('auth');

// yield_report
Route::get('yield_report_main/{date}', 'yield_report@main')->middleware('auth');
Route::get('yield_report_data/data/{ov}', 'yield_report@data_ov')->middleware('auth');

Route::get('yield_report_slice/{date}', 'yield_report@slice')->middleware('auth');

Route::get('yield_report_slice_order/{date}', 'yield_report@slice_order_main')->middleware('auth');
// display yield 
Route::get('yield_slice_main', 'yield_report@slice_main')->middleware('auth');
Route::get('yield_report_data_daily/{date}', 'yield_report@yield_report_data_daily')->middleware('auth');

Route::get('yield_report_data_daily_all/{date}', 'yield_report@yield_report_data_daily_all')->middleware('auth');

Route::get('yield_report_data_daily_all_order/{order_number}', 'yield_report@yield_report_data_daily_all_order')->middleware('auth');
// cost from yield 
Route::get('cost_yield_report_data_daily/{date}', 'yield_report@yield_report_data_daily_all')->middleware('auth');


Route::get('debug/{order_numer}', 'setting@debug')->middleware('auth');

//!! PERMISSION
Route::get('menu_permission', 'setting@menu_permission')->middleware('auth');

Route::get('test_array', 'setting@test_array')->middleware('auth');

//map real - time
Route::get('/factory_monitor', 'MapRealTimeController@get_factory')->middleware('auth');
Route::get('/ajax/scales', 'MapRealTimeController@getScale')->middleware('auth');


//send line
Route::get('/send_line/{id}', 'transfer@send_line');
Route::get('/send_line_tranfrom/{id}', 'tranfrom@send_line');
Route::get('/send_line_transfer_to_fac/{id}', 'transfer_to_fac@send_line');

// ref_order
Route::get('/ref_order', function () {
        return view('stock.ref_order');
    });
    Route::get('/get_ref_order', 'stock@get_ref_order');   

// marinade
Route::get('marinade_order', 'order_marinade@index')->middleware('auth');
Route::post('create_order_marinade/create_order', 'order_marinade@create_order')->middleware('auth');
Route::get('create_order_marinade/get_ajax', 'order_marinade@ajaxOrder')->middleware('auth');
Route::post('order_marinade/edit', 'order_marinade@order_edit')->middleware('auth');
Route::get('delete_order_marinade', 'order_marinade@delete_order_marinade')->middleware('auth');