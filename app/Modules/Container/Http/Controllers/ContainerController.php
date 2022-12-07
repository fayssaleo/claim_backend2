<?php

namespace App\Modules\Container\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Modules\Container\Models\Container;
use App\Modules\NatureOfDamage\Models\NatureOfDamage;
use App\Modules\TypeOfEquipment\Models\TypeOfEquipment;

class ContainerController extends Controller
{
    public function createOrUpdateContainer(Request $request){

        if($request->id==0){

            $validator = Validator::make($request->all(), [
              //  "name" => "required:brand,name",
            ]);
            if ($validator->fails()) {
                return [
                    "payload" => $validator->errors(),
                    "status" => "406_2"
                ];
            }

            $container=Container::make($request->all());



            if($request->nature_of_damage["id"]==0){
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndSave($request->nature_of_damage);
                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
                $container->nature_of_damage_id=$nature_of_damage_returnedValue["payload"]->id;
            } else {
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndUpdate($request->nature_of_damage);
                $container->nature_of_damage_id=$request->nature_of_damage["id"];

                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
            }





           /*  if($request->type_of_equipment["id"]==0){
                $type_of_equipment_returnedValue=$this->type_of_equipment_confirmAndSave($request->type_of_equipment);
                if($type_of_equipment_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $type_of_equipment_returnedValue["payload"],
                        "status" => $type_of_equipment_returnedValue["status"]
                    ];
                }
                $container->type_of_equipment_id=$type_of_equipment_returnedValue["payload"]->id;
            }
            else{
                $type_of_equipment_returnedValue=$this->type_of_equipment_confirmAndUpdate($request->type_of_equipment);

                if($type_of_equipment_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $type_of_equipment_returnedValue["payload"],
                        "status" => $type_of_equipment_returnedValue["status"]
                    ];
                }
            } */

            $container->save();
            return [
                "payload" => $container,
                "status" => "200"
            ];
        }
        else {
            $validator = Validator::make($request->all(), [
            ]);
            if ($validator->fails()) {
                return [
                    "payload" => $validator->errors(),
                    "status" => "406_2"
                ];
            }
            $container=Container::find($request->id);
            if (!$container) {
                return [
                    "payload" => "The searched row does not exist !",
                    "status" => "404_3"
                ];
            }
            $container->name=$request->name;
            $container->deductible_charge_TAT=$request->deductible_charge_TAT;
            $container->categorie_of_equipment=$request->categorie_of_equipment;
            $container->status=$request->status;
            $container->incident_date=$request->incident_date;
            $container->claim_date=$request->claim_date;
            $container->ClaimOrIncident=$request->ClaimOrIncident;
            $container->concerned_internal_department=$request->concerned_internal_department;
            $container->equipement_registration=$request->equipement_registration;
            $container->cause_damage=$request->cause_damage;
            $container->Liability_letter_number=$request->Liability_letter_number;
            $container->amount=$request->amount;
            $container->currency=$request->currency;
            $container->comment_third_party=$request->comment_third_party;
            $container->reinvoiced=$request->reinvoiced;
            $container->currency_Insurance=$request->currency_Insurance;
            $container->Invoice_number=$request->Invoice_number;
            $container->date_of_reimbursement=$request->date_of_reimbursement;
            $container->reimbursed_amount=$request->reimbursed_amount;
            $container->date_of_declaration=$request->date_of_declaration;
            $container->date_of_feedback=$request->date_of_feedback;
            $container->comment_Insurance=$request->comment_Insurance;
            $container->Indemnification_of_insurer=$request->Indemnification_of_insurer;
            $container->currency_indemnisation=$request->currency_indemnisation;
            $container->deductible_charge_TAT=$request->deductible_charge_TAT;
            $container->damage_caused_by=$request->damage_caused_by;
            $container->comment_nature_of_damage=$request->comment_nature_of_damage;
            $container->TAT_name_persons=$request->TAT_name_persons;
            $container->outsourcer_company_name=$request->outsourcer_company_name;
            $container->thirdparty_company_name=$request->thirdparty_company_name;
            $container->thirdparty_Activity_comments=$request->thirdparty_Activity_comments;

            if($request->nature_of_damage["id"]==0){
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndSave($request->nature_of_damage);
                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
                $container->nature_of_damage_id=$nature_of_damage_returnedValue["payload"]->id;
            } else {
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndUpdate($request->nature_of_damage);

                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
            }






            $container->save();

            return [
                "payload" => $container,
                "status" => "200"
            ];

        }
    }

