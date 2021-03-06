<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 8/16/17
 * Time: 9:32 PM
 */
namespace Salon\GiftCertificates;

use App\GiftCertificate;
use App\GiftCerticateDetail;
use Carbon\Carbon;

use Salon\Square\Square;

class GiftAPI{
    protected $gift;

    public function __construct(GiftCertificate $giftCertificate)
    {
        $this->gift = $giftCertificate;
    }

    public function getDailyGiftsSold(){

        $gifts = Square::getDailyGiftsSold();

        foreach($gifts as $gift){
            $this->gift->updateOrCreate(['squareId' => $gift['squareId']],$gift);
        }

    }
    public function getGiftsSold($saleDate){

        $gifts = Square::getGiftCardsSold($saleDate);


        if(isset($gifts)){
            foreach($gifts as $gift){
                $this->gift->firstOrCreate($gift);
            }
        }

    }


    public function getRecentGifts(){
        $today = Carbon::now();
        $date = clone $today;
        $aWeekAgo = $date->subWeek(1)->toDateString();


        $gifts = GiftCertificate::hasValue()->active()->
        whereBetween('sold_at',array($aWeekAgo,$today->toDateTimeString()))->orderBy('sold_at','desc')->get();

        return $gifts;
    }

    public function useGift($use, $id){

        $gift = GiftCertificate::find($id);
        if(is_numeric($use['amount'])){
            if($use['amount'] <= $gift->amount){

                $gift->amount = $gift->amount - $use['amount'];
                $gift->save();
                if(!isset($use['comments'])){
                    $use['comments'] = 'use';
                }

                $use['amount'] = 0 - $use['amount'];
                $use['date'] = Carbon::now()->toDateTimeString();

                $gift->detail()->save(new GiftCerticateDetail($use));

                $result = ['success' => true, 'amount' => number_format($gift->amount,2)];

            }else{
                $result = ['success' => false, 'message' => 'Not enough value to use'];
            }
        }
        else{
            $result = ['success' => false, 'message' => 'The use amount is not a number'];
        }
        return $result;

    }

    public function voidGift($id){

        $gift = GiftCertificate::find($id);

        $gift->amount = 0.00;

        $gift->save();

        $gift->detail()->create(['comments' => 'void', 'date' => Carbon::now()->toDateTimeString(),'amount' => 0.00]);

        return(['success' => true, 'amount' => 0.00]);

    }

    public function search($squareId, $date){

        if(!is_null($date)){
            $this->getGiftsSold($date);
        }

        $gifts = GiftCertificate::where('squareId','like',$squareId.'%')->get();


        return $gifts;
    }

}


