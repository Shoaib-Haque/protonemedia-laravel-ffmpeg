<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use Carbon\Carbon;
//use FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VideoController extends Controller
{
    public function upload1(Request $request)
    {
        $path = public_path('temp');
        if (isset($request->file)) {
            $file = $request->file('file');                                    //get file from request
            $filename =  $file->getClientOriginalName();
            //$extension    =  $file->extension();                               //to get existing name  of file
            //$arrayFileName = explode(".", $file->getClientOriginalName());     //to get name of file in array form
            $file->move($path, $filename);


            //$lowBitrateFormat = (new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))->setKiloBitrate(200);
            //inFormat((new X264('aac', 'libx265'))->setKiloBitrate(4000))
            $lowBitrateFormat = ((new \FFMpeg\Format\Video\X264('aac', 'libx264'))->setKiloBitrate(700));
            FFMpeg::fromDisk('temp')
                ->open($filename)
                // ->addFilter(function ($filters) {
                //         $filters->resize(new \FFMpeg\Coordinate\Dimension(960, 540));
                //     })
                ->export()
                ->toDisk('uploads')
                ->inFormat($lowBitrateFormat)
                ->save($filename);

            echo "Done";
        }
    }

    // https://laracasts.com/discuss/channels/laravel/is-there-any-way-that-i-can-speed-up-the-ffmpeg-processing-time
    public function upload2(Request $request)
    {
        $path = public_path('temp');
        if (isset($request->file)) {
            $file = $request->file('file');                                    //get file from request
            $filename =  $file->getClientOriginalName();
            //$extension    =  $file->extension();                               //to get existing name  of file
            //$arrayFileName = explode(".", $file->getClientOriginalName());     //to get name of file in array form
            $file->move($path, $filename);


            //$lowBitrateFormat = (new \FFMpeg\Format\Video\X264('libmp3lame', 'libx264'))->setKiloBitrate(200);
            //inFormat((new X264('aac', 'libx265'))->setKiloBitrate(4000))
            //$lowBitrateFormat = ((new \FFMpeg\Format\Video\X264('aac', 'libx264'))->setKiloBitrate(700));
            FFMpeg::fromDisk('temp')
                ->open($filename)
                ->addFilter(function ($filters) {
                    $filters->resize(new \FFMpeg\Coordinate\Dimension(640, 480));
                })
                ->export()
                // ->onProgress(function ($percentage, $remaining, $rate) {
                //     echo "{$remaining} seconds left at rate: {$rate}";
                // })
                ->toDisk('uploads')
                ->inFormat(new \FFMpeg\Format\Video\X264('libmp3lame'))
                ->save($filename);

            echo "Done";
        }
    }

    // https://protone.media/en/blog/how-to-use-ffmpeg-in-your-laravel-projects
    public function handle(Request $request)
    {
        $path = public_path('temp');
        if (isset($request->file)) {
            $file = $request->file('file');                                    //get file from request
            $filename =  $file->getClientOriginalName();
            //$extension    =  $file->extension();                               //to get existing name  of file
            //$arrayFileName = explode(".", $file->getClientOriginalName());     //to get name of file in array form
            $file->move($path, $filename);

            // create some video formats...
            $lowBitrateFormat  = (new X264)->setKiloBitrate(500);
            $midBitrateFormat  = (new X264)->setKiloBitrate(1500);
            $highBitrateFormat = (new X264)->setKiloBitrate(3000);

            // open the uploaded video from the right disk...
            FFMpeg::fromDisk('temp')
                ->open($filename)

                // call the 'exportForHLS' method and specify the disk to which we want to export...
                ->exportForHLS()
                ->toDisk('uploads')

                // we'll add different formats so the stream will play smoothly
                // with all kinds of internet connections...
                ->addFormat($lowBitrateFormat)
                ->addFormat($midBitrateFormat)
                ->addFormat($highBitrateFormat)

                // call the 'save' method with a filename...
                ->save($filename);

            echo "Done";
        }
    }
}