    public function allClaim(){
        $container=Container::select()->where('ClaimOrIncident', "Claim")
        ->with("typeOfEquipment")
        ->with("natureOfDamage")
        ->with("department")
        ->with("estimate")
        ->get();
            return [
                "payload" => $container,
                "status" => "200_1"
            ];
    }

    public function allIncident(){
        $container=Container::select()->where('ClaimOrIncident', "Incident")
        ->with("typeOfEquipment")
        ->with("natureOfDamage")
        ->with("department")
        ->with("estimate")
        ->get();
       // $container->nature_of_damage=$container->natureOfDamage;

            return [
                "payload" => $container,
                "status" => "200_1"
            ];
    }

    public function delete(Request $request){
        $container=Container::find($request->id);
        if(!$container){
            return [
                "payload" => "The searched row does not exist !",
                "status" => "404_4"
            ];
        }
        else {
            $container->delete();
            return [
                "payload" => "Deleted successfully",
                "status" => "200_4"
            ];
        }
    }

    public function nature_of_damage_confirmAndSave($NatureOfDamage){
        $validator = Validator::make($NatureOfDamage, [
            "name" => "required:nature_of_damage,name",
        ]);
        if ($validator->fails()) {
            return [
                "payload" => $validator->errors(),
                "status" => "406_2",
                "IsReturnErrorRespone" => true
            ];
        }
        $natureOfDamage=NatureOfDamage::make($NatureOfDamage);
        $natureOfDamage->save();
        return [
            "payload" => $natureOfDamage,
            "status" => "200",
            "IsReturnErrorRespone" => false

        ];
    }
    public function nature_of_damage_confirmAndUpdate($NatureOfDamage){
        $natureOfDamage=NatureOfDamage::find($NatureOfDamage['id']);
            if(!$natureOfDamage){
                return [
                    "payload"=>"natureOfDamage is not exist !",
                    "status"=>"404_2",
                    "IsReturnErrorRespone" => true
                ];
            }
            else if ($natureOfDamage){
               // $natureOfDamage->name=$NatureOfDamage['name'];
                $natureOfDamage->save();
                return [
                    "payload"=>$natureOfDamage,
                    "status"=>"200",
                    "IsReturnErrorRespone" => false
                ];
            }
    }


    public function type_of_equipment_confirmAndSave($Type_of_equipment){
        $validator = Validator::make($Type_of_equipment, [
            "name" => "required:type_of_equipment,name",
        ]);

        if ($validator->fails()) {
            return [
                "payload" => $validator->errors(),
                "status" => "406_2"
            ];
        }

        $type_of_equipemnt=TypeOfEquipment::make($Type_of_equipment);
        $type_of_equipemnt->save();

        return [
            "payload" => $type_of_equipemnt,
            "status" => "200",
            "IsReturnErrorRespone" => false
        ];
    }
    public function type_of_equipment_confirmAndUpdate($Type_of_equipment){
        $type_of_equipment=TypeOfEquipment::find($Type_of_equipment['id']);
            if(!$type_of_equipment){
                return [
                    "payload"=>"type_of_equipment is not exist !",
                    "status"=>"404_2",
                    "IsReturnErrorRespone" => true
                ];
            }
            else if ($type_of_equipment){
              //  $type_of_equipment->name=$Type_of_equipment['name'];
                $type_of_equipment->save();
                return [
                    "payload"=>$type_of_equipment,
                    "status"=>"200",
                    "IsReturnErrorRespone" => false
                ];
            }
    }
}
