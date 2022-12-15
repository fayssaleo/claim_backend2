<?php

namespace App\Modules\Container\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Libs\UploadTrait;

use App\Modules\Container\Models\Container;
use App\Modules\NatureOfDamage\Models\NatureOfDamage;
use App\Modules\ShippingLine\Models\ShippingLine;

class ContainerController extends Controller
{
    use UploadTrait;

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
                if($request->nature_of_damage["name"]!=null || $request->nature_of_damage["name"]!=""){
                    $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndSave($request->nature_of_damage);
                        if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                            return [
                                "payload" => $nature_of_damage_returnedValue["payload"],
                                "status" => $nature_of_damage_returnedValue["status"]
                            ];
                        }
                        $container->nature_of_damage_id=$nature_of_damage_returnedValue["payload"]->id;
                }

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



            if($request->shipping_line["id"]==0){
                if($request->shipping_line["name"]!=null || $request->shipping_line["name"]!=""){
                    $shipping_line_returnedValue=$this->shipping_line_confirmAndSave($request->shipping_line);
                    if($shipping_line_returnedValue["IsReturnErrorRespone"]){
                        return [
                            "payload" => $shipping_line_returnedValue["payload"],
                            "status" => $shipping_line_returnedValue["status"]
                        ];
                    }
                    $container->shipping_line_id=$shipping_line_returnedValue["payload"]->id;
                }
            }
            else{
                $shipping_line_returnedValue=$this->shipping_line_confirmAndUpdate($request->shipping_line);
                $container->shipping_line_id=$request->shipping_line["id"];
                if($shipping_line_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $shipping_line_returnedValue["payload"],
                        "status" => $shipping_line_returnedValue["status"]
                    ];
                }
            }

            if($request->file()) {
                if($request->incident_reportFile!=null){
                    $file=$request->incident_reportFile;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.containers.path'),$filename,"public_uploads_containers_incident_report");
                    $container->incident_report=$filename;
                }
                if($request->liability_letterFile!=null){
                    $file=$request->liability_letterFile;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.containers.path'),$filename,"public_uploads_containers_liability_letter");
                    $container->liability_letter=$filename;
                }
                if($request->insurance_declarationFile!=null){
                    $file=$request->insurance_declarationFile;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.containers.path'),$filename,"public_uploads_containers_insurance_declaration");
                    $container->insurance_declaration=$filename;
                }
            }

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

            $container->containerType=$request->containerType;
            $container->containerID=$request->containerID;
            $container->nombre_of_containers=$request->nombre_of_containers;

            $container->deductible_charge_TAT=$request->deductible_charge_TAT;
            $container->categorie_of_container=$request->categorie_of_container;
            $container->status=$request->status;
            $container->incident_date=$request->incident_date;
            $container->claim_date=$request->claim_date;
            $container->ClaimOrIncident=$request->ClaimOrIncident;
            $container->concerned_internal_department=$request->concerned_internal_department;
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
            $container->Indemnification_date=$request->Indemnification_date;
            $container->currency_indemnisation=$request->currency_indemnisation;
            $container->deductible_charge_TAT=$request->deductible_charge_TAT;
            $container->damage_caused_by=$request->damage_caused_by;
            $container->comment_nature_of_damage=$request->comment_nature_of_damage;
            $container->TAT_name_persons=$request->TAT_name_persons;
            $container->outsourcer_company_name=$request->outsourcer_company_name;
            $container->thirdparty_company_name=$request->thirdparty_company_name;
            $container->thirdparty_Activity_comments=$request->thirdparty_Activity_comments;
            $container->incident_report=$request->incident_report;
            $container->liability_letter=$request->liability_letter;
            $container->insurance_declaration=$request->insurance_declaration;
            if($request->nature_of_damage["id"]==0){
                if($request->nature_of_damage["name"]!=null || $request->nature_of_damage["name"]!=""){
                    $nature_of_damage_returnedValue=$this->nature_of_damage_confirmAndSave($request->nature_of_damage);
                        if($nature_of_damage_returnedValue["IsReturnErrorRespone"]){
                            return [
                                "payload" => $nature_of_damage_returnedValue["payload"],
                                "status" => $nature_of_damage_returnedValue["status"]
                            ];
                        }
                        $container->nature_of_damage_id=$nature_of_damage_returnedValue["payload"]->id;
                }

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

            if($request->shipping_line["id"]==0){
                if($request->shipping_line["name"]!=null || $request->shipping_line["name"]!=""){
                    $shipping_line_returnedValue=$this->shipping_line_confirmAndSave($request->shipping_line);
                    if($shipping_line_returnedValue["IsReturnErrorRespone"]){
                        return [
                            "payload" => $shipping_line_returnedValue["payload"],
                            "status" => $shipping_line_returnedValue["status"]
                        ];
                    }
                    $container->shipping_line_id=$shipping_line_returnedValue["payload"]->id;
                }
            }
            else{
                $shipping_line_returnedValue=$this->shipping_line_confirmAndUpdate($request->shipping_line);
                $container->shipping_line_id=$request->shipping_line["id"];

                if($shipping_line_returnedValue["IsReturnErrorRespone"]){
                    return [
                        "payload" => $shipping_line_returnedValue["payload"],
                        "status" => $shipping_line_returnedValue["status"]
                    ];
                }
            }
            if($request->file()) {
                if($request->incident_reportFile!=null && $request->incident_reportFile!=""){
                    $file=$request->incident_reportFile;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.containers.path'),$filename,"public_uploads_containers_incident_report");
                    $container->incident_report=$filename;
                }
                if($request->liability_letterFile!=null && $request->liability_letterFile!=""){
                    $file=$request->liability_letterFile;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.containers.path'),$filename,"public_uploads_containers_liability_letter");
                    $container->liability_letter=$filename;



                }
                if($request->insurance_declarationFile!=null && $request->insurance_declarationFile!=""){
                    $file=$request->insurance_declarationFile;
                    $filename=time()."_".$file->getClientOriginalName();
                    $this->uploadOne($file, config('cdn.containers.path'),$filename,"public_uploads_containers_insurance_declaration");
                    $container->insurance_declaration=$filename;

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
        ->with("shippingLine")
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
        //->with("typeOfEquipment")
        ->with("natureOfDamage")
        //->with("department")
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


    public function shipping_line_confirmAndSave($shipping_line){
        $validator = Validator::make($shipping_line, [
            "name" => "required:shipping_lines,name",
        ]);

        if ($validator->fails()) {
            return [
                "payload" => $validator->errors(),
                "status" => "406_2"
            ];
        }

        $shipping_line=ShippingLine::make($shipping_line);
        $shipping_line->save();

        return [
            "payload" => $shipping_line,
            "status" => "200",
            "IsReturnErrorRespone" => false
        ];
    }
    public function shipping_line_confirmAndUpdate($shipping_line){
        $shipping_line=ShippingLine::find($shipping_line['id']);
            if(!$shipping_line){
                return [
                    "payload"=>"shipping_line is not exist !",
                    "status"=>"404_2",
                    "IsReturnErrorRespone" => true
                ];
            }
            else if ($shipping_line){
              //  $shipping_line->name=$Type_of_equipment['name'];
                $shipping_line->save();
                return [
                    "payload"=>$shipping_line,
                    "status"=>"200",
                    "IsReturnErrorRespone" => false
                ];
            }
    }
}
