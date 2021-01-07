<?php

namespace App;

use App\tb_tranfrom;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Hinaloe\LineNotify\Message\LineMessage;

class alert_tranfrom_send_line extends Notification
{
    use Queueable;
    
    /** @var User  */
    protected $tb_tranfrom;
    
    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(tb_tranfrom $tb_tranfrom)
    {
        $this->tb_tranfrom  = $tb_tranfrom;
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

                // return (new LineMessage())->message('ทดสอบ ขออนุมัติการแปลสภาพ เลขที่: '.$this->tb_tranfrom->order_number."\r\n".
                //                                     'จาก: '.$this->tb_tranfrom->id_user_customer_from.' ถึง: '
                //                                     .$this->tb_tranfrom->id_user_customer_to."\r\n"
                //                                     .'หมายเหตุ: '.$this->tb_tranfrom->note."\r\n"
                //                                     .'ทะเบียนรถขนส่ง: '.$this->tb_tranfrom->truck_number."\r\n"
                //                                     .'พนักงานขับรถ: '.$this->tb_tranfrom->truck_driver."\r\n"
                //                                     .'Link อนุมัติ: http://www.dcore.center/pig_factorychm_web/order/report_transfer/'.$this->tb_tranfrom->order_number);
                return (new LineMessage())->message('ขออนุมัติการแปลสภาพ เลขที่: '.$this->tb_tranfrom->order_number."\r\n".
                                                    'สาขา: '.$this->tb_tranfrom->id_user_customer_from."\r\n".
                                                    'หมายเหตุ: '.$this->tb_tranfrom->note."\r\n"
                                                    .'Link อนุมัติ: http://www.dcore.center/pig_factorychm_web/order/transfer');
                //  return (new LineMessage())->message('test');
                                                    
    }
}
