<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Medcine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class MedcineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $desc = $this->description;
        if(!$this->show){
            $desc=null;
        }
        $cat=$this->category()->get();
        return [
            "id"=> $this->id,
            "sciName"=>$this->sciName,
            "useName"=>$this->useName,
            "category"=>CategoryResource::collection($cat),
            "companyName"=>$this->companyName,
            "qtn"=>$this->qtn,
            "expiredDate"=>$this->expiredDate,
            "price"=> $this->price,
            "description"=> $desc
        ];
    }

}
