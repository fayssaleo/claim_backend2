<?php

namespace App\Modules\Automobile\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Modules\Brand\Models\Brand;
use App\Modules\Automobile\Models\Automobile;
use App\Modules\NatureOfDamage\Models\NatureOfDamage;
use App\Modules\TypeOfEquipment\Models\TypeOfEquipment;

class AutomobileController extends Controller
{

    public function createOrUpdateAutomobile(Request $request){

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

            $automobile=Automobile::make($request->all());



            if($request->nature_of_damage["id"]==0){
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndSave($request->nature_of_damage);
                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
                $automobile->nature_of_damage_id=$nature_of_damage_returnedValue["payload"]->id;
            } else {
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndUpdate($request->nature_of_damage);
                $automobile->nature_of_damage_id=$request->nature_of_damage["id"];

                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
            }


            if($request->brand["id"]==0){
                $brand_returnedValue=$this->brand_confirmAndSave($request->brand);

                if($brand_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $brand_returnedValue["payload"],
                        "status" => $brand_returnedValue["status"]
                    ];
                }
                $automobile->brand_id=$brand_returnedValue["payload"]->id;
            }
            else{
                $band_returnedValue=$this->brand_confirmAndUpdate($request->brand);
                $automobile->brand_id=$request->brand["id"];

                if($band_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $band_returnedValue["payload"],
                        "status" => $band_returnedValue["status"]
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
                $automobile->type_of_equipment_id=$type_of_equipment_returnedValue["payload"]->id;
            }
            else{
                $type_of_equipment_returnedValue=$this->type_of_equipment_confirmAndUpdate($request->type_of_equipment);
                $automobile->type_of_equipment_id=$request->type_of_equipment["id"];

                if($type_of_equipment_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $type_of_equipment_returnedValue["payload"],
                        "status" => $type_of_equipment_returnedValue["status"]
                    ];
                }
            }

            $automobile->save();
            return [
                "payload" => $automobile,
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
            $automobile=Automobile::find($request->id);
            if (!$automobile) {
                return [
                    "payload" => "The searched row does not exist !",
                    "status" => "404_3"
                ];
            }
            $automobile->name=$request->name;
            $automobile->deductible_charge_TAT=$request->deductible_charge_TAT;
            $automobile->categorie_of_equipment=$request->categorie_of_equipment;
            $automobile->status=$request->status;
            $automobile->incident_date=$request->incident_date;
            $automobile->claim_date=$request->claim_date;
            $automobile->ClaimOrIncident=$request->ClaimOrIncident;
            $automobile->concerned_internal_department=$request->concerned_internal_department;
            $automobile->equipement_registration=$request->equipement_registration;
            $automobile->cause_damage=$request->cause_damage;
            $automobile->Liability_letter_number=$request->Liability_letter_number;
            $automobile->amount=$request->amount;
            $automobile->currency=$request->currency;
            $automobile->comment_third_party=$request->comment_third_party;
            $automobile->reinvoiced=$request->reinvoiced;
            $automobile->currency_Insurance=$request->currency_Insurance;
            $automobile->Invoice_number=$request->Invoice_number;
            $automobile->date_of_reimbursement=$request->date_of_reimbursement;
            $automobile->reimbursed_amount=$request->reimbursed_amount;
            $automobile->date_of_declaration=$request->date_of_declaration;
            $automobile->date_of_feedback=$request->date_of_feedback;
            $automobile->comment_Insurance=$request->comment_Insurance;
            $automobile->Indemnification_of_insurer=$request->Indemnification_of_insurer;
            $automobile->currency_indemnisation=$request->currency_indemnisation;
            $automobile->deductible_charge_TAT=$request->deductible_charge_TAT;
            $automobile->damage_caused_by=$request->damage_caused_by;
            $automobile->comment_nature_of_damage=$request->comment_nature_of_damage;
            $automobile->TAT_name_persons=$request->TAT_name_persons;
            $automobile->outsourcer_company_name=$request->outsourcer_company_name;
            $automobile->thirdparty_company_name=$request->thirdparty_company_name;
            $automobile->thirdparty_Activity_comments=$request->thirdparty_Activity_comments;


            if($request->nature_of_damage["id"]==0){
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndSave($request->nature_of_damage);
                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
                $automobile->nature_of_damage_id=$nature_of_damage_returnedValue["payload"]->id;
            } else {
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndUpdate($request->nature_of_damage);

                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
            }


            if($request->brand["id"]==0){
                $brand_returnedValue=$this->brand_confirmAndSave($request->brand);

                if($brand_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $brand_returnedValue["payload"],
                        "status" => $brand_returnedValue["status"]
                    ];
                }
                $automobile->brand_id=$brand_returnedValue["payload"]->id;
            }
            else{
                $band_returnedValue=$this->band_confirmAndUpdate($request->band);

                if($band_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $band_returnedValue["payload"],
                        "status" => $band_returnedValue["status"]
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
                $automobile->brand_id=$type_of_equipment_returnedValue["payload"]->id;
            }
            else{
                $type_of_equipment_returnedValue=$this->type_of_equipment_confirmAndUpdate($request->type_of_equipment);
                $automobile->brand_id=$type_of_equipment_returnedValue["payload"]->id;

                if($type_of_equipment_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $type_of_equipment_returnedValue["payload"],
                        "status" => $type_of_equipment_returnedValue["status"]
                    ];
                }
            }

