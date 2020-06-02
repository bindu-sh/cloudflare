<?php

namespace App\Helpers\CloudFlareHelper;
use App\Models\Cloudflare\Account;
use App\Models\Cloudflare\Domain;
use GuzzleHttp\Client;

class Cloudflare{

    public static function getAccounts(){

        $url = "https://api.cloudflare.com/client/v4/accounts";
        $client=new Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'X-Auth-Email' =>'bindu07.ideaclan@gmail.com',
                'X-Auth-Key' =>'f1f0a0e8373cf871ba12e4f0ae36a8ca24aa2' ,
            ]
        ]);
        $res=$response->getBody()->getContents();
        $result=json_decode($res,true);
        return $result;
    }
    public static function getDomains(Account $account){
       $accounts=$account->get();

        $url = "https://api.cloudflare.com/client/v4/zones";
        $client=new Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'X-Auth-Email' =>$accounts[0]->account_name,
                'X-Auth-Key' =>'f1f0a0e8373cf871ba12e4f0ae36a8ca24aa2' ,
            ]
        ]);
        $data=$response->getBody()->getContents();
        $result=json_decode($data,true);

        return $result;
    }
    public function insertZoneInCloudflare(Account $account){
        $accounts=$account->get();
        $url = "https://api.cloudflare.com/client/v4/zones";
        $client=new Client();
        $response1 = $client->request('POST', $url, [
            'name'=>'cloud-flare.com',
            'jump_start'=>true,
            'headers' => [
                'X-Auth-Email' =>'bindu07.ideaclan@gmail.com',
                'X-Auth-Key' =>'f1f0a0e8373cf871ba12e4f0ae36a8ca24aa2' ,
            ]
        ]);
    }

    public static function getListDns($domainId){
        if(isset($domainId) && !empty($domainId)){
            /** Id is Not Empty */
            $url = "https://api.cloudflare.com/client/v4/zones/".$domainId."/dns_records";

            $client = new Client();
            $response = $client->request('GET ', $url, [
                'headers' => [
                    'X-Auth-Email' => 'bindu07.ideaclan@gmail.com',
                    'X-Auth-Key' => 'f1f0a0e8373cf871ba12e4f0ae36a8ca24aa2',
                    'Content-Type' => 'application/json'
                ]
            ]);
            $data = $response->getBody()->getContents();
            $res=json_decode($data, true);
        }
        $getZones=domain::all();
        $res=[];
        foreach($getZones as $key=>$value) {
            $url = "https://api.cloudflare.com/client/v4/zones/" . $value->zoneid . "/dns_records";

            $client = new Client();
            $response = $client->request('GET ', $url, [
                'headers' => [
                    'X-Auth-Email' => 'bindu07.ideaclan@gmail.com',
                    'X-Auth-Key' => 'f1f0a0e8373cf871ba12e4f0ae36a8ca24aa2',
                    'Content-Type' => 'application/json'
                ]
            ]);
            $data = $response->getBody()->getContents();
            $res[]=json_decode($data, true);

        }

        return ['dnsRecords'=>$res];
    }

    public static function createDns(){
        $url = "https://api.cloudflare.com/client/v4/zones/cfa9c011d0c331c7a241b4c235ed8b79/dns_records";
        $client = new Client();
        $response = $client->request('POST', $url, [
            /** Change values  **/
            'json'=>[
               "type"=>"A",
                "name"=>"testbin.com",
                "content"=>"127.0.0.1",
                "ttl"=>120,
                "priority"=>10,
                "proxied"=>false
                ],
            'headers' => [
                'X-Auth-Email' =>'bindu07.ideaclan@gmail.com',
                'X-Auth-Key' =>'f1f0a0e8373cf871ba12e4f0ae36a8ca24aa2',
                'Content-Type'=>'application/json'
            ]
        ]);
        $data=$response->getBody()->getContents();
        $res=json_decode($data,true);
        return $res;
    }
    public static function deleteDns(){
        $url = "https://api.cloudflare.com/client/v4/zones/cfa9c011d0c331c7a241b4c235ed8b79/dns_records/c3eb4975e35eb024aede8ee17d467c9d";
        $client = new Client();
        $response = $client->request('DELETE ', $url, [

            'headers' => [
                'X-Auth-Email' =>'bindu07.ideaclan@gmail.com',
                'X-Auth-Key' =>'f1f0a0e8373cf871ba12e4f0ae36a8ca24aa2',
                'Content-Type'=>'application/json'
            ]
        ]);
        $data=$response->getBody()->getContents();
        $res=json_decode($data,true);
        return $res;
    }
    public static function updateDns(){
        $url = "https://api.cloudflare.com/client/v4/zones/cfa9c011d0c331c7a241b4c235ed8b79/dns_records/66e93d33065701190bbe64723fd7094a";
        $client=new Client();
        $response = $client->request('Put ', $url, [
            'json'=>[
                "type"=>"CNAME",
                "name"=>"admin.alphabeta.com",
                "content"=>"148.72.249.186",
                "ttl"=>1,
               "proxied"=>false],
            'headers' => [
                'X-Auth-Email' =>'bindu07.ideaclan@gmail.com',
                'X-Auth-Key' =>'f1f0a0e8373cf871ba12e4f0ae36a8ca24aa2',
                'Content-Type'=>'application/json'
            ]
        ]);
        $data=$response->getBody()->getContents();

        return $data;
    }
    public static function deleteZones(){
        $url='https://api.cloudflare.com/client/v4/zones/4245e0a32d0b9da30b5f9cf63c61aa94';
        $client=new Client();
        $response = $client->request('DELETE', $url, [
            'headers' => [
                'X-Auth-Email' =>'bindu07.ideaclan@gmail.com',
                'X-Auth-Key' =>'f1f0a0e8373cf871ba12e4f0ae36a8ca24aa2',
                'Content-Type'=>'application/json'
            ]
        ]);
    }
    public static function purgeCacheByFile(Domain $domain){
        $domains=$domain->get();
        foreach($domains as $key=>$value){
            $url='https://api.cloudflare.com/client/v4/zones/'.$value->zoneid.'/purge_cache';
            $client=new Client();
            $response = $client->request('POST', $url, [
                'json'=>'{"files":["http://www.example.com/css/styles.css",{"url":"http://www.example.com/cat_picture.jpg","headers":{"Origin":"https://www.cloudflare.com","CF-IPCountry":"US","CF-Device-Type":"desktop"}}]}',
                'headers' => [
                    'X-Auth-Email' =>'bindu07.ideaclan@gmail.com',
                    'X-Auth-Key' =>'f1f0a0e8373cf871ba12e4f0ae36a8ca24aa2',
                    'Content-Type'=>'application/json'
                ]
            ]);
            $data=$response->getBody()->getContents();
            dd($data);
        }

    }
}
