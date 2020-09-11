<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NtuhaRide extends Model
{

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public static function saveRide($driver_id,$customer_id,$amount,$from,$to,$date,$month_year,$ntuha_amount)
    {
    	$save_ride = new NtuhaRide();
    	$save_ride->driver_id = $driver_id;
    	$save_ride->customer_id = $customer_id;
    	$save_ride->from = $from;
    	$save_ride->to = $to;
    	$save_ride->amount = $amount;
        $save_ride->date = $date;
        $save_ride->month_year = $month_year;
        $save_ride->ntuha_amount = $ntuha_amount;
    	$save_ride->save();
    }

    public static function getDays($from,$to,$sizeOfData)
    {
        $period = new \DatePeriod(new \DateTime($from),new \DateInterval('P1D'),new \DateTime($to));//get all days btn the date customer was created and today

        $dates = $month_year = $dataValues = array();

        foreach ($period as $key => $value) {

           $dates[] = ['date'=>$value->format('Y-m-d'), 'month'=>$value->format('Y-m')];//puck them together       

        }

        if ($sizeOfData > count($dates)) {
            $sizeOfData = count($dates);
        }

        $keys = array_rand($dates, $sizeOfData);//select random N days from them

        if (count($keys) > 0) {
            foreach ($keys as $k => $value) {
                $dataValues[] = $dates[$value];
            }

            sort($dataValues);//sort those days

            return $dataValues;

        }else{

            return [];
            
        }


        
    }

    public static function randomItemSeletor($arrayObject)
    {
        $key = array_rand($arrayObject);
        return $arrayObject[$key];
    }

    public static function movementLocations()
    {
       $arrLoc = [
                "Ntare School Mosque",
                "Kakoba Market",
                "Nyakayojo Secondary School",
                "Divine Mercy Baby's Home",
                "Baptist Church Kakoba",
                "Kakoba Weather Station",
                "Tankhill",
                "Mbarara Secondary School",
                "Katete Trading Centre",
                "Kosiya Hotel & Services Apartment",
                "Mbarara Referral Hospital Mortuar",
                "Bishop Stuart University",
                "Rwebikona",
                "Petrol Station",
                "Holy Innocents Children's Hospital, Mbarara",
                "Ntare Road",
                "Mbaguta Lyptus Products",
                "Kakyeka Stadium(Rwebikoona) A-J Polling Station",
                "Amazon Building",
                "Ankole Farmers Saving And Credit Limited",
                "Kakoba Mosque",
                "Ruti Trading Centre",
                "Kakoba Weather Station",
                "Main Post Office",
                "Bus Park Road",
                "MUST Research Office",
                "Ntare School Sports Grounds",
                "Lakeview Hotel",
                "Biharwe sub-county headquaters",
                "Katete Road",
                "Mandela Junior School",
                "International window school",
                "Uganda Martyrs Church Mbarara",
                "Biharwe sub-county headquaters",
                "Katete Hospital",
                "Ankole Farmers Saving And Credit Limited",
                "Igongo Cultural Centre",
                "Buffalo Resort",
                "Bushenyi District Government Administrative Area",
                "Bushenyi District Presidential Lodge",
                "Kashaka Girls Secondary School",
                "Biharwe sub-county headquaters",
                "Agip Motel's Restaunt and Bar",
                "Ruharo Cathedral",
                "Mbarara University Of Science And Technology",
                "Ruti Trading Centre",
                "Ntare School Sports Grounds",
                "Ruharo Mission Hospital",
                "Mwengura Guest House",
                "Ruharo Cathedral",
                "Ruharo Mission Hospital",
                "Ruti Trading Centre",
                "Mbarara - Bushenyi Road",
                "Kosiya Hotel & Services Apartment",
                "Mackansigh Street",
                "Cleverland high school",
                "Kiyanja Trading Center",
                "Booma Primary School Polling Station",
                "Nkokonjeru Tombs",
                "Bishop Stuart Univesity",
                "Katete Hospital",
                "Mbarara - Masaka Road",
                "Mbaguta Street",
                "Buremba Road",
                "Kakoba Central (K) Polling Station",
                "Kamukuzi Health Centre",
                "Mbarara Central Market",
                "Nsikye Trading Centre",
                "Katete Police Station",
                "Kamukuzi",
                "Kakoba Central (K) Polling Station",
                "St. Mary's Cathedral Nyamitanga",
                "Coffee Bar",
                "Kabaterine Memorial Primary School",
                "Ruharo Hospital II A - M Polling Station",
                "Andrews Inn",
                "Jack's Lounge",
                "Ruharo Cathedral",
                "Hotel Triangle Mbarara",
                "SOHO Terrace bar (former Peers)",
                "Katukuru Catholic Church",
                "Easy view hotel",
                "Biharwe Bus Stop",
                "Nile Breweries",
                "Stanbic Bank (Mbarara Main Branch)",
                "Kamukuzi Hill",
                "Kabwohe Town Council",
                "Kashaka Girls Secondary School",
                "Agip Motel",
                "Igongo Cultural Centre & Country Hotel",
                "Wagga Resort Mbarara",
                "Kakyeka Stadium(Rwebikoona) A-J Polling Station",
                "mbarara university kihumuro campus"
            ];

            array_unique($arrLoc);

            $keys = array_rand($arrLoc, 2);

            $val1 = $arrLoc[$keys[0]];
            $val2 = $arrLoc[$keys[1]];

            if ($val1 != $val2) {
                return [$val1,$val2];
            }else{
                return [NtuhaRide::randomItemSeletor($arrLoc),NtuhaRide::randomItemSeletor($arrLoc)];
            }         
        }  
    }