            $automobile->save();

            return [
                "payload" => $automobile,
                "status" => "200"
            ];

        }
    }

    public function allClaim(){
        $automobile=Automobile::select()->where('ClaimOrIncident', "Claim")->with("typeOfEquipment")
        ->with("brand")
        ->with("natureOfDamage")
        ->with("department")
        //->with("estimate")
        ->get();
            return [
                "payload" => $automobile,
                "status" => "200_1"
            ];
    }

    public function allIncident(){
        $automobile=Automobile::select()->where('ClaimOrIncident', "Incident")->with("typeOfEquipment")
        ->with("brand")
        ->with("natureOfDamage")
        ->with("department")
        //->with("estimate")
        ->get();
            return [
                "payload" => $automobile,
                "status" => "200_1"
            ];
    }

    public function delete(Request $request){
        $automobile=Automobile::find($request->id);
        if(!$automobile){
            return [
                "payload" => "The searched row does not exist !",
                "status" => "404_4"
            ];
        }
        else {
            $automobile->delete();
            return [
                "payload" => "Deleted successfully",
                "status" => "200_4"
            ];
        }
    }

    public function nature_of_damage_confirmAndSave($NatureOfDamage){
        $validator = Validator::make($NatureOfDamage, [
            "name" => "required:nature_of_damages,name",
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
                //$natureOfDamage->name=$NatureOfDamage['name'];
                $natureOfDamage->save();
                return [
                    "payload"=>$natureOfDamage,
                    "status"=>"200",
                    "IsReturnErrorRespone" => false
                ];
            }
    }

    public function brand_confirmAndSave($Brand){
        $validator = Validator::make($Brand, [
            "name" => "required:brands,name",
        ]);

        if ($validator->fails()) {
            return [
                "payload" => $validator->errors(),
                "status" => "406_2"
            ];
        }

        $brand=Brand::make($Brand);
        $brand->save();

        return [
            "payload" => $brand,
            "status" => "200",
            "IsReturnErrorRespone" => false
        ];
    }
    public function brand_confirmAndUpdate($Brand){
        $brand=Brand::find($Brand['id']);
            if(!$brand){
                return [
                    "payload"=>"brand is not exist !",
                    "status"=>"404_2",
                    "IsReturnErrorRespone" => true
                ];
            }
            else if ($brand){
              //  $brand->name=$Brand['name'];
                $brand->save();
                return [
                    "payload"=>$brand,
                    "status"=>"200",
                    "IsReturnErrorRespone" => false
                ];
            }
    }

    public function type_of_equipment_confirmAndSave($Type_of_equipment){
        $validator = Validator::make($Type_of_equipment, [
            "name" => "required:type_of_equipments,name",
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
