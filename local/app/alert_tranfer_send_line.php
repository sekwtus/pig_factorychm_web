<?php

namespace App;

use App\tb_transfer_product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Hinaloe\LineNotify\Message\LineMessage;

class alert_tranfer_send_line extends Notification
{
    use Queueable;
    
    /** @var User  */
    protected $tb_transfer_product;
    
    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(tb_transfer_product $tb_transfer_product)
    {
        $this->tb_transfer_product  = $tb_transfer_product;
    }
    
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['line'];
    }
    
    /**
     * @param mixed $notifable callee instance
     * @return LineMessage 
     */
    public function toLine($notifable)
    {
        // return (new LineMessage())->message('New user: ' . $this->user->name)
        //     ->imageUrl('https://example.com/sample.jpg') // With image url (jpeg only)
        //     ->imageFile('/path/to/image.png') // With image file (png/jpg/gif will convert to jpg)
        //     ->sticker(40, 2); // With Sticker

                return (new LineMessage())->message('ขออนุมัติการโอน เลขที่: '.$this->tb_transfer_product->order_number."\r\n".
                                                    'จาก: '.$this->tb_transfer_product->id_user_customer_from.' ถึง: '
                                                    .$this->tb_transfer_product->id_user_customer_to."\r\n"
                                                    .'หมายเหตุ: '.$this->tb_transfer_product->note."\r\n"
                                                    .'ทะเบียนรถขนส่ง: '.$this->tb_transfer_product->truck_number."\r\n"
                                                    .'พนักงานขับรถ: '.$this->tb_transfer_product->truck_driver."\r\n"
                                                    .'Link อนุมัติ: http://www.dcore.center/pig_factorychm_web/order/report_transfer/'.$this->tb_transfer_product->order_number);
                                                    
    }
}
