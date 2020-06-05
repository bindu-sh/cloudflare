<?php

namespace App\Helpers\CloudFlareHelper;
use App\Models\Cloudflare\Account;
use App\Models\Cloudflare\DnsRecords;
use App\Models\Cloudflare\Domain;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Cloudflare{


    public static function getDomains(Account $account){

        $url = "https://api.cloudflare.com/client/v4/zones";
        $client=new Client();
        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'X-Auth-Email' =>$account->email,
                    'X-Auth-Key' => $account->auth_key,
                ]
            ]);
            $data=$response->getBody()->getContents();
            $result=json_decode($data,true);
            return $result;
        } catch (GuzzleException $e) {
            echo $e;
        }

    }
    public function insertZoneInCloudflare(Account $account,$data){

        $url = "https://api.cloudflare.com/client/v4/zones";
        $client=new Client();
        $response1 = $client->request('POST', $url, [
            json=>$data,
            'headers' => [
                'X-Auth-Email' =>$account->email,
                'X-Auth-Key' =>$account->auth_key,
            ]
        ]);
    }

    public static function getDnsList(Account $account){
        $getZones=Domain::where(['account_id'=>$account->account_id])->get();
        $res=[];
        foreach($getZones as $key=>$value) {
            $url = "https://api.cloudflare.com/client/v4/zones/" . $value->zoneid . "/dns_records";

            $client = new Client();
            $response = $client->request('GET ', $url, [
                'headers' => [
                    'X-Auth-Email' => $account->email,
                    'X-Auth-Key' => $account->auth_key,
                    'Content-Type' => 'application/json'
                ]
            ]);
            $data = $response->getBody()->getContents();
            $res[]=json_decode($data, true);

        }
        return ['dnsRecords'=>$res];
    }

    public static function createDns(Account $account,$data){
        $domain=Domain::where(['account_id'=>$account->account_id])->first();
        $url = "https://api.cloudflare.com/client/v4/zones/".$domain->zoneid."/dns_records";
        $client = new Client();
        $response = $client->request('POST', $url, [
            /** Change values  **/
            'json'=>$data,
            'headers' => [
                'X-Auth-Email' => $account->email,
                'X-Auth-Key' => $account->auth_key,
                'Content-Type'=>'application/json'
            ]
        ]);
        $data=$response->getBody()->getContents();
        $res=json_decode($data,true);
        return $res;
    }
    public static function deleteDns($domain_id){
        $dnsRecord=DnsRecords::where(['zone_id'=>$domain_id])->get();
        $domain=Domain::where(['zoneid'=>$domain_id])->first();
        $account=Account::where(['account_id'=>$domain->account_id])->first();
        foreach($dnsRecord as $key=>$value){
            $url = "https://api.cloudflare.com/client/v4/zones/".$domain_id."/dns_records/$value->identifier";
            $client = new Client();
            $response = $client->request('DELETE ', $url, [

                'headers' => [
                    'X-Auth-Email' =>$account->email,
                    'X-Auth-Key' =>$account->auth_key,
                    'Content-Type'=>'application/json'
                ]
            ]);
            $data=$response->getBody()->getContents();
            $res=json_decode($data,true);

            $dnsRecordDDelete=DnsRecords::find($value->id);
            $dnsRecordDDelete->delete();
            return $res;
        }

    }
    public static function updateDns(Domain $domain,$dnsid,$data){
        $account=Account::where(['account_id'=>$domain->account_id])->first();
        $url = "https://api.cloudflare.com/client/v4/zones/".$domain->zoneid."/dns_records/".$dnsid."";
        $client=new Client();
        $response = $client->request('Put ', $url, [
            'json'=>$data,
            'headers' => [
                'X-Auth-Email' =>$account->email,
                'X-Auth-Key' =>$account->auth_key,
                'Content-Type'=>'application/json'
            ]
        ]);
        $data=$response->getBody()->getContents();

        return $data;
    }
    public static function deleteZones(Domain $domain){
        $account=Account::where(['account_id'=>$domain->account_id])->first();
        $url='https://api.cloudflare.com/client/v4/zones/'.$domain->zoneid;
        $client=new Client();
        $response = $client->request('DELETE', $url, [
            'headers' => [
                'X-Auth-Email' =>$account->email,
                'X-Auth-Key' =>$account->auth_key,
                'Content-Type'=>'application/json'
            ]
        ]);
    }
    public static function purgeCacheForAll(Domain $domain){
        $account=Account::where(['account_id'=>$domain->account_id])->first();

            $url='https://api.cloudflare.com/client/v4/zones/'.$domain->zoneid.'/purge_cache';
            $client=new Client();
            $response = $client->request('POST', $url, [
                'json'=>[
                    "purge_everything"=>true],
                    'headers' => [
                    'X-Auth-Email' =>$account->email,
                    'X-Auth-Key' =>$account->auth_key,
                    'Content-Type'=>'application/json'
                ]
            ]);
            $data=$response->getBody()->getContents();
            $res=json_decode($data, true);
           return $res;

    }
}
