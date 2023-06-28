<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomData;
class CustomDataController extends Controller
{
    public function store_research_quantity_sum() {
        // Define your endpoints and their auth credentials
        $endpoints = [
            'CLINIC_WEBMED_DOMAIN' => ['d01a667f-a60e-4772-9ac4-46d7e378442e', 'ebd6b155-782b-4131-a237-a530da11d5ba'],
            'MARNEULI_WEBMED_DOMAIN' => ['a4b525b0-c67e-41f5-9d3c-b92c219025a9', 'fdef6e8e-c748-43c2-a4e1-f2e4efd6c3da'],
            'TEMQA_WEBMED_DOMAIN' => ['88e81821-64f3-4d44-a507-033c269e48b5', '203608d5-697e-4a3c-83b9-60148aeb8a44'],
            'RUSTAVI_WEBMED_DOMAIN' => ['4a26d78c-ff15-41fa-87ce-61881c5ce91e', '90446098-e567-4490-8bab-fae4273420ab'],
            'ISANI_WEBMED_DOMAIN' => ['5537ef84-3ac0-417d-b8a5-55d2ff77a64b', '1dff203f-2780-44b7-a6b0-cc83c5768eb4'],
            'GORI_WEBMED_DOMAIN' => ['e13fcab9-bcb1-4016-80a8-ea332182a006', '6dd6828f-4d6b-45a7-b085-3250c7a33f84'],
            'BOGDANI_WEBMED_DOMAIN' => ['978ff94c-f71c-4c08-b2b1-d60aa17f48aa', '6e018167-ac65-47df-9552-ace55e4dd6d8'],
        ];
        
        $client = new \GuzzleHttp\Client();
        $totalResearchQuantitySum = 0;
        $totalPatientQuantitySum = 0;
        // Loop over the endpoints to make the requests
        foreach ($endpoints as $domain => $auth) {
            $res = $client->request('GET', env($domain) . '/Statistic/TotalVisits', ['auth' => $auth]);
            
            // Decode the response body
            $responseBody = json_decode($res->getBody(), true);
        
            // Add to the total sum
            $totalResearchQuantitySum += $responseBody['ResearchQuantitySum'];
            $totalPatientQuantitySum += $responseBody['PatientCount'];
        }
        $customData = CustomData::where('title', 'ResearchQuantitySum')->first();
        $customData->value = number_format($totalResearchQuantitySum, 0);
        $customData->save();
        
        $customData = CustomData::where('title', 'PatientCount')->first();
        $customData->value = number_format($totalPatientQuantitySum, 0);
        $customData->save();
        // Output or return the total sum
        return $responseBody;
    }
}
