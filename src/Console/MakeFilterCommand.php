<?php
/**
 *
 *
 * @category
 * @package
 * @author yusuf.yilmaz
 * @since  : 9.01.2020
 */

namespace Garavel\Console;

use Illuminate\Console\GeneratorCommand;

class MakeFilterCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'garavel:make-filter {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Filter Class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Filter';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../stubs/DummyFilter.stub';
    }


    /**
     * Build the class with the given name.
     *
     * @param  string $name
     * @return string
     */
    protected function buildClass($name)
    {

        $namespaceFilter =  trim($this->rootNamespace(),'\\').'\\Http\Filters';

        $filter = str_replace(
            ['\\', '/'], '', $this->argument('name'));

        return str_replace(
            [
                'NamespacedDummyFilter',
                'DummyFilter',
            ],
            [
                $namespaceFilter,
                $filter,
            ],
            parent::buildClass($name)
        );
    }


    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace(
            ['\\', '/'], '', $this->argument('name')
        );
        return app_path("Http/Filters/{$name}.php");
    }


}