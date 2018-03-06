<?php

namespace Library\Models;

use Catalogue\Support\Scopes\OfCatalogue;
use Catalogue\Support\Traits\BelongsToCatalogue;
use Frontier\Support\Traits\TypeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Library\Support\Mutators\LibraryMutator;
use Pluma\Models\Model;

class Library extends Model
{
    use BelongsToCatalogue,
        LibraryMutator,
        OfCatalogue,
        SoftDeletes,
        TypeTrait;

    protected $table = 'library';

    protected $appends = [
        'created',
        'filesize',
        'icon',
        'modified',
        'thumbnail',
    ];

    protected $searchables = [
        'created_at',
        'mimetype',
        'name',
        'originalname',
        'size',
        'thumbnail',
        'updated_at',
        'url',
    ];
}
