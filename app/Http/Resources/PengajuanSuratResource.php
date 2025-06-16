<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PengajuanSuratResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->category,
            'suratNumber' => $this->surat_number,
            'date'        => Carbon::parse($this->created_at)->translatedFormat('d F Y'),
            'time'        => Carbon::parse($this->created_at)->format('H:i'),
            'status'      => $this->status ?? 'Proses',
            'category' => $this->category,
            'remarks' => $this->remarks,  
            'attachment_path' => $this->attachment_path, // Bisa juga disertakan
'file_url' => $this->attachment_path ? asset('storage/app/public/uploads/' . $this->attachment_path) : null,
        ];
    }
}