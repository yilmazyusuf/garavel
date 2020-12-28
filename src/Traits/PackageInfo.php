<?php

namespace Garavel\Traits;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;

/**
 *
 *
 * @category
 * @package
 * @author yusuf.yilmaz
 * @since  : 16.06.2020
 */
trait PackageInfo {


    /**
     * @return Collection
     * @throws FileNotFoundException
     */
    public static function getPackageCollections(): Collection
    {
        $filesystem = new \Illuminate\Filesystem\Filesystem;
        $basePath = app()->basePath();
        $vendorPath = $basePath . '/vendor';

        if ($filesystem->exists($path = $vendorPath . '/composer/installed.json'))
        {
            $installed = json_decode($filesystem->get($path), true);
            $packages = $installed['packages'] ?? $installed;
        }

        $collection = collect($packages);

        return $collection;
    }

    /**
     * @param $packageName
     *
     * @return array
     * @throws FileNotFoundException
     */
    public static function findPackageByName($packageName): array
    {
        $collection = self::getPackageCollections();
        $filtered = $collection->filter(function ($value, $key) use ($packageName)
        {
            return $value['name'] == $packageName;
        });

        return $filtered->first();
    }

    /**
     * @param array $package
     *
     * @return string
     */
    public static function getVersion(array $package): string
    {
        return $package['version'];
    }

    /**
     * @param array $package
     *
     * @return string
     */
    public static function getMajorVersion(array $package): string
    {
        return (int)$package['version'];
    }


}
