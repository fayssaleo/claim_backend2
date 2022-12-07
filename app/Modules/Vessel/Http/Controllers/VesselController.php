<?php

namespace App\Modules\Vessel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Modules\Vessel\Models\Vessel;
use App\Modules\NatureOfDamage\Models\NatureOfDamage;
use App\Modules\TypeOfEquipment\Models\TypeOfEquipment;
class VesselController extends Controller
{

    public function createOrUpdateVessel(Request $request){

        if($request->id==0){

            $validator = Validator::make($request->all(), [
               // "name" => "required:brand,name",
            ]);
            if ($validator->fails()) {
                return [
                    "payload" => $validator->errors(),
                    "status" => "406_2"
                ];
            }

            $vessel=Vessel::make($request->all());

            if($request->nature_of_damage["id"]==0){
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndSave($request->nature_of_damage);
                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
                $vessel->nature_of_damage_id=$nature_of_damage_returnedValue["payload"]->id;
            } else {
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndUpdate($request->nature_of_damage);
                $vessel->nature_of_damage_id=$request->nature_of_damage["id"];

                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
            }



            $vessel->save();

            return [
                "payload" => $vessel,
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
            $vessel=Vessel::find($request->id);
            if (!$vessel) {
                return [
                    "payload" => "The searched row does not exist !",
                    "status" => "404_3"
                ];
            }
            $vessel->name=$request->name;
            $vessel->deductible_charge_TAT=$request->deductible_charge_TAT;
            $vessel->categorie_of_equipment=$request->categorie_of_equipment;
            $vessel->status=$request->status;
            $vessel->incident_date=$request->incident_date;
            $vessel->claim_date=$request->claim_date;
            $vessel->ClaimOrIncident=$request->ClaimOrIncident;
            $vessel->concerned_internal_department=$request->concerned_internal_department;
            $vessel->equipement_registration=$request->equipement_registration;
            $vessel->cause_damage=$request->cause_damage;
            $vessel->Liability_letter_number=$request->Liability_letter_number;
            $vessel->amount=$request->amount;
            $vessel->currency=$request->currency;
            $vessel->comment_third_party=$request->comment_third_party;
            $vessel->reinvoiced=$request->reinvoiced;
            $vessel->currency_Insurance=$request->currency_Insurance;
            $vessel->Invoice_number=$request->Invoice_number;
            $vessel->date_of_reimbursement=$request->date_of_reimbursement;
            $vessel->reimbursed_amount=$request->reimbursed_amount;
            $vessel->date_of_declaration=$request->date_of_declaration;
            $vessel->date_of_feedback=$request->date_of_feedback;
            $vessel->comment_Insurance=$request->comment_Insurance;
            $vessel->Indemnification_of_insurer=$request->Indemnification_of_insurer;
            $vessel->currency_indemnisation=$request->currency_indemnisation;
            $vessel->deductible_charge_TAT=$request->deductible_charge_TAT;
            $vessel->damage_caused_by=$request->damage_caused_by;
            $vessel->comment_nature_of_damage=$request->comment_nature_of_damage;
            $vessel->TAT_name_persons=$request->TAT_name_persons;
            $vessel->outsourcer_company_name=$request->outsourcer_company_name;
            $vessel->thirdparty_company_name=$request->thirdparty_company_name;
            $vessel->thirdparty_Activity_comments=$request->thirdparty_Activity_comments;

            if($request->nature_of_damage["id"]==0){
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndSave($request->nature_of_damage);
                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
                $vessel->nature_of_damage_id=$nature_of_damage_returnedValue["payload"]->id;
            } else {
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndUpdate($request->nature_of_damage);

                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
            }

            if($request->type_of_equipment["id"]==0){
                $type_of_equipment_returnedValue=$this->type_of_equipment_confirmAndSave($request->type_of_equipment);
                if($type_of_equipment_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $type_of_equipment_returnedValue["payload"],
                        "status" => $type_of_equipment_returnedValue["status"]
                    ];
                }
                $vessel->brand_id=$type_of_equipment_returnedValue["payload"]->id;
            }
            else{
                $type_of_equipment_returnedValue=$this->type_of_equipment_confirmAndUpdate($request->type_of_equipment);

                if($type_of_equipment_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $type_of_equipment_returnedValue["payload"],
                        "status" => $type_of_equipment_returnedValue["status"]
                    ];
                }
            }

            $vessel->save();

            return [
                "payload" => $vessel,
                "status" => "200"
            ];

        }
    }

    public function allClaim(){
        $vessel=Vessel::select()->where('ClaimOrIncident', "Claim")->with("typeOfEquipment")
        ->with("natureOfDamage")
        ->with("department")
        //->with("estimate")
        ->get();
            return [
                "payload" => $vessel,
                "status" => "200_1"
            ];
    }

    public function allIncident(){
        $vessel=Vessel::select()->where('ClaimOrIncident', "Incident")->with("typeOfEquipment")
        ->with("natureOfDamage")
        ->with("department")
        //->with("estimate")
        ->get();
            return [
                "payload" => $vessel,
                "status" => "200_1"
            ];
    }

    public function delete(Request $request){
        $vessel=Vessel::find($request->id);
        if(!$vessel){
            return [
                "payload" => "The searched row does not exist !",
                "status" => "404_4"
            ];
        }
        else {
            $vessel->delete();
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
               // $type_of_equipment->name=$Type_of_equipment['name'];
                $type_of_equipment->save();
                return [
                    "payload"=>$type_of_equipment,
                    "status"=>"200",
                    "IsReturnErrorRespone" => false
                ];
            }
    }

}
