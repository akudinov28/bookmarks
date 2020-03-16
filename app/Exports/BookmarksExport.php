<?php

namespace App\Exports;

use App\Http\Models\Bookmark;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BookmarksExport implements FromCollection, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $bookmarks = Bookmark::orderBy('created_at', 'DESC')->get()->makeHidden(['id', 'favicon']);
        foreach($bookmarks as $bookmark) {
            $bookmark->keywords = json_decode($bookmark->keywords);
            if($bookmark->keywords) {
                $bookmark->keywords = implode(', ', $bookmark->keywords);
            }
        }
        return $bookmarks;
    }
}
