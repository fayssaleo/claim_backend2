<?php

namespace App\Modules\Equipment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libs\UploadTrait;
use App\Modules\Brand\Models\Brand;
use App\Modules\Equipment\Models\Equipment;
use App\Modules\File\Models\File;
use App\Modules\NatureOfDamage\Models\NatureOfDamage;
use App\Modules\TypeOfEquipment\Models\TypeOfEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipmentController extends Controller
{
    use UploadTrait;
    public function createOrUpdateEquipment(Request $request){
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

            $equipment=Equipment::make($request->all());

            if($request->nature_of_damage["name"]!=null || $request->nature_of_damage["name"]!=""){
                if($request->nature_of_damage["id"]==0){
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndSave($request->nature_of_damage);
                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
                $equipment->nature_of_damage_id=$nature_of_damage_returnedValue["payload"]->id;
            } else {
                $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndUpdate($request->nature_of_damage);
                $equipment->nature_of_damage_id=$request->nature_of_damage["id"];

                if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $nature_of_damage_returnedValue["payload"],
                        "status" => $nature_of_damage_returnedValue["status"]
                    ];
                }
            }
            }


            if($request->brand["name"]!=null || $request->brand["name"]!=""){
                if($request->brand["id"]==0){
                $brand_returnedValue=$this->brand_confirmAndSave($request->brand);

                if($brand_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $brand_returnedValue["payload"],
                        "status" => $brand_returnedValue["status"]
                    ];
                }
                $equipment->brand_id=$brand_returnedValue["payload"]->id;
            }
            else{
                $band_returnedValue=$this->brand_confirmAndUpdate($request->brand);
                $equipment->brand_id=$request->brand["id"];

                if($band_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $band_returnedValue["payload"],
                        "status" => $band_returnedValue["status"]
                    ];
                }
            }
            }


            if($request->type_of_equipment["name"]!=null || $request->type_of_equipment["name"]!=""){
                if($request->type_of_equipment["id"]==0){
                $type_of_equipment_returnedValue=$this->type_of_equipment_confirmAndSave($request->type_of_equipment);
                if($type_of_equipment_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $type_of_equipment_returnedValue["payload"],
                        "status" => $type_of_equipment_returnedValue["status"]
                    ];
                }
                $equipment->type_of_equipment_id=$type_of_equipment_returnedValue["payload"]->id;
            }
            else{
                $type_of_equipment_returnedValue=$this->type_of_equipment_confirmAndUpdate($request->type_of_equipment);
                $equipment->type_of_equipment_id=$request->type_of_equipment["id"];

                if($type_of_equipment_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $type_of_equipment_returnedValue["payload"],
                        "status" => $type_of_equipment_returnedValue["status"]
                    ];
                }
            }
            }



            $equipment->save();

            if($request->file()) {
                if($request->incedent_report!=null){
                    $file=$request->incedent_report;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.equipments.path'),$filename,"public_uploads_equipments_incedent_report");
                    $fileObj=new File();
                    $fileObj->table_id=$equipment->id;
                    $fileObj->filename=$filename;
                    $fileObj->table_name="equipments";
                    $fileObj->file_category="incedent_report";
                    $fileObj->save();
                }
                if($request->liability_letter!=null){
                    $file=$request->liability_letter;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.equipments.path'),$filename,"public_uploads_equipments_liability_letter");
                    $fileObj=new File();
                    $fileObj->table_id=$equipment->id;
                    $fileObj->filename=$filename;
                    $fileObj->table_name="equipments";
                    $fileObj->file_category="liability_letter";
                    $fileObj->save();
                }
                if($request->insurance_declaration!=null){
                    $file=$request->insurance_declaration;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.equipments.path'),$filename,"public_uploads_equipments_insurance_declaration");
                    $fileObj=new File();
                    $fileObj->table_id=$equipment->id;
                    $fileObj->filename=$filename;
                    $fileObj->table_name="equipments";
                    $fileObj->file_category="insurance_declaration";
                    $fileObj->save();
                }
            }
            return [
                "payload" => $equipment,
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
            $equipment=Equipment::find($request->id);
            if (!$equipment) {
                return [
                    "payload" => "The searched row does not exist !",
                    "status" => "404_3"
                ];
            }
            $equipment->name=$request->name;
            $equipment->deductible_charge_TAT=$request->deductible_charge_TAT;
            $equipment->categorie_of_equipment=$request->categorie_of_equipment;
            $equipment->status=$request->status;
            $equipment->incident_date=$request->incident_date;
            $equipment->claim_date=$request->claim_date;
            $equipment->ClaimOrIncident=$request->ClaimOrIncident;
            $equipment->concerned_internal_department=$request->concerned_internal_department;
            $equipment->equipement_registration=$request->equipement_registration;
            $equipment->cause_damage=$request->cause_damage;
            $equipment->Liability_letter_number=$request->Liability_letter_number;
            $equipment->amount=$request->amount;
            $equipment->currency=$request->currency;
            $equipment->comment_third_party=$request->comment_third_party;
            $equipment->reinvoiced=$request->reinvoiced;
            $equipment->currency_Insurance=$request->currency_Insurance;
            $equipment->Invoice_number=$request->Invoice_number;
            $equipment->date_of_reimbursement=$request->date_of_reimbursement;
            $equipment->reimbursed_amount=$request->reimbursed_amount;
            $equipment->date_of_declaration=$request->date_of_declaration;
            $equipment->date_of_feedback=$request->date_of_feedback;
            $equipment->comment_Insurance=$request->comment_Insurance;
            $equipment->Indemnification_of_insurer=$request->Indemnification_of_insurer;
            $equipment->currency_indemnisation=$request->currency_indemnisation;
            $equipment->deductible_charge_TAT=$request->deductible_charge_TAT;
            $equipment->damage_caused_by=$request->damage_caused_by;
            $equipment->comment_nature_of_damage=$request->comment_nature_of_damage;
            $equipment->TAT_name_persons=$request->TAT_name_persons;
            $equipment->outsourcer_company_name=$request->outsourcer_company_name;
            $equipment->thirdparty_company_name=$request->thirdparty_company_name;
            $equipment->thirdparty_Activity_comments=$request->thirdparty_Activity_comments;

            if($request->nature_of_damage["name"]!=null || $request->nature_of_damage["name"]!=""){
                if($request->nature_of_damage["id"]==0){
                    $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndSave($request->nature_of_damage);
                    if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                        return [
                            "payload" => $nature_of_damage_returnedValue["payload"],
                            "status" => $nature_of_damage_returnedValue["status"]
                        ];
                    }
                    $equipment->nature_of_damage_id=$nature_of_damage_returnedValue["payload"]->id;
                }
                else {
                    $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndUpdate($request->nature_of_damage);

                    if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                        return [
                            "payload" => $nature_of_damage_returnedValue["payload"],
                            "status" => $nature_of_damage_returnedValue["status"]
                        ];
                    }
                }
            }


            if($request->brand["name"]!=null || $request->brand["name"]!=""){
                if($request->brand["id"]==0){
                    $brand_returnedValue=$this->brand_confirmAndSave($request->brand);

                    if($brand_returnedValue["IsReturnErrorRespone"]){
                        return [
                            "payload" => $brand_returnedValue["payload"],
                            "status" => $brand_returnedValue["status"]
                        ];
                    }
                    $equipment->brand_id=$brand_returnedValue["payload"]->id;
                }
                else{
                    $brand_returnedValue=$this->brand_confirmAndUpdate($request->brand);

                    if($brand_returnedValue["IsReturnErrorRespone"]){
                        return [
                            "payload" => $brand_returnedValue["payload"],
                            "status" => $brand_returnedValue["status"]
                        ];
                    }
                }

            }

            if($request->type_of_equipment["name"]!=null || $request->type_of_equipment["name"]!=""){
                if($request->type_of_equipment["id"]==0){
                    dd($request->type_of_equipment["id"]);
                    $type_of_equipment_returnedValue=$this->type_of_equipment_confirmAndSave($request->type_of_equipment);
                    if($type_of_equipment_returnedValue["IsReturnErrorRespone"]){
                        return [
                            "payload" => $type_of_equipment_returnedValue["payload"],
                            "status" => $type_of_equipment_returnedValue["status"]
                        ];
                    }
                    $equipment->brand_id=$type_of_equipment_returnedValue["payload"]->id;
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
            }


            $equipment->save();


            if($request->file()) {
                if($request->incedent_report!=null){
                    $file=$request->incedent_report;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.equipments.path'),$filename,"public_uploads_equipments_incedent_report");
                    $fileObj=new File();
                    $fileObj->table_id=$equipment->id;
                    $fileObj->filename=$filename;
                    $fileObj->table_name="equipments";
                    $fileObj->file_category="incedent_report";
                    $fileObj->save();
                }
                if($request->liability_letter!=null){
                    $file=$request->liability_letter;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.equipments.path'),$filename,"public_uploads_equipments_liability_letter");
                    $fileObj=new File();
                    $fileObj->table_id=$equipment->id;
                    $fileObj->filename=$filename;
                    $fileObj->table_name="equipments";
                    $fileObj->file_category="liability_letter";
                    $fileObj->save();
                }
                if($request->insurance_declaration!=null){
                    $file=$request->insurance_declaration;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.equipments.path'),$filename,"public_uploads_equipments_insurance_declaration");
                    $fileObj=new File();
                    $fileObj->table_id=$equipment->id;
                    $fileObj->filename=$filename;
                    $fileObj->table_name="equipments";
                    $fileObj->file_category="insurance_declaration";
                    $fileObj->save();
                }
            }


            return [
                "payload" => $equipment,
                "status" => "200"
            ];

        }
    }

    public function allClaim(){
        $equipment=Equipment::select()->where('ClaimOrIncident', "Claim")->with("typeOfEquipment")
        ->with("brand")
        ->with("natureOfDamage")
        ->with("department")
        //->with("estimate")
        ->get();
            return [
                "payload" => $equipment,
                "status" => "200_1"
            ];
    }
    public function allIncident(){
        $equipment=Equipment::select()->where('ClaimOrIncident', "Incident")->with("typeOfEquipment")
        ->with("brand")
        ->with("natureOfDamage")
        ->with("department")
        //->with("estimate")
        ->get();
            return [
                "payload" => $equipment,
                "status" => "200_1"
            ];
    }

    public function delete(Request $request){
        $equipment=Equipment::find($request->id);
        if(!$equipment){
            return [
                "payload" => "The searched row does not exist !",
                "status" => "404_4"
            ];
        }
        else {
            $equipment->delete();
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
                    "payload"=>"nature Of Damage is not exist !",
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
                //$brand->name=$Brand['name'];
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
