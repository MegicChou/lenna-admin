<?php
/**
 * 頁面產生器
 *
 * 快速產生 AdminLTE 樣版
 *
 */
namespace Lenna\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateViewCommand extends Command
{

    protected $signature = "gen:view {layoutName} {path}";

    protected $description = "quickly generate view templates";

    public function handle()
    {
        $layoutName = $this->argument('layoutName');
        $bladePath  = $this->argument('path');

        $tplFilePath = '';

        if ($layoutName == 'blank-page') {
            $tplFilePath = __DIR__ . "/../../resources/views/codegen/blank-page.blade.php";
        }
        $targetPath         = base_path('resources/views/' . $bladePath . ".blade.php");
        $targetFileName     = pathinfo($targetPath,PATHINFO_BASENAME);
        $targetDirectory    = str_replace($targetFileName,"", $targetPath);

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory,0777,true);
        }

        File::copy($tplFilePath,  $targetPath);

        $this->info("[SUCCESS] blade view template {$layoutName} created path: {$targetPath}");
    }
}
