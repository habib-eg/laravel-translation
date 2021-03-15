<?php
namespace Habib\TranslationManager;

class RouterTranslationManager
{
    public function translationManager()
    {
        return function (){
            $this->group([
                'prefix'     => config('translation_manager.prefix'),
                'middleware' => config('translation_manager.middlecware', []),
                'namespace'  => config('translation_manager.namespace', '\Habib\TranslationManager\Controllers'),
            ], function ()
            {
                $this->get("/", "Controller@index")->name('translation_manager.index');
                $this->get("/edit/{language}/{file}/{namespace?}", "Controller@edit")->name('translation_manager.edit');
                $this->put("/edit/{language}/{file}/{namespace?}", "Controller@update")->name('translation_manager.update');
                $this->get("/ajax/files", "Controller@files")->name('translation_manager.files');
            });
        };
    }

}
